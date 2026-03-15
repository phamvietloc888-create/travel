@extends('clients.layout')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight"
    style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>Profile <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Hồ sơ cá nhân</h1>
            </div>
        </div>
    </div>
</section>
<div class="profile-wrapper">
<div class="container profile-container">
<div class="row">

<!-- SIDEBAR -->
<div class="col-lg-3">
<div class="profile-card profile-sidebar">

<a href="{{ route('profile') }}"
class="{{ request()->routeIs('profile') ? 'active' : '' }}">
<i class="fa fa-user"></i> Hồ sơ của tôi
</a>

<a href="{{ route('profile.bookings') }}"
class="{{ request()->routeIs('profile.bookings') ? 'active' : '' }}">
<i class="fa fa-suitcase"></i> Tour đã đặt
</a>

<a href="{{ route('profile.wishlist') }}"
class="{{ request()->routeIs('profile.wishlist') ? 'active' : '' }}">
<i class="fa fa-heart"></i> Danh sách yêu thích
</a>

<hr>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn logout w-100 text-left">
<i class="fa fa-sign-out"></i> Đăng xuất
</button>
</form>

</div>
</div>

<!-- MAIN -->
<div class="col-lg-9">

<!-- HEADER -->
<div class="profile-card mb-4">
<div class="d-flex align-items-center gap-4">

<div>
<h2 class="profile-name">{{ $user->name }}</h2>

<span class="profile-badge">
<i class="fa fa-star"></i> Gold Member
</span>

<p class="text-muted mt-3">
"Đam mê khám phá những vùng đất mới."
</p>

<div class="profile-stats">
<div>
<h3>{{ $user->bookings()->count() }}</h3>
<span>Chuyến đi</span>
</div>

<div>
<h3>{{ $user->reviews()->count() ?? 0 }}</h3>
<span>Đánh giá</span>
</div>

<div>
<h3>{{ $user->points ?? 0 }}</h3>
<span>Pacific Point</span>
</div>
</div>

</div>
</div>
</div>

<!-- FORM -->
<div class="profile-card profile-form">

<h4 class="mb-4">
<i class="fa fa-edit text-warning"></i> Thông tin chi tiết
</h4>

<form method="POST" action="{{ route('profile.update') }}">
@csrf

<div class="row">

<div class="col-md-6 mb-3">
<label>Họ và tên</label>
<input name="name" value="{{ $user->name }}">
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input value="{{ $user->email }}" readonly>
</div>

<div class="col-md-6 mb-3">
<label>Số điện thoại</label>
<input name="phone" value="{{ $user->phone }}">
</div>

<div class="col-md-6 mb-3">
<label>Ngày sinh</label>
<input type="date" name="birthday" value="{{ $user->birthday }}">
</div>

<div class="col-12 mb-3">
<label>Địa chỉ</label>
<input name="address" value="{{ $user->address }}">
</div>

</div>

<div class="text-right mt-4">
<button class="profile-btn">Cập nhật thông tin</button>
</div>

</form>

</div>

</div>
</div>
</div>
</div>

<style>
.profile-wrapper { background: linear-gradient(180deg, #f6f9fc 0%, #eef3f8 100%); padding: 48px 0 72px; }
.profile-card { background: #fff; border: 1px solid #e5edf5; border-radius: 24px; box-shadow: 0 18px 38px rgba(36, 60, 88, 0.08); }
.profile-sidebar { padding: 20px; display: grid; gap: 10px; }
.profile-sidebar a { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-radius: 14px; color: #34475d; font-weight: 600; background: #f8fbfe; text-decoration: none; }
.profile-sidebar a.active { background: linear-gradient(135deg, #2c83c5 0%, #359de0 100%); color: #fff; }
.profile-sidebar hr { margin: 10px 0; }
.logout { border-radius: 14px; padding: 14px 16px; background: #fff3f2; color: #d85c4a; border: 0; font-weight: 700; }
.logout:hover { background: #ffe8e4; color: #c84d3c; }
.profile-card.mb-4 { padding: 28px; }
.profile-name { margin: 0; color: #23384f; font-size: 34px; font-weight: 800; }
.profile-badge { display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; padding: 8px 14px; border-radius: 999px; background: #eef6fd; color: #2c83c5; font-size: 13px; font-weight: 700; }
.profile-stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-top: 24px; }
.profile-stats > div { padding: 16px; border-radius: 18px; background: #f8fbfe; text-align: center; }
.profile-stats h3 { margin: 0 0 6px; color: #23384f; font-size: 28px; font-weight: 800; }
.profile-stats span { color: #7b8b9d; font-size: 14px; }
.profile-form { padding: 28px; }
.profile-form h4 { color: #23384f; font-size: 26px; font-weight: 800; }
.profile-form label { display: block; margin-bottom: 10px; color: #52657c; font-weight: 700; }
.profile-form input { width: 100%; min-height: 54px; border-radius: 16px; border: 1px solid #d9e5f0; background: #fdfefe; padding: 0 16px; color: #23384f; box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.03); }
.profile-form input:focus { outline: none; border-color: #2c83c5; box-shadow: 0 0 0 4px rgba(44, 131, 197, 0.12); }
.profile-btn { display: inline-flex; align-items: center; justify-content: center; min-width: 220px; min-height: 52px; border: 0; border-radius: 16px; background: linear-gradient(135deg, #2c83c5 0%, #359de0 100%); color: #fff; font-weight: 800; }
.profile-btn:hover { background: linear-gradient(135deg, #236ea8 0%, #2d8bc8 100%); }
@media (max-width: 991.98px) {
    .profile-card.mb-4 .d-flex.align-items-center { flex-direction: column; align-items: flex-start !important; }
}
@media (max-width: 767.98px) {
    .profile-wrapper { padding: 32px 0 56px; }
    .profile-card.mb-4,.profile-form { padding: 22px; }
    .profile-name { font-size: 28px; }
    .profile-stats { grid-template-columns: 1fr; }
    .profile-btn { width: 100%; }
}
</style>

@endsection
