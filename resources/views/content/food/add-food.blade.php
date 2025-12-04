@extends('layouts/blankLayout')

@section('title', 'Additional Food')

@section('page-script')
@vite('resources/assets/js/additional_food.js')
@endsection

@section('content')
<section class="min-vh-100 bg-white" id="details">
  <div class="container" style="padding-top: 90px;">
    <div class="row mb-3">
      <div class="col">
        <nav aria-label="breadcrumb" class="mt-8">
          <ol class="breadcrumb breadcrumb-style2">
            <li class="breadcrumb-item">
              <a href="{{ url()->previous() }}">Reservation</a>
            </li>
            <li class="breadcrumb-item active">Foods</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      {{-- Left Column: Foods --}}
      <div class="col-lg-8">
        <h4 class="mb-4">Available Foods</h4>
        <div class="row">
          @foreach($foods as $food)
            <div class="col-md-6 mb-4">
              <div class="card h-100 shadow-sm">
                @php
                  $firstPicture = $food->picture->first();
                @endphp
                @if($firstPicture && $firstPicture->path)
                  <img src="{{ asset($firstPicture->path) }}" class="card-img-top" alt="{{ $food->name }}" style="height: 350px; object-fit: cover;">
                @else
                  <img src="{{ asset('images/no-image.png') }}" class="card-img-top" alt="No Image">
                @endif
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">{{ $food->name }} - {{ number_format($food->price, 2) }}</h5>
                  <div class="mt-auto">
                    <form class="add-food-form" data-food-name="{{ $food->name }}" data-food-id="{{ $food->id }}" data-food-price="{{ $food->price }}">
                      @csrf
                      <input type="hidden" name="food_id" value="{{ $food->id }}">
                      <div class="input-group mb-2">
                        <input type="number" min="1" value="1" class="form-control food-qty" style="max-width:80px;" placeholder="Qty">
                        <button type="submit" class="btn btn-primary btn-block add-food-btn">Add Food</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>


      <div class="col-lg-4">
        <div class="card shadow-sm sticky-top" style="top: 100px;">
          <div class="card-body">
            <h5 class="card-title mb-3">Booking Details</h5>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <strong>Facility Name: <?= $booking->name ?></strong> 
              </li>
              <li class="list-group-item">
                <strong>Number of Guests: <?= $booking->guest ?></strong>
              </li>
               <li class="list-group-item">
                <strong>Number of Days: <?= $booking->day ?></strong> 
              </li>
              @php
                  $totalPrice = 0;
              @endphp

              <ul class="list-group">
                  <li class="list-group-item">
                      <strong>Foods: </strong>
                      @foreach($food_list as $index => $food)
                          {{ $food->food_name ?? 'No Name' }} x {{ $food->quantity }}
                          @php
                              $totalPrice += $food->price * $food->quantity;
                          @endphp
                          @if(!$loop->last), @endif
                      @endforeach
                  </li>
              </ul>
              <li class="list-group-item">
                  <strong>Additional Foods</strong>
              </li>
              <li class="list-group-item">
                  <strong>Added Foods: </strong>  
              </li>
              <li class="list-group-item">
                <strong  class="fw-bold">Total Amount: </strong><span id="total-amount" class="text-primary fw-bold"></span>
              </li>
            </ul>
            <form class="mt-3 d-flex justify-content-end" method="POST" action="{{ route('reservation-add-food-process') }}">
              @csrf
              <input type="hidden" name="bookings_id" value="<?= $booking->bookings_id ?>">
              <input type="hidden" name="food_id" id="food_id">
              <input type="hidden" name="food_quantity" id="food_quantity">
              <input type="hidden" id="total_amount" name="total_amount">
              <div class="d-flex gap-3">
                  <button type="submit" name="payment_type" value="full" class="btn btn-success">
                      Confirm
                  </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection
