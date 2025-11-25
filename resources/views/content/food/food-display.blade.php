@extends('layouts/homeLayout')

@section('title', 'Foods')

@section('page-script')
@vite('resources/assets/js/food-display.js')
@endsection

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@600&display=swap');
body, p, a, button {
  font-family: 'Poppins', sans-serif;
}

#food-image-col .carousel-item img {
  width: 100%;
  height: 530px;
}

#food-text-col {
  padding: 40px;
}

#foodHeaderQuote {
  font-size: 2rem;
  font-weight: 00;
  color: #0077b6;
  margin-bottom: 20px;
}

#foodQuote {
  font-style: italic;
  color: #0077b6;
  font-size: 1.2rem;
  line-height: 1.8;
  text-align: justify;
}

/* Smooth fade transition for carousel */
.carousel-fade .carousel-item {
  transition-duration: 1s !important;
}
p{
  font-size: 1.2rem;
  max-width: 600px; 
  margin: 15px auto 0; 
  line-height: 1.6; 
}
</style>

@section('content')
<section class="min-vh-100 bg-white" id="foodsection">
  <div class="container" style="padding-top: 120px; padding-bottom: 40px;">
    <div class="row">
      <div class="col-12">
        <div class="row align-items-center" id="food-carousel-container">
          <!-- Image column -->
          <div class="col-md-6" id="food-image-col">
            <div id="foodCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
              <div class="carousel-inner" id="foodCarouselInner">
                <!-- slides inserted dynamically -->
              </div>
            </div>
          </div>

          <!-- Fixed header quote and paragraph -->
          <div class="col-md-6 d-flex flex-column justify-content-center" id="food-text-col">
            <h2 id="foodHeaderQuote">
              "Good Food, Great Family Moments"
            </h2>
            <p>
              Welcome to Blue Oasis, where every meal feels like home. Enjoy delicious, home-style dishes that bring your family together — full of flavor, warmth, and love, without stretching your budget. Whether you’re sharing a special occasion, enjoying a weekend feast, or just looking for a comforting everyday meal, our menu has something to delight everyone.
            </p>
            <p>
              At Blue Oasis, we take pride in crafting meals that satisfy every craving. From hearty, savory classics to fresh, vibrant dishes, each plate is made with care and the finest ingredients. Our goal is simple: to create food that not only fills your stomach but also warms your heart.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@php
  $foods = collect($foods)->map(function($food) {
    return [
      'picture' => $food->picture,
    ];
  })->values()->toArray();
@endphp

<script>
  window.foods = @json($foods);
</script>
@endsection
