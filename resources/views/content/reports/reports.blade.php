@extends('layouts/contentNavbarLayout')

@section('title', 'Generate Report')

@section('content')
<section>
  <div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header ">
            <h4 class="mb-0">Generate Revenue Report</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('reports-page-generate') }}" method="GET" target="_blank">
                <div class="row mb-3">

                    {{-- Date From --}}
                    <div class="col-md-6">
                        <label for="from_date" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" required>
                    </div>

                    {{-- Date To --}}
                    <div class="col-md-6">
                        <label for="to_date" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" required>
                    </div>
                </div>


                <div class="mt-4 d-flex justify-content-end">

                    <div>
                        <button type="submit" name="export" value="pdf" class="btn btn-danger me-2">
                            <i class="bi bi-file-earmark-pdf"></i> Generate Report
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
  </div>
</section>
@if(session('show_modal'))
    <script>
        Toastify({
            text: "You Cannot choose the future dates",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "orange",
            stopOnFocus: true
        }).showToast();
    </script>
@endif
@if(session('show_modal_2'))
    <script>
        Toastify({
            text: "Invalid Date input",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "orange",
            stopOnFocus: true
        }).showToast();
    </script>
@endif
@endsection
