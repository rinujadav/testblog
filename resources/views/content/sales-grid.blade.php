
@extends('layouts/contentLayoutMaster')

@section('title', 'Sales')

@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-vue/2.21.2/bootstrap-vue.min.css">
@endsection
@section('content')

<!-- Basic table -->
<section id="sales">
  <div class="row">
      <div class="col-12">
        <sales-list></sales-list>
      </div>
  </div>
</section>
<!--/ Basic table -->
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script type="text/javascript">
    var base_url = "{{ url('/'). '/' }}";
  </script>
  <script src="{{ asset('js/sales.js') }}"></script>
  
@endsection
