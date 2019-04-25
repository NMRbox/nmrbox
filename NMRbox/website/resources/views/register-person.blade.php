<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/nmr-favicon/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico" type="image/x-icon') }}">
    <!-- end of global css-->
    <!-- page level styles-->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/vendors/iCheck/skins/all.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/vendors/iCheck/skins/minimal/blue.css') }}">
    <link href="{{ asset('assets/css/frontend/register.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/nmr.css') }}">
    <!-- end of page level styles-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="box animated fadeInDown">
            <img class="center-block" src="{{ asset('assets/img/logo/nmrbox-logo-sm.png') }}">
            <h2 class="text-center text-primary logo-text">NMRbox</h2>
            <h4 class="text-primary"><strong>Sign Up</strong></h4>
            <!-- Notifications -->
            @include('notifications')
            @if($errors->has())
                @foreach ($errors->all() as $error)
                    <div class="text-danger">{{ $error }}</div>
                @endforeach
            @endif
            <form action="{{ route('register-person') }}" method="POST">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="username"> First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{!! Input::old('first_name') !!}" required>
                </div>
                <div class="form-group">
                    <label for="username"> Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{!! Input::old('last_name') !!}" required>
                </div>
                <div class="form-group">
                    <label for="Email"> Email</label>
                    <input type="email" class="form-control" id="Email" name="email" placeholder="Email" value="{!! Input::old('Email') !!}" required>
                </div>
                <div class="form-group">
                    <label for="institutional_email"> Preferred contact email (if different than institutional email)</label>
                    <input type="email" class="form-control" id="institutional_email" name="institutional_email" placeholder="Email" value="{!! Input::old('institutional_email') !!}">
                </div>
                <div class="form-group">
                    <label for="Institution"> Institution</label>
                    <input type="text" class="form-control" id="Institution" name="institution" placeholder="Institution" value="{!! Input::old('Institution') !!}" required>
                </div>
                <div class="form-group">
                    <label for="PI"> PI</label>
                    <input type="text" class="form-control" id="PI" name="pi" placeholder="Principal Investigator" value="{!! Input::old('PI') !!}" required>
                </div>
                <input type="submit" class="btn btn-block btn-primary" value="Register" name="submit">
                {{--Have account already? <a href="{{ route('login') }}">Sign In</a>--}}
            </form>
        </div>
    </div>
</div>
<!-- global js -->
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/frontend/register.js') }}"></script>
<!-- end of global js -->
</body>
</html>