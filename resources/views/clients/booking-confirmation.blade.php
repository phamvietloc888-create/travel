@extends('clients.layout')

@section('content')
@php
    $bookingCode = $booking->booking_code ?? ('#' . $booking->id);
    $travelDate = $booking->travel_date?->format('d/m/Y') ?? 'Chưa xác định';
    $bookingDate = $booking->created_at?->format('d/m/Y H:i') ?? '';
    $guestCount = ($booking->adult_qty ?? 0) + ($booking->child_qty ?? 0);
    $durationDays = $booking->tour->duration_days ?? 1;
    $durationNights = max($durationDays - 1, 0);
    $endDate = $booking->travel_date?->copy()->addDays($durationNights)->format('d/m/Y') ?? 'Chưa xác định';
    $paymentLabel = match($booking->payment_status) {
        'PAID' => 'Đã thanh toán',
        'PENDING' => 'Đã gửi thanh toán',
        'FAILED' => 'Thanh toán thất bại',
        'REFUNDED' => 'Đã hoàn tiền',
        default => 'Chưa thanh toán',
    };
    $bookingLabel = match($booking->booking_status) {
        'CONFIRMED' => 'Đã được admin xác nhận',
        'COMPLETED' => 'Hoàn tất',
        'CANCELED' => 'Đã hủy',
        default => 'Đang chờ admin duyệt',
    };
    $heroTitle = match(true) {
        $booking->booking_status === 'CANCELED' => 'Booking đã hủy',
        $booking->payment_status === 'PAID' => 'Thanh toán thành công',
        $booking->payment_status === 'PENDING' => 'Đã gửi thông tin thanh toán',
        $booking->booking_status === 'CONFIRMED' => 'Booking đã được duyệt',
        default => 'Đã gửi yêu cầu đặt tour',
    };
    $heroMessage = match(true) {
        $booking->booking_status === 'CANCELED' => 'Bạn có thể đặt lại tour khác bất cứ lúc nào khi sẵn sàng.',
        $booking->payment_status === 'PAID' => 'Admin đã xác nhận thanh toán. Bạn chỉ cần theo dõi lịch trình trong mục booking.',
        $booking->payment_status === 'PENDING' => 'Hệ thống đã ghi nhận thông tin thanh toán và đang chờ admin xác nhận.',
        $booking->booking_status === 'CONFIRMED' => 'Admin đã mở bước thanh toán cho booking này. Bạn có thể thanh toán ngay hoặc hủy nếu đổi kế hoạch.',
        default => 'Booking đã vào admin để duyệt. Khi được xác nhận, chuông thông báo bên cạnh tài khoản sẽ hiển thị tin mới.',
    };
@endphp

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 text-center pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span>
                    <span>Booking <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Theo dõi booking</h1>
            </div>
        </div>
    </div>
</section>

