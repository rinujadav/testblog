@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-style')
 <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <div class="row match-height">
        <!-- Greetings Card starts -->
        <div class="col-md-12">
            <div class="card card-congratulations">
                <div class="card-body text-center">
                    <img src="{{asset('images/elements/decore-left.png')}}" class="congratulations-img-left" alt="card-img-left" />
                    <img src="{{asset('images/elements/decore-right.png')}}" class="congratulations-img-right" alt="card-img-right" />
                    <div class="avatar avatar-xl bg-primary shadow">
                        <div class="avatar-content">
                            <i data-feather="award" class="font-large-1"></i>
                        </div>
                    </div>
                    <div class="text-center">
                        <h1 class="mb-1 text-white">Congratulations {{ Auth::user()->name }},</h1>
                        <p class="card-text m-auto w-75">
                            You have successfully logged in to <strong>Test Blog</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Greetings Card ends -->
    </div>

    <!-- Line Chart Starts-->
  <div class="row" id="sales-data">
    <sales-data></sales-data>
  </div>
  <!-- Line Chart Ends-->
</section>
<!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
<script type="text/javascript">
    var user = {!! json_encode(auth()->user()) !!};
</script>
<!-- vendor files -->
<script src="{{ asset('vendors/js/charts/chart.min.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script type="text/javascript">
    var base_url = "{{ url('/'). '/' }}";
  </script>
  <script src="{{ asset('js/sales-data.js') }}"></script>
  
@endsection