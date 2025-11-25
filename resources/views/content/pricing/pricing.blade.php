@extends('layouts/homeLayout')

@section('title', 'Pricing')

@section('content')
<section class="bg-white py-5" >
  <div class="container" style="padding-top: 90px;">
    <!-- Section Header -->
    <div class="text-center mb-5">
      <h2 class="fw-bold">Our Pricing</h2>
      <p class="text-muted">Choose the perfect room or cottage for your stay at Blue Oasis</p>
    </div>

    <div class="row g-4 justify-content-center">
      {{-- Rooms --}}
      @foreach ($rooms as $item)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0 hover-shadow">
          <div class="position-relative">
            <img
              src="{{ asset($item->picture->first()->path) }}"
              class="card-img-top rounded-top"
              alt="{{ $item->name }}"
              style="height: 220px; object-fit: cover;"
            >
            @if($item->promo->count())
            <span class="badge bg-success position-absolute top-0 start-0 m-2">Promo</span>
            @endif
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $item->name }}</h5>
            <p class="mb-2">
              <strong class="text-primary">₱{{ number_format($item->price) }}</strong> / day — {{ $item->max_person }} guest
            </p>

            {{-- Promo details --}}
            @if($item->promo->count())
            <ul class="list-unstyled mb-3 text-success small">
              @foreach ($item->promo as $promo)
              <li>{{ $promo->name }}: ₱{{ number_format($promo->price) }} / day — {{ $promo->max_person }} guest</li>
              @endforeach
            </ul>
            @endif

            <h6 class="mt-2">Amenities</h6>
            @if(!empty($item->amenities))
            <ul class="list-unstyled small">
              @foreach (explode(',', $item->amenities) as $amenity)
              <li>• {{ trim($amenity) }}</li>
              @endforeach
            </ul>
            @else
            <p class="text-muted small">No amenities listed.</p>
            @endif

            <p class="text-muted small mt-auto">
              Note: An additional charge of ₱{{ number_format($item->additional_price) }} per guest applies for guests exceeding the maximum allowed.
            </p>
          </div>
        </div>
      </div>
      @endforeach

      {{-- Cottages --}}
      @foreach ($cottages as $cottage)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0 hover-shadow">
          <div class="position-relative">
            <img
              src="{{ asset($cottage->picture->first()->path) }}"
              class="card-img-top rounded-top"
              alt="{{ preg_replace('/\s*\d+$/', '', $cottage->name) }}"
              style="height: 220px; object-fit: cover;"
            >
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ preg_replace('/\s*\d+$/', '', $cottage->name) }}</h5>
            <p class="mb-2">
              <strong class="text-primary">₱{{ number_format($cottage->price) }}</strong> — {{ $cottage->max_person }} guest
            </p>

            <h6>Schedule Time</h6>
            <ul class="list-unstyled small mb-3">
              <li>Morning: 5:00 AM - 5:00 PM</li>
              <li>Afternoon: 5:00 PM - 10:00 PM</li>
              <li>Whole Day: 5:00 AM - 10:00 PM</li>
            </ul>

            <p class="text-muted small mt-auto">
              Note: An additional charge of ₱{{ number_format($cottage->additional_price) }} per guest applies for guests exceeding the maximum allowed and for overtime usage ₱100 per hour.
            </p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<style>
  /* Card hover effect */
  .hover-shadow {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
  }
</style>
@endsection
