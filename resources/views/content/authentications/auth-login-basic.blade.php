@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])

<style>
  body {
    background: url('assets/img/backgrounds/cover5.jpg') no-repeat center center fixed;
    background-size: cover;
  }
  .authentication-inner .card {
    background: rgba(255, 255, 255, 0.20);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.25);
  }

  .authentication-inner h4,
  .authentication-inner p,
  .authentication-inner span,
  .authentication-inner label,
  .authentication-inner a {
    color: #ffffff !important; /* make text clean & readable on background */
  }

  /* Divider lines */
  .authentication-inner hr {
    border-top: 1px solid rgba(255, 255, 255, 0.6);
  }

  /* Button border + text inside button */
  .authentication-inner .btn {
    border: 1px solid rgba(255, 255, 255, 0.8) !important;
    color: #fff !important;
  }

  /* Google icon inside button */
  .authentication-inner .btn i {
    color: #fff !important;
  }
</style>

@endsection

@section('page-script')
@vite('resources/assets/js/login.js')
@endsection

@section('content')
<div class="container-fluid position-relative">
  <a href="{{ url('/') }}" class="text-decoration-none d-inline-block"><i class="ri-arrow-left-s-line"></i></a>
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6 mx-4">

      <!-- Login Card -->
      <div class="card p-4 shadow-lg border-0 rounded-4">
        
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-4">
          <a href="{{url('/')}}" class="app-brand-link gap-3">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>150,"withbg"=>'fill: #fff;'])</span>
          </a>
        </div>

        <div class="card-body mb-5">
          <h4 class="mb-1 text-center">Welcome to {{ config('variables.templateName') }}</h4>
          <p class="mb-5 text-center text-white">Log in to continue your journey by the shore.</p>

          <!-- Login With Divider using Bootstrap -->
          <div class="d-flex justify-content-center align-items-center my-3">
            <hr class="flex-grow-1">
            <span class="mx-3 text-white">SIGN IN WITH</span>
            <hr class="flex-grow-1">
          </div>

          <div class="mb-5">
            <a href="{{ route('auth.google.redirect') }}" class="border border-primary w-full btn btn-primary p-3 rounded-md d-flex align-items-center">
              <div class="d-flex justify-content-center align-items-center">
                <div>
                  <i class="ri-google-line me-2"></i>
                </div>
                <div>
                   Google
                </div>
              </div>
            </a>
          </div>
        </div>

      </div> 
    </div>
  </div>
</div>

@endsection
