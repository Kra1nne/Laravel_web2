@extends('layouts/contentNavbarLayout')

@section('title', 'Evaluation')

@section('page-script')
@vite('resources/assets/js/evaluation.js')
@endsection


@section('content')
<div class="card">
  <header class="mb-3 navbar-nav-right d-flex align-items-center px-3 mt-3">
    <div class="navbar-nav align-items-start">
      <div class="nav-item d-flex align-items-center">
        <i class="ri-search-line ri-22px me-1_5"></i>
        <input type="search" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50" placeholder="Search name.." aria-label="Search...">
      </div>
    </div>
  </header>
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Email</th>
          <th>Date</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>E</th>
          <th>F</th>
          <th>G</th>
          <th>H</th>
          <th>Status</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="evalList">
      </tbody>
    </table>
  </div>
</div>
<script>
  window.data = @json($data);
</script>
@endsection
