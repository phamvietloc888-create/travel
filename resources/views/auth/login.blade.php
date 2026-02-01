@php($title = 'Đăng nhập')
@extends('layouts.guest')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f3f5f7; color: #0f172a; }
        .login-wrapper { max-width: 1100px; width: 94%; margin: 40px auto; background: #fff; border-radius: 22px; overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; box-shadow: 0 24px 80px rgba(15,23,42,0.12); }
        .login-hero { position: relative; background: url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat; min-height: 100%; }
        .login-hero::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(15,23,42,0.25), rgba(15,23,42,0.55)); }
        .login-hero-content { position: relative; height: 100%; display: flex; flex-direction: column; justify-content: space-between; padding: 36px; color: #fff; }
        .login-brand { display: inline-flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.1); padding: 10px 14px; border-radius: 16px; backdrop-filter: blur(6px); font-weight: 700; }
        .login-hero-text h3 { margin: 0 0 10px; font-size: 28px; }
        .login-hero-text p { margin: 0; color: rgba(255,255,255,0.8); line-height: 1.6; }
        .login-form { padding: 48px 56px; display: flex; flex-direction: column; justify-content: center; }
        .login-header h1 { margin: 0; font-size: 30px; }
        .login-header p { margin: 6px 0 24px; color: #6b7280; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #0f172a; }
        .form-group input { width: 100%; padding: 14px 14px; border-radius: 12px; border: 1px solid #e5e7eb; font-size: 15px; outline: none; transition: 0.2s; background: #fff; }
        .form-group input:focus { border-color: #22b8c9; box-shadow: 0 0 0 4px rgba(34,184,201,0.2); }
        .remember { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #4b5563; margin-bottom: 14px; }
        .btn-primary { width: 100%; padding: 14px; border: none; border-radius: 14px; background: linear-gradient(120deg, #22b8c9, #0ea5e9); color: #fff; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 0 15px 40px rgba(14,165,233,0.25); }
        .btn-primary:hover { opacity: .95; }
        .signup { margin-top: 18px; font-size: 14px; color: #4b5563; }
        .signup a { color: #0ea5e9; font-weight: 600; text-decoration: none; }
        .alert { background: #fff1f2; color: #be123c; padding: 12px 14px; border-radius: 12px; border: 1px solid #fecdd3; margin-bottom: 12px; font-size: 14px; }
        @media (max-width: 960px) { .login-wrapper { grid-template-columns: 1fr; } .login-hero { display: none; } .login-form { padding: 36px 28px; } }
    </style>
@endpush

@section('content')
    <div class="login-wrapper">
        <div class="login-hero">
            <div class="login-hero-content">
                <div class="login-brand">
                    <span class="material-symbols-outlined">landscape</span>
                    <span>WanderBlue</span>
                </div>
                <div class="login-hero-text">
                    <h3>Discover the Hidden Gems</h3>
                    <p>Join over 50,000 travelers exploring the world's most serene nature spots.</p>
                </div>
            </div>
        </div>

        <div class="login-form">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Đăng nhập để quản trị nội dung.</p>
            </div>

            @if(session('status'))
                <div class="alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus placeholder="travel@example.com">
                    @error('email')
                        <div class="alert" style="margin-top:8px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required placeholder="Enter your password">
                    @error('password')
                        <div class="alert" style="margin-top:8px;">{{ $message }}</div>
                    @enderror
                </div>

                <label class="remember">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>

                <button type="submit" class="btn-primary">Sign In</button>
            </form>

            <p class="signup">
                Chưa có tài khoản?
                <a href="{{ route('register') }}">Đăng ký</a>
            </p>
        </div>
    </div>
@endsection
