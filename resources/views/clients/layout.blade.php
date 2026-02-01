    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Pacific - Travel Agency</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- CSS --}}
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

    {{-- HEADER --}}
    @include('clients.blocks.header')

    {{-- CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('clients.blocks.footer')

    {{-- JS --}}
    <script src="{{ asset('clients/js/jquery.min.js') }}"></script>
    <script src="{{ asset('clients/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
