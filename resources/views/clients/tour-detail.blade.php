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
    $heroGallery = $galleryImages->take(5);
    $sideGallery = $heroGallery->slice(1)->values();
    $reviews = $tour->reviews ?? collect();
    $avgRating = $reviews->isNotEmpty() ? round($reviews->avg('rating'), 1) : 0;
    $durationDays = $tour->duration_days ?? 1;
    $durationNights = max($durationDays - 1, 0);
    $hotelStars = (int) ($tour->hotel_stars ?? 0);
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
        @if($heroGallery->isNotEmpty())
            <div class="tour-hero-gallery mb-4">
                @if($heroGallery->count() === 1)
                    <div class="tour-gallery-single">
                        <img src="{{ $heroGallery[0] }}" alt="{{ $tour->name }}">
                    </div>
                @else
                    <div class="tour-gallery-grid">
                        <div class="gallery-main">
                            <img src="{{ $heroGallery[0] }}" alt="{{ $tour->name }}">
                        </div>
                        <div class="gallery-side gallery-side--{{ $sideGallery->count() }}">
                            @foreach($sideGallery as $index => $image)
                                <div class="gallery-side-item {{ $sideGallery->count() === 3 && $loop->last ? 'is-wide' : '' }}">
                                    <img src="{{ $image }}" alt="{{ $tour->name }} {{ $index + 2 }}">
                                    @if($loop->last && $galleryImages->count() > 5)
                                        <div class="gallery-more">+{{ $galleryImages->count() - 5 }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="row tour-detail-main-row">
            <div class="col-lg-7">
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
                            <i class="fa fa-road"></i>
                            <div>
                                <strong>Phương tiện</strong>
                                <p>{{ $tour->transport_type ?: 'Đang cập nhật' }}</p>
                            </div>
                        </div>
                        <div class="overview-card">
                            <i class="fa fa-users"></i>
                            <div>
                                <strong>Số chỗ</strong>
                                <p>{{ $tour->remaining_seats }} chỗ</p>
                            </div>
                        </div>
                        <div class="overview-card">
                            <i class="fa fa-star"></i>
                            <div>
                                <strong>Chất lượng</strong>
                                <p>{{ $avgRating }}/5 từ {{ $reviews->count() }} đánh giá</p>
                            </div>
                        </div>
                        <div class="overview-card">
                            <i class="fa fa-building"></i>
                            <div>
                                <strong>Khach san</strong>
                                <p>{{ $tour->hotel_name ?: 'Dang cap nhat' }}</p>
                            </div>
                        </div>
                        <div class="overview-card">
                            <i class="fa fa-hotel"></i>
                            <div>
                                <strong>Tieu chuan</strong>
                                @if($hotelStars > 0)
                                    <p class="hotel-stars-line">
                                        <span>{{ $hotelStars }} sao</span>
                                        <span aria-hidden="true">
                                            @for($i = 1; $i <= 5; $i++)
                                                {{ $i <= $hotelStars ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                    </p>
                                @else
                                    <p>Dang cap nhat</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($tour->hotel_name || $hotelStars > 0)
                    <div class="content-panel mb-4">
                        <div class="section-head">
                            <span class="section-kicker">Luu tru</span>
                            <h3>Thong tin khach san</h3>
                        </div>
                        <div class="stay-card">
                            <div class="stay-card__icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="stay-card__content">
                                <strong>{{ $tour->hotel_name ?: 'Khach san se duoc cap nhat sau' }}</strong>
                                @if($hotelStars > 0)
                                    <div class="stay-card__stars" aria-label="Khach san {{ $hotelStars }} sao">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $hotelStars ? 'is-active' : '' }}">★</span>
                                        @endfor
                                        <em>{{ $hotelStars }} sao</em>
                                    </div>
                                @else
                                    <p class="stay-card__note">Tieu chuan khach san dang duoc cap nhat.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

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
                                <details class="itinerary-day" {{ $loop->first ? 'open' : '' }}>
                                    <summary class="itinerary-summary">
                                        <span class="itinerary-day-badge">Ngày {{ $schedule->day_no }}</span>
                                        <div class="itinerary-summary-copy">
                                            <h4>{{ $schedule->title }}</h4>
                                            <p>{{ collect($timelineLines)->filter(fn ($line) => trim((string) $line) !== '')->count() }} hoạt động trong ngày</p>
                                        </div>
                                        <span class="itinerary-summary-icon" aria-hidden="true">
                                            <i class="fa fa-chevron-down"></i>
                                        </span>
                                    </summary>
                                    <div class="itinerary-card">
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
                                </details>
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

            <div class="col-lg-5">
                <div class="booking-card {{ $tour->remaining_seats <= 0 ? 'is-sold-out' : '' }}">
                    <div class="booking-card-head">
                        <span class="booking-card-chip">Đặt tour</span>
                        <h3>Sẵn sàng cho chuyến đi này?</h3>
                        <p>Chọn số lượng khách và ngày đi để gửi yêu cầu đặt tour.</p>
                    </div>

                    <div class="price-main">{{ number_format($tour->price_adult,0,',','.') }} VND</div>
                    <p class="price-note">Giá cho 1 người lớn</p>
                    @if($tour->remaining_seats <= 0)
                        <p class="sold-out-message">Tour này đã hết chỗ. Vui lòng chọn tour khác.</p>
                    @endif

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

                    <div class="date-box">
                        <label><strong>Ngày đi</strong></label>
                        <input
                            type="date"
                            id="travelDate"
                            min="{{ date('Y-m-d') }}"
                            value=""
                            class="form-control modern-input"
                        >
                    </div>

                    <div class="price-breakdown" id="priceBreakdown"></div>

                    <div class="total-box">
                        <span>Tổng cộng</span>
                        <strong id="totalPrice"></strong>
                    </div>

                    <div class="booking-card-actions">
                        @if(Auth::check())
                            <button onclick="goCheckout()" class="btn btn-book w-100 {{ $tour->remaining_seats <= 0 ? 'is-disabled' : '' }}">Gửi yêu cầu đặt tour</button>
                        @else
                            <button onclick="requireLogin()" class="btn-book w-100 {{ $tour->remaining_seats <= 0 ? 'is-disabled' : '' }}">Đăng nhập để đặt tour</button>
                        @endif
                    </div>
                </div>

                <div class="mobile-booking-bar">
                    <div class="mobile-booking-bar__meta">
                        <span>Tổng cộng</span>
                        <strong id="mobileTotalPrice"></strong>
                    </div>
                    @if(Auth::check())
                        <button onclick="goCheckout()" class="btn btn-book mobile-booking-bar__button {{ $tour->remaining_seats <= 0 ? 'is-disabled' : '' }}">Đặt tour</button>
                    @else
                        <button onclick="requireLogin()" class="btn-book mobile-booking-bar__button {{ $tour->remaining_seats <= 0 ? 'is-disabled' : '' }}">Đăng nhập</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tour-detail-page { background: linear-gradient(180deg, #f5f8fc 0%, #eef4fb 100%); }
.tour-detail-main-row { align-items: flex-start; }
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
.tour-hero-gallery { overflow: hidden; border-radius: 26px; }
.tour-gallery-grid { display: grid; grid-template-columns: 1fr 0.96fr; gap: 4px; align-items: stretch; background: #fff; }
.gallery-main,.gallery-side-item,.tour-gallery-single { position: relative; overflow: hidden; border-radius: 0; min-height: 220px; }
.tour-gallery-grid .gallery-main { border-radius: 26px 0 0 26px; }
.gallery-main { min-height: 592px; max-height: 592px; }
.gallery-side { display: grid; gap: 4px; }
.gallery-side--1 { grid-template-columns: 1fr; grid-template-rows: 1fr; }
.gallery-side--2 { grid-template-columns: 1fr; grid-template-rows: repeat(2, minmax(0, 1fr)); }
.gallery-side--3,
.gallery-side--4 { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-template-rows: repeat(2, minmax(0, 1fr)); }
.gallery-side-item { min-height: 0; height: 294px; }
.gallery-side--3 .gallery-side-item.is-wide { grid-column: 1 / -1; }
.gallery-side--1 .gallery-side-item { border-radius: 0 26px 26px 0; }
.gallery-side--2 .gallery-side-item:first-child { border-radius: 0 26px 0 0; }
.gallery-side--2 .gallery-side-item:last-child { border-radius: 0 0 26px 0; }
.gallery-side--3 .gallery-side-item:nth-child(1) { border-radius: 26px 0 0 0; }
.gallery-side--3 .gallery-side-item:nth-child(2) { border-radius: 0 26px 0 0; }
.gallery-side--3 .gallery-side-item:nth-child(3) { border-radius: 0 0 26px 26px; }
.gallery-side--4 .gallery-side-item:nth-child(1) { border-radius: 26px 0 0 0; }
.gallery-side--4 .gallery-side-item:nth-child(2) { border-radius: 0 26px 0 0; }
.gallery-side--4 .gallery-side-item:nth-child(3) { border-radius: 0 0 0 26px; }
.gallery-side--4 .gallery-side-item:nth-child(4) { border-radius: 0 0 26px 0; }
.gallery-main img,.gallery-side-item img,.tour-gallery-single img { width: 100%; height: 100%; object-fit: cover; display: block; }
.tour-gallery-single { min-height: 420px; max-height: 520px; border-radius: 26px; }
.gallery-more { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(15, 23, 42, 0.36); color: #fff; font-size: 44px; font-weight: 800; backdrop-filter: blur(2px); }
.content-panel { padding: 28px; border-radius: 26px; background: rgba(255,255,255,0.95); border: 1px solid #e5edf5; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08); }
.section-head { margin-bottom: 20px; }
.section-kicker { display: inline-flex; margin-bottom: 8px; color: #2579ba; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
.section-head h3 { margin: 0; color: #17304c; font-size: 30px; font-weight: 800; }
.tour-overview-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
.overview-card { display: flex; gap: 14px; padding: 18px; border-radius: 20px; background: #f8fbfe; border: 1px solid #eaf0f6; }
.overview-card i { width: 44px; height: 44px; border-radius: 14px; background: #f3f4f6; color: #111111; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; }
.overview-card strong { display: block; color: #17304c; margin-bottom: 4px; }
.overview-card p { margin: 0; color: #6d7f95; }
.hotel-stars-line { display: inline-flex; flex-wrap: wrap; gap: 8px; align-items: center; }
.hotel-stars-line span:last-child { color: #f59e0b; letter-spacing: 2px; }
.rich-content { color: #475569; line-height: 1.85; font-size: 15px; }
.stay-card { display: flex; gap: 16px; align-items: flex-start; padding: 20px; border-radius: 22px; background: #f8fbfe; border: 1px solid #e5edf5; }
.stay-card__icon { width: 54px; height: 54px; border-radius: 18px; background: linear-gradient(135deg, #0f766e, #155e75); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; flex: 0 0 auto; }
.stay-card__content strong { display: block; margin-bottom: 8px; color: #17304c; font-size: 20px; }
.stay-card__stars { display: inline-flex; flex-wrap: wrap; gap: 10px; align-items: center; color: #cbd5e1; font-size: 22px; }
.stay-card__stars .is-active { color: #f59e0b; }
.stay-card__stars em { font-style: normal; font-size: 14px; font-weight: 700; color: #516579; }
.stay-card__note { margin: 0; color: #6d7f95; line-height: 1.7; }
.itinerary-list { display: grid; gap: 16px; }
.itinerary-day { border-radius: 24px; border: 1px solid #e5edf5; background: #ffffff; overflow: hidden; box-shadow: 0 14px 30px rgba(15, 23, 42, 0.05); }
.itinerary-summary { list-style: none; display: grid; grid-template-columns: auto minmax(0, 1fr) auto; align-items: center; gap: 18px; padding: 18px 22px; cursor: pointer; background: linear-gradient(180deg, #fbfdff 0%, #f6fafe 100%); }
.itinerary-summary::-webkit-details-marker { display: none; }
.itinerary-day-badge { display: inline-flex; width: fit-content; padding: 12px 18px; border-radius: 999px; background: linear-gradient(135deg, #0f766e, #155e75); color: #fff; font-weight: 800; text-align: center; }
.itinerary-summary-copy h4 { margin: 0; color: #17304c; font-size: 24px; font-weight: 800; line-height: 1.35; overflow-wrap: anywhere; }
.itinerary-summary-copy p { margin: 6px 0 0; color: #6d7f95; font-size: 14px; }
.itinerary-summary-icon { width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; border-radius: 14px; background: #eef5fb; color: #17304c; transition: transform .22s ease, background .22s ease; }
.itinerary-day[open] .itinerary-summary-icon { transform: rotate(180deg); background: #dbeaf7; }
.itinerary-card { width: 100%; padding: 0 22px 22px; background: #ffffff; overflow: hidden; }
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
.booking-card { position: sticky; top: 132px; margin-top: 18px; padding: 34px; border-radius: 30px; background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%); border: 1px solid #e2edf7; box-shadow: 0 24px 50px rgba(15,23,42,.08); }
.booking-card.is-sold-out { border-color: #fecaca; background: linear-gradient(180deg, #fff7f7 0%, #fff1f2 100%); }
.booking-card-head h3 { margin: 10px 0 10px; color: #17304c; font-size: 34px; font-weight: 800; line-height: 1.2; }
.booking-card-head p { margin: 0 0 18px; color: #6d7f95; line-height: 1.7; font-size: 17px; }
.sold-out-message { color: #b91c1c !important; font-weight: 600; }
.booking-card-chip { display: inline-flex; padding: 9px 16px; border-radius: 999px; background: #f3f4f6; color: #111111; font-size: 13px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
.price-main { font-size: 40px; font-weight: 800; color: #dc2626; line-height: 1.12; letter-spacing: -0.03em; }
.price-note { margin: 8px 0 22px; color: #8da0b2; font-size: 16px; }
.quantity-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 14px; margin-bottom: 22px; }
.guest-card { padding: 18px; border-radius: 20px; background: #fff; border: 1px solid #e5edf5; }
.guest-card label { display: block; margin-bottom: 14px; color: #42586e; font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: .08em; }
.quantity-box { display: flex; justify-content: center; align-items: center; gap: 12px; }
.quantity-box button { width: 38px; height: 38px; border: none; background: #111111; color: white; border-radius: 12px; font-weight: bold; font-size: 18px; }
.quantity-box span { min-width: 34px; text-align: center; font-weight: 800; color: #17304c; font-size: 19px; }
.date-box { margin-bottom: 20px; }
.date-box label { display: block; margin-bottom: 10px; font-size: 17px; color: #111827; }
.modern-input { min-height: 58px; border-radius: 18px; border: 1px solid #d2dfea; background: #fbfdff; box-shadow: none; font-size: 17px; padding: 0 18px; }
.modern-input:focus { border-color: #57a5da; box-shadow: 0 0 0 4px rgba(44, 131, 197, 0.14); }
.price-breakdown { white-space: pre-line; margin-bottom: 16px; color: #6d7f95; line-height: 1.75; overflow-wrap: anywhere; font-size: 15px; }
.total-box { display: flex; justify-content: space-between; align-items: center; gap: 18px; padding: 20px 22px; border-radius: 22px; background: #eef7ff; border: 1px solid #d8e8f7; }
.total-box span { color: #587188; font-weight: 700; font-size: 16px; }
.total-box strong { color: #ff0000; font-size: 26px; text-align: right; overflow-wrap: anywhere; }
.btn-book { min-height: 60px; border: none; border-radius: 18px; background: linear-gradient(135deg, #1d7dc4 0%, #1a9ed6 100%); color: #fff; font-size: 18px; font-weight: 700; box-shadow: 0 14px 26px rgba(30, 126, 196, 0.25); }
.btn-book.is-disabled { background: #9ca3af; box-shadow: none; cursor: not-allowed; }
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
    .tour-hero-gallery { border-radius: 24px; }
    .tour-gallery-grid .gallery-main { border-radius: 24px; }
    .gallery-side { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; grid-template-rows: none !important; gap: 10px; margin-top: 10px; }
    .gallery-side .gallery-side-item,
    .gallery-side--1 .gallery-side-item,
    .gallery-side--2 .gallery-side-item,
    .gallery-side--3 .gallery-side-item,
    .gallery-side--4 .gallery-side-item { border-radius: 18px; }
    .gallery-side--3 .gallery-side-item.is-wide { grid-column: auto; }
    .gallery-side-item { min-height: 140px; height: 140px; }
    .itinerary-summary { grid-template-columns: 1fr auto; gap: 12px; padding: 16px; }
    .itinerary-day-badge { grid-column: 1 / -1; }
    .itinerary-summary-copy h4 { font-size: 20px; }
    .itinerary-card { padding: 0 16px 16px; }
    .itinerary-row { grid-template-columns: 1fr; }
    .stay-card { flex-direction: column; }
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
const remainingSeats = Number({{ $tour->remaining_seats }});
const travelDateInput = document.getElementById('travelDate');
let adultQty = 1;
let childQty = 0;

function changeQty(type, value) {
    if (type === 'adult') {
        const nextAdultQty = Math.max(1, adultQty + value);
        if ((nextAdultQty + childQty) > remainingSeats && value > 0) {
            alert('So khach vuot qua so cho con lai. Tour chi con ' + remainingSeats + ' cho.');
            return;
        }
        adultQty = nextAdultQty;
        document.getElementById('adultQty').innerText = adultQty;
    }
    if (type === 'child') {
        const nextChildQty = Math.max(0, childQty + value);
        if ((adultQty + nextChildQty) > remainingSeats && value > 0) {
            alert('So khach vuot qua so cho con lai. Tour chi con ' + remainingSeats + ' cho.');
            return;
        }
        childQty = nextChildQty;
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
    if (remainingSeats <= 0) {
        alert('Tour đã hết chỗ.');
        return;
    }
    if ((adultQty + childQty) > remainingSeats) {
        alert('So khach vuot qua so cho con lai. Tour chi con ' + remainingSeats + ' cho.');
        return;
    }
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
    if (remainingSeats <= 0) {
        alert('Tour đã hết chỗ.');
        return;
    }
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