<div class="confirmation-page py-5">
    <div class="container">
        <div class="confirmation-shell">
            <div class="confirmation-steps">
                <div class="step-pill completed"><span>1</span><strong>Gửi yêu cầu</strong></div>
                <div class="step-pill {{ $booking->booking_status === 'PENDING' ? 'active' : 'completed' }}"><span>2</span><strong>Admin duyệt</strong></div>
                <div class="step-pill {{ $booking->canUserPay() || in_array($booking->payment_status, ['PENDING', 'PAID'], true) ? 'active' : '' }}"><span>3</span><strong>Thanh toán</strong></div>
            </div>

            <div class="success-state text-center">
                <div class="success-icon {{ $booking->booking_status === 'CANCELED' ? 'is-canceled' : '' }}">
                    <i class="fa {{ $booking->booking_status === 'CANCELED' ? 'fa-ban' : 'fa-check' }}"></i>
                </div>
                <div class="success-alert {{ $booking->booking_status === 'CANCELED' ? 'is-canceled' : '' }}">
                    <i class="fa {{ $booking->booking_status === 'CANCELED' ? 'fa-exclamation-circle' : 'fa-bell' }}"></i>
                    {{ $heroTitle }}. Mã booking của bạn là {{ $bookingCode }}.
                </div>
                <h2>{{ $heroTitle }}</h2>
                <p>{{ $heroMessage }}</p>

                @if($booking->customer_notice)
                    <div class="notice-panel">
                        <strong>Thông báo mới từ hệ thống:</strong>
                        <span>{{ $booking->customer_notice }}</span>
                    </div>
                @endif
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-lg-8">
                    <div class="info-card mb-4">
                        <div class="info-card-title">
                            <div class="title-icon"><i class="fa fa-map"></i></div>
                            <h4>Chi tiết hành trình</h4>
                        </div>
                        <div class="journey-grid">
                            <div class="journey-item">
                                <span class="item-label">Tên tour</span>
                                <strong>{{ $booking->tour->name }}</strong>
                                <div class="item-note"><i class="fa fa-moon-o"></i> {{ $durationDays }} ngày {{ $durationNights }} đêm</div>
                            </div>
                            <div class="journey-item">
                                <span class="item-label">Ngày khởi hành</span>
                                <strong>{{ $travelDate }}</strong>
                                <div class="item-note">Kết thúc: {{ $endDate }}</div>
                            </div>
                            <div class="journey-item">
                                <span class="item-label">Số khách</span>
                                <strong>{{ $guestCount }} người</strong>
                                <div class="item-note">Người lớn: {{ $booking->adult_qty }} | Trẻ em: {{ $booking->child_qty }}</div>
                            </div>
                            <div class="journey-item">
                                <span class="item-label">Thời điểm tạo booking</span>
                                <strong>{{ $bookingDate }}</strong>
                                <div class="item-note">Admin sẽ xử lý booking này trong danh sách booking.</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-card mb-4">
                        <div class="info-card-title">
                            <div class="title-icon"><i class="fa fa-user"></i></div>
                            <h4>Thông tin khách hàng</h4>
                        </div>
                        <div class="customer-grid">
                            <div class="customer-item">
                                <span class="item-label">Họ và tên</span>
                                <strong>{{ $booking->customer_name }}</strong>
                            </div>
                            <div class="customer-item">
                                <span class="item-label">Số điện thoại</span>
                                <strong>{{ $booking->customer_phone }}</strong>
                            </div>
                            <div class="customer-item customer-item-email">
                                <span class="item-label">Email</span>
                                <strong>{{ $booking->customer_email ?: 'Chưa cung cấp' }}</strong>
                            </div>
                        </div>

                        @if($booking->note || $booking->admin_note)
                            <div class="note-grid">
                                @if($booking->note)
                                    <div class="note-box">
                                        <span class="item-label">Ghi chú của khách</span>
                                        <p>{{ $booking->note }}</p>
                                    </div>
                                @endif
                                @if($booking->admin_note)
                                    <div class="note-box admin">
                                        <span class="item-label">Tin nhắn từ admin</span>
                                        <p>{{ $booking->admin_note }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="confirmation-actions">
                        @if($booking->canUserPay())
                            <a href="{{ route('booking.payment', $booking) }}" class="btn action-btn primary-btn">
                                <i class="fa fa-credit-card"></i>Thanh toán ngay
                            </a>
                        @endif
                        <a href="{{ route('profile.bookings') }}" class="btn action-btn secondary-btn">
                            <i class="fa fa-suitcase"></i>Xem tất cả booking
                        </a>
                        @if(!empty($booking->tour?->slug))
                            <a href="{{ route('tours.show', $booking->tour->slug) }}" class="btn action-btn secondary-btn">
                                <i class="fa fa-map-o"></i>Xem lại tour
                            </a>
                        @endif
                        @if(in_array($booking->booking_status, ['PENDING', 'CONFIRMED'], true))
                            <form method="POST" action="{{ route('profile.bookings.cancel', $booking) }}" onsubmit="return confirm('Bạn có chắc muốn hủy booking này?');">
                                @csrf
                                <button type="submit" class="btn action-btn danger-btn">
                                    <i class="fa fa-times-circle"></i>Hủy tour
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="summary-card-title">
                            <i class="fa fa-money"></i>
                            <span>Trạng thái booking</span>
                        </div>
                        <div class="summary-card-body">
                            <div class="summary-row">
                                <span>Booking</span>
                                <strong class="status-pill">{{ $bookingLabel }}</strong>
                            </div>
                            <div class="summary-row">
                                <span>Thanh toán</span>
                                <strong>{{ $paymentLabel }}</strong>
                            </div>
                            <div class="summary-row">
                                <span>Mở thanh toán</span>
                                <strong>{{ $booking->payment_ready_at?->format('d/m/Y H:i') ?? 'Chưa mở' }}</strong>
                            </div>
                            <div class="summary-total">
                                <span>Tổng cộng</span>
                                <strong>{{ number_format($booking->total_amount, 0, ',', '.') }} VND</strong>
                            </div>
                            <div class="summary-safe">
                                <i class="fa fa-shield"></i>
                                Theo dõi biểu tượng chuông để nhận xác nhận booking và thông báo mới.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.confirmation-page { background: linear-gradient(180deg, #f6f9fc 0%, #eef3f8 100%); }
.confirmation-shell { max-width: 1100px; margin: 0 auto; }
.confirmation-steps { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 28px; }
.step-pill { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 999px; background: #fff; border: 1px solid #dce6f0; color: #87a0b1; font-size: 14px; }
.step-pill span { width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: #edf3f7; font-size: 12px; font-weight: 700; }
.step-pill.completed,.step-pill.active { color: #1fae6b; border-color: #bde8d2; }
.step-pill.completed span,.step-pill.active span { background: #1fb874; color: #fff; }
.success-state { margin-bottom: 34px; }
.success-icon { width: 78px; height: 78px; margin: 0 auto 18px; border-radius: 50%; background: #dff5ea; color: #1fb874; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 12px 30px rgba(31, 184, 116, 0.18); }
.success-icon.is-canceled { background: #fdecec; color: #d65c4a; box-shadow: 0 12px 30px rgba(214, 92, 74, 0.18); }
.success-alert { display: inline-flex; align-items: center; gap: 10px; padding: 10px 16px; margin-bottom: 18px; border-radius: 999px; background: #effbf5; border: 1px solid #c9edd8; color: #1b9860; font-weight: 600; }
.success-alert.is-canceled { background: #fff1ef; border-color: #f1c7c0; color: #c9503d; }
.success-state h2 { margin-bottom: 10px; color: #22364d; font-size: 42px; font-weight: 800; }
.success-state p { max-width: 700px; margin: 0 auto 18px; color: #7c8b9c; font-size: 16px; }
.notice-panel { display: inline-grid; gap: 8px; max-width: 760px; padding: 16px 18px; text-align: left; border-radius: 20px; background: #fff; border: 1px solid #e1e9f1; color: #52667d; }
.info-card,.summary-card { background: #fff; border: 1px solid #e5edf5; border-radius: 22px; box-shadow: 0 16px 38px rgba(36, 60, 88, 0.08); }
.info-card { padding: 24px; }
.info-card-title,.summary-card-title { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; }
.info-card-title h4,.summary-card-title span { margin: 0; color: #263a52; font-size: 23px; font-weight: 700; }
.title-icon { width: 40px; height: 40px; border-radius: 12px; background: #ebf5fc; color: #2d88ce; display: inline-flex; align-items: center; justify-content: center; }
.journey-grid,.customer-grid,.note-grid { display: grid; gap: 18px; }
.journey-grid,.customer-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.note-grid { margin-top: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
.journey-item,.customer-item,.note-box { padding: 18px; border-radius: 18px; background: #f8fbfe; border: 1px solid #ecf2f8; }
.note-box.admin { background: #f3f8ff; }
.item-label { display: block; margin-bottom: 10px; color: #93a1b3; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
.journey-item strong,.customer-item strong { color: #24384f; font-size: 17px; line-height: 1.5; }
.customer-item-email strong { display: block; overflow-wrap: anywhere; word-break: break-word; font-size: 15px; line-height: 1.6; }
.item-note,.note-box p { margin: 8px 0 0; color: #7a8a9d; font-size: 14px; }
.confirmation-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-top: 20px; }
.confirmation-actions form { margin: 0; }
.action-btn { min-height: 52px; padding: 0 20px; border-radius: 14px; display: inline-flex; align-items: center; gap: 10px; font-weight: 700; }
.primary-btn { background: linear-gradient(135deg, #111111 0%, #000000 100%); color: #fff; box-shadow: 0 14px 26px rgba(17, 17, 17, 0.22); }
.secondary-btn { background: #fff; border: 1px solid #dbe5f0; color: #2f4359; }
.danger-btn { background: #fff1ef; border: 1px solid #f1c7c0; color: #c9503d; }
.summary-card { overflow: hidden; position: sticky; top: 100px; }
.summary-card-title { margin: 0; padding: 20px 22px; border-bottom: 1px solid #edf2f7; color: #263a52; }
.summary-card-title i { color: #2d88ce; }
.summary-card-body { padding: 22px; }
.summary-row,.summary-total { display: flex; justify-content: space-between; gap: 12px; }
.summary-row { margin-bottom: 14px; color: #7c8b9d; }
.summary-row strong { color: #2f4257; text-align: right; }
.status-pill { color: #1aa063; }
.summary-total { margin-top: 18px; padding: 18px; border: 1px solid #dbe8f3; border-radius: 18px; background: linear-gradient(180deg, #f8fbff 0%, #f2f8fd 100%); align-items: center; color: #2d88ce; font-size: 24px; font-weight: 800; }
.summary-safe { margin-top: 22px; padding-top: 18px; border-top: 1px dashed #dce6ef; color: #90a0b0; font-size: 13px; text-align: center; }
@media (max-width: 991.98px) {
    .summary-card { position: static; }
    .journey-grid,.customer-grid,.note-grid { grid-template-columns: 1fr; }
}
@media (max-width: 767.98px) {
    .success-state h2 { font-size: 30px; }
    .success-alert { border-radius: 18px; }
    .info-card { padding: 18px; }
}
</style>
@endsection
