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
                    <span>Giới thiệu <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Về Chúng Tôi</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section services-section">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
                <div class="w-100">
                    <span class="subheading">Chào mừng đến với Pacific</span>
                    <h2 class="mb-4">Đã đến lúc bắt đầu chuyến phiêu lưu của bạn</h2>
                    <p>Chúng tôi mang đến những hành trình tuyệt vời với dịch vụ chuyên nghiệp và tận tâm.</p>
                    <p>Hãy để chúng tôi đồng hành cùng bạn khám phá những điểm đến tuyệt đẹp, trải nghiệm văn hóa và tạo nên những kỷ niệm khó quên.</p>
                    <p>
                        <a href="{{ route('tours.index') }}" class="btn btn-primary py-3 px-4">Tìm kiếm điểm đến</a>
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-1 d-block img"
                            style="background-image: url('{{ asset('clients/images/services-1.jpg') }}');">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-paragliding"></span>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Hoạt động</h3>
                                <p>Nhiều hoạt động thú vị và hấp dẫn trong suốt hành trình.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-2 d-block img"
                            style="background-image: url('{{ asset('clients/images/services-2.jpg') }}');">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-route"></span>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Sắp xếp du lịch</h3>
                                <p>Hỗ trợ đặt vé máy bay, khách sạn và lịch trình hoàn chỉnh.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-3 d-block img"
                            style="background-image: url('{{ asset('clients/images/services-3.jpg') }}');">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-tour-guide"></span>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Hướng dẫn viên riêng</h3>
                                <p>Đội ngũ hướng dẫn viên chuyên nghiệp và giàu kinh nghiệm.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-4 d-block img"
                            style="background-image: url('{{ asset('clients/images/services-4.jpg') }}');">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-map"></span>
                            </div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Quản lý địa điểm</h3>
                                <p>Lựa chọn và quản lý những điểm đến tốt nhất cho bạn.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-about img"
    style="background-image: url('{{ asset('clients/images/bg_4.jpg') }}');">
    <div class="overlay"></div>
    <div class="container py-md-5">
        <div class="row py-md-5">
            <div class="col-md d-flex align-items-center justify-content-center">
                <a href="https://vimeo.com/45830194"
                    class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
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
                        <div class="img d-flex w-100 align-items-center justify-content-center"
                            style="background-image:url('{{ asset('clients/images/about-1.jpg') }}');">
                        </div>
                    </div>

                    <div class="col-md-6 pl-md-5 py-5">
                        <div class="row justify-content-start pb-3">
                            <div class="col-md-12 heading-section ftco-animate">
                                <span class="subheading">Về Chúng Tôi</span>
                                <h2 class="mb-4">Chuyến đi an toàn và đáng nhớ cùng chúng tôi</h2>
                                <p>Chúng tôi cam kết mang đến dịch vụ du lịch chất lượng cao, an toàn và chuyên nghiệp, giúp bạn tận hưởng hành trình một cách trọn vẹn nhất.</p>
                                <p>
                                    <a href="{{ route('tours.index') }}" class="btn btn-primary">Đặt điểm đến ngay</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section testimony-section bg-bottom"
    style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                <span class="subheading">Đánh giá</span>
                <h2 class="mb-4">Phản hồi của khách hàng</h2>
            </div>
        </div>

        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel">
                    @for($i = 1; $i <= 3; $i++)
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
                                    <p class="mb-4">Dịch vụ tuyệt vời, trải nghiệm đáng nhớ và đội ngũ rất chuyên nghiệp.</p>
                                    <div class="d-flex align-items-center">
                                        <div class="user-img"
                                            style="background-image: url('{{ asset('clients/images/person_'.$i.'.jpg') }}')">
                                        </div>
                                        <div class="pl-3">
                                            <p class="name">Nguyễn Văn A</p>
                                            <span class="position">Khách hàng</span>
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

@endsection
