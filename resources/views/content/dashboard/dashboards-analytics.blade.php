@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection

@section('content')
<div class="row gy-6">

  <div class="col-xl-3 col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="avatar">
          <div class="avatar-initial bg-primary rounded-circle shadow-xs">
            <i class="ri-hotel-line ri-24px text-white"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-1 mt-4">Rooms & Cottages</h6>
        <div class="d-flex flex-wrap mb-4 align-items-center">
          <h4 class="mb-0 me-2 fw-semibold" id="roomCount">{{ $facilitycount }}</h4>
        </div>
        <div class="mt-4">
          <ul class="p-0 m-0">
            <li class="d-flex mb-3">
              <div class="avatar flex-shrink-0 bg-light-primary rounded me-3">
                <i class="ri-home-smile-line ri-xl text-primary"></i>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-1">Total Facilities</h6>
                <div class="progress bg-label-primary" style="height: 4px;">
                  <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Overall Rating -->
  <div class="col-xl-3 col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="avatar">
          <div class="avatar-initial bg-warning rounded-circle shadow-xs">
            <i class="ri-star-smile-line ri-24px text-white"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-1 mt-4">Overall Rating</h6>
        <div class="d-flex flex-wrap mb-4 align-items-center">
          <h4 class="mb-0 me-2 fw-semibold" id="overallRating">{{ number_format($ratingavg, 1) ?? 0 }} / 5</h4>
        </div>
        <div class="mt-4">
          <ul class="p-0 m-0">
            <li class="d-flex mb-3">
              <div class="avatar flex-shrink-0 bg-light-warning rounded me-3">
                <i class="ri-user-smile-line ri-xl text-warning"></i>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-1">Guest Satisfaction</h6>
                <div class="progress bg-label-warning" style="height: 4px;">
                  <div class="progress-bar bg-warning" style="width: 100%"></div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Items in Menu -->
  <div class="col-xl-3 col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="avatar">
          <div class="avatar-initial bg-success rounded-circle shadow-xs">
            <i class="ri-restaurant-line ri-24px text-white"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-1 mt-4">Food Menu</h6>
        <div class="d-flex flex-wrap mb-4 align-items-center">
          <h4 class="mb-0 me-2 fw-semibold" id="menuItemCount">{{ $foodCount }}</h4>
        </div>
        <div class="mt-4">
          <ul class="p-0 m-0">
            <li class="d-flex mb-3">
              <div class="avatar flex-shrink-0 bg-light-success rounded me-3">
                <i class="ri-bread-line ri-xl text-success"></i>
              </div>
              <div class="flex-grow-1">
                <h6 class="mb-1">Available Today</h6>
                <div class="progress bg-label-success" style="height: 4px;">
                  <div class="progress-bar bg-success" style="width: 100%"></div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="avatar">
          <div class="avatar-initial bg-info rounded-circle shadow-xs">
            <i class="ri-cash-line ri-24px text-white"></i>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-1 mt-4">Total Earnings</h6>
        <div class="d-flex flex-wrap mb-4 align-items-center">
          <h4 class="mb-0 me-2 fw-semibold" id="totalEarnings">₱{{ number_format($amount, 2)}}</h4>
        </div>
        <div class="mt-4">
          <ul class="p-0 m-0">
            <li class="d-flex mb-3">
              <div class="avatar flex-shrink-0 bg-light-info rounded me-3">
                <i class="ri-wallet-2-line ri-xl text-info"></i>
              </div>
              <div class="flex-grow-1">
               <h6 class="mb-1">{{ now()->format('F j, Y') }}</h6>
                <div class="progress bg-label-info" style="height: 4px;">
                  <div class="progress-bar bg-info" style="width: 100%"></div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Monthly Payment Line Chart with Year Filter -->
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Payment</h4>
        <form method="GET">
          <div class="d-flex align-items-center">
            <select name="year" id="year" class="form-select" onchange="this.form.submit()">
              @foreach ($availableYears as $year)
                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="card-body">
        <div id="totalProfitLineChart" style="height: 400px;"></div>
        <span id="monthly-data" style="display:none;">{{ json_encode($monthlyData) }}</span>
      </div>
    </div>
  </div>
   <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Partial Payment</h4>
        <form method="GET">
          <div class="d-flex align-items-center">
            <select name="year" id="year" class="form-select" onchange="this.form.submit()">
              @foreach ($availableYears as $year)
                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="card-body">
        <div id="totalProfitLineChartPartial" style="height: 400px;"></div>
        <span id="monthly-partial-data" style="display:none;">{{ json_encode($monthlyPartialData) }}</span>
      </div>
    </div>
  </div>
  <!-- facilities -->
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-item-center">
        <h4>Facilties</h4>
      </div>
      <div class="card-body">
        <div id="facilitiesChart" style="height: 400px;"></div>
        <span id="facility-revenue-data" style="display:none;">
            {{ json_encode($facilitiesData->map(fn($f) => ['name' => $f->name, 'total' => $f->total])) }}
        </span>
      </div>
    </div>
  </div>
  <!-- foods -->
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-item-center">
        <h4>Foods</h4>
      </div>
      <div class="card-body">
        <div id="foodsChart" style="height: 400px;"></div>
        <span id="foods-revenue-data" style="display:none;">
            {{ json_encode($foodData->map(fn($f) => ['name' => $f->name, 'total' => $f->total])) }}
        </span>
      </div>
    </div>
  </div>
  <div class="row gy-4">
    <div class="col-xl-4 col-md-12">
        <div class="card h-100 position-relative">
            <!-- Badge -->
            <span class="badge bg-success text-dark position-absolute top-0 start-0 m-2">Best Seller</span>
            <div class="card-body p-0">
                <img class="d-block w-100" src="{{ $RoomBest->path }}" alt="Room Best" style="height: 300px; object-fit: cover;">
            </div>
            <div class="card-body">
              <h6>{{ $RoomBest->name}}</h3>
              <span>Total Sales of ₱{{ number_format($RoomBest->total, 2)}}</span>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-12">
        <div class="card h-100 position-relative">
            <!-- Badge -->
            <span class="badge bg-success text-dark position-absolute top-0 start-0 m-2">Best Seller</span>
            <div class="card-body p-0">
                <img class="d-block w-100" src="{{ $CottageBest->path }}" alt="Room Best" style="height: 300px; object-fit: cover;">
            </div>
             <div class="card-body">
              <h6>{{ $CottageBest->name}}</h3>
              <span>Total Sales of ₱{{ number_format($CottageBest->total, 2)}}</span>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-12">
        <div class="card h-100 position-relative">
            <!-- Badge -->
            <span class="badge bg-success text-dark position-absolute top-0 start-0 m-2">Best Seller</span>
            <div class="card-body p-0">
                <img class="d-block w-100" src="{{ $foodBest->path }}" alt="Room Best" style="height: 300px; object-fit: cover;">
            </div>
             <div class="card-body">
              <h6>{{ $foodBest->name}}</h3>
              <span>Total Sales of ₱{{ number_format($foodBest->total, 2)}}</span>
            </div>
        </div>
    </div>
