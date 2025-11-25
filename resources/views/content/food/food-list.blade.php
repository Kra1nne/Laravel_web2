@extends('layouts/contentNavbarLayout')

@section('title', 'Foods')

@section('page-script')
@vite('resources/assets/js/food.js')
@endsection

@section('content')
<section class="row" id="foodsection">
  <div class="col card">
    <header class="mb-3 navbar-nav-right d-flex flex-wrap align-items-center px-3 mt-4">
      <!-- Search input -->
      <div class="navbar-nav align-items-start flex-grow-1 mb-2 mb-sm-0">
        <div class="nav-item d-flex align-items-center w-100">
          <i class="ri-search-line ri-22px me-1_5"></i>
          <input type="text" id="search" class="form-control border-0 shadow-none ps-1 ps-sm-2 ms-50 w-100" placeholder="Search..." aria-label="Search...">
        </div>
      </div>

      <!-- Buttons -->
      <div class="navbar-nav d-flex flex-row align-items-center gap-2 ms-auto">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddProduct">
          <span class="tf-icons ri-add-circle-line ri-16px me-1_5"></span>Add Food
        </button>
      </div>
    </header>
    <main>
      <div class="row row-cols-1 row-cols-md-3" id="foods">

      </div>
    </main>
  </div>
</section>
{{-- add product modal --}}
<div class="modal fade" id="AddProduct" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProductData" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col mb-3">
              <div class="input-group">
                <input type="file" name="imagesData" accept="image/*" class="form-control" id="DataImages">
              </div>
            </div>
          </div>
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
                <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price">
                <label for="Price">Price</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-2 mt-2">
              <div class="form-floating form-floating-outline mb-4">
                <select class="form-select" id="category" name="category" aria-label="Default select example">
                  <option value="" selected disabled>Select Category</option>
                  <option value="Drinks">Drinks</option>
                  <option value="Snacks">Snacks</option>
                  <option value="Desserts">Desserts</option>
                  <option value="Meal">Meal</option>
                </select>
                <label for="category">Category</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-floating form-floating-outline mb-2">
                <textarea class="form-control h-px-100" id="description" placeholder="Comments here..." name="description"></textarea>
                <label for="description">Description</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="SaveProduct">Save</button>
      </div>
    </div>
  </div>
</div>
{{-- update product modal --}}
<div class="modal fade" id="EditProduct" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProductDataUpdate" enctype="multipart/form-data">
          @csrf
           <input type="hidden" id="Edit_id" name="id" class="form-control" placeholder="Id">
          <div class="row">
            <div class="col mb-3">
              <div class="input-group">
                <input type="file" name="imagesData" accept="image/*" class="form-control" id="Edit_DataImages">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3 mt-2">
              <div class="form-floating form-floating-outline">
                <input type="text" id="Edit_name" name="name" class="form-control" placeholder="Enter Name">
                <label for="name">Name</label>
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
            <div class="col mb-2 mt-2">
              <div class="form-floating form-floating-outline mb-4">
                <select class="form-select" id="Edit_category" name="category" aria-label="Default select example">
                  <option value="" selected disabled>Select Category</option>
                  <option value="Drinks">Drinks</option>
                  <option value="Snacks">Snacks</option>
                  <option value="Desserts">Desserts</option>
                  <option value="Meal">Meal</option>
                </select>
                <label for="category">Category</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-floating form-floating-outline mb-2">
                <textarea class="form-control h-px-100" id="Edit_description" placeholder="Comments here..." name="description"></textarea>
                <label for="description">Description</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="UpdateProduct">Save</button>
      </div>
    </div>
  </div>
</div>
<a href="#foodsection"
  class="btn btn-primary position-fixed bottom-0 end-0 m-3 rounded-circle d-flex align-items-center justify-content-center"
  style="width: 50px; height: 50px; z-index: 1030;">
  <i class="ri-arrow-up-line fs-4 text-white"></i>
</a>
@php
  $foods = collect($foods)->map(function($food) {
    return [
      'id' => $food->id,
      'name' => $food->name,
      'category' => $food->category,
      'description' => $food->description,
      'picture' => $food->picture,
      'price' => $food->price,
      'encrypted_id' => Crypt::encryptString($food->id),
    ];
  })->values()->toArray();
@endphp

<script>
  window.foods = @json($foods);
</script>
@endsection
