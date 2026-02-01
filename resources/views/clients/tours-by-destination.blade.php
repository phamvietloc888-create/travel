@extends('clients.layout')

@section('content')

<section class="hero-wrap hero-wrap-2"
  style="background-image:url('{{ asset('clients/images/bg_1.jpg') }}')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-9 text-center">
        <h1 class="mb-0 bread">{{ $destination->name }}</h1>
        <p class="text-white">
          Có {{ $tours->total() }} tour tại {{ $destination->name }}
        </p>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row">
      @forelse ($tours as $tour)
        <div class="col-md-4 ftco-animate">
          <div class="project-wrap">
            <a href="#" class="img"
               style="background-image:url('{{ Storage::url($tour->thumbnail_path) }}')">
            </a>
            <div class="text p-4">
              <h3>{{ $tour->name }}</h3>
              <p class="location">
                <span class="fa fa-map-marker"></span>
                {{ $destination->province }}
              </p>
              <p class="price">{{ number_format($tour->price) }} VNĐ</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-md-12 text-center text-muted">
          Chưa có tour nào tại {{ $destination->name }}
        </div>
      @endforelse
    </div>

    {{-- Pagination --}}
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
