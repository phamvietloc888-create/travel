@extends('clients.layout')

@section('content')
    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ $post['image'] }}'); min-height: 620px;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center" style="min-height: 620px;">
                <div class="col-lg-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="{{ route('home') }}">Trang chu <i class="fa fa-chevron-right"></i></a>
                        </span>
                        <span class="mr-2">
                            <a href="{{ route('blog.index') }}">Blog <i class="fa fa-chevron-right"></i></a>
                        </span>
                        <span>{{ $post['category'] }}</span>
                    </p>
                    <div class="article-badge">{{ $post['category'] }}</div>
                    <h1 class="mb-3 bread article-title">{{ $post['title'] }}</h1>
                    <div class="article-meta">
                        <span>{{ \Carbon\Carbon::parse($post['published_at'])->format('d/m/Y') }}</span>
                        <span>{{ $post['read_time'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section article-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9">
                    <article class="article-shell ftco-animate">
                        <div class="article-intro">
                            <p>Bai viet duoc bien soan theo huong thuc te, de doc va uu tien thong tin nguoi dang chuan bi di du lich thuong can tim nhat.</p>
                        </div>

                        @foreach ($post['sections'] as $section)
                            <section class="article-block">
                                <h2>{{ $section['heading'] }}</h2>
                                @foreach ($section['paragraphs'] as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            </section>
                        @endforeach

                        <div class="article-action-box">
                            <h3>Muon xem them hanh trinh phu hop?</h3>
                            <p>Ban co the tiep tuc tham khao danh sach tour va diem den de doi chieu voi nhung kinh nghiem vua doc.</p>
                            <div class="article-action-links">
                                <a href="{{ route('tours.index') }}" class="btn btn-primary py-3 px-4">Xem tour</a>
                                <a href="{{ route('destinations.index') }}" class="btn btn-outline-dark py-3 px-4">Kham pha diem den</a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-xl-10">
                    <div class="heading-section text-center ftco-animate mb-4">
                        <span class="subheading">Doc tiep</span>
                        <h2 class="mb-0">Bai viet lien quan</h2>
                    </div>
                    <div class="row">
                        @foreach ($relatedPosts as $relatedPost)
                            <div class="col-md-6 d-flex ftco-animate mb-4">
                                <article class="related-post-card">
                                    <a href="{{ route('blog.show', $relatedPost['slug']) }}" class="related-post-image" style="background-image: url('{{ $relatedPost['image'] }}');"></a>
                                    <div class="related-post-body">
                                        <div class="related-post-meta">
                                            <span>{{ $relatedPost['category'] }}</span>
                                            <span>{{ $relatedPost['read_time'] }}</span>
                                        </div>
                                        <h3>
                                            <a href="{{ route('blog.show', $relatedPost['slug']) }}">{{ $relatedPost['title'] }}</a>
                                        </h3>
                                        <a href="{{ route('blog.show', $relatedPost['slug']) }}" class="related-post-link">Doc bai viet</a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .article-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 0 18px;
            border-radius: 999px;
            margin-bottom: 18px;
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .article-title {
            max-width: 820px;
            margin-left: auto;
            margin-right: auto;
        }

        .article-meta {
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
            color: rgba(255, 255, 255, 0.86);
            font-weight: 600;
        }

        .article-section {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
        }

        .article-shell {
            padding: 42px 38px;
            border-radius: 30px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 24px 56px rgba(15, 23, 42, 0.08);
        }

        .article-intro p {
            font-size: 18px;
            line-height: 1.9;
            color: #334155;
            margin-bottom: 28px;
        }

        .article-block + .article-block {
            margin-top: 28px;
        }

        .article-block h2 {
            font-size: 32px;
            line-height: 1.35;
            margin-bottom: 16px;
            color: #0f172a;
        }

        .article-block p {
            color: #334155;
            line-height: 1.95;
            font-size: 17px;
            margin-bottom: 16px;
        }

        .article-action-box {
            margin-top: 34px;
            padding: 30px;
            border-radius: 24px;
            background: #f8fafc;
            border: 1px solid rgba(15, 23, 42, 0.08);
        }

        .article-action-box h3 {
            margin-bottom: 10px;
        }

        .article-action-box p {
            color: #475569;
            margin-bottom: 18px;
        }

        .article-action-links {
            display: inline-flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .related-post-card {
            width: 100%;
            overflow: hidden;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.08);
        }

        .related-post-image {
            display: block;
            min-height: 220px;
            background-size: cover;
            background-position: center;
        }

        .related-post-body {
            padding: 24px;
        }

        .related-post-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
        }

        .related-post-body h3 {
            font-size: 24px;
            line-height: 1.4;
            margin-bottom: 14px;
        }

        .related-post-body h3 a,
        .related-post-link {
            color: #111111;
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
            .article-shell {
                padding: 26px 18px;
                border-radius: 24px;
            }

            .article-block h2 {
                font-size: 26px;
            }

            .article-block p,
            .article-intro p {
                font-size: 16px;
            }

            .article-action-box,
            .related-post-body {
                padding: 22px 18px;
            }
        }
    </style>
@endsection
