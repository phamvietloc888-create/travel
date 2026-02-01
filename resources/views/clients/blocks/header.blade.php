

</head>
<body>

    {{-- 🔔 THÔNG BÁO --}}
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show alert-top" role="alert">
            <i class="fas fa-check-circle"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-top" role="alert">
            <i class="fas fa-exclamation-circle"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
   
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="{{ route('home') }}">Pacific<span>Travel Agency</span></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
			
				<span class="oi oi-menu"></span> Menu
			</button>
			
			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                       <a href="{{ route('home') }}" class="nav-link">Home</a>
                   </li>

                   <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}" class="nav-link">About</a>
                   </li>

                   <li class="nav-item {{ request()->routeIs('destination') ? 'active' : '' }}">
                    <a href="{{ route('destination') }}" class="nav-link">destination</a>
                   </li>
                     <li class="nav-item {{ request()->routeIs('tours') ? 'active' : '' }}">
                     <a href="{{ route('tours') }}" class="nav-link">Tour</a>
                    </li>
                   <li class="nav-item {{ request()->routeIs('hotel') ? 'active' : '' }}">
                    <a href="{{ route('hotel') }}" class="nav-link">Hotel</a>
                   </li>

                   <li class="nav-item {{ request()->routeIs('blog') ? 'active' : '' }}">
                    <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                   </li>

                   <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                   </li>
				</ul>
			</div>
		</div>
	<div class="nav-auth">
   @auth
<div class="dropdown d-inline">
    <a href="#" class="text-white dropdown-toggle"
       id="userDropdown"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">

        Hi, {{ auth()->user()->name }}
    </a>

    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{ route('profile.user') }}">
            👤 Profile
        </a>
         
        @if(auth()->user()->isAdmin())
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                🛠 Admin
            </a>
        @endif
        <div class="dropdown-divider"></div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
                🚪 Logout
            </button>
        </form>
    </div>
</div>

    @else
        <a href="#" class="auth-btn" data-toggle="modal" data-target="#authModal">
            Login
        </a>
    @endauth
</div>
	</nav>	
	
	<!-- END nav -->

<!-- Auth Modal -->
<div class="modal fade auth-modal" id="authModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content auth-modal">
            <div class="modal-body p-0">
                <div class="row no-gutters">

                    <!-- ASIDE -->
                    <div class="col-md-5 d-none d-md-flex auth-aside"
                        style="--auth-bg: url('{{ asset('clients/images/auth-bg.jpg') }}');">
                        <div class="p-4 auth-aside-inner">
                            <h4 class="text-white">Welcome back </h4>
                            <p class="text-white-50 small">
                                Login or create an account to continue
                            </p>
                        </div>
                    </div>

                    <!-- FORM -->
                    <div class="col-md-7">
                        <div class="p-4">

                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <h5 class="mb-1">Account</h5>
                                    <p class="small text-muted mb-0">
                                        Secure access to your account
                                    </p>
                                </div>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>

                            <!-- TABS -->
                            <ul class="nav nav-pills auth-tabs mb-3">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#login-pane">
                                        Login
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#register-pane">
                                        Register
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <!-- LOGIN -->
                                <div class="tab-pane fade show active" id="login-pane">
                                    <form method="POST" action="/login">
                                        @csrf

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email"
                                                   class="form-control"
                                                   placeholder="Enter your email"
                                                   required>
                                            <small class="text-muted">
                                                Use the email you registered with
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password"
                                                   class="form-control"
                                                   placeholder="Enter your password"
                                                   required>
                                            <small class="text-muted">
                                                Minimum 8 characters
                                            </small>
                                        </div>

                                        <button class="btn btn-primary btn-block mt-3">
                                            Login
                                        </button>
                                    </form>
                                </div>

                                <!-- REGISTER -->
                                <div class="tab-pane fade" id="register-pane">
                                    <form method="POST" action="/register">
                                        @csrf

                                        <div class="form-group">
                                            <label>Full name</label>
                                            <input type="text" name="name"
                                                   class="form-control"
                                                   placeholder="Your full name"
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email"
                                                   class="form-control"
                                                   placeholder="example@email.com"
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password"
                                                   class="form-control"
                                                   placeholder="At least 8 characters"
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <label>Confirm password</label>
                                            <input type="password" name="password_confirmation"
                                                   class="form-control"
                                                   placeholder="Re-enter your password"
                                                   required>
                                        </div>

                                        <button class="btn btn-primary btn-block mt-3">
                                            Create account
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


	<script>
		// Auto-dismiss alerts after 4 seconds
		document.addEventListener('DOMContentLoaded', function() {
			const alerts = document.querySelectorAll('.alert-top');
			alerts.forEach(alert => {
				setTimeout(() => {
					alert.style.animation = 'slideOut 0.3s ease-out forwards';
					setTimeout(() => {
						alert.remove();
					}, 300);
				}, 4000);
			});
		});
	</script>