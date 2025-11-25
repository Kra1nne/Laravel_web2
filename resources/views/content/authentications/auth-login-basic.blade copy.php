@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('page-script')
@vite('resources/assets/js/login.js')
@endsection

@section('content')
<div class="container-fluid position-relative">
  <a href="{{ url('/') }}" class="text-decoration-none mb-3 d-inline-block"><i class="ri-arrow-left-s-line"></i></a>
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6 mx-4">

      <!-- Login Card -->
      <div class="card p-4 shadow-lg border-0 rounded-4">
        
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-4">
          <a href="{{url('/')}}" class="app-brand-link gap-3">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>100,"withbg"=>'fill: #fff;'])</span>
          </a>
        </div>

        <div class="card-body mt-2">
          <h4 class="mb-1 text-center">Welcome to {{config('variables.templateName')}}! 👋🏻</h4>
          <p class="mb-5 text-center text-muted">Sign in to your account to continue your adventure</p>

          <!-- Login Form -->
          <form id="formAuthentication" class="mb-4">
            @csrf

            <!-- Email / Username -->
            <div class="form-floating form-floating-outline mb-4">
              <input type="text" class="form-control" id="email" name="email_username" placeholder="Enter your email or username" autofocus>
              <label for="email">Email or Username</label>
            </div>

            <!-- Password with toggle -->
            <div class="position-relative mb-4">
              <div class="form-floating form-floating-outline">
                <input type="password" id="password" class="form-control" name="password" placeholder="Password" aria-describedby="password" />
                <label for="password">Password</label>
              </div>

            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">Remember Me</label>
              </div>
              <a href="{{url('forgot-password')}}" class="text-primary">Forgot Password?</a>
            </div>
          </form>

          <!-- Login Button -->
          <div class="mb-4" id="loginBtn">
            <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
          </div>

          <!-- Register Link -->
          <p class="text-center text-muted">
            New on our platform?
            <a href="{{url('register')}}" class="text-primary fw-semibold">Create an account</a>
          </p>
        </div>
      </div>
      <!-- /Login Card -->

      <!-- Optional Background Images -->
      {{-- 
      <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block" height="160">
      <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" height="172" alt="triangle-bg">
      <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
      --}}
    </div>
  </div>
</div>

<!-- Password Toggle Script -->
<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', function() {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.querySelector('i').classList.toggle('ri-eye-line'); // toggle icon
  });
</script>
@endsection
