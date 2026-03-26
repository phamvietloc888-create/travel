@extends('clients.layout')

@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg')}}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">Home <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>Điểm đến <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Điểm đến yêu thích</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section destination-section-modern">
    <div class="container">
        <div class="destination-region-bar ftco-animate">
            <a href="{{ route('destinations.index') }}"
               class="destination-region-pill {{ !$currentRegion ? 'is-active' : '' }}">
                Tất cả
            </a>
            @foreach($regions as $region)
                <a href="{{ route('destinations.index', ['region' => $region]) }}"
                   class="destination-region-pill {{ $currentRegion === $region ? 'is-active' : '' }}">
                    {{ $region }}
                </a>
            @endforeach
        </div>

        <div class="destination-section-head ftco-animate">
            <div>
                <span class="destination-section-kicker">Khám phá theo vùng miền</span>
                <h2 class="destination-section-title">{{ $currentRegion ?: 'Tất cả điểm đến nổi bật' }}</h2>
            </div>
            <p class="destination-section-meta">{{ $destinations->total() }} điểm đến đang hiển thị</p>
        </div>

        <div class="row">
            @forelse ($destinations as $destination)
                <div class="col-md-6 col-lg-4 ftco-animate">
                    <div class="destination-card-modern">
                        <a href="{{ route('tours.byDestination', $destination->slug) }}"
                           class="destination-card-image"
                           style="background-image: url('{{ $destination->thumbnail_url }}');">
                            <span class="destination-tour-badge">{{ $destination->tours_count }} tours</span>
                        </a>

                        <div class="destination-card-body">
                            <div class="destination-card-top">
                                <span class="destination-region-tag">{{ $destination->region ?: 'Việt Nam' }}</span>
                                <span class="destination-location-text">{{ $destination->province ?: 'Đang cập nhật' }}</span>
                            </div>

                            <h3 class="destination-card-title">
                                <a href="{{ route('tours.byDestination', $destination->slug) }}">{{ $destination->name }}</a>
                            </h3>

                            <p class="destination-card-desc">
                                {{ \Illuminate\Support\Str::limit(strip_tags($destination->description ?: 'Điểm đến phù hợp cho hành trình nghỉ dưỡng, khám phá và trải nghiệm bản sắc địa phương.'), 110) }}
                            </p>

                            <div class="destination-card-footer">
                                <div class="destination-card-stat">
                                    <span class="fa fa-map-marker"></span>
                                    {{ $destination->province ?: 'Việt Nam' }}
                                </div>
                                <a href="{{ route('tours.byDestination', $destination->slug) }}" class="destination-card-link">
                                    Xem tour
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="destination-empty-state">
                        <h3>Chưa có điểm đến phù hợp</h3>
                        <p>Hãy thử chuyển sang vùng miền khác hoặc xem lại tất cả điểm đến.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($destinations->hasPages())
            <div class="row mt-5">
                <div class="col text-center">
                    {{ $destinations->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</section>

<style>
.destination-section-modern {
    padding-top: 5rem;
    padding-bottom: 5rem;
}

.destination-region-bar {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 28px;
    padding: 10px;
    border-radius: 28px;
    background: #f3f5f9;
    box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.16);
}

.destination-region-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 56px;
    padding: 12px 18px;
    border-radius: 22px;
    color: #64748b;
    font-size: 15px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    background: transparent;
    transition: all 0.22s ease;
}

.destination-region-pill:hover {
    color: #1e293b;
    background: rgba(255, 255, 255, 0.75);
}

.destination-region-pill.is-active {
    color: #fff;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.28);
}

.destination-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 28px;
}

.destination-section-kicker {
    display: inline-block;
    margin-bottom: 8px;
    color: #2563eb;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.destination-section-title {
    margin: 0;
    color: #0f172a;
    font-size: 36px;
    font-weight: 800;
    line-height: 1.2;
}

.destination-section-meta {
    margin: 0;
    color: #64748b;
    font-size: 15px;
}

.destination-card-modern {
    overflow: hidden;
    margin-bottom: 28px;
    border-radius: 24px;
    background: #fff;
    border: 1px solid rgba(148, 163, 184, 0.18);
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
}

.destination-card-image {
    position: relative;
    display: block;
    min-height: 260px;
    background-size: cover;
    background-position: center;
}

.destination-card-image::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.08) 0%, rgba(15, 23, 42, 0.36) 100%);
}

.destination-tour-badge {
    position: absolute;
    top: 18px;
    right: 18px;
    z-index: 1;
    padding: 8px 12px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.92);
    color: #0f172a;
    font-size: 13px;
    font-weight: 700;
}

.destination-card-body {
    padding: 22px;
}

.destination-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 14px;
}

.destination-region-tag {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
}

.destination-location-text {
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
}

.destination-card-title {
    margin-bottom: 12px;
    font-size: 26px;
    font-weight: 800;
    line-height: 1.25;
}

.destination-card-title a {
    color: #0f172a;
}

.destination-card-desc {
    margin-bottom: 18px;
    color: #475569;
    font-size: 15px;
    line-height: 1.75;
}

.destination-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.destination-card-stat {
    color: #334155;
    font-size: 14px;
    font-weight: 600;
}

.destination-card-stat .fa {
    margin-right: 6px;
    color: #2563eb;
}

.destination-card-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 0 18px;
    border-radius: 14px;
    background: #0f172a;
    color: #fff;
    font-size: 14px;
    font-weight: 700;
}

.destination-card-link:hover {
    color: #fff;
    background: #1e293b;
}

.destination-empty-state {
    padding: 48px 28px;
    text-align: center;
    border-radius: 24px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}

.destination-empty-state h3 {
    margin-bottom: 10px;
    color: #0f172a;
    font-size: 26px;
    font-weight: 800;
}

.destination-empty-state p {
    margin: 0;
    color: #64748b;
}

@media (max-width: 991.98px) {
    .destination-region-bar {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .destination-section-head {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 767.98px) {
    .destination-section-modern {
        padding-top: 4rem;
        padding-bottom: 4rem;
    }

    .destination-region-bar {
        grid-template-columns: 1fr;
        gap: 10px;
        border-radius: 22px;
    }

    .destination-region-pill {
        min-height: 50px;
        font-size: 14px;
    }

    .destination-section-title {
        font-size: 30px;
    }

    .destination-card-image {
        min-height: 220px;
    }

    .destination-card-top,
    .destination-card-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endsection
