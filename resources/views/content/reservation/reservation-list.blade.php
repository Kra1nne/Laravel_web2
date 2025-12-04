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
          <th>Reservation Status</th>
          <th>Payment Status</th>
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
<div class="modal fade" id="Extend" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title text-center w-100">Extend</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ExtendData" >
          @csrf
          <input type="hidden" id="id" name="id">
          <div class="row mb-4">
            <div class="col">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control" disabled>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label for="facilities" class="form-label">Facilities Name</label>
              <input type="text" name="facilities" id="facilities" class="form-control" disabled>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label for="payment" class="form-label">Payment</label>
              <input type="text" name="payment" id="payment" class="form-control" disabled>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label for="checkin" class="form-label">Start Date</label>
              <input type="datetime-local" name="checkin" id="checkin" class="form-control" disabled>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label for="checkout" class="form-label">End Date</label>
              <input type="datetime-local" name="checkout" id="checkout" class="form-control" disabled>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label for="extend" class="form-label">Extend Date</label>
              <input type="datetime-local" name="extend" id="extend" class="form-control">
            </div>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label for="additional" class="form-label">Additional Payment</label>
              <input type="number" name="NewNumber" id="additional" class="form-control" readonly>
            </div>
          </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="Check">Check Price</button>
            <button type="button" class="btn btn-primary" id="SaveExtend">Apply</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="GuestModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title text-center w-100">Add Guest</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="GuestData" >
          @csrf
          <input type="hidden" id="reservation_id" name="reservation_id">
          <div class="row mb-4">
            <div class="col">
              <label for="guest" class="form-label">Guest</label>
              <input type="number" name="guest" id="guest" class="form-control" placeholder="Enter the number of guest you want to add....">
            </div>
          </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="AddGuestSubmit">Add Guest</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  window.reservations = @json($reservations);
</script>
@if(session('payment_success'))
<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'success',
        title: 'Payment Sucess',
        text: '{{ session("payment_success") }}',
        confirmButtonText: 'Okay',
    });
});
</script>
@endif
@endsection
