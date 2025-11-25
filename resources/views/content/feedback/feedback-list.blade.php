@extends('layouts/contentNavbarLayout')

@section('title', 'Feedback - List')

@section('page-script')
@vite('resources/assets/js/feedback.js')
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
          <th>Date</th>
          <th>Rate</th>
          <th>Comments</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="feedbackslist">
      </tbody>
    </table>
  </div>
</div>
<div class="modal fade" id="CommentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel1">Comment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-5">
          <div class="col">
            <p id="comment"></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.feedbacks = @json($feedbacks);
</script>
@endsection
