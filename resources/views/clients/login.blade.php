@include('clients.blocks.header')

<link rel="stylesheet" href="{{ asset('clients/css/dangky.css') }}">

<div class="login-page">
    <div class="wrapper">
        <form method="POST" action="">
            @csrf
            <h1>Đăng nhập</h1>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit" class="btn">Đăng nhập</button>

            <div class="register-link">
                <p>Don't have an account?
                    <a href="{{ url('/register') }}">Đăng ký</a>
                </p>
            </div>
        </form>
    </div>
</div>
