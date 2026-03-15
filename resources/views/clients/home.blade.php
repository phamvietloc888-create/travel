@extends('clients.layout')
@section('content')

    <div class="hero-wrap js-fullheight" style="background-image: url('{{ asset('clients/images/bg_5.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <span class="subheading" style="color: #dc2626 !important;">Welcome to Lotus</span>
                    <h1 class="mb-4">Cùng bạn khám phá những miền đất yêu thương</h1>
                    <p class="caps">Khám phá muôn nơi, hành trình gọn gàng, trọn vẹn</p>
                </div>
                <a href="https://www.youtube.com/watch?v=Au6LqK1UH8g" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
                    <span class="fa fa-play"></span>
                </a>
            </div>
        </div>
    </div>

    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ftco-search d-flex justify-content-center">
                        <div class="row">
                            <div class="col-md-12 nav-link-wrap">
                                <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active mr-md-1" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Search Tour</a>
                                </div>
                            </div>
                            <div class="col-md-12 tab-wrap">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel">
                                        <form action="{{ route('tours.index') }}" method="GET" class="search-property-1">
                                            <div class="row no-gutters">
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4 border-0">
                                                        <label>Điểm đến</label>
                                                        <div class="form-field">
                                                            <div class="icon"><span class="fa fa-search"></span></div>
                                                            <input type="text" name="destination" class="form-control" placeholder="Bạn muốn đi đâu?">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label>Ngày khởi hành</label>
                                                        <div class="form-field">
                                                            <div class="icon"><span class="fa fa-calendar"></span></div>
                                                            <input type="date" name="start_date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label>Giá tiền</label>
                                                        <div class="form-field">
                                                            <div class="icon"><span class="fa fa-money"></span></div>
                                                            <select name="budget" class="form-control">
                                                                <option value="">Chọn mức giá</option>
                                                                <option value="duoi-5">Dưới 5 triệu</option>
                                                                <option value="5-10">5 - 10 triệu</option>
                                                                <option value="10-20">10 - 20 triệu</option>
                                                                <option value="tren-20">Trên 20 triệu</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md d-flex">
                                                    <div class="form-group d-flex w-100 border-0">
                                                        <div class="form-field w-100 align-items-center d-flex">
                                                            <button type="submit" class="align-self-stretch form-control btn btn-primary">
                                                                Tìm Tour
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section services-section">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
                    <div class="w-100">
                        <span class="subheading">Welcome to Pacific</span>
                        <h2 class="mb-4">Lên đường để cảm nhận vẻ đẹp Việt Nam</h2>
                        <p>Một con sông nhỏ hiền hòa uốn lượn qua làng, mang theo phù sa và hơi thở của đất trời, nuôi dưỡng cuộc sống nơi đây. Vùng đất ấy thanh bình như chốn thiên đường, nơi lời ăn tiếng nói mộc mạc, ấm áp, len lỏi vào lòng người một cách tự nhiên.</p>
                        <p>Xa xa, vượt qua những dãy núi trùng điệp và những miền đất lạ, có một làng quê nép mình bên bờ biển tri thức bao la. Người dân sống chan hòa, gắn bó với thiên nhiên, với từng con chữ, từng câu chuyện được truyền lại qua bao thế hệ. Dòng sông quen thuộc vẫn lặng lẽ chảy, mang theo tinh hoa và nếp sống thuần Việt, bồi đắp cho tâm hồn con người nơi ấy.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-1 d-block img" style="background-image: url('{{ asset('clients/images/services-1.jpg') }}');">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-paragliding"></span></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Hoạt động trải nghiệm</h3>
                                    <p>Những hoạt động phong phú, được thiết kế phù hợp để mang đến cho bạn hành trình trọn vẹn và đáng nhớ.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-2 d-block img" style="background-image: url('{{ asset('clients/images/services-2.jpg') }}');">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Sắp xếp lịch trình</h3>
                                    <p>Chúng tôi lo trọn gói mọi khâu di chuyển và sắp xếp, giúp bạn yên tâm tận hưởng chuyến đi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-3 d-block img" style="background-image: url('{{ asset('clients/images/services-3.jpg') }}');">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-tour-guide"></span></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Hướng dẫn viên riêng</h3>
                                    <p>Đồng hành cùng bạn là hướng dẫn viên tận tâm, am hiểu văn hóa và địa phương, mang đến trải nghiệm sâu sắc hơn.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                            <div class="services services-1 color-4 d-block img" style="background-image: url('{{ asset('clients/images/services-4.jpg') }}');">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-map"></span></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Quản lý điểm đến</h3>
                                    <p>Đội ngũ chuyên trách hỗ trợ và điều phối tại điểm đến, đảm bảo chuyến đi diễn ra suôn sẻ và an toàn.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section img ftco-select-destination destination-showcase-section" style="background-image: url('{{ asset('clients/images/bg_3.jpg') }}');">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                        <span class="subheading_logo">Khám phá điểm đến</span>
                        <h2 class="mb-4">Chọn điểm đến của bạn</h2>
                </div>
            </div>
        </div>
        <div class="container container-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="carousel-destination owl-carousel ftco-animate">
                        @foreach($carouselDestinations as $destination)
                            <div class="item">
                                <div class="project-destination">
                                    <a href="{{ route('tours.byDestination', $destination->slug) }}"
                                       class="img"
                                       style="background-image: url('{{ $destination->thumbnail_url }}');">
                                        <div class="text">
                                            <h3>{{ $destination->name }}</h3>
                                            <span>{{ $destination->total_tours }} Tours</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section latest-tour-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Tour</span>
                    <h2 class="mb-4">Tour mới nhất</h2>
                </div>
            </div>

            <div class="row">
                @forelse ($tourDestinations as $tour)
                    <div class="col-md-6 col-lg-4 mb-4 d-flex">
                        <div class="tour-card-grid">
                            <a href="{{ route('tours.show', $tour->slug) }}">
                                <img class="tour-img"
                                     src="{{ $tour->thumbnail_url }}"
                                     alt="{{ $tour->tour_name }}">
                            </a>

                            <div class="tour-body">
                                <h5 class="tour-title-grid">
                                    <a href="{{ route('tours.show', $tour->slug) }}">
                                        {{ $tour->tour_name }}
                                    </a>
                                </h5>

                                <div class="tour-rating-grid">
                                    <div class="tour-rating-stars" aria-hidden="true">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="fa fa-star {{ $i <= floor($tour->avg_rating) ? 'is-active' : '' }}"></span>
                                        @endfor
                                    </div>
                                    <span class="tour-rating-text">{{ number_format($tour->avg_rating, 1) }}/5.0 | {{ $tour->total_reviews }} đánh giá</span>
                                </div>

                                    <div class="tour-info">
                                        <div>
                                            <i class="fa fa-clock"></i>
                                            {{ $tour->duration_days }} ngày {{ max(($tour->duration_days ?? 1) - 1, 0) }} đêm
                                        </div>

                                        <div>
                                            <i class="fa fa-map-marker"></i>
                                            Khởi hành: {{ $tour->province ?? 'Việt Nam' }}
                                        </div>
                                    </div>

                                <div class="tour-footer">
                                    <div class="tour-price-grid">
                                        Giá từ {{ number_format($tour->price_adult) }}đ
                                    </div>

                                    <a href="{{ route('tours.show', $tour->slug) }}" class="btn-detail-grid">
                                        Xem
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Chưa có tour nào.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-about img" style="background-image: url('{{ asset('clients/images/bg_4.jpg') }}');">
        <div class="overlay"></div>
        <div class="container py-md-5">
            <div class="row py-md-5">
                <div class="col-md d-flex align-items-center justify-content-center">
                    <a href="https://vimeo.com/45830194" class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
                        <span class="fa fa-play"></span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-about ftco-no-pt img">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-12 about-intro">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-stretch">
                            <div class="img d-flex w-100 align-items-center justify-content-center" style="background-image:url('{{ asset('clients/images/about-1.jpg') }}');">
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-5 py-5">
                            <div class="row justify-content-start pb-3">
                                <div class="col-md-12 heading-section ftco-animate">
                                    <span class="subheading">Về chúng tôi</span>
                                    <h2 class="mb-4">Hãy để chúng tôi giúp chuyến đi của bạn an toàn và đáng nhớ</h2>
                                    <p>
                                        Rất xa, phía sau những dãy núi ngôn từ, cách xa các miền đất Vokalia và Consonantia,
                                        có những văn bản thầm lặng sinh sống. Chúng tách biệt và tồn tại tại Bookmarksgrove,
                                        nằm bên bờ đại dương ngôn ngữ rộng lớn.
                                    </p>
                                    <p><a href="#" class="btn btn-primary">Đặt điểm đến ngay</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section testimony-section home-testimony-section bg-bottom" style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                    <span class="subheading">Đánh giá</span>
                    <h2 class="mb-4">Phản hồi từ du khách</h2>
                </div>
            </div>
            <div class="row ftco-animate">
                <div class="col-md-12">
                    <div class="carousel-testimony owl-carousel">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="item">
                                <div class="testimony-wrap py-4">
                                    <div class="text">
                                        <p class="star">
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </p>
                                        <p class="mb-4">
                                            Rất xa, phía sau những dãy núi ngôn từ, cách xa các miền đất Vokalia và Consonantia,
                                            có những văn bản thầm lặng sinh sống.
                                        </p>
                                        <div class="d-flex align-items-center">
                                            <div class="user-img" style="background-image: url('{{ asset('clients/images/person_'.$i.'.jpg') }}')"></div>
                                            <div class="pl-3">
                                                <p class="name">Roger Scott</p>
                                                <span class="position">Quản lý Marketing</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
    .destination-showcase-section,
    .latest-tour-section,
    .home-testimony-section {
        --home-primary: #111111;
        --home-primary-dark: #000000;
        --home-accent-soft: rgba(17, 17, 17, 0.18);
        --home-text: #0f172a;
        --home-muted: #475569;
        --home-surface: rgba(255, 255, 255, 0.96);
    }

    .destination-showcase-section {
        --home-primary: #111111;
        --home-primary-dark: #000000;
        --home-accent-soft: rgba(17, 17, 17, 0.22);
    }

    .destination-showcase-section .heading-section .subheading {
        color: var(--home-primary) !important;
    }

    .destination-showcase-section .container-2 {
        max-width: 1380px;
        padding: 0 24px;
        margin: 0 auto !important;
        position: relative;
        overflow: visible;
    }

    .destination-showcase-section .owl-stage-outer {
        padding: 18px 10px 24px;
        overflow: visible;
    }

    .destination-showcase-section .item {
        padding: 0 10px;
    }

    .destination-showcase-section .project-destination {
        position: relative;
    }

    .destination-showcase-section .project-destination .img {
        position: relative;
        min-height: 400px;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
        background-size: cover;
        background-position: center;
    }

    .destination-showcase-section .project-destination .img::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.04) 0%, rgba(15, 23, 42, 0.24) 100%);
    }

    .destination-showcase-section .project-destination .text {
        position: absolute;
        inset: 0;
        height: auto;
        padding: 0;
        z-index: 1;
    }

    .destination-showcase-section .project-destination .text h3 {
        top: 18px;
        left: 18px;
        margin-top: 0;
        padding: 10px 18px;
        border-radius: 16px 16px 16px 4px;
        font-size: 20px;
        font-weight: 700;
        line-height: 1;
        background: rgba(255, 255, 255, 0.12) !important;
        border: 1px solid transparent !important;
        backdrop-filter: blur(10px);
        color: #fff;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
    }

    .destination-showcase-section .project-destination .text h3::before,
    .destination-showcase-section .project-destination .text h3::after {
        display: none;
    }

    .destination-showcase-section .project-destination .text span {
        right: 18px;
        bottom: 18px;
        padding: 10px 18px;
        border-radius: 999px;
        font-size: 16px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.12) !important;
        border: 1px solid transparent !important;
        backdrop-filter: blur(10px);
        color: #fff;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);
    }

    .destination-showcase-section .project-destination .text span::after {
        display: none;
    }

    .destination-showcase-section .project-destination:hover .text span {
        background: rgba(255, 255, 255, 0.18) !important;
        border-color: transparent !important;
    }

    .destination-showcase-section .owl-dots {
        margin-top: 6px;
    }

    .destination-showcase-section .owl-dots .owl-dot span {
        width: 10px;
        height: 10px;
    }

    .testimony-section.home-testimony-section .owl-stage-outer {
        padding: 18px 0 28px;
    }

    .testimony-section.home-testimony-section .item {
        padding: 0 10px;
    }

    .testimony-section.home-testimony-section .testimony-wrap {
        min-height: 390px;
        margin-top: 0;
        border-radius: 24px;
        background: var(--home-surface);
        box-shadow: 0 22px 48px rgba(15, 23, 42, 0.14);
    }

    .testimony-section.home-testimony-section .testimony-wrap .text {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 28px 26px 24px;
    }

    .testimony-section.home-testimony-section .testimony-wrap .star {
        margin-bottom: 18px;
        color: #f5b301;
        font-size: 20px;
        letter-spacing: 2px;
    }

    .testimony-section.home-testimony-section .testimony-wrap .mb-4 {
        margin-bottom: 20px !important;
        color: var(--home-text);
        font-size: 17px;
        line-height: 1.8;
    }

    .testimony-section.home-testimony-section .testimony-wrap .d-flex.align-items-center {
        margin-top: auto;
        align-items: center !important;
        gap: 16px;
        padding-top: 18px;
        border-top: 1px solid rgba(15, 23, 42, 0.08);
    }

    .testimony-section.home-testimony-section .testimony-wrap .user-img {
        flex: 0 0 78px;
        width: 78px;
        height: 78px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        background-color: #e5e7eb;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
    }

    .testimony-section.home-testimony-section .testimony-wrap .pl-3 {
        padding-left: 0 !important;
    }

    .testimony-section.home-testimony-section .testimony-wrap .name {
        margin-bottom: 6px;
        color: var(--home-text);
        font-size: 18px;
        font-weight: 800;
    }

    .testimony-section.home-testimony-section .testimony-wrap .position {
        color: #dc2626;
        font-size: 15px;
        font-weight: 600;
    }

    .latest-tour-section .tour-card-grid {
        display: flex;
        flex-direction: column;
        width: 100%;
        border-radius: 24px;
        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .latest-tour-section .tour-card-grid:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px rgba(15, 23, 42, 0.12);
    }

    .latest-tour-section .tour-img {
        width: 100%;
        height: 276px;
        object-fit: cover;
        display: block;
    }

    .latest-tour-section .tour-body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 22px 22px 24px;
    }

    .latest-tour-section .tour-title-grid {
        margin-bottom: 16px;
        font-size: 20px;
        font-weight: 800;
        line-height: 1.45;
    }

    .latest-tour-section .tour-title-grid a {
        color: var(--home-text);
        text-decoration: none;
    }

    .latest-tour-section .tour-rating-grid {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: #4b5563;
        font-size: 15px;
    }

    .latest-tour-section .tour-rating-stars {
        display: inline-flex;
        gap: 4px;
    }

    .latest-tour-section .tour-rating-stars .fa {
        color: #9ca3af;
        font-size: 18px;
    }

    .latest-tour-section .tour-rating-stars .fa.is-active {
        color: #f5b301;
    }

    .latest-tour-section .tour-rating-text {
        color: var(--home-muted);
        line-height: 1.4;
    }

    .latest-tour-section .tour-info {
        display: grid;
        gap: 12px;
        color: var(--home-muted);
        font-size: 15px;
    }

    .latest-tour-section .tour-info div {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .latest-tour-section .tour-info i {
        width: 18px;
        color: #111111;
    }

    .latest-tour-section .tour-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-top: auto;
        padding-top: 28px;
    }

    .latest-tour-section .tour-price-grid {
        color: #dc2626;
        font-size: 20px;
        font-weight: 800;
        line-height: 1.3;
    }

    .latest-tour-section .btn-detail-grid {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 74px;
        min-height: 44px;
        padding: 0 18px;
        border-radius: 12px;
        background: var(--home-primary);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
    }

    .latest-tour-section .btn-detail-grid:hover {
        background: var(--home-primary-dark);
        color: #fff;
    }

    @media (max-width: 991.98px) {
        .services-section .heading-section {
            padding-left: 0 !important;
            margin-bottom: 24px;
        }

        .destination-showcase-section .project-destination .img {
            min-height: 340px;
        }

        .latest-tour-section .tour-img {
            height: 230px;
        }
    }

    @media (max-width: 767.98px) {
        .services-section {
            padding-top: 4rem;
        }

        .services-section .services {
            min-height: 220px;
        }

        .destination-showcase-section {
            padding-top: 4.5rem;
            padding-bottom: 4.5rem;
            overflow-x: hidden;
        }

        .destination-showcase-section .container-2 {
            padding: 0 16px;
            overflow: hidden;
        }

        .destination-showcase-section .owl-stage-outer {
            padding: 12px 4px 18px;
            overflow: hidden;
        }

        .destination-showcase-section .item {
            padding: 0 4px;
        }

        .destination-showcase-section .project-destination .img {
            min-height: 360px;
            border-radius: 24px;
        }

        .destination-showcase-section .project-destination .text h3,
        .destination-showcase-section .project-destination .text span {
            max-width: calc(100% - 28px);
            white-space: normal;
            line-height: 1.25;
        }

        .latest-tour-section .row > [class*='col-'] {
            margin-bottom: 20px;
        }

        .latest-tour-section .tour-card-grid {
            border-radius: 20px;
        }

        .latest-tour-section .tour-img {
            height: 220px;
        }

        .latest-tour-section .tour-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding-top: 22px;
        }

        .latest-tour-section .btn-detail-grid {
            width: 100%;
        }

        .testimony-section.home-testimony-section {
            padding-top: 4.5rem;
            padding-bottom: 4.5rem;
        }

        .testimony-section.home-testimony-section .item {
            padding: 0 4px;
        }

        .testimony-section.home-testimony-section .testimony-wrap {
            min-height: unset;
            border-radius: 20px;
        }

        .testimony-section.home-testimony-section .testimony-wrap .text {
            padding: 22px 18px 20px;
        }

        .testimony-section.home-testimony-section .testimony-wrap .mb-4 {
            font-size: 15px;
            line-height: 1.7;
        }
    }

    @media (max-width: 575.98px) {
        .destination-showcase-section .container-2 {
            padding: 0 12px;
        }

        .destination-showcase-section .item {
            padding: 0 6px;
        }

        .destination-showcase-section .project-destination .img {
            min-height: 340px;
            border-radius: 18px;
        }

        .destination-showcase-section .project-destination .text h3 {
            top: 12px;
            left: 12px;
            right: 12px;
            font-size: 18px;
            padding: 10px 12px;
        }

        .destination-showcase-section .project-destination .text span {
            left: 12px;
            right: auto;
            bottom: 12px;
            font-size: 14px;
            padding: 8px 12px;
        }

        .latest-tour-section .tour-body {
            padding: 18px;
        }

        .latest-tour-section .tour-title-grid {
            font-size: 18px;
        }

        .latest-tour-section .tour-rating-grid {
            font-size: 14px;
        }

        .latest-tour-section .tour-price-grid {
            font-size: 18px;
        }

        .testimony-section.home-testimony-section .testimony-wrap .d-flex.align-items-center {
            align-items: flex-start !important;
            gap: 12px;
        }

        .testimony-section.home-testimony-section .testimony-wrap .user-img {
            width: 60px;
            height: 60px;
            flex-basis: 60px;
        }
    }

    @media (max-width: 420px) {
        .destination-showcase-section .heading-section h2,
        .latest-tour-section .heading-section h2,
        .home-testimony-section .heading-section h2 {
            font-size: 31px;
        }

        .destination-showcase-section .project-destination .img {
            min-height: 320px;
        }

        .latest-tour-section .tour-img {
            height: 200px;
        }

        .latest-tour-section .tour-title-grid {
            font-size: 17px;
        }

        .latest-tour-section .tour-rating-grid,
        .latest-tour-section .tour-info {
            font-size: 13px;
        }
    }
    </style>

@endsection
