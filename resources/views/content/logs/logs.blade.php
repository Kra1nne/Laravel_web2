@extends('layouts/contentNavbarLayout')

@section('title', 'Logs')

@section('page-script')
@vite('resources/assets/js/logs.js')
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
          <th>Action</th>
          <th>Table Name</th>
          <th>Description</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="logslist">
      </tbody>
    </table>
  </div>
</div>
@php
  $logs = collect($logs)->map(function($log) {
  return [
      'id' => $log->id,
      'encrypted_id' => Crypt::encryptString($log->id),
      'firstname' => $log->firstname,
      'middlename' => $log->middlename,
      'lastname' => $log->lastname,
      'action' => $log->action,
      'table_name' => $log->table_name,
      'description' => $log->description,
      'ip_address' => $log->ip_address,
      'date' => date('M d, Y h:i A', strtotime($log->created_at)),
  ];
  })->values()->toArray();
@endphp
<script>
  window.logs = @json($logs);
</script>
@endsection
