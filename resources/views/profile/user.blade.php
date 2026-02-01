@extends('clients.layout')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image:  url('{{ asset('clients/images/bg_1.jpg')}}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
         <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="fa fa-chevron-right"></i></a></span> <span>profile <i class="fa fa-chevron-right"></i></span></p>
         <h1 class="mb-0 bread">thông tin cá nhân</h1>
     </div>
 </div>
</div>
</section>
<div class="profile-wrapper container my-5">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-md-3">
            <div class="profile-sidebar">
                <h6 class="mb-3">User profile</h6>

                <ul class="list-unstyled">
                    <li class="active">👤 Hồ sơ</li>
                    <li>🧳 Đơn đặt tour</li>
                    <li>❤️ Wishlist</li>
                    <li>📍 Địa chỉ</li>
                </ul>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-link text-danger p-0 mt-3">
                        🚪 Sign out
                    </button>
                </form>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-md-9">
            <h4 class="mb-4">User profile</h4>

            {{-- BASIC INFO --}}
            <div class="profile-card mb-4">
                <div class="d-flex align-items-center">
                    <img src="https://i.pravatar.cc/100"
                         class="rounded-circle me-3" width="80">

                    <div>
                        <strong>{{ $user->name }}</strong><br>
                        <small>{{ $user->email }}</small>
                    </div>
                </div>

                <form class="mt-4" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Họ tên</label>
                            <input class="form-control" name="name" value="{{ $user->name }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input class="form-control" name="email" value="{{ $user->email }}">
                        </div>
                    </div>

                    <button class="btn btn-primary">Cập nhật</button>
                </form>
            </div>

            {{-- SECURITY --}}
            <div class="profile-card mb-4">
                <h6>Bảo mật</h6>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input type="password" name="current_password"
                                   placeholder="Mật khẩu cũ" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="password"
                                   placeholder="Mật khẩu mới" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="password_confirmation"
                                   placeholder="Nhập lại" class="form-control">
                        </div>
                    </div>

                    <button class="btn btn-outline-primary mt-3">
                        Đổi mật khẩu
                    </button>
                </form>
            </div>

            {{-- BOOKINGS --}}
            <div class="profile-card">
                <h6>Lịch sử đặt tour</h6>

                @forelse($bookings as $booking)
                    <div class="booking-item">
                        <strong>{{ $booking->tour->name }}</strong>
                        <span>{{ number_format($booking->total_price) }} đ</span>
                        <small>{{ $booking->created_at->format('d/m/Y') }}</small>
                    </div>
                @empty
                    <p>Bạn chưa đặt tour nào.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
