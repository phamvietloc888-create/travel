@extends('clients.layout')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image:  url('{{ asset('clients/images/bg_1.jpg')}}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
         <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="fa fa-chevron-right"></i></a></span> <span>Tour List <i class="fa fa-chevron-right"></i></span></p>
         <h1 class="mb-0 bread">Danh sách tour du lịch</h1>
     </div>
 </div>
</div>
</section>
<section class="ftco-section bg-light">
    <div class="container-fluid px-4">
        <div class="row">

            {{-- SIDEBAR --}}
            <div class="col-md-4">
                <div class="filter-modern">
                    <form method="GET" action="{{ route('tours.index') }}">

         <div class="filter-header">
    <h5>Bộ lọc tìm kiếm</h5>

   <a href="{{ route('tours.index') }}" class="button">
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 16 16"
    fill="currentColor"
  >
    <path
      d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"
    />
    <path
      fill-rule="evenodd"
      d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"
    />
  </svg>
  Đặt lại
</a>
</div>
                        <div class="filter-group">
                            <label>Ngân sách</label>
                            <select name="budget" class="form-control modern-input">
                                <option value="">Tất cả</option>
                                <option value="duoi-5" {{ request('budget')=='duoi-5'?'selected':'' }}>Dưới 5 triệu</option>
                                <option value="5-10" {{ request('budget')=='5-10'?'selected':'' }}>5 - 10 triệu</option>
                                <option value="10-20" {{ request('budget')=='10-20'?'selected':'' }}>10 - 20 triệu</option>
                                <option value="tren-20" {{ request('budget')=='tren-20'?'selected':'' }}>Trên 20 triệu</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Điểm khởi hành</label>
                            <select name="start_location" class="form-control modern-input">
                                <option value="">Tất cả</option>
                                @foreach($startLocations as $location)
                                    <option value="{{ $location }}"
                                        {{ request('start_location') == $location ? 'selected' : '' }}>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Điểm đến</label>
                            <select name="destination_id" class="form-control modern-input">
                                <option value="">Tất cả</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}"
                                        {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Ngày đi</label>
                            <input type="date"
                                   name="start_date"
                                   value="{{ request('start_date') }}"
                                   class="form-control modern-input">
                        </div>

                        <button class="btn-apply">
                            Áp dụng
                        </button>

                    </form>
                </div>
            </div>

            {{-- TOUR LIST --}}
     <div class="col-md-8">

    <div class="mb-4">
        <h4>
            Tìm thấy <strong>{{ $tours->total() }}</strong> tour
        </h4>
    </div>

    <div class="row">
        @forelse ($tours as $tour)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="tour-card-grid">

                <div class="tour-card-media">
                    <a href="{{ route('tours.show', $tour->slug) }}">
                        <img class="tour-img"
                             src="{{ $tour->thumbnail_url }}"
                             alt="{{ $tour->name }}">
                    </a>
                    @if($tour->remaining_seats <= 0)
                        <div class="tour-stock-badge is-sold-out">Hết chỗ</div>
                    @else
                        <div class="tour-stock-badge">Còn {{ $tour->remaining_seats }} chỗ</div>
                    @endif
                </div>
                <div class="tour-body">

                    <h5 class="tour-title-grid">
                        <a href="{{ route('tours.show', $tour->slug) }}">
                            {{ $tour->name }}
                        </a>
                    </h5>
                    {{-- ⭐ ĐÁNH GIÁ --}}
                    <div class="tour-rating mb-2">
                        @php
                            $avg = $tour->avg_rating ?? 0;
                            $fullStars = floor($avg);
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $fullStars)
                                <i class="fa fa-star text-warning"></i>
                            @else
                                <i class="fa fa-star text-secondary"></i>
                            @endif
                        @endfor

                        <span class="ms-2">
                            {{ number_format($avg,1) }}/5.0 | {{ $tour->total_reviews }} đánh giá
                        </span>
                    </div>

                    <div class="tour-info">
                        <div>
                            <i class="fa fa-clock"></i>
                            {{ $tour->duration_days }} ngày {{ $tour->duration_days - 1 }} đêm
                        </div>

                        <div>
                            <i class="fa fa-map-marker"></i>
                            Khởi hành: {{ $tour->start_location }}
                        </div>

                        <div>
                            <i class="fa fa-bus"></i>
                            Di chuyển: {{ $tour->transport_type ?: 'Đang cập nhật' }}
                        </div>

                    </div>

                    <div class="tour-footer mt-3">
                        <div class="tour-price-grid text-danger fw-bold">
                            Giá từ {{ number_format($tour->price_adult) }}đ
                        </div>

                        @if($tour->remaining_seats <= 0)
                            <a href="{{ route('tours.show', $tour->slug) }}" class="btn-detail-grid is-disabled">
                                Hết chỗ
                            </a>
                        @else
                            <a href="{{ route('tours.show', $tour->slug) }}" class="btn-detail-grid">
                                Xem
                            </a>
                        @endif
                    </div>

                </div>

            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Không có tour nào.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $tours->links('pagination::bootstrap-4') }}
    </div>

