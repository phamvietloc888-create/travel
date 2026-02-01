@extends('clients.layout')

@section('content')

<section class="hero-wrap hero-wrap-2"
    style="background-image: url('{{ 
        $tour->thumbnail_path 
        ? Storage::url($tour->thumbnail_path) 
        : asset('clients/images/bg_1.jpg') 
    }}');">
  <div class="overlay"></div>
  <div class="container text-center">
    <h1 class="mb-3">{{ $tour->name }}</h1>
    <p class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a> /
        <a href="#">Tours</a> /
        <span>{{ $tour->name }}</span>
    </p>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row">

      {{-- LEFT --}}
      <div class="col-md-8">
        <h3>📌 Thông tin tour</h3>

        <ul class="list-unstyled">
          <li>⏱ Thời gian: <strong>{{ $tour->duration_days }} ngày</strong></li>
          <li>📍 Khởi hành: <strong>{{ $tour->start_location }}</strong></li>
          <li>🗺 Điểm đến: <strong>{{ optional($tour->destination)->name }}</strong></li>
          <li>🚀 Ngày khởi hành: 
              <strong>{{ $tour->departure_date ?? 'Đang cập nhật' }}</strong>
          </li>
          <li>⭐ Rating: <strong>{{ $tour->rating ?? 'Chưa có' }}/5</strong></li>
          <li>👥 Đã đặt: <strong>{{ $tour->booked_count ?? 0 }}</strong> người</li>
        </ul>

        <hr>

        <h4>📝 Mô tả chi tiết</h4>
        <div class="mt-3">
          {!! $tour->content ?? 'Đang cập nhật nội dung...' !!}
        </div>
      </div>

      {{-- RIGHT --}}
      <div class="col-md-4">
        <div class="card p-4 shadow">
          <h4 class="text-danger">
            {{ number_format($tour->price_adult) }} VND
          </h4>

          <p>👨 Người lớn</p>

          <p>🧒 Trẻ em: 
            <strong>{{ number_format($tour->price_child) }} VND</strong>
          </p>

          <a href="#" class="btn btn-primary btn-block mt-3">
            Đặt tour ngay
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection
