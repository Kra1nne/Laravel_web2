<!-- filepath: c:\xampp\htdocs\Blue Oasis\resources\views\errors\429.blade.php -->
@extends('layouts/blankLayout')

@section('title', 'Too Many Requests - Pages')

@section('page-style')
<!-- Page -->
@vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection

@section('content')
<!-- Error -->
<div class="misc-wrapper">
  <h1 class="mb-2 mx-2" style="font-size: 6rem;line-height: 6rem;">429</h1>
  <h4 class="mb-2">Too Many Requests 🚫</h4>
  <p class="mb-4 mx-2">You've made too many requests. Please slow down!</p>

  <!-- Countdown Timer -->
  <div class="alert alert-warning text-center mb-4" role="alert">
    <h3 class="alert-heading text-danger mb-3">
      <span class="badge bg-danger fs-2 p-3" id="countdown">
        <span id="timer">{{ $retry_after ?? 60 }}</span> seconds
      </span>
    </h3>
    <hr>
    <p class="mb-0"><strong>Please wait before making another request.</strong></p>
    <small class="text-muted">This limit helps protect our system and ensures fair usage for all users.</small>
  </div>

  <div class="d-flex justify-content-center mt-5">
    <img src="{{asset('assets/img/illustrations/tree-3.png')}}" alt="misc-tree" class="img-fluid misc-object d-none d-lg-inline-block">
    <img src="{{asset('assets/img/illustrations/misc-mask-light.png')}}" alt="misc-error" class="misc-bg d-none d-lg-inline-block z-n1" height="172">
    <div class="d-flex flex-column align-items-center">
      <img src="{{asset('assets/img/illustrations/404.png')}}" alt="misc-error" class="misc-model img-fluid z-1" width="780">
      <div class="d-grid gap-2 d-md-block">
        <a href="javascript:history.back()" class="btn btn-success btn-lg text-center my-6 d-none" id="homeButton">
          <i class="fas fa-undo me-2"></i>Resume Previous Page
        </a>
        <button class="btn btn-secondary btn-lg text-center my-6" id="disabledButton" disabled>
          <div class="spinner-border spinner-border-sm me-2" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          Please wait <span class="badge bg-light text-dark ms-1" id="buttonTimer">{{ $retry_after ?? 60 }}</span>s
        </button>
      </div>
    </div>
  </div>
</div>
<!-- /Error -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeLeft = {{ $retry_after ?? 60 }};
    const timerElement = document.getElementById('timer');
    const buttonTimerElement = document.getElementById('buttonTimer');
    const homeButton = document.getElementById('homeButton');
    const disabledButton = document.getElementById('disabledButton');
    const countdownElement = document.getElementById('countdown');

    const countdown = setInterval(function() {
        timeLeft--;
        timerElement.textContent = timeLeft;
        buttonTimerElement.textContent = timeLeft;

        // Change badge color as time decreases
        if (timeLeft <= 10) {
            countdownElement.className = 'badge bg-warning fs-2 p-3';
        }
        if (timeLeft <= 5) {
            countdownElement.className = 'badge bg-success fs-2 p-3';
        }

        if (timeLeft <= 0) {
            clearInterval(countdown);

            // Show success state
            countdownElement.innerHTML = '<i class="fas fa-check-circle"></i> Ready!';
            countdownElement.className = 'badge bg-success fs-2 p-3';

            // Show the home button and hide disabled button
            homeButton.classList.remove('d-none');
            disabledButton.classList.add('d-none');

            // Show success alert
            const alertDiv = document.querySelector('.alert-warning');
            alertDiv.className = 'alert alert-success text-center mb-4';
            alertDiv.innerHTML = `
                <h4 class="alert-heading text-success">
                    <i class="fas fa-check-circle me-2"></i>You can now make requests again!
                </h4>
            `;
        }
    }, 1000);
});
</script>
@endsection
