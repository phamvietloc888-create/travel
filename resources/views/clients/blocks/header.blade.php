    @if(session('success'))
        <div class="custom-alert success-alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="custom-alert error-alert">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @auth
        @php
            $unreadBookingNotices = \App\Models\Booking::supportsCustomerNotifications()
                ? auth()->user()
                    ->bookings()
                    ->with('tour')
                    ->whereNotNull('customer_notice')
                    ->whereNull('customer_notice_read_at')
                    ->latest('updated_at')
                    ->limit(5)
                    ->get()
                : collect();
            $unreadBookingNoticeCount = $unreadBookingNotices->count();
        @endphp
    @endauth

    @php
        $authErrorBag = $errors;
        $hasRegisterError = old('name') || $authErrorBag->hasAny(['name', 'password', 'password_confirmation']) || ($authErrorBag->has('email') && old('name'));
        $hasLoginError = session('error') || ($authErrorBag->has('email') && ! $hasRegisterError) || ($authErrorBag->has('password') && ! $hasRegisterError);
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container-fluid navbar-mobile">
            <button class="navbar-toggler order-first" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Mở menu">
                <span class="oi oi-menu"></span> Menu
            </button>

            <a class="navbar-brand navbar-brand-center" href="{{ route('home') }}">Lotus<span>Vietnam Travel</span></a>

            <div class="nav-auth-mobile order-last">
        @auth
            <div class="nav-auth-cluster">
                <div class="dropdown d-inline nav-notice-dropdown">
                    <button type="button" class="nav-link nav-bell-trigger {{ $unreadBookingNoticeCount > 0 ? 'is-active' : '' }}" aria-expanded="false" aria-label="Thông báo">
                        <i class="fa fa-bell"></i>
                        @if($unreadBookingNoticeCount > 0)
                            <span class="nav-bell-badge">{{ $unreadBookingNoticeCount }}</span>
                        @endif
                    </button>
                    @if($unreadBookingNoticeCount > 0)
                        <div class="nav-notice-pill">Bạn có thông báo mới</div>
                    @endif
                    <div class="dropdown-menu dropdown-menu-right nav-notice-menu">
                        <div class="nav-notice-head">
                            <strong>Thông báo booking</strong>
                            <a href="{{ route('profile.bookings') }}">Xem tất cả</a>
                        </div>
                        @forelse($unreadBookingNotices as $noticeBooking)
                            <a class="dropdown-item nav-notice-item" href="{{ route('profile.bookings.notification', $noticeBooking) }}">
                                <span class="nav-notice-tour">{{ $noticeBooking->tour?->name ?? 'Booking' }}</span>
                                <span class="nav-notice-text">{{ \Illuminate\Support\Str::limit($noticeBooking->customer_notice, 88) }}</span>
                            </a>
                        @empty
                            <div class="dropdown-item nav-notice-empty">Chưa có thông báo mới.</div>
                        @endforelse
                    </div>
                </div>

                <div class="dropdown d-inline nav-user-dropdown">
                    <button type="button" class="nav-link dropdown-toggle nav-user-trigger" aria-expanded="false">
                        <span class="nav-user-label">{{ auth()->user()->name }}</span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right nav-user-menu">
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="fa fa-user mr-2"></i>Hồ sơ
                        </a>
                        <a class="dropdown-item" href="{{ route('profile.bookings') }}">
                            <i class="fa fa-suitcase mr-2"></i>Tour đã đặt
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-cog mr-2"></i>Quản trị
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn có chắc muốn đăng xuất không?')">
                                <i class="fa fa-sign-out mr-2"></i>Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="#" class="auth-btn" data-toggle="modal" data-target="#authModal">Đăng nhập</a>
        @endauth
    </div>
    <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}" class="nav-link">Trang chủ</a></li>
                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}" class="nav-link">Giới thiệu</a></li>
                    <li class="nav-item {{ request()->routeIs('destinations.index') ? 'active' : '' }}"><a href="{{ route('destinations.index') }}" class="nav-link">Điểm đến</a></li>
                    <li class="nav-item {{ request()->routeIs('tours.index') ? 'active' : '' }}"><a href="{{ route('tours.index') }}" class="nav-link">Tours</a></li>
                    <li class="nav-item {{ request()->routeIs('blog.*') ? 'active' : '' }}"><a href="{{ route('blog.index') }}" class="nav-link">Blog</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <style>
    .nav-auth-cluster { display: flex; align-items: center; gap: 10px; position: relative; }
    .nav-bell-trigger,.nav-user-trigger { position: relative; display: inline-flex; align-items: center; justify-content: center; min-height: 46px; border-radius: 999px; border: 1px solid rgba(255,255,255,0.18); background: rgba(15, 23, 42, 0.2); padding: 0 16px; color: #fff !important; backdrop-filter: blur(8px); }
    .nav-bell-trigger { width: 48px; padding: 0; }
    .nav-bell-trigger.is-active { animation: bellPulse 1.6s ease-in-out infinite; }
    .nav-bell-trigger.is-active i { animation: bellRing 1.6s ease-in-out infinite; transform-origin: top center; }
    .nav-bell-badge { position: absolute; top: -4px; right: -2px; min-width: 20px; height: 20px; padding: 0 6px; border-radius: 999px; background: #ef4444; color: #fff; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; }
    .nav-notice-pill { position: absolute; top: 54px; right: 0; padding: 8px 12px; border-radius: 999px; background: #fff8e6; border: 1px solid #f5d48a; color: #8a5a00; font-size: 12px; font-weight: 700; white-space: nowrap; box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12); animation: floatNotice 2.2s ease-in-out infinite; }
    .nav-notice-menu,.nav-user-menu { min-width: 320px; padding: 10px; border: 1px solid #e5edf5; border-radius: 18px; box-shadow: 0 20px 44px rgba(15, 23, 42, 0.14); }
    .nav-user-menu { min-width: 240px; }
    .nav-notice-head { display: flex; justify-content: space-between; align-items: center; padding: 8px 10px 12px; border-bottom: 1px solid #eef2f7; margin-bottom: 6px; }
    .nav-notice-head strong { color: #18314f; }
    .nav-notice-head a { font-size: 12px; font-weight: 700; color: #111111; }
    .nav-notice-item { display: grid; gap: 4px; white-space: normal; border-radius: 14px; }
    .nav-notice-item:hover { background: #f5f9fd; }
    .nav-notice-tour { font-weight: 700; color: #18314f; }
    .nav-notice-text { font-size: 13px; color: #6d7f95; }
    .nav-notice-empty { color: #7f8fa4; font-size: 13px; }
    #authModal { z-index: 2000; }
    #authModal .modal-dialog { z-index: 2001; pointer-events: auto; }
    .modal-backdrop.show { z-index: 1990; }
    .login-modal { position: relative; z-index: 2002; border-radius: 24px; border: 0; box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18); background: #ffffff; color: #0f172a; overflow: visible; }
    .login-modal .modal-body { padding: 28px; position: relative; z-index: 2; background: transparent; }
    .close-btn { position: absolute; right: -12px; top: -12px; width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #d7e3ef; border-radius: 999px; background: #fff; font-size: 22px; line-height: 1; color: #73869d; box-shadow: 0 14px 30px rgba(15, 23, 42, 0.14); z-index: 5; transition: all 0.2s ease; }
    .close-btn:hover { background: #f5f9fd; color: #18314f; border-color: #bfd3e6; }
    .auth-tabs { display: flex; gap: 10px; margin-bottom: 20px; padding-right: 48px; }
    .tab-btn { flex: 1; min-height: 48px; border-radius: 14px; border: 1px solid #d7e3ef; background: #fff; font-weight: 700; color: #64748b; }
    .tab-btn.active { background: #111827; border-color: #111827; color: #fff; }
    .auth-form { display: none; }
    .auth-form.active { display: block; }
    .form-header h4 { margin-bottom: 6px; color: #22364d; font-weight: 800; }
    .form-header p { margin-bottom: 20px; color: #7a8a9c; }
    .input-group { margin-bottom: 16px; display: block; }
    .input-wrapper { position: relative; display: block; z-index: 1; overflow: visible; isolation: isolate; }
    .input-wrapper input { position: relative; z-index: 2; width: 100%; min-height: 52px; border-radius: 14px; border: 1px solid #d6e1ec; background: #fff; color: #22364d; padding: 0 44px 0 42px; pointer-events: auto; touch-action: manipulation; -webkit-user-select: text; user-select: text; font-size: 16px; }
    .input-wrapper.password-wrapper input { padding-right: 56px; }
    .input-wrapper.has-clear input { padding-right: 82px; }
    .input-wrapper input::placeholder { color: #94a3b8; }
    .input-wrapper input:focus { outline: none; border-color: #111827; box-shadow: 0 0 0 4px rgba(17, 24, 39, 0.08); }
    .input-wrapper input.is-invalid { border-color: #dc2626; box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.08); }
    .input-icon-left { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #8ba0b5; pointer-events: none; z-index: 3; }
    .password-field { color: #22364d !important; caret-color: #22364d; -webkit-text-fill-color: #22364d; }
    .toggle-password { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); border: 0; background: transparent; color: #8ba0b5; z-index: 4; width: 28px; height: 28px; min-width: 28px; min-height: 28px; margin: 0; padding: 0; display: inline-flex; align-items: center; justify-content: center; pointer-events: auto; -webkit-appearance: none; appearance: none; box-shadow: none; }
    .clear-input-btn { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 26px; height: 26px; border: 0; border-radius: 999px; background: #e5e7eb; color: #475569; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; line-height: 1; cursor: pointer; opacity: 0; pointer-events: none; transition: opacity .2s ease, background-color .2s ease, color .2s ease; }
    .clear-input-btn.is-visible { opacity: 1; pointer-events: auto; }
    .clear-input-btn:hover { background: #111827; color: #fff; }
    .input-note { display: block; margin-top: 8px; color: #8aa; font-size: 12px; }
    .form-alert { margin-bottom: 16px; padding: 12px 14px; border-radius: 14px; font-size: 14px; font-weight: 600; }
    .form-alert.is-error { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .input-error { display: block; margin-top: 8px; color: #dc2626; font-size: 12px; font-weight: 600; }
    .form-alert { margin-bottom: 16px; padding: 12px 14px; border-radius: 14px; font-size: 14px; font-weight: 600; }
    .form-alert.is-error { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .form-options { display: flex; justify-content: space-between; gap: 10px; margin-bottom: 18px; font-size: 14px; }
    .form-options label, .form-options a, .text-center a { color: #111827; }
    .main-btn { width: 100%; min-height: 52px; border-radius: 14px; border: 0; background: #111827; color: #fff; font-weight: 700; }
    .divider { display: flex; align-items: center; gap: 12px; margin: 20px 0 16px; color: #8aa0b5; font-size: 13px; }
    .divider::before,.divider::after { content: ''; flex: 1; height: 1px; background: #dfe8f1; }
    .social-login { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .social-btn { display: inline-flex; align-items: center; justify-content: center; gap: 10px; min-height: 48px; border-radius: 14px; border: 1px solid #d6e1ec; color: #22364d; font-weight: 700; background: #fff; }
    .social-btn img { width: 18px; height: 18px; object-fit: contain; }
    .social-btn:hover { background: #f8fafc; color: #111827; }
    body.auth-modal-open .site-chat-widget { opacity: 0; pointer-events: none; visibility: hidden; }
    @keyframes bellRing { 0%,100% { transform: rotate(0); } 10% { transform: rotate(18deg); } 20% { transform: rotate(-16deg); } 30% { transform: rotate(12deg); } 40% { transform: rotate(-8deg); } 50% { transform: rotate(0); } }
    @keyframes bellPulse { 0%,100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.18); } 50% { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0); } }
    @keyframes floatNotice { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
    @media (max-width: 991.98px) {
        .nav-auth-cluster { gap: 8px; }
        .nav-notice-menu,.nav-user-menu { right: 0; left: auto; }
        .nav-notice-pill { top: 52px; right: -6px; }
        .social-login { grid-template-columns: 1fr; }
    }

    @media (max-width: 767.98px) {
        #authModal {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        #authModal .modal-dialog {
            margin: 72px auto 16px;
            max-width: 100%;
            min-height: calc(100vh - 88px);
            display: flex;
            align-items: flex-start;
        }

        .navbar-mobile {
            padding-left: 12px;
            padding-right: 12px;
            align-items: center;
        }

        .navbar-brand.navbar-brand-center {
            max-width: calc(100% - 120px);
            font-size: 20px !important;
            line-height: 1.1;
            text-align: center;
        }

        .navbar-brand.navbar-brand-center span {
            display: block;
            font-size: 11px !important;
            letter-spacing: 0.12em;
        }

        .nav-auth-mobile .auth-btn,
        .nav-user-trigger,
        .nav-bell-trigger {
            min-height: 40px;
        }

        .nav-bell-trigger {
            width: 40px;
        }

        .nav-user-trigger {
            padding: 0 12px;
        }

        .nav-user-label {
            max-width: 88px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .nav-notice-menu,
        .nav-user-menu {
            min-width: min(320px, calc(100vw - 24px));
            max-width: calc(100vw - 24px);
        }

        .login-modal .modal-body {
            padding: 22px 18px;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .login-modal {
            overflow: hidden;
        }

        .input-wrapper.password-wrapper input {
            padding-right: 52px;
        }

        .toggle-password {
            right: 10px;
            width: 24px;
            height: 24px;
            min-width: 24px;
            min-height: 24px;
            pointer-events: none;
            opacity: 0.8;
        }

        .auth-tabs {
            padding-right: 36px;
        }

        .form-options {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 420px) {
        #authModal .modal-dialog {
            margin-top: 64px;
            min-height: calc(100vh - 80px);
        }

        .navbar-brand.navbar-brand-center {
            font-size: 18px !important;
        }

        .nav-user-trigger {
            padding: 0 10px;
        }

        .nav-user-label {
            max-width: 64px;
        }

        .nav-notice-pill {
            display: none;
        }
    }
    </style>

    <div class="modal fade" id="authModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content login-modal">
                <div class="modal-body">
                    <button type="button" class="close-btn" data-dismiss="modal">&times;</button>
                    <div class="auth-tabs">
                        <button type="button" class="tab-btn active" onclick="switchTab('login')">Đăng nhập</button>
                        <button type="button" class="tab-btn" onclick="switchTab('register')">Đăng ký</button>
                    </div>
                    <div id="loginForm" class="auth-form active">
                        <div class="form-header">
                            <h4>Chào mừng quay lại</h4>
                            <p>Đăng nhập để tiếp tục hành trình của bạn</p>
                        </div>
                        @if(session('error'))
                            <div class="form-alert is-error">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="/login" id="loginModalForm" autocomplete="on">
                            @csrf
                            <div class="input-group">
                                <div class="input-wrapper has-clear">
                                    <i class="fa fa-envelope input-icon-left"></i>
                                    <input type="email" name="email" id="loginEmail" value="{{ old('email', request()->cookie('remembered_email')) }}" placeholder="Nhập email của bạn" autocomplete="username" required>
                                    <button type="button" class="clear-input-btn" data-target="loginEmail" aria-label="Xóa email">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <small class="input-note">Dùng email bạn đã đăng ký</small>
                            </div>
                            <div class="input-group">
                                <div class="input-wrapper">
                                    <i class="fa fa-lock input-icon-left"></i>
                                    <input type="password" name="password" class="password-field" placeholder="Nhập mật khẩu" autocomplete="current-password" required>
                                    <button type="button" class="toggle-password"><i class="fa fa-eye"></i></button>
                                </div>
                                <small class="input-note">Mật khẩu phải có ít nhất 8 ký tự</small>
                            </div>
                            <div class="form-options">
                                <label><input type="checkbox" name="remember_login" id="loginRemember" {{ request()->cookie('remembered_email') ? 'checked' : '' }}> Ghi nhớ đăng nhập</label>
                                <a href="#" onclick="switchTab('forgot')">Quên mật khẩu?</a>
                            </div>
                            <button type="submit" class="main-btn">Đăng nhập</button>
                        </form>

                
                    </div>
                    <div id="registerForm" class="auth-form">
                        <div class="form-header">
                            <h4>Tạo tài khoản</h4>
                            <p>Đăng ký để khám phá cùng Lotus Vietnam Travel</p>
                        </div>
                        @if($hasRegisterError)
                            <div class="form-alert is-error">
                                {{ $errors->first('email') ?: $errors->first('name') ?: $errors->first('password') ?: $errors->first('password_confirmation') }}
                            </div>
                        @endif
                        <form method="POST" action="/register">
                            @csrf
                            <div class="input-group">
                                <div class="input-wrapper"><i class="fa fa-user input-icon-left"></i><input type="text" name="name" placeholder="Họ và tên" required></div>
                                <small class="input-note">Nhập đầy đủ họ và tên của bạn</small>
                            </div>
                            <div class="input-group">
                                <div class="input-wrapper"><i class="fa fa-envelope input-icon-left"></i><input type="email" name="email" placeholder="Email" required></div>
                                <small class="input-note">Chúng tôi không chia sẻ email của bạn</small>
                            </div>
                            <div class="input-group">
                                <div class="input-wrapper"><i class="fa fa-lock input-icon-left"></i><input type="password" name="password" class="password-field" placeholder="Mật khẩu" required><button type="button" class="toggle-password"><i class="fa fa-eye"></i></button></div>
                                <small class="input-note">Tối thiểu 8 ký tự, nên có cả chữ và số</small>
                            </div>
                            <div class="input-group">
                                <div class="input-wrapper"><i class="fa fa-lock input-icon-left"></i><input type="password" name="password_confirmation" class="password-field" placeholder="Xác nhận mật khẩu" required><button type="button" class="toggle-password"><i class="fa fa-eye"></i></button></div>
                                <small class="input-note">Nhập lại mật khẩu để xác nhận</small>
                            </div>
                            <button type="submit" class="main-btn">Tạo tài khoản</button>
                        </form>
                    </div>
                    <div id="forgotForm" class="auth-form">
                        <div class="form-header">
                            <h4>Quên mật khẩu?</h4>
                            <p>Nếu bạn cần lấy lại mật khẩu, hãy liên hệ quản trị viên để được cấp lại an toàn.</p>
                        </div>
                        <div class="input-group">
                            <div class="input-wrapper">
                                <i class="fa fa-shield input-icon-left"></i>
                                <input type="text" value="Liên hệ quản trị viên để lấy lại mật khẩu" readonly>
                            </div>
                            <small class="input-note">Hiện tại tính năng chat cần đăng nhập, nên nếu quên mật khẩu bạn hãy liên hệ admin hoặc hotline để được hỗ trợ.</small>
                        </div>
                        <button type="button" class="main-btn" data-dismiss="modal">Đã hiểu</button>
                        <div class="text-center mt-3"><a href="#" onclick="switchTab('login')">← Quay lại đăng nhập</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    setTimeout(() => {
        document.querySelectorAll('.custom-alert').forEach((alert) => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 4000);

    document.addEventListener('click', function (event) {
        const button = event.target.closest('.toggle-password');
        if (!button) return;
        const input = button.parentElement.querySelector('.password-field');
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            input.dataset.manualVisible = 'true';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            delete input.dataset.manualVisible;
            delete input.dataset.mobileReveal;
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    document.addEventListener('focusin', function (event) {
        const input = event.target.closest('.password-field');
        if (!input) return;

        const isSmallTouchDevice = window.matchMedia('(max-width: 767.98px)').matches;
        if (!isSmallTouchDevice) return;

        // iOS/Safari can fail to start typing on password fields inside animated modals.
        // Briefly switching to text on focus stabilizes the keyboard, then we restore masking.
        if (input.type === 'password' && !input.dataset.manualVisible) {
            input.type = 'text';
            input.dataset.mobileReveal = 'true';

            const toggleIcon = input.parentElement.querySelector('.toggle-password i');
            if (toggleIcon) {
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }

            setTimeout(() => {
                if (document.activeElement === input && input.dataset.mobileReveal === 'true') {
                    input.type = 'password';
                    delete input.dataset.mobileReveal;
                    if (toggleIcon && !input.dataset.manualVisible) {
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                    }
                }
            }, 150);
        }
    });

    document.addEventListener('pointerdown', function (event) {
        const wrapper = event.target.closest('.input-wrapper');
        if (!wrapper || event.target.closest('.toggle-password') || event.target.matches('input')) return;

        const input = wrapper.querySelector('input');
        if (!input) return;

        setTimeout(() => input.focus(), 0);
    });

    function switchTab(tab) {
        document.querySelectorAll('.tab-btn').forEach((btn) => btn.classList.remove('active'));
        document.querySelectorAll('.auth-form').forEach((form) => form.classList.remove('active'));
        if (tab === 'login') {
            document.querySelectorAll('.tab-btn')[0].classList.add('active');
            document.getElementById('loginForm').classList.add('active');
        } else if (tab === 'register') {
            document.querySelectorAll('.tab-btn')[1].classList.add('active');
            document.getElementById('registerForm').classList.add('active');
        } else if (tab === 'forgot') {
            document.getElementById('forgotForm').classList.add('active');
        }
    }

    $(document).ready(function () {
        const loginEmail = document.getElementById('loginEmail');
        const loginRemember = document.getElementById('loginRemember');
        const clearLoginEmailBtn = document.querySelector('.clear-input-btn[data-target="loginEmail"]');
        const authParam = new URLSearchParams(window.location.search).get('auth');
        const shouldOpenLogin = @json((bool) $hasLoginError);
        const shouldOpenRegister = @json((bool) $hasRegisterError);

        function syncClearButton(input, button) {
            if (!input || !button) return;
            button.classList.toggle('is-visible', input.value.trim().length > 0);
        }

        if (loginEmail && clearLoginEmailBtn) {
            syncClearButton(loginEmail, clearLoginEmailBtn);
            loginEmail.addEventListener('input', function () {
                syncClearButton(loginEmail, clearLoginEmailBtn);
            });
            clearLoginEmailBtn.addEventListener('click', function () {
                loginEmail.value = '';
                syncClearButton(loginEmail, clearLoginEmailBtn);
                loginEmail.focus();
            });
        }

        $('#authModal').on('show.bs.modal', function () {
            document.body.classList.add('auth-modal-open');
        });

        $('#authModal').on('hidden.bs.modal', function () {
            document.body.classList.remove('auth-modal-open');
            const passwordFields = this.querySelectorAll('.password-field');
            passwordFields.forEach((input) => {
                input.value = '';
                input.type = 'password';
            });
            this.querySelectorAll('.toggle-password i').forEach((icon) => {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            });
            if (loginRemember && !loginRemember.checked && loginEmail) {
                loginEmail.value = '';
            }
            syncClearButton(loginEmail, clearLoginEmailBtn);
        });

        if (shouldOpenRegister) {
            switchTab('register');
            $('#authModal').modal('show');
        } else if (shouldOpenLogin) {
            switchTab('login');
            $('#authModal').modal('show');
        } else if (authParam && ['login', 'register', 'forgot'].includes(authParam)) {
            switchTab(authParam);
            $('#authModal').modal('show');

            const cleanUrl = window.location.pathname + window.location.hash;
            window.history.replaceState({}, document.title, cleanUrl);
        }

        $('.nav-user-trigger').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            const $dropdown = $(this).closest('.nav-user-dropdown');
            const $menu = $dropdown.find('.nav-user-menu');
            $('.nav-notice-dropdown, .nav-user-dropdown').not($dropdown).removeClass('show').find('.dropdown-menu').removeClass('show');
            $dropdown.toggleClass('show');
            $menu.toggleClass('show');
            $(this).attr('aria-expanded', $dropdown.hasClass('show') ? 'true' : 'false');
        });

        $('.nav-bell-trigger').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            const $dropdown = $(this).closest('.nav-notice-dropdown');
            const $menu = $dropdown.find('.nav-notice-menu');
            $('.nav-notice-dropdown, .nav-user-dropdown').not($dropdown).removeClass('show').find('.dropdown-menu').removeClass('show');
            $dropdown.toggleClass('show');
            $menu.toggleClass('show');
            $(this).attr('aria-expanded', $dropdown.hasClass('show') ? 'true' : 'false');
            $(this).siblings('.nav-notice-pill').fadeOut(180);
        });

        $('.nav-user-dropdown, .nav-user-menu, .nav-notice-dropdown, .nav-notice-menu').on('click', function (event) {
            event.stopPropagation();
        });

        $(document).on('click', function () {
            $('.nav-notice-dropdown, .nav-user-dropdown').removeClass('show');
            $('.nav-notice-menu, .nav-user-menu').removeClass('show');
            $('.nav-bell-trigger, .nav-user-trigger').attr('aria-expanded', 'false');
        });
    });
    </script>
