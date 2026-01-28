
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.html">Pacific<span>Travel Agency</span></a>
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
                    <a href="{{ route('destination') }}" class="nav-link">Destination</a>
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
		
		<a href="#" class="auth-btn" data-toggle="modal" data-target="#loginModal">Login</a>
		</div>
		
	</nav>	
			<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content auth-modal">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="text-center mt-3">
          Chưa có tài khoản?
          <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#signupModal">Sign up</a>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="signupModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content auth-modal">
      <div class="modal-header">
        <h5 class="modal-title">Sign Up</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Full Name">
          </div>
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-primary btn-block">Create Account</button>

        </form>
        <p class="text-center mt-3">
          Đã có tài khoản?
          <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Login</a>
        </p>
      </div>
    </div>
  </div>
</div>
	<!-- END nav -->