@extends('clients.layout')

@section('content')
<style>
    
</style>

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image:  url('{{ asset('clients/images/bg_1.jpg')}}');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
         <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="fa fa-chevron-right"></i></a></span> <span>Tour List <i class="fa fa-chevron-right"></i></span></p>
         <h1 class="mb-0 bread">destination</h1>
     </div>
 </div>
</div>
</section>

<section class="ftco-section ftco-no-pb">
   <div class="container">
      <div class="row">
       <div class="col-md-12">
          <div class="search-wrap-1 ftco-animate">
             <form action="#" class="search-property-1">
                <div class="row no-gutters">
                   <div class="col-lg d-flex">
                      <div class="form-group p-4 border-0">
                         <label for="#">Destination</label>
                         <div class="form-field">
                           <div class="icon"><span class="fa fa-search"></span></div>
                           <input type="text" class="form-control" placeholder="Search place">
                       </div>
                   </div>
               </div>
               <div class="col-lg d-flex">
                  <div class="form-group p-4">
                     <label for="#">Check-in date</label>
                     <div class="form-field">
                       <div class="icon"><span class="fa fa-calendar"></span></div>
                       <input type="text" class="form-control checkin_date" placeholder="Check In Date">
                   </div>
               </div>
           </div>
           <div class="col-lg d-flex">
              <div class="form-group p-4">
                 <label for="#">Check-out date</label>
                 <div class="form-field">
                   <div class="icon"><span class="fa fa-calendar"></span></div>
                   <input type="text" class="form-control checkout_date" placeholder="Check Out Date">
               </div>
           </div>
       </div>
       
<div class="col-lg d-flex">
  <div class="form-group d-flex w-100 border-0">
     <div class="form-field w-100 align-items-center d-flex">
        <input type="submit" value="Search" class="align-self-stretch form-control btn btn-primary">
    </div>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</section>

<section class="ftco-section">
   <div class="container">
    <div class="row">
        @forelse ($destinations as $destination)
            <div class="col-md-4 ftco-animate">
                <div class="project-wrap">
                    <a href="{{ route('tours.byDestination', $destination->slug) }}" class="img" style="background-image: url('{{ $destination->thumbnail_path ? Storage::url($destination->thumbnail_path) : asset('clients/images/destination-1.jpg') }}');">
                        <span class="price">{{ $destination->tours_count }} Tours</span>
                    </a>
                    <div class="text p-4">
                        <span class="days">{{ $destination->province ?: 'Việt Nam' }}</span>
                        <h3><a href="{{ route('tours.byDestination', $destination->slug) }}">{{ $destination->name }}</a></h3>
                        <p class="location"><span class="fa fa-map-marker"></span> {{ $destination->province ?: 'Updating' }}</p>
                        <ul>
                            <li><span class="flaticon-mountains"></span>{{ $destination->status }}</li>
                            <li><span class="flaticon-route"></span>{{ $destination->tours_count }} tours</li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <p class="text-center text-muted">Chưa có điểm đến nào được hiển thị.</p>
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

@endsection