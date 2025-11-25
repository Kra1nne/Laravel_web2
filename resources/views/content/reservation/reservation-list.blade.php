@extends('layouts/contentNavbarLayout')

@section('title', 'Reservation List')

@section('page-script')
@vite('resources/assets/js/reservation.js')
@endsection

@section('content')
<div class="card">
  <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-3">
    <div class="navbar-nav align-items-start">
      <div class="nav-item d-flex align-items-center">
        <i class="ri-search-line ri-22px me-1_5"></i>
        <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search..." aria-label="Search...">
      </div>
    </div>
  </header>
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Name</th>
          <th>Facilities Name</th>
          <th>Amount</th>
          <th>Payment</th>
          <th>Schedule</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="reservationList">
      </tbody>
    </table>
  </div>
</div>
<div class="modal fade" id="ViewReservation" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-3">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20])</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
          </a>
        </div>
        <!-- /Logo -->
        <div class="card-body mt-5">

          <div class="mb-5 p-4">

            <div class="mb-3">
              <strong>Customer Name: </strong> <span id="facility-customer"></span>
            </div>

            <div class="mb-3">
              <strong>Facility Name: </strong> <span id="facility-name_details"></span>
            </div>

            <!-- Time In / Time Out -->
            <div class="row mb-2">
              <div class="col-12">
                <strong>Time In: </strong> <span id="time-in_details"></span>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <strong>Time Out: </strong> <span id="time-out_details"></span>
              </div>
            </div>

            <!-- Promo -->
            <div class="mb-2">
              <strong>Promo: </strong> <span id="promo_details"></span>
            </div>
            <div class="mb-2">
              <strong>Guests: </strong> <span id="number_of_guests"></span>
            </div>

            <!-- Price & Service Fee -->
            <div class="row mb-2">
              <div class="col-12">
                <strong>Price: </strong><span><span id="price_details"></span>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-12">
                <strong>Date: </strong> <span id="date"></span>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-12">
                <strong>Payment: </strong> <span id="payment_amount"></span>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <strong>Mode of Payment: </strong> <span>Gcash</span>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <strong>Payment Status: </strong> <span id="status"></span>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <strong>Service Fee: </strong> <span>50.00</span>
              </div>
            </div>

            <div><h5 class="text-center">Foods</h5></div>
            <div id="foods_list" class="mt-3"></div>

            <!-- Total -->
            <div class="border-top pt-2 mb-3">
              <h5 class="d-flex justify-content-between">
                <span>Total (PHP):</span>
                <span id="total_amount" class="text-primary fw-bold"></span>
              </h5>
            </div>

          </div>
        </div>
        <div class="modal-footer" id="footerBtn">
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.reservations = @json($reservations);
</script>
@endsection
