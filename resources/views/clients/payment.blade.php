@extends('clients.layout')

@section('content')
@php
    $tour = $booking->tour;
    $durationDays = $tour->duration_days ?? 1;
    $durationNights = max($durationDays - 1, 0);
@endphp
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span>
                    <span>Thanh toán <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Thanh toán booking đã duyệt</h1>
            </div>
        </div>
    </div>
</section>

<div class="payment-page py-5">
    <div class="container">
        <div class="payment-hero">
            <div>
                <span class="eyebrow">Bước 3</span>
                <h2>Admin đã xác nhận booking {{ $booking->booking_code }}</h2>
                <p>Bạn có thể thanh toán ngay bây giờ. Sau khi gửi thông tin chuyển khoản, admin sẽ xác nhận và cập nhật trạng thái.</p>
            </div>
            <a href="{{ route('booking.confirmation', $booking) }}" class="back-link"><i class="fa fa-arrow-left"></i> Quay lại booking</a>
        </div>

        <form method="POST" action="{{ route('booking.payment.submit', $booking) }}">
            @csrf
            <input type="hidden" name="payment_method" value="BANK_TRANSFER">

            <div class="row g-4 align-items-start">
                <div class="col-lg-7">
                    <div class="payment-card">
                        <div class="section-title">
                            <div class="title-icon"><i class="fa fa-university"></i></div>
                            <div>
                                <h4>Thông tin chuyển khoản</h4>
                                <p>Quét QR hoặc chuyển khoản đúng số tiền và đúng nội dung để admin xác nhận nhanh.</p>
                            </div>
                        </div>

                        <div class="payment-grid">
                            <div class="payment-info">
                                <div class="payment-line"><span>Ngân hàng</span><strong>{{ $paymentSettings?->bank_name ?? 'Đang cập nhật' }}</strong></div>
                                <div class="payment-line"><span>Chủ tài khoản</span><strong>{{ $paymentSettings?->account_name ?? 'Đang cập nhật' }}</strong></div>
                                <div class="payment-line"><span>Số tài khoản</span><strong>{{ $paymentSettings?->account_number ?? 'Đang cập nhật' }}</strong></div>
                                <div class="payment-line"><span>Số tiền</span><strong>{{ number_format($booking->total_amount, 0, ',', '.') }} VND</strong></div>
                                <div class="payment-line"><span>Nội dung chuyển khoản</span><strong class="code-pill">{{ $simulationCode }}</strong></div>
                            </div>
                            <div class="payment-qr">
                                @if($paymentSettings?->qr_code_path)
                                    <img src="{{ route('payment.qr') }}" alt="QR thanh toán">
                                @else
                                    <div class="qr-placeholder">Chưa có QR</div>
                                @endif
                                <p>{{ $paymentSettings?->instructions ?? 'Vui lòng chuyển khoản đúng nội dung và xác nhận lại bên dưới.' }}</p>
                            </div>
                        </div>

                        <div class="verify-wrap mt-4">
                            <label class="form-label">Nhập lại nội dung chuyển khoản để xác nhận</label>
                            <input type="text" id="simulationCodeVerify" name="simulation_code" class="form-control payment-input text-uppercase" placeholder="Nhập {{ $simulationCode }}" required>
                            @error('simulation_code')
                                <p class="field-error is-visible">{{ $message }}</p>
                            @else
                                <p class="field-error" id="verifyError">Mã xác nhận chưa đúng.</p>
                            @enderror
                        </div>

                        <div class="payment-actions">
                            <a href="{{ route('booking.confirmation', $booking) }}" class="btn secondary-btn">Để sau</a>
                            <button type="submit" class="btn primary-btn" id="confirmPaymentBtn" disabled>Xác nhận đã chuyển khoản</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="summary-card">
                        <img src="{{ $tour->thumbnail_url }}" alt="{{ $tour->name }}" class="summary-image">
                        <div class="summary-body">
                            <span class="summary-kicker">Booking đã duyệt</span>
                            <h5>{{ $tour->name }}</h5>
                            <div class="summary-meta">
                                <div><i class="fa fa-ticket"></i> {{ $booking->booking_code }}</div>
                                <div><i class="fa fa-calendar"></i> {{ $booking->travel_date?->format('d/m/Y') }} - {{ $durationDays }} ngày {{ $durationNights }} đêm</div>
                                <div><i class="fa fa-users"></i> {{ $booking->adult_qty + $booking->child_qty }} khách</div>
                            </div>
                            <div class="summary-total">
                                <span>Tổng thanh toán</span>
                                <strong>{{ number_format($booking->total_amount, 0, ',', '.') }} VND</strong>
                            </div>
                            @if($booking->admin_note)
                                <div class="admin-note">
                                    <span>Ghi chú từ admin</span>
                                    <p>{{ $booking->admin_note }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.payment-page { background: linear-gradient(180deg, #f3f7fc 0%, #edf3fa 100%); }
.payment-hero { display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; margin-bottom: 24px; }
.eyebrow { display: inline-block; margin-bottom: 8px; padding: 6px 12px; border-radius: 999px; background: #f3f4f6; color: #111111; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
.payment-hero h2 { margin: 0 0 8px; color: #18314f; font-size: 36px; font-weight: 800; }
.payment-hero p { margin: 0; color: #6d7f95; max-width: 680px; }
.back-link { display: inline-flex; align-items: center; gap: 8px; padding: 12px 16px; border-radius: 14px; background: #fff; border: 1px solid #dce8f5; color: #294764; font-weight: 700; }
.payment-card,.summary-card { background: #fff; border: 1px solid #e5edf5; border-radius: 24px; box-shadow: 0 16px 35px rgba(21, 43, 71, 0.08); }
.payment-card { padding: 28px; }
.section-title { display: flex; gap: 12px; margin-bottom: 22px; }
.title-icon { width: 42px; height: 42px; border-radius: 12px; background: #f3f4f6; color: #111111; display: inline-flex; align-items: center; justify-content: center; }
.section-title h4 { margin: 0; color: #203a56; font-size: 28px; font-weight: 800; }
.section-title p { margin: 6px 0 0; color: #6d7f95; }
.payment-grid { display: grid; gap: 16px; grid-template-columns: 1.1fr 0.9fr; }
.payment-info { border: 1px solid #dce8f5; background: #f8fbff; border-radius: 16px; padding: 14px; }
.payment-line { display: flex; justify-content: space-between; gap: 10px; padding: 10px 0; border-bottom: 1px dashed #cfe0f0; }
.payment-line:last-child { border-bottom: 0; }
.payment-line span { color: #5c7289; }
.payment-line strong { color: #17304c; text-align: right; }
.payment-qr { border: 1px solid #dce8f5; border-radius: 16px; padding: 14px; display: flex; flex-direction: column; gap: 12px; align-items: center; background: #fff; text-align: center; }
.payment-qr img { width: 220px; max-width: 100%; border-radius: 14px; border: 1px solid #e3edf8; object-fit: contain; }
.qr-placeholder { width: 220px; height: 220px; border-radius: 14px; border: 1px dashed #c7d9ea; color: #6f8196; display: flex; align-items: center; justify-content: center; background: #f8fbff; }
.code-pill { background: #17395e; color: #fff; border-radius: 999px; padding: 6px 10px; letter-spacing: .04em; font-size: 13px; }
.payment-input { min-height: 56px; border-radius: 14px; border: 1px solid #cfdceb; background: #fbfdff; }
.payment-input.is-invalid { border-color: #e15252; background: #fff8f8; }
.field-error { display: none; margin: 8px 0 0; color: #cc3434; font-size: 13px; }
.field-error.is-visible,.payment-input.is-invalid + .field-error { display: block; }
.payment-actions { margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap; }
.primary-btn,.secondary-btn { min-height: 54px; padding: 0 20px; border-radius: 14px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; }
.primary-btn { background: linear-gradient(135deg, #1d7dc4 0%, #1a9ed6 100%); color: #fff; border: none; box-shadow: 0 14px 26px rgba(30, 126, 196, 0.25); }
.primary-btn:disabled { background: #8ea8bd; box-shadow: none; cursor: not-allowed; }
.secondary-btn { background: #fff; border: 1px solid #d7e3ef; color: #2f4359; }
.summary-card { overflow: hidden; position: sticky; top: 100px; }
.summary-image { width: 100%; height: 220px; object-fit: cover; }
.summary-body { padding: 22px; }
.summary-kicker { display: inline-block; margin-bottom: 10px; color: #111111; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
.summary-body h5 { margin-bottom: 16px; color: #23364c; font-size: 30px; font-weight: 800; line-height: 1.28; }
.summary-meta { display: grid; gap: 10px; color: #72849a; font-size: 14px; margin-bottom: 22px; }
.summary-total { display: flex; justify-content: space-between; gap: 12px; align-items: center; margin: 18px 0 0; padding: 14px 16px; border-radius: 16px; background: #f4f9ff; border: 1px solid #d7e8f7; font-size: 18px; }
.admin-note { margin-top: 18px; padding: 16px; border-radius: 16px; background: #f7fbff; border: 1px solid #deebf7; }
.admin-note span { display: block; margin-bottom: 8px; color: #6b8197; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
.admin-note p { margin: 0; color: #39516c; }
@media (max-width: 991.98px) {
    .payment-hero { flex-direction: column; }
    .payment-grid { grid-template-columns: 1fr; }
    .summary-card { position: static; }
}
</style>

<script>
(() => {
    const expectedCode = @json($simulationCode);
    const verifyInput = document.getElementById('simulationCodeVerify');
    const confirmButton = document.getElementById('confirmPaymentBtn');

    function refreshState() {
        const value = (verifyInput.value || '').trim().toUpperCase();
        const isValid = value.length > 0 && value === String(expectedCode).toUpperCase();
        verifyInput.classList.toggle('is-invalid', value.length > 0 && !isValid);
        confirmButton.disabled = !isValid;
    }

    verifyInput.addEventListener('input', refreshState);
    refreshState();
})();
</script>
@endsection
