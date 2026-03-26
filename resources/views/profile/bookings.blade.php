@extends('clients.layout')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span>
                    <span>Tour đã đặt <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Tour đã đặt</h1>
            </div>
        </div>
    </div>
</section>

<div class="profile-wrapper">
    <div class="container profile-container">
        <div class="row">
            <div class="col-lg-3">
                <div class="profile-card profile-sidebar">
                    <a href="{{ route('profile') }}"><i class="fa fa-user"></i> Hồ sơ của tôi</a>
                    <a href="{{ route('profile.bookings') }}" class="active"><i class="fa fa-suitcase"></i> Tour đã đặt</a>
                  
                    <hr>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn logout w-100 text-left"><i class="fa fa-sign-out"></i> Đăng xuất</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="profile-card bookings-head mb-4">
                    <div>
                        <h2>Lịch sử booking của bạn</h2>
                        <p>Theo dõi trạng thái xác nhận, thanh toán và xem lại những tour bạn đã đặt.</p>
                    </div>
                    <div class="booking-count">{{ $bookings->total() }} booking</div>
                </div>

                @if($bookings->isEmpty())
                    <div class="profile-card empty-bookings">
                        <div class="empty-icon"><i class="fa fa-suitcase"></i></div>
                        <h3>Bạn chưa có tour nào</h3>
                        <p>Khám phá thêm những hành trình mới và gửi yêu cầu đặt tour ngay hôm nay.</p>
                        <a href="{{ route('tours.index') }}" class="btn explore-btn">Xem danh sách tour</a>
                    </div>
                @else
                    <div class="booking-list">
                        @foreach($bookings as $booking)
                            @php
                                $tour = $booking->tour;
                                $durationDays = $tour->duration_days ?? 1;
                                $durationNights = max($durationDays - 1, 0);
                                $travelDate = $booking->travel_date?->format('d/m/Y') ?? 'Chưa xác định';
                                $endDate = $booking->travel_date?->copy()->addDays($durationNights)->format('d/m/Y') ?? 'Chưa xác định';
                                $statusLabel = match($booking->booking_status) {
                                    'CONFIRMED' => 'Đã xác nhận',
                                    'COMPLETED' => 'Hoàn tất',
                                    'CANCELED' => 'Đã hủy',
                                    default => 'Chờ xác nhận',
                                };
                                $canCancel = in_array($booking->booking_status, ['PENDING', 'CONFIRMED'], true);
                                $canDelete = $booking->booking_status === 'CANCELED';
                                $canPay = $booking->canUserPay();
                                $paymentLabel = match($booking->payment_status) {
                                    'PAID' => 'Đã thanh toán',
                                    'FAILED' => 'Thanh toán thất bại',
                                    'REFUNDED' => 'Đã hoàn tiền',
                                    'PENDING' => 'Đã gửi thanh toán',
                                    default => $booking->booking_status === 'CONFIRMED' ? 'Chờ bạn thanh toán' : 'Chưa mở thanh toán',
                                };
                                $paymentNoticeClass = match($booking->payment_status) {
                                    'PAID' => 'is-success',
                                    'FAILED' => 'is-danger',
                                    'PENDING' => 'is-pending',
                                    default => '',
                                };
                            @endphp

                            <div class="profile-card booking-item">
                                <div class="booking-main">
                                    <div class="booking-image-wrap">
                                        @if(!empty($tour?->thumbnail_url))
                                            <img src="{{ $tour->thumbnail_url }}" alt="{{ $tour?->name }}" class="booking-image">
                                        @else
                                            <div class="booking-image fallback"><i class="fa fa-image"></i></div>
                                        @endif
                                    </div>

                                    <div class="booking-content">
                                        <div class="booking-top">
                                            <div>
                                                <div class="booking-code">{{ $booking->booking_code ?? ('#' . $booking->id) }}</div>
                                                <h3>{{ $tour?->name ?? 'Tour không tồn tại' }}</h3>
                                            </div>
                                            <div class="booking-price">{{ number_format($booking->total_amount, 0, ',', '.') }} đ</div>
                                        </div>

                                        <div class="booking-meta">
                                            <span><i class="fa fa-calendar"></i> Ngày đi: {{ $travelDate }}</span>
                                            <span><i class="fa fa-flag-checkered"></i> Ngày về: {{ $endDate }}</span>
                                            <span><i class="fa fa-moon-o"></i> {{ $durationDays }} ngày {{ $durationNights }} đêm</span>
                                            <span><i class="fa fa-users"></i> {{ ($booking->adult_qty ?? 0) + ($booking->child_qty ?? 0) }} khách</span>
                                        </div>

                                        @if(!empty($booking->customer_notice))
                                            <div class="booking-notice {{ $paymentNoticeClass }}">
                                                <i class="fa fa-bell"></i>
                                                <span>{{ $booking->customer_notice }}</span>
                                            </div>
                                        @endif

                                        <div class="booking-status-row">
                                            <span class="status-chip booking-status {{ $booking->booking_status === 'CANCELED' ? 'is-canceled' : '' }}">{{ $statusLabel }}</span>
                                            <span class="status-chip payment-status {{ $paymentNoticeClass }}">{{ $paymentLabel }}</span>
                                        </div>

                                        <div class="booking-actions">
                                            <a href="{{ route('booking.confirmation', $booking) }}" class="btn booking-btn primary">Xem booking</a>
                                            @if($canPay)
                                                <a href="{{ route('booking.payment', $booking) }}" class="btn booking-btn pay">Thanh toán</a>
                                            @endif
                                            @if(!empty($tour?->slug))
                                                <a href="{{ route('tours.show', $tour->slug) }}" class="btn booking-btn secondary">Xem tour</a>
                                            @endif
                                            @if($canCancel)
                                                <form method="POST" action="{{ route('profile.bookings.cancel', $booking) }}" onsubmit="return confirm('Bạn có chắc muốn hủy tour này?');" class="cancel-booking-form">
                                                    @csrf
                                                    <button type="submit" class="btn booking-btn danger">Hủy tour</button>
                                                </form>
                                            @endif
                                            @if($canDelete)
                                                <form method="POST" action="{{ route('profile.bookings.delete', $booking) }}" onsubmit="return confirm('Bạn có chắc muốn xóa booking này?');" class="cancel-booking-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn booking-btn delete">Xóa booking</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="booking-pagination">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.profile-wrapper { background: linear-gradient(180deg, #f6f9fc 0%, #eef3f8 100%); padding: 48px 0 72px; }
.profile-card { background: #fff; border: 1px solid #e5edf5; border-radius: 24px; box-shadow: 0 18px 38px rgba(36, 60, 88, 0.08); }
.profile-sidebar { padding: 20px; display: grid; gap: 10px; }
.profile-sidebar a { padding: 14px 16px; border-radius: 14px; color: #34475d; font-weight: 600; background: #f8fbfe; }
.profile-sidebar a.active { background: linear-gradient(135deg, #2c83c5 0%, #359de0 100%); color: #fff; }
.profile-sidebar hr { margin: 10px 0; }
.logout { border-radius: 14px; padding: 14px 16px; background: #fff3f2; color: #d85c4a; }
.bookings-head { padding: 26px 28px; display: flex; justify-content: space-between; align-items: center; gap: 16px; }
.bookings-head h2 { margin: 0 0 8px; color: #23384f; font-size: 34px; font-weight: 800; }
.bookings-head p { margin: 0; color: #7b8b9d; }
.booking-count { padding: 10px 16px; border-radius: 999px; background: #eef6fd; color: #2c83c5; font-weight: 700; white-space: nowrap; }
.empty-bookings { padding: 48px 24px; text-align: center; }
.empty-icon { width: 72px; height: 72px; margin: 0 auto 16px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #ebf5fc; color: #2c83c5; font-size: 28px; }
.empty-bookings h3 { color: #23384f; font-size: 28px; margin-bottom: 10px; }
.empty-bookings p { color: #7b8b9d; margin-bottom: 20px; }
.explore-btn,.booking-btn.primary { background: linear-gradient(135deg, #2c83c5 0%, #359de0 100%); color: #fff; border-radius: 14px; padding: 12px 18px; font-weight: 700; }
.booking-list { display: grid; gap: 18px; }
.booking-item { padding: 22px; overflow: hidden; }
.booking-main { display: grid; grid-template-columns: 220px 1fr; gap: 22px; }
.booking-content { min-width: 0; }
.booking-image { width: 100%; height: 190px; object-fit: cover; border-radius: 18px; }
.booking-image.fallback { background: #eef5fb; color: #90a5bb; display: flex; align-items: center; justify-content: center; font-size: 36px; }
.booking-top { display: flex; justify-content: space-between; gap: 18px; align-items: flex-start; margin-bottom: 14px; }
.booking-code { display: inline-block; padding: 6px 12px; border-radius: 999px; background: #f3f8fc; color: #7f91a5; font-size: 12px; font-weight: 700; margin-bottom: 10px; }
.booking-content h3 { color: #23384f; font-size: 30px; line-height: 1.3; margin: 0; overflow-wrap: anywhere; }
.booking-price { color: #ff0000; font-size: 28px; font-weight: 800; white-space: nowrap; }
.booking-meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px 16px; color: #71839a; margin-bottom: 16px; }
.booking-meta span { min-width: 0; }
.booking-notice { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; margin-bottom: 16px; border-radius: 16px; background: #f7fbff; border: 1px solid #d7e8f7; color: #45627f; }
.booking-notice.is-success { background: #eefaf2; border-color: #bfe7cb; color: #167c4d; }
.booking-notice.is-pending { background: #fff8eb; border-color: #f3deae; color: #9a6b08; }
.booking-notice.is-danger { background: #fff1ef; border-color: #f1c7c0; color: #c9503d; }
.booking-status-row { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; }
.status-chip { padding: 8px 12px; border-radius: 999px; font-size: 13px; font-weight: 700; }
.booking-status { background: #fff4dd; color: #c58b18; }
.booking-status.is-canceled { background: #fff1ef; color: #d65c4a; }
.payment-status { background: #eef6fd; color: #2c83c5; }
.payment-status.is-success { background: #eefaf2; color: #167c4d; }
.payment-status.is-pending { background: #fff8eb; color: #9a6b08; }
.payment-status.is-danger { background: #fff1ef; color: #c9503d; }
.booking-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.cancel-booking-form { margin: 0; }
.booking-btn.danger,.booking-btn.delete,.booking-btn.secondary,.booking-btn.pay { border-radius: 14px; padding: 12px 18px; font-weight: 700; }
.booking-btn.danger { background: #fff2f1; border: 1px solid #f3c5be; color: #d65c4a; }
.booking-btn.delete { background: #fbeaea; border: 1px solid #e9b4b4; color: #bf3d3d; }
.booking-btn.secondary { background: #fff; border: 1px solid #d7e3ef; color: #2f4359; }
.booking-btn.pay { background: #edf9f2; border: 1px solid #bfe7cb; color: #13834d; }
.booking-pagination { margin-top: 24px; display: flex; justify-content: center; }
.booking-pagination nav > div:first-child { display: none; }
.booking-pagination nav > div:last-child > span,.booking-pagination nav > div:last-child a { display: inline-flex; align-items: center; justify-content: center; min-width: 42px; height: 42px; margin: 0 4px; border-radius: 12px; border: 1px solid #dbe6f1; background: #fff; color: #486078; font-weight: 700; box-shadow: 0 10px 22px rgba(36, 60, 88, 0.06); }
.booking-pagination nav > div:last-child span[aria-current="page"] span { background: linear-gradient(135deg, #2c83c5 0%, #359de0 100%); border-color: transparent; color: #fff; }
@media (max-width: 991.98px) {
    .bookings-head { flex-direction: column; align-items: flex-start; }
    .booking-main { grid-template-columns: 1fr; }
    .booking-meta { grid-template-columns: 1fr; }
}
@media (max-width: 767.98px) {
    .profile-wrapper { padding: 32px 0 56px; }
    .bookings-head h2,.booking-content h3 { font-size: 24px; }
    .booking-top { flex-direction: column; }
    .booking-price { font-size: 24px; }
}
</style>
@endsection
