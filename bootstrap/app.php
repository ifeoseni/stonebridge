<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Guests hitting auth-protected admin pages (e.g. /admin/profile,
        // /admin/pages) must go to /admin/login instead of throwing
        // "Route [login] not defined".
        $middleware->redirectGuestsTo(fn (Request $request) => route('admin.login'));

        $middleware->validateCsrfTokens(except: [
            'inquiry',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Website errors redirect to the homepage (home blade) with a toast
        // message instead of a bare error page. Admin-area errors redirect
        // back into the admin panel. JSON / API requests keep Laravel's
        // default JSON error responses. Form validation (422) is untouched.
        $toSafePage = function (Request $request, string $message) {
            if ($request->is('admin/*')) {
                return back(fallback: route('admin.dashboard'))->with('error', $message);
            }

            return redirect()->route('home')->with('error', $message);
        };

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }
            if ($request->is('admin/*')) {
                return back(fallback: route('admin.dashboard'))->with('error', 'The requested admin page or record could not be found.');
            }

            return redirect()->route('home')->with('error', 'The page you were looking for could not be found — you are back at the Stonebridge Advisory overview.');
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) use ($toSafePage) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }

            return $toSafePage($request, 'That action is not available from this address — you are back at a safe page.');
        });

        $exceptions->render(function (TokenMismatchException $e, Request $request) use ($toSafePage) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }

            return $toSafePage($request, 'Your session expired — please try again.');
        });

        $exceptions->render(function (HttpExceptionInterface $e, Request $request) use ($toSafePage) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }

            $status = $e->getStatusCode();

            if (in_array($status, [404, 405], true)) {
                return null; // Handled by the dedicated renderers above.
            }

            if (in_array($status, [500, 502, 503, 504], true) && config('app.debug')) {
                return null; // Keep detailed error pages while debugging.
            }

            if (! in_array($status, [400, 401, 403, 419, 429, 500, 502, 503, 504], true)) {
                return null;
            }

            $messages = [
                400 => 'The request could not be understood — you are back at a safe page.',
                401 => 'Please log in to continue.',
                403 => 'You do not have permission to view that page.',
                419 => 'Your session expired — please try again.',
                429 => 'Too many attempts — please wait a moment and try again.',
                500 => 'Something went wrong on our side — please try again shortly.',
                502 => 'Something went wrong on our side — please try again shortly.',
                503 => 'The site is briefly undergoing maintenance — please try again shortly.',
                504 => 'The request timed out — please try again shortly.',
            ];

            return $toSafePage($request, $messages[$status] ?? 'Something went wrong — you are back at a safe page.');
        });
    })->create();
