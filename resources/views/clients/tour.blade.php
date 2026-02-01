@extends('clients.layout')

@section('content')

{{-- HERO --}}
<section class="hero-wrap hero-wrap-2 js-fullheight"
    style="background-image: url('{{ asset('clients/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">

                {{-- BREADCRUMB --}}
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ route('home') }}">
                            Home <i class="fa fa-chevron-right"></i>
                        </a>
                    </span>

                    <span>
                        Tour <i class="fa fa-chevron-right"></i>
                    </span>

                    @if(isset($destination))
                        <span>{{ $destination->name }}</span>
                    @endif
                </p>

                {{-- TITLE --}}
                <h1 class="mb-0 bread">
                    @if(isset($destination))
                        Tour {{ $destination->name }}
                    @else
                        Danh sách tour
                    @endif
                </h1>

                {{-- SUB TITLE --}}
                @if(isset($destination))
                    <p class="text-white mt-2">
                        Có {{ $tours->total() }} tour tại {{ $destination->name }}
                    </p>
                @endif

            </div>
        </div>
    </div>
</section>

{{-- TOUR LIST --}}
<section class="ftco-section">
    <div class="container">
        <div class="row">

            @forelse ($tours as $tour)
                <div class="col-md-4 ftco-animate">
                    <div class="project-wrap">

                        {{-- IMAGE --}}
                        <a href="{{ route('tours.show', $tour->slug) }}"
                           class="img"
                           style="background-image: url('{{ 
                                $tour->thumbnail_path
                                ? Storage::url($tour->thumbnail_path)
                                : asset('clients/images/destination-1.jpg')
                           }}');">

                            {{-- PRICE --}}
                            <span class="price">
                                {{ number_format($tour->price_adult) }} VND
                            </span>

                            {{-- LOW SEAT BADGE --}}
                            @if($tour->available_seats <= 5)
                                <span class="badge badge-danger"
                                      style="position:absolute;top:15px;right:15px;">
                                    Sắp hết chỗ
                                </span>
                            @endif
                        </a>

                        {{-- CONTENT --}}
                        <div class="text p-4">

                            <span class="days">
                                {{ $tour->duration_days }} ngày
                            </span>

                            <h3>
                                <a href="{{ route('tours.show', $tour->slug) }}">
                                    {{ $tour->name }}
                                </a>
                            </h3>

                            <p class="location">
                                <span class="fa fa-map-marker"></span>
                                {{ optional($tour->destination)->name ?? 'Đang cập nhật' }}
                            </p>

                            {{-- SHORT DESC --}}
                            @if($tour->short_desc)
                                <p style="font-size:14px;color:#666;">
                                    {{ Str::limit($tour->short_desc, 90) }}
                                </p>
                            @endif

                            {{-- FOOTER --}}
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span style="font-size:14px;">
                                    👥 Còn {{ $tour->available_seats }} chỗ
                                </span>

                                <a href="{{ route('tours.show', $tour->slug) }}"
                                   class="btn btn-sm btn-primary">
                                    Xem chi tiết
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center">
                    <p class="text-muted">Không có tour nào.</p>
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if ($tours->hasPages())
            <div class="row mt-5">
                <div class="col text-center">
                    {{ $tours->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</section>

@endsection
