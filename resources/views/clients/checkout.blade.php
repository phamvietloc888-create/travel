@extends('clients.layout')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span>
                    <span>Gửi yêu cầu đặt tour <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Gửi yêu cầu đặt tour</h1>
            </div>
        </div>
    </div>
</section>

@php
    $adult = $adult ?? 1;
    $child = $child ?? 0;
    $adultTotal = $adult * $tour->price_adult;
    $childTotal = $child * ($tour->price_child ?? 0);
    $total = $adultTotal + $childTotal;
    $formattedTravelDate = $travel_date ? \Carbon\Carbon::parse($travel_date)->format('d/m/Y') : 'Chưa chọn';
    $durationNights = max(($tour->duration_days ?? 1) - 1, 0);
@endphp

<div class="checkout-page py-5">
    <div class="container">
        <div class="checkout-shell">
            <div class="checkout-header">
                <span class="eyebrow">Đặt tour</span>
                <h2>Điền thông tin để gửi yêu cầu đặt tour</h2>
                <p>Thông tin của bạn sẽ được gửi đến quản trị viên để xác nhận booking trước khi thanh toán.</p>
            </div>

            <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                <input type="hidden" name="adult" value="{{ $adult }}">
                <input type="hidden" name="child" value="{{ $child }}">
                <input type="hidden" name="travel_date" value="{{ $travel_date }}">

                <div class="row g-4 align-items-start">
                    <div class="col-lg-7">
                        <div class="checkout-card">
                            <div class="checkout-card-title">
                                <div class="checkout-icon"><i class="fa fa-user"></i></div>
                                <div>
                                    <h4>Thông tin khách đặt</h4>
                                    <p>Vui lòng nhập chính xác để chúng tôi liên hệ xác nhận nhanh hơn.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Họ và tên</label>
                                    <input type="text" name="name" class="form-control checkout-input" value="{{ old('name', auth()->user()->name) }}" minlength="2" maxlength="255" required>
                                    <p class="field-error">Vui lòng nhập họ và tên hợp lệ.</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="tel" name="phone" class="form-control checkout-input" value="{{ old('phone', auth()->user()->phone) }}" pattern="^(0|\+84)\d{9,10}$" required>
                                    <p class="field-error">Số điện thoại phải bắt đầu bằng 0 hoặc +84.</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control checkout-input" value="{{ old('email', auth()->user()->email) }}" maxlength="255" required>
                                    <p class="field-error">Vui lòng nhập email hợp lệ.</p>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Ghi chú thêm</label>
                                    <textarea name="note" rows="5" class="form-control checkout-input">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="summary-card">
                            <img src="{{ $tour->thumbnail_url }}" alt="{{ $tour->name }}" class="summary-image">
                            <div class="summary-body">
                                <span class="summary-kicker">Thông tin tour</span>
                                <h5>{{ $tour->name }}</h5>

                                <div class="summary-meta">
                                    <div><i class="fa fa-calendar"></i> Ngày đi: {{ $formattedTravelDate }}</div>
                                    <div><i class="fa fa-moon-o"></i> {{ $tour->duration_days }} ngày {{ $durationNights }} đêm</div>
                                    <div><i class="fa fa-users"></i> {{ $adult + $child }} khách</div>
                                </div>

                                <div class="summary-prices">
                                    <div class="summary-line">
                                        <span>Người lớn x {{ $adult }}</span>
                                        <strong>{{ number_format($adultTotal, 0, ',', '.') }} VND</strong>
                                    </div>
                                    @if($child > 0)
                                        <div class="summary-line">
                                            <span>Trẻ em x {{ $child }}</span>
                                            <strong>{{ number_format($childTotal, 0, ',', '.') }} VND</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="summary-total">
                                    <span>Tổng tạm tính</span>
                                    <strong>{{ number_format($total, 0, ',', '.') }} VND</strong>
                                </div>

                                <button class="btn complete-payment-btn w-100" type="submit">
                                    <i class="fa fa-paper-plane mr-2"></i>Gửi yêu cầu đặt tour
                                </button>
                                <p class="summary-note">Sau khi được xác nhận, bạn sẽ nhận thông báo ngay trên biểu tượng chuông.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.checkout-page { background: linear-gradient(180deg, #f4f7fb 0%, #edf3fb 100%); }
.checkout-shell { max-width: 1180px; margin: 0 auto; }
.checkout-header { margin-bottom: 26px; }
.eyebrow { display: inline-flex; margin-bottom: 10px; padding: 7px 14px; border-radius: 999px; background: #f3f4f6; color: #111111; font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
.checkout-header h2 { margin: 0 0 8px; font-size: 40px; color: #17304c; font-weight: 800; }
.checkout-header p { margin: 0; color: #688097; max-width: 760px; }
.checkout-card,.summary-card { background: rgba(255,255,255,0.96); border: 1px solid #e4edf6; border-radius: 28px; box-shadow: 0 24px 50px rgba(20, 45, 72, 0.08); }
.checkout-card { padding: 30px; }
.checkout-card-title { display: flex; gap: 14px; align-items: flex-start; margin-bottom: 24px; }
.checkout-card-title h4 { margin: 0 0 4px; font-size: 30px; color: #17304c; font-weight: 800; }
.checkout-card-title p { margin: 0; color: #7b8fa4; }
.checkout-icon { width: 46px; height: 46px; border-radius: 14px; background: #f3f4f6; color: #111111; display: inline-flex; align-items: center; justify-content: center; }
.checkout-input { min-height: 56px; border-radius: 16px; border: 1px solid #d2dfea; background: #fbfdff; box-shadow: none; }
textarea.checkout-input { min-height: 140px; padding-top: 14px; }
.checkout-input:focus { border-color: #57a5da; box-shadow: 0 0 0 4px rgba(44, 131, 197, 0.14); }
.checkout-input.is-invalid { border-color: #e15252; background: #fff8f8; }
.field-error { display: none; margin: 6px 0 0; font-size: 13px; color: #cc3434; }
.checkout-input.is-invalid + .field-error { display: block; }
.summary-card { position: sticky; top: 100px; overflow: hidden; }
.summary-image { width: 100%; height: 250px; object-fit: cover; }
.summary-body { padding: 24px; }
.summary-kicker { display: inline-block; margin-bottom: 10px; color: #111111; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
.summary-body h5 { margin: 0 0 18px; color: #23364c; font-size: 32px; font-weight: 800; line-height: 1.25; }
.summary-meta { display: grid; gap: 12px; color: #6d7f95; font-size: 15px; margin-bottom: 22px; }
.summary-prices { display: grid; gap: 12px; padding: 18px 0; border-top: 1px solid #edf2f7; border-bottom: 1px solid #edf2f7; }
.summary-line,.summary-total { display: flex; justify-content: space-between; gap: 12px; align-items: center; }
.summary-total { margin: 18px 0 22px; padding: 16px 18px; border-radius: 18px; background: linear-gradient(135deg, #f5fbff 0%, #eef7ff 100%); border: 1px solid #d6e8f8; }
.summary-total span { color: #668099; font-weight: 700; }
.summary-total strong { color: #17304c; font-size: 22px; }
.complete-payment-btn { min-height: 58px; border: none; border-radius: 18px; background: linear-gradient(135deg, #176fb2 0%, #1f96d0 100%); color: #fff; font-size: 16px; font-weight: 700; box-shadow: 0 14px 26px rgba(30, 126, 196, 0.24); }
.summary-note { margin: 14px 0 0; color: #74869b; font-size: 13px; }
@media (max-width: 991.98px) {
    .summary-card { position: static; }
    .checkout-header h2 { font-size: 32px; }
}
</style>

<script>
(() => {
    const form = document.getElementById('checkoutForm');
    const inputs = Array.from(form.querySelectorAll('input[required]'));
    const phoneRegex = /^(0|\+84)\d{9,10}$/;
    function isValid(input) {
        if (input.name === 'phone') return phoneRegex.test((input.value || '').trim());
        return input.checkValidity();
    }
    inputs.forEach((input) => {
        input.addEventListener('blur', () => input.classList.toggle('is-invalid', !isValid(input)));
    });
    form.addEventListener('submit', (event) => {
        let hasInvalid = false;
        inputs.forEach((input) => {
            const valid = isValid(input);
            input.classList.toggle('is-invalid', !valid);
            hasInvalid = hasInvalid || !valid;
        });
        if (hasInvalid) event.preventDefault();
    });
})();
</script>
@endsection
