@extends('clients.layout')

@section('content')
@php
    $galleryImages = collect();
    if ($tour->thumbnail_url) {
        $galleryImages->push($tour->thumbnail_url);
    }
    foreach ($tour->images as $image) {
        $galleryImages->push($image->image_url);
    }
    $galleryImages = $galleryImages->filter()->unique()->values();
    $heroGallery = $galleryImages->take(4);
    $reviews = $tour->reviews ?? collect();
    $avgRating = $reviews->isNotEmpty() ? round($reviews->avg('rating'), 1) : 0;
    $durationDays = $tour->duration_days ?? 1;
    $durationNights = max($durationDays - 1, 0);
@endphp

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg')}}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="{{ route('tours.index') }}">Tours <i class="fa fa-chevron-right"></i></a></span>
                    <span>Chi tiết tour <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">{{ $tour->name }}</h1>
            </div>
        </div>
    </div>
</section>

<div class="tour-detail-page py-5">
    <div class="container">
        <div class="tour-intro-card">
            <div class="tour-intro-copy">
                <span class="tour-chip">Hành trình nổi bật</span>
                <h2>{{ $tour->name }}</h2>
                <p>{{ $tour->short_desc ?: 'Khám phá hành trình được thiết kế chỉn chu, cân bằng giữa trải nghiệm, nghỉ dưỡng và các điểm dừng ấn tượng.' }}</p>
                <div class="tour-facts">
                    <div class="fact-card">
                        <span class="fact-label">Thời lượng</span>
                        <strong>{{ $durationDays }} ngày {{ $durationNights }} đêm</strong>
                    </div>
                    <div class="fact-card">
                        <span class="fact-label">Khởi hành</span>
                        <strong>{{ $tour->start_location ?: 'Đang cập nhật' }}</strong>
                    </div>
                    <div class="fact-card">
                        <span class="fact-label">Đánh giá</span>
                        <strong>{{ $avgRating }}/5.0 · {{ $reviews->count() }} đánh giá</strong>
                    </div>
                </div>
            </div>
            <div class="tour-intro-price">
                <span>Giá từ</span>
                <strong>{{ number_format($tour->price_adult, 0, ',', '.') }} VND</strong>
                <small>Áp dụng cho 1 người lớn</small>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                @if($heroGallery->isNotEmpty())
                    <div class="tour-hero-gallery mb-4">
                        @if($heroGallery->count() === 1)
                            <div class="tour-gallery-single">
                                <img src="{{ $heroGallery[0] }}" alt="{{ $tour->name }}">
                                <div class="tour-gallery-overlay">
                                    <span>Bộ ảnh tour</span>
                                </div>
                            </div>
                        @else
                            <div class="tour-gallery-grid">
                                <div class="gallery-main">
                                    <img src="{{ $heroGallery[0] }}" alt="{{ $tour->name }}">
                                    <div class="tour-gallery-overlay">
                                        <span>Khung hình nổi bật</span>
                                    </div>
                                </div>
                                <div class="gallery-side">
                                    @foreach($heroGallery->slice(1) as $index => $image)
                                        <div class="gallery-side-item">
                                            <img src="{{ $image }}" alt="{{ $tour->name }} {{ $index + 2 }}">
                                            @if($loop->last && $galleryImages->count() > 4)
                                                <div class="gallery-more">+{{ $galleryImages->count() - 4 }} ảnh</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="content-panel mb-4">
                    <div class="section-head">
                        <span class="section-kicker">Tổng quan</span>
                        <h3>Vì sao hành trình này đáng đi?</h3>
                    </div>
                    <div class="tour-overview-grid">
                        <div class="overview-card">
                            <i class="fa fa-map-marker"></i>
                            <div>
                                <strong>Điểm đến</strong>
                                <p>{{ $tour->destination?->name ?? 'Đang cập nhật' }}</p>
                            </div>
                        </div>
                        <div class="overview-card">
                            <i class="fa fa-bus"></i>
                            <div>
                                <strong>Khởi hành</strong>
                                <p>{{ $tour->start_location ?: 'Đang cập nhật' }}</p>
                            </div>
                        </div>
                        <div class="overview-card">
                            <i class="fa fa-users"></i>
                            <div>
                                <strong>Số chỗ</strong>
                                <p>{{ $tour->available_seats ?? 'Đang cập nhật' }} chỗ</p>
                            </div>
                        </div>
                        <div class="overview-card">
                            <i class="fa fa-star"></i>
                            <div>
                                <strong>Chất lượng</strong>
                                <p>{{ $avgRating }}/5 từ {{ $reviews->count() }} đánh giá</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($tour->content)
                    <div class="content-panel mb-4">
                        <div class="section-head">
                            <span class="section-kicker">Nội dung</span>
                            <h3>Mô tả chi tiết</h3>
                        </div>
                        <div class="rich-content">{!! $tour->content !!}</div>
                    </div>
                @endif

                @if($tour->schedules->count())
                    <div class="content-panel mb-4">
                        <div class="section-head">
                            <span class="section-kicker">Lịch trình</span>
                            <h3>Chi tiết từng ngày</h3>
                        </div>
                        <div class="itinerary-list">
                            @foreach($tour->schedules as $schedule)
                                @php
                                    $timelineDetail = preg_replace('/<br\s*\/?>/i', "\n", (string) $schedule->detail);
                                    $timelineLines = preg_split('/\r\n|\r|\n|(?=\b\d{1,2}:\d{2}\b)/u', trim($timelineDetail));
                                @endphp
                                <div class="itinerary-day">
                                    <div class="itinerary-day-badge">Ngày {{ $schedule->day_no }}</div>
                                    <div class="itinerary-card">
                                        <h4>{{ $schedule->title }}</h4>
                                        <div class="itinerary-rows">
                                            @foreach($timelineLines as $line)
                                                @php
                                                    $line = trim($line);
                                                @endphp
                                                @if($line !== '')
                                                    @php preg_match('/^(\d{1,2}:\d{2})\s*(.*)$/u', $line, $matches); @endphp
                                                    @if(!empty($matches))
                                                        <div class="itinerary-row">
                                                            <span class="itinerary-time">{{ $matches[1] }}</span>
                                                            <span class="itinerary-desc">{{ $matches[2] }}</span>
                                                        </div>
                                                    @else
                                                        <div class="itinerary-row is-full">
                                                            <span class="itinerary-desc">{{ $line }}</span>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="content-panel mb-4">
                    <div class="section-head">
                        <span class="section-kicker">Đánh giá</span>
                        <h3>Cảm nhận từ khách hàng</h3>
                    </div>

                    @if($reviews->count())
                        <div class="review-summary-inline">
                            <strong>⭐ {{ $avgRating }}/5</strong>
                            <span>{{ $reviews->count() }} đánh giá thực tế</span>
                        </div>
                        <div class="review-list">
                            @foreach($reviews as $review)
                                <div class="review-box">
                                    <div class="review-top">
                                        <div>
                                            <strong class="review-author">{{ $review->user->name }}</strong>
                                            <div class="review-stars-line">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                                @endfor
                                            </div>
                                        </div>
                                        <small class="review-date">{{ $review->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    @if($review->comment)
                                        <p class="review-comment">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có đánh giá nào cho tour này.</p>
                    @endif
                </div>

                @if(Auth::check())
                    <div class="content-panel review-form-panel">
                        <div class="section-head">
                            <span class="section-kicker">Chia sẻ</span>
                            <h3>Viết đánh giá của bạn</h3>
                        </div>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                            <div class="mb-3">
                                <label class="review-form-label">Chọn số sao</label>
                                <div class="review-star-picker">
                                    <input type="hidden" name="rating" id="reviewRatingInput" required>
                                    <button type="button" class="review-star-btn" data-value="1" aria-label="1 sao">★</button>
                                    <button type="button" class="review-star-btn" data-value="2" aria-label="2 sao">★</button>
                                    <button type="button" class="review-star-btn" data-value="3" aria-label="3 sao">★</button>
                                    <button type="button" class="review-star-btn" data-value="4" aria-label="4 sao">★</button>
                                    <button type="button" class="review-star-btn" data-value="5" aria-label="5 sao">★</button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="review-form-label">Nhận xét</label>
                                <textarea name="comment" class="form-control review-form-control" rows="4" required></textarea>
                            </div>

                            <button class="btn btn-primary review-submit-btn">Gửi đánh giá</button>
                        </form>
                    </div>
                @else
                    <div class="content-panel">
                        <p class="mb-0 text-muted">Vui lòng đăng nhập để gửi đánh giá về tour.</p>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="booking-card">
                    <div class="booking-card-head">
                        <span class="booking-card-chip">Đặt tour</span>
                        <h3>Sẵn sàng cho chuyến đi này?</h3>
                        <p>Chọn số lượng khách và ngày đi để gửi yêu cầu đặt tour.</p>
                    </div>

                    <div class="price-main">{{ number_format($tour->price_adult,0,',','.') }} VND</div>
                    <p class="price-note">Giá cho 1 người lớn</p>

                    <div class="quantity-grid">
                        <div class="guest-card">
                            <label>Người lớn</label>
                            <div class="quantity-box">
                                <button type="button" onclick="changeQty('adult', -1)">-</button>
                                <span id="adultQty">1</span>
                                <button type="button" onclick="changeQty('adult', 1)">+</button>
                            </div>
                        </div>
                        <div class="guest-card">
                            <label>Trẻ em</label>
                            <div class="quantity-box">
                                <button type="button" onclick="changeQty('child', -1)">-</button>
                                <span id="childQty">0</span>
                                <button type="button" onclick="changeQty('child', 1)">+</button>
                            </div>
                        </div>
                    </div>

                    @php
                        $today = \Carbon\Carbon::today();
                        $departureDays = [7, 14, 21, 28];
                        $defaultTravelDate = null;
                        foreach ($departureDays as $day) {
                            $candidate = $today->copy()->day($day);
                            if ($candidate->lt($today)) {
                                continue;
                            }
                            $defaultTravelDate = $candidate;
                            break;
                        }
                        if (!$defaultTravelDate) {
                            $defaultTravelDate = $today->copy()->addMonthNoOverflow()->day($departureDays[0]);
                        }
                    @endphp

                    <div class="date-box">
                        <label><strong>Ngày đi</strong></label>
                        <input type="date" id="travelDate" min="{{ date('Y-m-d') }}" value="{{ $defaultTravelDate->format('Y-m-d') }}" class="form-control modern-input">
                    </div>

                    <div class="price-breakdown" id="priceBreakdown"></div>

                    <div class="total-box">
                        <span>Tổng cộng</span>
                        <strong id="totalPrice"></strong>
                    </div>

                    <div class="booking-card-actions">
                        @if(Auth::check())
                            <button onclick="goCheckout()" class="btn btn-book w-100">Gửi yêu cầu đặt tour</button>
                        @else
                            <button onclick="requireLogin()" class="btn-book w-100">Đăng nhập để đặt tour</button>
                        @endif
                    </div>
                </div>

                <div class="mobile-booking-bar">
                    <div class="mobile-booking-bar__meta">
                        <span>Tổng cộng</span>
                        <strong id="mobileTotalPrice"></strong>
                    </div>
                    @if(Auth::check())
                        <button onclick="goCheckout()" class="btn btn-book mobile-booking-bar__button">Đặt tour</button>
                    @else
                        <button onclick="requireLogin()" class="btn-book mobile-booking-bar__button">Đăng nhập</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tour-detail-page { background: linear-gradient(180deg, #f5f8fc 0%, #eef4fb 100%); }
.tour-intro-card { margin-bottom: 24px; padding: 30px; border-radius: 30px; background: linear-gradient(135deg, #0f2f4d 0%, #1f5f8b 54%, #2f8dc4 100%); color: #fff; display: grid; grid-template-columns: minmax(0, 1fr) 260px; gap: 24px; box-shadow: 0 30px 60px rgba(15, 47, 77, 0.24); }
.tour-chip { display: inline-flex; margin-bottom: 14px; padding: 8px 14px; border-radius: 999px; background: rgba(255,255,255,0.14); font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
.tour-intro-copy h2 { margin: 0 0 10px; font-size: 42px; color: #fff; font-weight: 800; }
.tour-intro-copy p { margin: 0 0 18px; max-width: 760px; color: rgba(255,255,255,0.86); font-size: 16px; line-height: 1.75; }
.tour-facts { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
.fact-card { padding: 16px; border-radius: 20px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.12); }
.fact-label { display: block; margin-bottom: 6px; color: rgba(255,255,255,0.7); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
.fact-card strong { font-size: 16px; color: #fff; }
.tour-intro-price { padding: 24px; border-radius: 24px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18); display: flex; flex-direction: column; justify-content: center; }
.tour-intro-price span { color: rgba(255,255,255,0.78); text-transform: uppercase; font-size: 12px; letter-spacing: .1em; font-weight: 700; }
.tour-intro-price strong { margin: 8px 0; font-size: 34px; line-height: 1.1; }
.tour-intro-price small { color: rgba(255,255,255,0.76); }
.tour-gallery-grid { display: grid; grid-template-columns: 1.08fr .92fr; gap: 14px; }
.gallery-main,.gallery-side-item,.tour-gallery-single { position: relative; overflow: hidden; border-radius: 24px; min-height: 220px; }
.gallery-main { min-height: 430px; }
.gallery-side { display: grid; gap: 14px; }
.gallery-side-item { min-height: 132px; }
.gallery-main img,.gallery-side-item img,.tour-gallery-single img { width: 100%; height: 100%; object-fit: cover; display: block; }
.tour-gallery-single { min-height: 320px; max-height: 420px; }
.tour-gallery-overlay { position: absolute; inset: 0; display: flex; align-items: flex-end; padding: 24px; background: linear-gradient(180deg, rgba(15,23,42,0.06) 0%, rgba(15,23,42,0.58) 100%); }
.tour-gallery-overlay span { padding: 8px 14px; border-radius: 999px; background: rgba(255,255,255,0.9); color: #0f172a; font-weight: 700; }
.gallery-more { position: absolute; right: 16px; bottom: 16px; padding: 10px 14px; border-radius: 16px; background: rgba(255,255,255,0.92); color: #0f172a; font-weight: 800; }
.content-panel { padding: 28px; border-radius: 26px; background: rgba(255,255,255,0.95); border: 1px solid #e5edf5; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); }
.section-head { margin-bottom: 20px; }
.section-kicker { display: inline-flex; margin-bottom: 8px; color: #2579ba; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
.section-head h3 { margin: 0; color: #17304c; font-size: 30px; font-weight: 800; }
.tour-overview-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
.overview-card { display: flex; gap: 14px; padding: 18px; border-radius: 20px; background: #f8fbfe; border: 1px solid #eaf0f6; }
.overview-card i { width: 44px; height: 44px; border-radius: 14px; background: #f3f4f6; color: #111111; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; }
.overview-card strong { display: block; color: #17304c; margin-bottom: 4px; }
.overview-card p { margin: 0; color: #6d7f95; }
.rich-content { color: #475569; line-height: 1.85; font-size: 15px; }
.itinerary-list { display: grid; gap: 18px; }
.itinerary-day { display: grid; gap: 14px; align-items: start; }
.itinerary-day-badge { display: inline-flex; width: fit-content; padding: 12px 18px; border-radius: 999px; background: linear-gradient(135deg, #0f766e, #155e75); color: #fff; font-weight: 800; text-align: center; }
.itinerary-card { width: 100%; padding: 20px; border-radius: 22px; background: #f8fbfe; border: 1px solid #e5edf5; overflow: hidden; }
.itinerary-card h4 { margin: 0 0 14px; color: #17304c; font-size: 24px; font-weight: 800; line-height: 1.45; overflow-wrap: anywhere; }
.itinerary-rows { display: grid; gap: 10px; }
.itinerary-row { display: grid; grid-template-columns: 92px minmax(0, 1fr); gap: 14px; align-items: start; }
.itinerary-row.is-full { grid-template-columns: minmax(0, 1fr); }
.itinerary-time { font-weight: 800; color: #0f766e; }
.itinerary-desc { color: #516579; line-height: 1.75; overflow-wrap: anywhere; }
.review-summary-inline { display: inline-flex; gap: 10px; align-items: center; padding: 12px 16px; border-radius: 16px; background: #f6fafe; color: #4f6478; margin-bottom: 18px; }
.review-list { display: grid; gap: 14px; }
.review-box { padding: 18px; border-radius: 20px; background: #f8fbfe; border: 1px solid #e6eef5; }
.review-top { display: flex; justify-content: space-between; gap: 12px; }
.review-author { display: block; margin-bottom: 6px; color: #17304c; }
.review-stars-line { color: #f59e0b; font-size: 19px; letter-spacing: 2px; }
.review-date { color: #7b8fa4; }
.review-comment { margin: 12px 0 0; color: #4a6075; line-height: 1.8; }
.review-form-panel { max-width: 620px; }
.review-form-label { display: block; margin-bottom: 8px; font-weight: 700; color: #2a435a; }
.review-form-control { min-height: 46px; border-radius: 14px; border: 1px solid #dbe2ea; padding: 10px 12px; background: #f8fafc; font-size: 14px; }
.review-form-control:focus { border-color: #111111; box-shadow: 0 0 0 4px rgba(17, 17, 17, 0.12); }
.review-star-picker { display: inline-flex; align-items: center; gap: 6px; padding: 10px 12px; border: 1px solid #dbe2ea; border-radius: 14px; background: #f8fafc; }
.review-star-btn { border: none; background: transparent; padding: 0; font-size: 28px; line-height: 1; color: #cbd5e1; cursor: pointer; transition: transform .15s ease, color .15s ease; }
.review-star-btn:hover { transform: scale(1.06); }
.review-star-btn.is-active { color: #f59e0b; }
.review-submit-btn { min-width: 140px; min-height: 44px; border: none; border-radius: 14px; background: linear-gradient(135deg, #0f172a, #1e293b); font-size: 13px; font-weight: 700; padding: 0 18px; }
.booking-card { position: sticky; top: 100px; padding: 26px; border-radius: 28px; background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%); border: 1px solid #e2edf7; box-shadow: 0 24px 50px rgba(15,23,42,.08); }
.booking-card-head h3 { margin: 8px 0 8px; color: #17304c; font-size: 30px; font-weight: 800; }
.booking-card-head p { margin: 0 0 16px; color: #6d7f95; line-height: 1.7; }
.booking-card-chip { display: inline-flex; padding: 7px 14px; border-radius: 999px; background: #f3f4f6; color: #111111; font-size: 12px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
.price-main { font-size: 34px; font-weight: 800; color: #dc2626; line-height: 1.1; }
.price-note { margin: 6px 0 18px; color: #8da0b2; }
.quantity-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 12px; margin-bottom: 18px; }
.guest-card { padding: 16px; border-radius: 18px; background: #fff; border: 1px solid #e5edf5; }
.guest-card label { display: block; margin-bottom: 12px; color: #42586e; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: .08em; }
.quantity-box { display: flex; justify-content: center; align-items: center; gap: 10px; }
.quantity-box button { width: 34px; height: 34px; border: none; background: #111111; color: white; border-radius: 10px; font-weight: bold; }
.quantity-box span { min-width: 28px; text-align: center; font-weight: 800; color: #17304c; }
.date-box { margin-bottom: 18px; }
.modern-input { min-height: 52px; border-radius: 16px; border: 1px solid #d2dfea; background: #fbfdff; box-shadow: none; }
.modern-input:focus { border-color: #57a5da; box-shadow: 0 0 0 4px rgba(44, 131, 197, 0.14); }
.price-breakdown { white-space: pre-line; margin-bottom: 14px; color: #6d7f95; line-height: 1.7; }
.total-box { display: flex; justify-content: space-between; align-items: center; padding: 16px 18px; border-radius: 18px; background: #eef7ff; border: 1px solid #d8e8f7; }
.total-box span { color: #587188; font-weight: 700; }
.total-box strong { color: #ff0000; font-size: 22px; }
.btn-book { min-height: 54px; border: none; border-radius: 16px; background: linear-gradient(135deg, #1d7dc4 0%, #1a9ed6 100%); color: #fff; font-size: 16px; font-weight: 700; box-shadow: 0 14px 26px rgba(30, 126, 196, 0.25); }
.booking-card-actions { margin-top: 16px; }
.mobile-booking-bar { display: none; }
@media (max-width: 991.98px) {
    .tour-intro-card { grid-template-columns: 1fr; }
    .tour-facts,.tour-overview-grid { grid-template-columns: 1fr; }
    .booking-card { position: static; margin-top: 20px; }
}
@media (max-width: 767.98px) {
    body { padding-bottom: 92px; }
    .tour-intro-copy h2 { font-size: 30px; }
    .tour-gallery-grid { grid-template-columns: 1fr; }
    .gallery-main,.tour-gallery-single { min-height: 260px; max-height: none; }
    .gallery-side-item { min-height: 120px; }
    .itinerary-row { grid-template-columns: 1fr; }
    .booking-card { padding: 18px; border-radius: 22px; }
    .booking-card-head h3 { margin: 6px 0; font-size: 24px; line-height: 1.25; }
    .booking-card-head p { display: none; }
    .booking-card-chip { padding: 6px 12px; font-size: 11px; }
    .price-main { font-size: 28px; }
    .price-note { margin: 4px 0 12px; font-size: 14px; }
    .quantity-grid { grid-template-columns: repeat(2, minmax(0,1fr)); gap: 10px; margin-bottom: 14px; }
    .guest-card { padding: 12px; border-radius: 16px; }
    .guest-card label { margin-bottom: 8px; font-size: 11px; }
    .quantity-box { gap: 8px; }
    .quantity-box button { width: 32px; height: 32px; }
    .date-box { margin-bottom: 12px; }
    .date-box label { margin-bottom: 6px; font-size: 14px; }
    .modern-input { min-height: 46px; border-radius: 14px; }
    .price-breakdown { margin-bottom: 10px; font-size: 14px; line-height: 1.5; }
    .total-box { padding: 12px 14px; border-radius: 16px; }
    .total-box strong { font-size: 18px; }
    .booking-card-actions { display: none; }
    .mobile-booking-bar { position: fixed; left: 12px; right: 12px; bottom: 12px; z-index: 1040; display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 18px; background: rgba(255,255,255,0.96); border: 1px solid #dbe7f2; box-shadow: 0 18px 36px rgba(15, 23, 42, 0.16); backdrop-filter: blur(12px); }
    .mobile-booking-bar__meta { min-width: 0; display: grid; }
    .mobile-booking-bar__meta span { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #6d7f95; }
    .mobile-booking-bar__meta strong { color: #17304c; font-size: 18px; line-height: 1.15; }
    .mobile-booking-bar__button { min-height: 46px; padding: 0 18px; white-space: nowrap; box-shadow: none; }
}
</style>

<script>
let adultPrice = Number({{ $tour->price_adult ?? 0 }});
let childPrice = Number({{ $tour->price_child ?? 0 }});
const travelDateInput = document.getElementById('travelDate');
let adultQty = 1;
let childQty = 0;

function changeQty(type, value) {
    if (type === 'adult') {
        adultQty = Math.max(1, adultQty + value);
        document.getElementById('adultQty').innerText = adultQty;
    }
    if (type === 'child') {
        childQty = Math.max(0, childQty + value);
        document.getElementById('childQty').innerText = childQty;
    }
    updateTotal();
}

function updateTotal() {
    let adultTotal = adultQty * adultPrice;
    let childTotal = childQty * childPrice;
    let total = adultTotal + childTotal;
    let breakdown = '';

    if (adultQty > 0) {
        breakdown += adultQty + ' người lớn × ' + adultPrice.toLocaleString('vi-VN') + ' = ' + adultTotal.toLocaleString('vi-VN') + ' VND\n';
    }
    if (childQty > 0) {
        breakdown += childQty + ' trẻ em × ' + childPrice.toLocaleString('vi-VN') + ' = ' + childTotal.toLocaleString('vi-VN') + ' VND';
    }

    document.getElementById('priceBreakdown').innerText = breakdown;
    const formattedTotal = total.toLocaleString('vi-VN') + ' VND';
    document.getElementById('totalPrice').innerText = formattedTotal;
    const mobileTotalPrice = document.getElementById('mobileTotalPrice');
    if (mobileTotalPrice) {
        mobileTotalPrice.innerText = formattedTotal;
    }
}

function goCheckout() {
    let travelDate = travelDateInput.value;
    if (!travelDate) {
        alert('Vui lòng chọn ngày đi trước khi đặt tour.');
        travelDateInput.focus();
        return;
    }
    let url = "{{ route('checkout', $tour) }}";
    url += '?adult=' + adultQty + '&child=' + childQty + '&travel_date=' + encodeURIComponent(travelDate);
    window.location.href = url;
}

if (travelDateInput) {
    travelDateInput.addEventListener('focus', function () {
        if (typeof this.showPicker === 'function') this.showPicker();
    });
    travelDateInput.addEventListener('click', function () {
        if (typeof this.showPicker === 'function') this.showPicker();
    });
}

updateTotal();

function requireLogin() {
    alert('Bạn cần đăng nhập để đặt tour.');
    $('#authModal').modal('show');
}

document.addEventListener('DOMContentLoaded', function () {
    const ratingInput = document.getElementById('reviewRatingInput');
    const starButtons = document.querySelectorAll('.review-star-btn');
    const starPicker = document.querySelector('.review-star-picker');
    if (!ratingInput || !starButtons.length || !starPicker) return;

    function paintStars(value) {
        starButtons.forEach((button) => {
            const buttonValue = Number(button.dataset.value);
            button.classList.toggle('is-active', buttonValue <= value);
        });
    }

    starButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const value = Number(this.dataset.value);
            ratingInput.value = value;
            paintStars(value);
        });
        button.addEventListener('mouseenter', function () {
            paintStars(Number(this.dataset.value));
        });
    });

    starPicker.addEventListener('mouseleave', function () {
        paintStars(Number(ratingInput.value || 0));
    });
});
</script>
@endsection