</div>

        </div>
    </div>
</section>


<style>

/* ===== TOUR CARD ===== */

.tour-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    transition: 0.3s ease;
}

.tour-card:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.tour-image {
    width: 100%;
    height: 320px;
    object-fit: cover;
}

.tour-title a {
    font-size: 22px;
    font-weight: 700;
    color: #111;
    text-decoration: none;
}

.tour-title a:hover {
    color: #0d6efd;
}

.tour-meta {
    font-size: 15px;
    color: #555;
}

.tour-meta i {
    margin-right: 6px;
    color: #555;
}

.price-label {
    font-size: 14px;
    color: #666;
}

.tour-price {
    font-size: 30px;
    font-weight: 700;
    color: #e10600;
}

.btn-detail {
    background: #111111;
    color: #fff;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
}

.btn-detail:hover {
    background: #000000;
    color: #fff;
}
.tour-card-media {
    position: relative;
}
.tour-stock-badge {
    display: inline-flex;
    align-items: center;
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 2;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(232, 247, 238, 0.96);
    color: #0f7b3b;
    font-size: 13px;
    font-weight: 700;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.14);
}
.tour-stock-badge.is-sold-out {
    background: rgba(254, 226, 226, 0.96);
    color: #b91c1c;
}
.btn-detail-grid.is-disabled {
    background: #9ca3af;
    pointer-events: none;
}

/* ===== SIDEBAR FULL SIZE ===== */

.filter-modern {
    background: #f3f4f6;
    padding: 35px;
    border-radius: 22px;
    top: 100px;
    position: sticky;
}

.filter-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #222;
}

.filter-group {
    margin-bottom: 28px;
}

.filter-group label {
    font-weight: 600;
    margin-bottom: 10px;
    display: block;
    font-size: 16px;
}

.modern-input {
    width: 100%;
    height: px;              /* chiều cao chuẩn */
    border-radius: 10px;
    border: 1px solid #d1d5db;
    padding: 0 14px;
    font-size: 14px;
    background: #fff;
}

.modern-input:focus {
    border-color: #2f6fad;
    box-shadow: 0 0 0 3px rgba(47,111,173,0.1);
    outline: none;
}

/* BUTTON GRID */

.filter-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 25px;
}

.filter-btn {
    height: 52px;               /* TO hơn */
    border-radius: 12px;
    border: 1px solid #d1d5db;
    background: #fff;
    font-size: 15px;
    font-weight: 600;
    transition: 0.2s ease;
}

.filter-btn:hover {
    border-color: #2f6fad;
}

.filter-btn.active {
    background: #e6f0fb;
    border-color: #2f6fad;
    color: #2f6fad;
}

/* APPLY BUTTON */

.btn-apply {
    width: 100%;
    height: 50px;            /* TO giống hình */
    border-radius: 14px;
    background: #1f5e99;
    border: none;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-apply:hover {
    background: #174a77;
}
/* HEADER FILTER */

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.filter-header h5 {
    font-size: 22px;
    font-weight: 700;
    margin: 0;
    color: #1f2937;
}

.btn-reset-inline {
    background: #e5e7eb;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    text-decoration: none;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-reset-inline i {
    font-size: 13px;
}

.filter-modern {
    padding: 22px;
    border-radius: 18px;
}

.filter-group {
    margin-bottom: 18px;
}

.filter-group label {
    margin-bottom: 7px;
    font-size: 14px;
}

.modern-input {
    height: 46px !important;
    padding: 0 12px;
    font-size: 13px;
}

.btn-apply {
    height: 44px;
    border-radius: 12px;
    font-size: 15px;
}

.filter-header {
    margin-bottom: 18px;
}

.filter-header h5 {
    font-size: 16px;
}

.filter-header .button {
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 13px;
}

.filter-header .button svg {
    width: 14px;
    height: 14px;
}

@media (max-width: 767.98px) {
    .filter-modern {
        padding: 18px;
    }
}
</style>

@endsection
