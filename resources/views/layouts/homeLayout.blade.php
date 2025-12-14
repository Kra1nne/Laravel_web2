<!-- filepath: c:\xampp\htdocs\Blue Oasis\resources\views\layouts\homelayout.blade.php -->
@extends('layouts/commonMaster' )

@section('layoutContent')
@include('layouts/sections/navbar/homenavbar')
<!-- Content -->
@yield('content')
<!--/ Content -->
@include('layouts/sections/footer/homefooter')
@endsection

@section('page-style')
@vite(['resources/assets/css/homenavbar.css'])
@endsection

