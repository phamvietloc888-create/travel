<!DOCTYPE html>
<html lang="en">
<head>
	<title>Pacific - Free Bootstrap 4 Template by Colorlib</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Arizonia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="{{ asset('clients/css/bootstrap.min.css') }}">

<link rel="stylesheet" href="{{ asset('clients/css/animate.css') }}">
<link rel="stylesheet" href="{{ asset('clients/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('clients/css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('clients/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('clients/css/jquery.timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('clients/css/flaticon.css') }}">
<link rel="stylesheet" href="{{ asset('clients/css/style.css') }}">


</head>
<body>
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
		 <a href="login.php" class="auth-btn">Login</a>
		</div>
	</nav>	
	
	<!-- END nav -->