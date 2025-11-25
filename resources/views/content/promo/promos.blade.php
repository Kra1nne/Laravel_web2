@extends('layouts/contentNavbarLayout')

@section('title', 'Promos')

@section('page-script')
@vite('resources/assets/js/promos.js')
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
      <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddPromos">
        <span class="tf-icons ri-add-circle-line ri-16px me-1_5"></span>Add Promos
      </button>
    </div>
  </header>
  <div class="table-responsive text-nowrap overflow-auto" style="max-height: 500px;">
    <table class="table table-hover">
      <thead class="position-sticky top-0 bg-body">
        <tr>
          <th>Name</th>
          <th>Facilities Name</th>
          <th>Price</th>
          <th>Max Person</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" id="promoslist">
      </tbody>
    </table>
  </div>
</div>
{{-- Add Promos Modal --}}
<div class="modal fade" id="AddPromos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Promos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="PromoData" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name">
                <label for="name">Name</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <select class="form-select" id="facilities_id" name="facilities_id" aria-label="Default select example">
                  <option value="" selected>Select Facilities</option>
                  @foreach ($facilities as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
                <label for="exampleFormControlSelect1">Facilities</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price">
                <label for="Price">Price</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="max_person" name="max_person" class="form-control" placeholder="Enter Price">
                <label for="Max_Person">Maximum Person</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="additional_price" name="additional_price" class="form-control" placeholder="Enter addtional price">
                <label for="Additional_Price">Additional Price</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-1 mt-1">
              <div class="form-floating form-floating-outline mb-6">
                <textarea class="form-control h-px-100" id="description" placeholder="Comments here..." name="description"></textarea>
                <label for="exampleFormControlTextarea1">Description</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="SubmitPromo">Save</button>
      </div>
    </div>
  </div>
</div>

{{-- Edit Promos Modal --}}
<div class="modal fade" id="EditPromos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Edit Promos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Edit_PromoData">
          @csrf
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="hidden" id="Edit_id" name="id" class="form-control" placeholder="Enter ID">
                <input type="text" id="Edit_name" name="name" class="form-control" placeholder="Enter Name">
                <label for="name">Name</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <select class="form-select" id="Edit_facilities_id" name="facilities_id" aria-label="Default select example">
                  <option value="" selected>Select Facilities</option>
                  @foreach ($facilities as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
                <label for="exampleFormControlSelect1">Facilities</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="Edit_price" name="price" class="form-control" placeholder="Enter Price">
                <label for="Price">Price</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="Edit_max_person" name="max_person" class="form-control" placeholder="Enter Price">
                <label for="Max_Person">Maximum Person</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="number" id="Edit_additional_price" name="additional_price" class="form-control" placeholder="Enter addtional price">
                <label for="Additional_Price">Additional Price</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-1 mt-1">
              <div class="form-floating form-floating-outline mb-6">
                <textarea class="form-control h-px-100" id="Edit_description" placeholder="Comments here..." name="description"></textarea>
                <label for="exampleFormControlTextarea1">Description</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="UpdatePromo">Save</button>
      </div>
    </div>
  </div>
</div>
@php
  $promos = collect($promos)->map(function($promo) {
  return [
      'encrypted_id' => Crypt::encryptString($promo->id),
      'facilities_id' => $promo->facilities_id,
      'name' => $promo->name,
      'price' => $promo->price,
      'additional_price' => $promo->additional_price,
      'max_person' => $promo->max_person,
      'description' => $promo->description,
      'facility_name' => $promo->facility_name
  ];
  })->values()->toArray();
@endphp
<script>
  window.promos = @json($promos);
</script>
@endsection
