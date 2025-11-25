@extends('layouts/homeLayout')

@section('title', 'Gallery')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@600&display=swap');

  body, p, a, button {
    font-family: 'Poppins', sans-serif;
  }
  .modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }
  .modal-content-img {
    max-width: 90%;
    max-height: 80vh;
    border-radius: 10px;
  }
  #modal-caption {
    margin-top: 15px;
    color: white;
    font-size: 1.1rem;
    text-align: center;
  }
  .close-modal {
    position: absolute;
    top: 20px;
    right: 35px;
    font-size: 40px;
    color: white;
    cursor: pointer;
  }
  h1, h2, h3, h4, h5, .section-title {
    font-family: 'Playfair Display', serif;
  }

  .text-primary { color: #0077b6 !important; }

  /* === HERO / HEADER === */
  .page-header {
    position: relative;
    background: url('assets/img/gallery/4.png') center/cover no-repeat;
    color: white;
    min-height: 65vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
  }
  .page-header::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.45);
  }
  .page-header .header-content { position: relative; z-index: 2; }
  .page-header h1 { font-size: 3.8rem; font-weight: 700; }
  .page-header p { font-size: 1.2rem; color: #f1f1f1; max-width: 600px; margin: 15px auto 0; line-height: 1.6; }

  /* === INTRO SECTION === */
  .intro-section { background-color: #fff; padding: 80px 0; }
  .intro-section img { border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
  .intro-section p { color: #555; line-height: 1.8; }

  /* === MODERN CARD GALLERY === */
  .card-gallery {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }
  .card-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .card-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
  .card-item:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.2); }
  .card-item::after {
    content: attr(data-caption);
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 15px;
    background: rgba(0, 0, 0, 0.45);
    color: #fff;
    font-weight: 500;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .card-item:hover::after { opacity: 1; }

  /* Responsive */
  @media (max-width: 1200px) { .card-gallery { grid-template-columns: repeat(3, 1fr); } }
  @media (max-width: 768px) { .card-gallery { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 576px) { .card-gallery { grid-template-columns: 1fr; } }
</style>

@php
$galleryImages = [
  ['url' => 'assets/img/gallery/11.png', 'caption' => 'Ocean Pool'],
  ['url' => 'assets/img/gallery/12.png', 'caption' => 'Sea Balcony'],
  ['url' => 'assets/img/gallery/10.png', 'caption' => 'Beach Steps'],
  ['url' => 'assets/img/gallery/9.png', 'caption' => 'Blue Horizon'],
  ['url' => 'assets/img/gallery/8.png', 'caption' => 'Calm View'],
  ['url' => 'assets/img/gallery/7.png', 'caption' => 'Poolside Bliss'],
  ['url' => 'assets/img/gallery/6.png', 'caption' => 'Sunset Glow'],
  ['url' => 'assets/img/gallery/2.png', 'caption' => 'Breakfast View'],
];
@endphp
@section('content')

{{-- PAGE HEADER --}}
<section class="page-header">
  <div class="header-content">
    <h1 style="color: #0077b6 !important; ">Captured Moments</h1>
    <p>"Every wave tells a story, every sunset holds a memory — welcome to Blue Oasis."</p>
  </div>
</section>

{{-- INTRO SECTION --}}
<section class="intro-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="{{ asset('assets/img/gallery/4.png')}}" 
             alt="Blue Oasis Feature" class="img-fluid rounded-3">
      </div>
      <div class="col-lg-6">
        <h3 class="fw-bold mb-3 section-title">Create Lasting Memories</h3>
        <p class="lead text-primary">Blue Oasis Beach Resort — where every stay tells a story.</p>
        <p>Turn clicks into memories at Blue Oasis Beach Resort — a serene sanctuary crafted for dreamers, explorers, and families.</p>
        <p>Escape the noise of everyday life and step into a world where the horizon meets your heart. At Blue Oasis Beach Resort, every view, every breeze, and every moment is crafted to bring peace and joy. Lounge by the sparkling waters, stroll along the sun-kissed sands, or gather with loved ones in our cozy cottages and family-friendly rooms. Whether you seek adventure, relaxation, or simply a place to reconnect, Blue Oasis promises an unforgettable escape where memories are made and worries drift away with the tide.</p>
      </div>
    </div>
  </div>
</section>

{{-- GALLERY GRID --}}
<section class="bg-white py-5">
  <div class="container">
    <h3 class="text-center fw-bold mb-5 section-title">Memories Captured</h3>
    <div class="card-gallery">
      @foreach ($galleryImages as $image)
        <div class="card-item open-modal" data-caption="{{ $image['caption'] }}" data-image="{{ $image['url'] }}">
            <img src="{{ $image['url'] }}" alt="{{ $image['caption'] }}">
        </div>
      @endforeach
    </div>
  </div>
</section>
<div id="imageModal" class="modal-overlay" style="display:none;">
  <span class="close-modal">&times;</span>
  <div>
    <div class="row">
        <div id="modal-caption"></div>
    </div>
    <div class="row">
      <img class="modal-content-img" id="modal-img">
    </div>
  </div>
</div>
<script>
document.querySelectorAll(".open-modal").forEach(item => {
    item.onclick = function() {
        document.getElementById("modal-img").src = this.dataset.image;
        document.getElementById("modal-caption").innerText = this.dataset.caption;
        document.getElementById("imageModal").style.display = "flex";
    }
});

document.querySelector(".close-modal").onclick = function() {
    document.getElementById("imageModal").style.display = "none";
};

document.getElementById("imageModal").onclick = function(e) {
    if (e.target === this) this.style.display = "none";
};
</script>

@endsection
