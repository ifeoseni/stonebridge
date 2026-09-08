@extends('admin.layouts.admin')

@section('title', 'Profile & Password')

@section('admin_content')
    <h1 class="wp-heading-inline">Profile & Security</h1>
    <hr class="wp-header-end" style="margin-bottom:20px; border:none;">

    @if(session('profile_success'))
        <div class="notice notice-success">
            <p><strong>{{ session('profile_success') }}</strong></p>
        </div>
    @endif

    @if(session('password_success'))
        <div class="notice notice-success">
            <p><strong>{{ session('password_success') }}</strong></p>
        </div>
    @endif

    @if($errors->any())
        <div class="notice notice-error">
            <p><strong>{{ $errors->first() }}</strong></p>
        </div>
    @endif

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
        <!-- Card 1: Name & Email -->
        <div class="postbox">
            <div class="postbox-header">
                <h2>Admin Information</h2>
            </div>
            <div class="inside">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table class="form-table">
                        <tr>
                            <th><label for="name">Display Name</label></th>
                            <td>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="large-text" required>
                                <p class="description">Your name as shown in the top admin bar and records.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="email">Email Address</label></th>
                            <td>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="large-text" required>
                                <p class="description">Used for logging into the Stonebridge Admin Dashboard.</p>
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="margin-top:16px; border-top:1px solid #f0f0f1; padding-top:16px;">
                        <button type="submit" class="button button-primary">Update Profile</button>
                    </p>
                </form>
            </div>
        </div>

        <!-- Card 2: Change Password -->
        <div class="postbox">
            <div class="postbox-header">
                <h2>Change Password</h2>
            </div>
            <div class="inside">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table class="form-table">
                        <tr>
                            <th><label for="current_password">Current Password</label></th>
                            <td>
                                <input type="password" name="current_password" id="current_password" class="large-text" required autocomplete="current-password">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="password">New Password</label></th>
                            <td>
                                <input type="password" name="password" id="password" class="large-text" required autocomplete="new-password">
                                <p class="description">Must be at least 6 characters.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="password_confirmation">Confirm New Password</label></th>
                            <td>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="large-text" required autocomplete="new-password">
                            </td>
                        </tr>
                    </table>

                    <p class="submit" style="margin-top:16px; border-top:1px solid #f0f0f1; padding-top:16px;">
                        <button type="submit" class="button button-primary">Update Password</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
