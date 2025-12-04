<header class="">
  <nav class="navbar navbar-light fixed-top bg-transparent">
    <div class="container">
      <!-- Logo / Brand -->
      <a class="navbar-brand" > <!-- href="{{ url('/') }}" -->
        <span class="app-brand-logo demo">@include('_partials.macros', ["height" => 80])</span>
      </a>
      
      <!-- Toggler -->
      <button class="navbar-toggler navbar-toggler-md bg-transparent border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        @if(Auth::check())
            <img src="{{ asset('assets/img/profile/profile.png')}}" 
                alt="Guest Photo" 
                class="rounded-circle me-3" 
                width="40" height="40" style="object-fit: cover;">
            <div>
        @else
            <span class="ri-menu-line" style="font-size: 25px; color: gray;"></span>
        @endif
      </button>

      <!-- Offcanvas Content -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          <!-- Navigation Links -->
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 gap-2">
            <li class="nav-item">
              <a class="nav-link nav-hover-effect {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-hover-effect {{ request()->routeIs('booking') ? 'active' : '' }}" href="{{ route('booking') }}">Booking</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-hover-effect {{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Pricing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-hover-effect {{ request()->routeIs('features') ? 'active' : '' }}" href="{{ route('features') }}">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-hover-effect {{ request()->routeIs('foods') ? 'active' : '' }}" href="{{ route('foods') }}">Foods</a>
            </li>
          </ul>

          <!-- Auth Section -->
          @guest
          <div class="mt-4">
            <a class="btn btn-outline-primary w-100 mb-2 fw-bold" href="{{ route('login') }}">Sign in</a>
          </div>
          @endguest

          @auth
          <div class="mt-4">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 gap-2">
              <li>
                <div class="border border-2 max-w-full"></div>
              </li>

              <li class="nav-item">
                <a class="nav-link nav-hover-effect {{ request()->routeIs('user-reservation-list') ? 'active' : '' }}" href="{{ route('user-reservation-list') }}">Reservation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link nav-hover-effect" data-page="logout" href="{{ route('logout-process') }}">Logout</a>
              </li>
            </ul>
          </div>
          @endauth
        </div>
      </div>
    </div>
  </nav>

</header>
