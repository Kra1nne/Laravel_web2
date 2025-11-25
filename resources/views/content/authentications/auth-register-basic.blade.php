@extends('layouts/blankLayout')

@section('title', 'Register Basic - Pages')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('page-script')
@vite('resources/assets/js/registration.js')
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6 mx-4">

      <div class="card p-4 shadow-lg border-0 rounded-4">

        <div class="app-brand justify-content-center mt-4">
          <a href="{{url('/')}}" class="app-brand-link gap-3">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>150])</span>
          </a>
        </div>

        <div class="card-body mt-2">
          <h4 class="mb-1 text-center">Adventure starts here 🚀</h4>
          <p class="mb-5 text-center text-muted">Make your app management easy and fun!</p>

          <!-- Registration Form -->
          <form class="mb-4" id="AddAccountData">
            @csrf

            <!-- Names -->
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" autofocus>
              <label for="firstname">Firstname</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middlename">
              <label for="middlename">Middlename</label>
            </div>
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname">
              <label for="lastname">Lastname</label>
            </div>

            <!-- Email -->
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
              <label for="email">Email</label>
            </div>

            <!-- Password -->
            <div class="position-relative mb-3">
              <div class="form-floating form-floating-outline">
                <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                <label for="password">Password</label>
              </div>   
            </div>

            <!-- Password Confirmation -->
            <div class="position-relative mb-3">
              <div class="form-floating form-floating-outline">
                <input type="password" id="password-confirmation" class="form-control" name="password-confirmation" placeholder="Confirm Password">
                <label for="password-confirmation">Password Confirmation</label>
              </div>
            </div>

            <!-- Terms -->
            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  I agree to <a href="#" data-bs-toggle="modal" data-bs-target="#bookingTermsModal">privacy policy & terms</a>
                </label>
              </div>
            </div>

          </form>

          <!-- Signup Button -->
          <button class="btn btn-primary d-grid w-100 mb-4" id="AddAcountBtn">Sign up</button>

          <!-- Login Link -->
          <p class="text-center text-muted">
            Already have an account? 
            <a href="{{url('/login')}}" class="text-primary fw-semibold">Sign in instead</a>
          </p>
        </div>
      </div>
      <!-- /Register Card -->

      <!-- Terms & Conditions Modal -->
      <!-- Booking Terms Modal -->
      <div class="modal fade" id="bookingTermsModal" tabindex="-1" aria-labelledby="bookingTermsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="bookingTermsModalLabel">Booking Terms & Conditions – Blue Oasis</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>By booking with <strong>Blue Oasis</strong>, you agree to the following terms:</p>

              <h6>1. Payment Terms</h6>
              <ul>
                <li>A 50% partial payment is required online to secure your reservation.</li>
                <li>The remaining 50% must be paid in cash upon arrival at the resort.</li>
              </ul>

              <h6>2. Cancellation Policy</h6>
              <ul>
                <li>All bookings are non-refundable. The 50% partial payment is not refundable under any circumstances.</li>
              </ul>

              <h6>3. Check-in and Check-out</h6>
              <ul>
                <li>Check-in time: Anytime</li>
                <li>Check-out time: It Depende of the reservation</li>
              </ul>

              <h6>4. Guest Responsibilities</h6>
              <ul>
                <li>Guests must provide valid ID and contact information.</li>
                <li>Guests are responsible for personal belongings.</li>
              </ul>

              <p class="fw-bold">By proceeding, you acknowledge that you have read, understood, and agreed to these terms and conditions.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

@endsection
