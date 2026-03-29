@extends('clients.layout')

@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('clients/images/bg_2.jpg') }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="{{ route('home') }}">Trang chu <i class="fa fa-chevron-right"></i></a>
                        </span>
                        <span>Blog du lich <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Blog Du Lich Huu Ich</h1>
                    <p class="blog-hero-copy">Tong hop bai viet goc ve kinh nghiem di chuyen, dat cho va review hanh trinh de nguoi doc de len ke hoach truoc khi di.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section blog-hub-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-10 text-center heading-section ftco-animate">
                    <span class="subheading">Noi dung cho nguoi dang tim hieu chuyen di</span>
                    <h2 class="mb-3">3 bai viet mau de xay nen mot muc blog chat luong</h2>
                    <p class="mb-0">Moi bai viet deu co noi dung goc, bo cuc ro rang va lien ket sang cac trang chinh cua website de tang do tin cay va trai nghiem doc.</p>
                </div>
            </div>

            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-6 col-lg-4 d-flex ftco-animate mb-4">
                        <article class="blog-card">
                            <a href="{{ route('blog.show', $post['slug']) }}" class="blog-card-image" style="background-image: url('{{ $post['image'] }}');"></a>
                            <div class="blog-card-body">
                                <div class="blog-card-meta">
                                    <span>{{ $post['category'] }}</span>
                                    <span>{{ \Carbon\Carbon::parse($post['published_at'])->format('d/m/Y') }}</span>
                                </div>
                                <h3>
                                    <a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'] }}</a>
                                </h3>
                                <p>{{ $post['excerpt'] }}</p>
                                <div class="blog-card-footer">
                                    <span>{{ $post['read_time'] }}</span>
                                    <a href="{{ route('blog.show', $post['slug']) }}">Doc bai viet</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="blog-cta-box text-center ftco-animate">
                <h3>Can mot hanh trinh phu hop ngay luc nay?</h3>
                <p>Ban co the doc blog truoc, sau do xem tour va lien he khi can tu van chi tiet hon.</p>
                <div class="blog-cta-actions">
                    <a href="{{ route('tours.index') }}" class="btn btn-primary py-3 px-4">Xem tour hien co</a>
                    <a href="{{ route('about') }}" class="btn btn-outline-dark py-3 px-4">Tim hieu ve chung toi</a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .blog-hero-copy {
            max-width: 760px;
            margin: 0 auto;
            color: rgba(255, 255, 255, 0.9);
            font-size: 17px;
            line-height: 1.8;
        }

        .blog-hub-section {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .blog-card {
            width: 100%;
            overflow: hidden;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.12);
        }

        .blog-card-image {
            display: block;
            min-height: 240px;
            background-size: cover;
            background-position: center;
        }

        .blog-card-body {
            padding: 24px;
        }

        .blog-card-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
        }

        .blog-card h3 {
            font-size: 25px;
            line-height: 1.35;
            margin-bottom: 14px;
        }

        .blog-card h3 a {
            color: #0f172a;
        }

        .blog-card p {
            color: #475569;
            line-height: 1.8;
            margin-bottom: 18px;
        }

        .blog-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            font-weight: 700;
        }

        .blog-card-footer span {
            color: #64748b;
            font-size: 14px;
        }

        .blog-card-footer a {
            color: #111111;
        }

        .blog-cta-box {
            margin-top: 26px;
            padding: 36px 30px;
            border-radius: 28px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.08);
        }

        .blog-cta-box h3 {
            margin-bottom: 10px;
        }

        .blog-cta-box p {
            max-width: 700px;
            margin: 0 auto 20px;
            color: #475569;
        }

        .blog-cta-actions {
            display: inline-flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        .btn-outline-dark {
            border: 1px solid #111111;
            color: #111111;
            background: transparent;
        }

        .btn-outline-dark:hover,
        .btn-outline-dark:focus {
            background: #111111;
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .blog-card-image {
                min-height: 210px;
            }

            .blog-card-body,
            .blog-cta-box {
                padding: 22px 18px;
            }

            .blog-card h3 {
                font-size: 22px;
            }

            .blog-card-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endsection