</div>

    <!-- Additional Analytics Section -->
  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Customer Satisfaction Score</h4>
      </div>
      <div class="card-body">
        <div id="customerSatisfactionGauge" style="height: 335px;"></div>
        <span id="satisfaction-score" style="display:none;">{{ $customerSatisfaction ?? 0 }}</span>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-6">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Revenue by Category</h4>
      </div>
      <div class="card-body">
        <div id="revenueByCategoryChart" style="height: 335px;"></div>

        <!-- Hidden JSON data -->
        <span id="revenue-category-data" style="display:none;">
          {{ json_encode($revenueByCategory ?? [
            'Cottages' => $cottageData,
            'Rooms' => $roomData
          ]) }}
        </span>
      </div>
    </div>
  </div>


  <div class="col-12 col-lg-4">
    <div class="card h-100">
      <div class="card-header">
        <h4 class="mb-0">Average Revenue per Reservation</h4>
      </div>
      <div class="card-body text-center">
        <h2 class="fw-semibold text-success mb-2">
          ₱{{ number_format($averageRevenue, 2) }}
        </h2>
        <p class="text-muted mb-3">Average per booking</p>
        <div id="avgRevenueSparkline" style="height: 120px;"></div>

        <!-- Hidden data for trend -->
        <span id="avg-revenue-data" style="display:none;">
          {{ json_encode($monthlyRevenue) }}
        </span>
      </div>
    </div>
  </div>


  <div class="col-12 col-lg-8">
    <div class="card">
      <div class="card-header">
        <h4 class="mb-0">Cancellations</h4>
      </div>
      <div class="card-body">
        <div id="refundsChart" style="height: 300px;"></div>
        <span id="refunds-data" style="display:none;">
          {{ json_encode($refundsData) }}
        </span>
      </div>
    </div>
  </div>
  
 


<!-- Pass the amounts data as a hidden JSON element -->
<span id="amounts-data" style="display:none;">{{ json_encode($amountReservation->pluck('amount')) }}</span>

@endsection