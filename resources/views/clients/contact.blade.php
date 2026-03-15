@extends('clients.layout')
@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_1.jpg')}}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>Liên hệ <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Liên hệ với chúng tôi</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section contact-section bg-light">
    <div class="container">
        <div class="row d-flex mb-5 contact-info">
            <div class="col-md-4 d-flex">
                <div class="box p-4 text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-map-marker"></span>
                    </div>
                    <h3 class="mb-3">Địa chỉ</h3>
                    <p>123 Đường Du Lịch, Quận 1, TP. Hồ Chí Minh</p>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="box p-4 text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-phone"></span>
                    </div>
                    <h3 class="mb-3">Điện thoại</h3>
                    <p><a href="tel:0988888888">0988 888 888</a></p>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="box p-4 text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-paper-plane"></span>
                    </div>
                    <h3 class="mb-3">Email</h3>
                    <p><a href="mailto:support@lotusvietnamtravel.vn">support@lotusvietnamtravel.vn</a></p>
                </div>
            </div>
        </div>

        <div class="row block-9">
            <div class="col-md-6 order-md-last d-flex">
                <form action="{{ route('contact.submit') }}" method="POST" class="bg-white p-5 contact-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Họ và tên" value="{{ old('name', auth()->user()?->name) }}">
                        @error('name')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email', auth()->user()?->email) }}">
                        @error('email')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Chủ đề" value="{{ old('subject') }}">
                        @error('subject')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea name="message" cols="30" rows="7" class="form-control @error('message') is-invalid @enderror" placeholder="Nội dung">{{ old('message') }}</textarea>
                        @error('message')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <input type="submit" value="Gửi liên hệ" class="btn btn-primary py-3 px-5">
                    </div>
                </form>
            </div>

            <div class="col-md-6 d-flex">
                <div class="bg-white p-4 p-md-5 w-100 d-flex flex-column justify-content-center">
                    <span class="subheading">Lotus Vietnam Travel</span>
                    <h2 class="mb-4">Chúng tôi luôn sẵn sàng hỗ trợ</h2>
                    <p class="mb-4">Nếu bạn cần tư vấn tour, hỗ trợ booking hoặc muốn hợp tác, hãy gửi thông tin qua form liên hệ. Đội ngũ của chúng tôi sẽ phản hồi sớm nhất trong giờ làm việc.</p>
                    <ul class="list-unstyled">
                        <li class="mb-3"><strong>Giờ làm việc:</strong> 08:00 - 18:00, Thứ 2 đến Thứ 7</li>
                        <li class="mb-3"><strong>Hotline:</strong> 0988 888 888</li>
                        <li><strong>Email hỗ trợ:</strong> support@lotusvietnamtravel.vn</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
