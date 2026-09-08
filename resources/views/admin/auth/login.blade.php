<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In &lsaquo; Stonebridge Advisory &mdash; WordPress</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #f0f0f1;
            color: #3c434a;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-size: 14px;
            line-height: 1.4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 24px;
            text-decoration: none;
        }
        .login-logo-title {
            font-family: 'Cinzel', serif;
            font-size: 18px;
            letter-spacing: 0.22em;
            color: #1d2327;
            font-weight: 600;
            display: block;
        }
        .login-logo-sub {
            font-size: 10px;
            letter-spacing: 0.28em;
            color: #9a7d55;
            text-transform: uppercase;
            font-weight: 600;
            margin-top: 4px;
            display: block;
        }
        .login-card {
            background: #fff;
            border: 1px solid #c3c4c7;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
            padding: 30px 24px;
            width: 100%;
            max-width: 360px;
        }
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #1d2327;
        }
        .form-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            font-size: 16px;
            outline: none;
            margin-bottom: 16px;
            transition: all 0.15s;
        }
        .form-input:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
        }
        .login-submit-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }
        .btn-wp-primary {
            background: #2271b1;
            border-color: #2271b1;
            color: #fff;
            padding: 8px 18px;
            border-radius: 3px;
            border: 1px solid transparent;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-wp-primary:hover {
            background: #135e96;
        }
        .login-error {
            background: #fff;
            border-left: 4px solid #d63638;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.05);
            margin-bottom: 16px;
            padding: 12px;
            font-size: 13px;
            color: #d63638;
        }
        .login-nav {
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
        }
        .login-nav a {
            color: #2271b1;
            text-decoration: none;
        }
        .login-nav a:hover {
            color: #135e96;
            text-decoration: underline;
        }
        .credentials-hint {
            margin-top: 16px;
            padding: 10px;
            background: #f6f7f7;
            border: 1px dashed #c3c4c7;
            font-size: 12px;
            color: #646970;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <a href="{{ route('home') }}" class="login-logo">
        <span class="login-logo-title">STONEBRIDGE ADVISORY</span>
        <span class="login-logo-sub">Content Management System</span>
    </a>

    <div class="login-card">
        @if($errors->any())
            <div class="login-error">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('status'))
            <div style="background:#fff; border-left:4px solid #00a32a; padding:12px; font-size:13px; margin-bottom:16px; color:#1b5e20;">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <label class="form-label" for="user_login">Username or Email Address</label>
            <input type="email" name="email" id="user_login" class="form-input" value="{{ old('email', 'admin@stonebridge.com') }}" required autofocus>

            <label class="form-label" for="user_pass">Password</label>
            <input type="password" name="password" id="user_pass" class="form-input" value="password" required>

            <div class="login-submit-row">
                <label style="display:flex; align-items:center; gap:6px; font-size:13px; color:#50575e; cursor:pointer;">
                    <input type="checkbox" name="remember" value="1" checked>
                    <span>Remember Me</span>
                </label>

                <button type="submit" class="btn-wp-primary">Log In</button>
            </div>
        </form>

        <div class="credentials-hint">
            <strong>Default Credentials:</strong><br>
            Email: <code>admin@stonebridge.com</code><br>
            Password: <code>password</code>
        </div>
    </div>

    <div class="login-nav">
        <a href="{{ route('home') }}">&larr; Go to Stonebridge Advisory</a>
    </div>

</body>
</html>
