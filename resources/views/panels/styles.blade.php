<link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendors/css/ui/prism.min.css') }}" />
{{-- Vendor Styles --}}
@yield('vendor-style')
{{-- Theme Styles --}}

<link rel="stylesheet" href="{{ asset('css/core.css') }}" />

{{-- {!! Helper::applClasses() !!} --}}
@php $configData = Helper::applClasses(); @endphp

{{-- Page Styles --}}
@if($configData['mainLayoutType'] === 'horizontal')
<link rel="stylesheet" href="{{ asset('css/base/core/menu/menu-types/horizontal-menu.css') }}" />
@endif
<link rel="stylesheet" href="{{ asset('css/base/core/menu/menu-types/vertical-menu.css') }}" />
<!-- <link rel="stylesheet" href="{{ asset('css/base/core/colors/palette-gradient.css') }}"> -->

{{-- Page Styles --}}
@yield('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
{{-- Laravel Style --}}
<link rel="stylesheet" href="{{ asset('css/overrides.css') }}" />

{{-- Custom RTL Styles --}}

@if($configData['direction'] === 'rtl' && isset($configData['direction']))
<link rel="stylesheet" href="{{ asset('css/custom-rtl.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style-rtl.css') }}" />
@endif

{{-- user custom styles --}}
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
