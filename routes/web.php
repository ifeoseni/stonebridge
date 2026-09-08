<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/page/{slug}', [HomeController::class, 'page'])->name('page.show');
Route::get('/api/page/{slug}', [HomeController::class, 'pageJson'])->name('page.json');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');

// Admin Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected WordPress-Style Admin Panel Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // WordPress-Style Customizer (Edit Every Section)
    Route::get('/customize', [ContentController::class, 'index'])->name('customize');
    Route::post('/customize/settings', [ContentController::class, 'updateSettings'])->name('customize.settings');
    Route::post('/customize/pillars', [ContentController::class, 'updatePillars'])->name('customize.pillars');
    Route::post('/customize/criteria', [ContentController::class, 'updateCriteria'])->name('customize.criteria');
    Route::delete('/customize/criteria/{id}', [ContentController::class, 'deleteCriterion'])->name('customize.criteria.delete');
    Route::post('/customize/retainers', [ContentController::class, 'updateRetainers'])->name('customize.retainers');
    Route::delete('/customize/retainers/{id}', [ContentController::class, 'deleteRetainer'])->name('customize.retainers.delete');

    // Private Inquiries Lead Inbox
    Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{id}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
    Route::put('/inquiries/{id}', [AdminInquiryController::class, 'update'])->name('inquiries.update');
    Route::delete('/inquiries/{id}', [AdminInquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Sub-Pages Management
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy');

    // Admin Profile & Change Password
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
