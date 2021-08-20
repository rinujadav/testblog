@extends('layouts/contentLayoutMaster')

@section('title', 'Account Settings')

@section('vendor-style')
<!-- vendor css files -->
<link rel='stylesheet' href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
<link rel='stylesheet' href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
<!-- account setting page -->
<section id="page-account-settings">
    <div class="row">
        <!-- left menu section -->
        <div class="col-md-3 mb-2 mb-md-0">
            <ul class="nav nav-pills flex-column nav-left">
                <!-- general -->
                <li class="nav-item">
                    <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                        <i data-feather="user" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">General</span>
                    </a>
                </li>
                <!-- change password -->
                <li class="nav-item">
                    <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                        <i data-feather="lock" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Change Password</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--/ left menu section -->

        <!-- right content section -->
        <div class="col-md-9">
            @if (session('error'))
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="alert-body">
                                        <i style="top: 0px;" class="fas fa-exclamation-circle"></i>
                                        <span style="margin-left: 3px;">Oops! You've entered invalid data. Please try again.</span>
                                        <div style="margin-top: 5px; margin-left: 15px;">
                                            <i style="top: 0px;" class="fas fa-exclamation-circle"></i>
                                            <span style="margin-left: 3px;"> {{ session('error') }} </span>
                                        </div>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('success'))
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            <i style="top: 0px;" class="fas fa-exclamation-circle"></i>
                                            <span style="margin-left: 3px;">Oops! You've entered invalid data. Please try again.</span>
                                            @foreach ($errors->all() as $error)
                                                <div style="margin-top: 5px; margin-left: 15px;">
                                                    <i style="top: 0px;" class="fas fa-exclamation-circle"></i>
                                                    <span style="margin-left: 3px;"> {{ $error }} </span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <!-- general tab -->
                        <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                            <!-- header media -->
                            <div class="media">
                                <a href="javascript:void(0);" class="mr-25">
                                    <img src="{{ asset(!empty(Auth::user()->profile_photo_path) ? Auth::user()->profile_photo_path : 'images/logo/logo-icon.png') }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                </a>
                                <form action="{{ route('profile.update') }}" id="image-upload" method="POST" role="form" enctype="multipart/form-data">
                                    @csrf
                                    <!-- upload and reset button -->
                                    <div class="media-body mt-75 ml-1">
                                        <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                        <input type="file" id="account-upload" name="image" hidden accept="image/*" onchange="document.getElementById('image-upload').submit()" />
                                        <p>Allowed JPG, GIF or PNG. Max size of 800kB</p>
                                    </div>
                                    <!--/ upload and reset button -->
                                </form>
                            </div>
                            <!--/ header media -->

                            <!-- form -->
                            <form  action="{{ url('page/user-general-update') }}" method="POST">
                                @csrf
                                <div class="row mt-2">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-username">Name</label>
                                            <input type="text" class="form-control" id="account-username" name="name" placeholder="Name" value="{{ Auth::user()->name }}" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-e-mail">E-mail</label>
                                            <input type="email" class="form-control" disabled id="account-e-mail" name="email" placeholder="Email" value="{{ Auth::user()->email }}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mt-2 mr-1">Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-2">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            <!--/ form -->
                        </div>
                        <!--/ general tab -->

                        <!-- change password -->
                        <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                            <!-- form -->
                            <form class="validate-form" id="password-form" action="{{ url('page/user-password-update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-old-password">Old Password</label>
                                            <div class="input-group form-password-toggle input-group-merge">
                                                <input type="password" class="form-control" id="account-old-password" name="password" placeholder="Old Password" />
                                                <div class="input-group-append">
                                                    <div class="input-group-text cursor-pointer">
                                                        <i data-feather="eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-new-password">New Password</label>
                                            <div class="input-group form-password-toggle input-group-merge">
                                                <input type="password" id="account-new-password" name="new_password" class="form-control" placeholder="New Password" />
                                                <div class="input-group-append">
                                                    <div class="input-group-text cursor-pointer">
                                                        <i data-feather="eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="account-retype-new-password">Retype New Password</label>
                                            <div class="input-group form-password-toggle input-group-merge">
                                                <input type="password" class="form-control" id="account-retype-new-password" name="confirm_new_password" placeholder="New Password" />
                                                <div class="input-group-append">
                                                    <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 mt-1" onclick="event.preventDefault(); document.getElementById('password-form').submit();">Save changes</button>
                                        <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
                                    </div>
                                </div>
                            </form>
                            <!--/ form -->
                        </div>
                        <!--/ change password -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ right content section -->
    </div>
</section>
<!-- / account setting page -->
@endsection

@section('vendor-script')
<!-- vendor files -->
{{-- select2 min js --}}
<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
{{-- jQuery Validation JS --}}
<script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/dropzone.min.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset('js/scripts/pages/page-account-settings.js') }}"></script>
@endsection