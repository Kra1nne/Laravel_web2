@extends('layouts/contentNavbarLayout')

@section('title', 'Register')

@section('page-script')
@vite('resources/assets/js/register.js')
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
    <div class="navbar-nav flex-row align-items-center ms-auto gap-5">
      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddAccount">
        <span class="tf-icons ri-add-circle-line ri-16px me-1_5"></span>Add Account
      </button>
    </div>
  </header>
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="userlist">
      </tbody>
    </table>
  </div>
</div>
{{-- Add Account Modal --}}
<div class="modal fade" id="AddAccount" tabindex="-1" aria-hidden="true">
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

          <form id="AddAccountData" class="mb-5">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your firstname" autofocus>
              <label for="firstname">Firstname</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter your middlename" autofocus>
              <label for="middlename">Middlename</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your lastname" autofocus>
              <label for="lastname">Lastname</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
              <label for="email">Email</label>
            </div>
            <div class="form-floating form-floating-outline mb-6">
              <select class="form-select" id="role" name="role" aria-label="Default select example">
                <option value="" selected disabled>Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Employee">Employee</option>
                <option value="User">User</option>
              </select>
              <label for="exampleFormControlSelect1">Role</label>
            </div>
            <div class="mb-5 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
              </div>
              <div class="invalid-feedback" id="password-error" style="display: none;"></div>
            </div>
            <div class="mb-5 form-password-toggle">
              <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="password-confirmation" class="form-control" name="password-confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <label for="password">Password Confirmation</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
              </div>
              <div class="invalid-feedback" id="password-confirmation-error" style="display: none;"></div>
            </div>

            <div class="mb-5 py-2">
              <div class="form-check mb-0">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div>
          </form>
        </div>
        <div>
          <button type="button" class="btn btn-primary d-grid w-100 mb-5" id="AddAcountBtn">Submit</button>
      </div>
      </div>
    </div>
  </div>
</div>

{{-- Edit Account Modal --}}
<div class="modal fade" id="EditAccount" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="app-brand justify-content-center mt-5 mb-5">
          <a href="{{url('/')}}" class="app-brand-link gap-3">
            <span class="app-brand-logo demo">@include('_partials.macros',["height"=>20])</span>
            <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>
          </a>
        </div>
        <!-- /Logo -->
        <div class="card-body mt-5">
          <form id="EditAccountData" class="mb-5">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
              <input type="hidden" class="form-control" id="Edit_id" name="id" placeholder="Enter your firstname" autofocus>
              <label for="id">Id</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_firstname" name="firstname" placeholder="Enter your firstname" autofocus>
              <label for="firstname">Firsname</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_middlename" name="middlename" placeholder="Enter your middlename">
              <label for="middlename">Middlename</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_lastname" name="lastname" placeholder="Enter your username" autofocus>
              <label for="lastname">Lastname</label>
            </div>
            <div class="form-floating form-floating-outline mb-6">
              <select class="form-select" id="Edit_role" name="role" aria-label="Default select example">
                <option value="" selected disabled>Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Employee">Employee</option>
                <option value="User">User</option>
              </select>
              <label for="exampleFormControlSelect1">Role</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
              <input type="text" class="form-control" id="Edit_email" name="email" placeholder="Enter your email">
              <label for="email">Email</label>
            </div>

          </form>
        </div>
        <div>
          <button type="button" class="btn btn-primary d-grid w-100 mb-5" id="SaveEditBtn">Submit</button>
      </div>
      </div>
    </div>
  </div>
</div>
@php
  $users = collect($users)->map(function($user) {
  return [
      'id' => $user->id,
      'encrypted_id' => Crypt::encryptString($user->id),
      'firstname' => $user->firstname,
      'middlename' => $user->middlename,
      'lastname' => $user->lastname,
      'email' => $user->email,
      'role' => $user->role,
  ];
  })->values()->toArray();
@endphp
<script>
  window.users = @json($users);
</script>

@endsection
