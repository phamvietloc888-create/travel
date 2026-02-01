@php($title = 'Đăng ký')
@extends('layouts.guest')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f3f5f7; color: #0f172a; }
        .auth-wrapper { max-width: 1100px; width: 94%; margin: 40px auto; background: #fff; border-radius: 22px; overflow: hidden; display: grid; grid-template-columns: 1fr 1fr; box-shadow: 0 24px 80px rgba(15,23,42,0.12); }
        .auth-image { position: relative; background: url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat; min-height: 100%; color: #fff; }
        .auth-image::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(15,23,42,0.35), rgba(15,23,42,0.65)); }
        .auth-image-content { position: relative; height: 100%; display: flex; flex-direction: column; justify-content: space-between; padding: 36px; }
        .brand { font-size: 22px; font-weight: 700; display: inline-flex; align-items: center; gap: 10px; }
        .hero-text h2 { font-size: 32px; margin: 0 0 10px; }
        .hero-text p { margin: 0; opacity: .85; line-height: 1.6; }
        .auth-form { padding: 48px 56px; display: flex; flex-direction: column; justify-content: center; }
        .auth-form h1 { margin: 0; font-size: 30px; }
        .auth-form p { margin: 8px 0 22px; color: #6b7280; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; }
        .form-group input { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #e5e7eb; font-size: 15px; outline: none; transition: .2s; background: #fff; }
        .form-group input:focus { border-color: #22b8c9; box-shadow: 0 0 0 4px rgba(34,184,201,0.2); }
        .btn { margin-top: 10px; padding: 14px; border-radius: 14px; border: none; background: linear-gradient(120deg, #22b8c9, #0ea5e9); color: #fff; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 0 15px 40px rgba(14,165,233,0.25); width: 100%; }
        .btn:hover { opacity: .96; }
        .footer { margin-top: 18px; font-size: 14px; color: #4b5563; }
        .footer a { color: #0ea5e9; font-weight: 600; text-decoration: none; }
        .alert { background: #fff1f2; color: #be123c; padding: 12px 14px; border-radius: 12px; border: 1px solid #fecdd3; margin-bottom: 12px; font-size: 14px; }
        @media (max-width: 960px) { .auth-wrapper { grid-template-columns: 1fr; } .auth-image { display: none; } .auth-form { padding: 36px 28px; } }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <div class="auth-image">
            <div class="auth-image-content">
                <div class="brand">WanderBlue</div>
                <div class="hero-text">
                    <h2>Khám phá & lưu lại hành trình</h2>
                    <p>Tạo tài khoản để đặt tour, lưu wishlist, và nhận thông báo ưu đãi.</p>
                </div>
            </div>
        </div>

        <div class="auth-form">
            <h1>Tạo tài khoản</h1>
            <p>Nhập thông tin để bắt đầu.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="Nguyễn Văn A">
                    @error('name')<div class="alert" style="margin-top:8px;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="travel@example.com">
                    @error('email')<div class="alert" style="margin-top:8px;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input id="password" name="password" type="password" required placeholder="Tối thiểu 8 ký tự">
                    @error('password')<div class="alert" style="margin-top:8px;">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Nhập lại mật khẩu">
                </div>

                <button type="submit" class="btn">Đăng ký</button>
            </form>

            <div class="footer">
                Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
            </div>
        </div>
    </div>
@endsection
