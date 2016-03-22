<!DOCTYPE html>
<html>
<head>
    {{--<meta charset="UTF-8">--}}
    <title>Forgot Password Confirm | Welcome to Chandra_Frontend</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-3.3.4-dist/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('assets/img/nmr-favicon/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- end of global css-->
    <!-- page level styles-->
    <link type="text/css" href="{{ asset('assets/vendors/iCheck/skins/minimal/blue.css') }}">
    <link href="{{ asset('assets/css/frontend/register.css') }}" rel="stylesheet">
    <!-- end of page level styles-->
</head>
<body>
<div class="container">
    <div class="row">

        <div class="box animated fadeInDown">

            <h2 class="text-center text-primary"><img src="{{ asset('assets/images/logo3.png') }}"><br />Chandra</h2>
            <h4 class="text-primary text-center"><strong>Reset your Password</strong></h4>

            <p class="text-center">Enter your new password details</p>
            {{--<form action="#" method="post">--}}
            {{--<div class="form-group">--}}
            @include('notifications')

            <form action="{{ route('forgot-password-confirm',compact(['userId','passwordResetCode'])) }}" class="omb_loginForm"  autocomplete="off" method="POST">
                {!! Form::token() !!}
                <input type="password" class="form-control" name="password" placeholder="New Password">
                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                <input type="password" class="form-control" name="password_confirm" placeholder="Confirm New Password">
                <span class="help-block">{{ $errors->first('password_confirm', ':message') }}</span>

                <input type="submit" class="btn btn-block btn-primary" value="Submit to Reset Password" style="margin-top:10px;">
            </form>
            {{--</div>--}}

            <div class="panel-header">
                <h4 class="text-center text-primary">
                    <a href="{{ route('login') }}">Login</a> or
                    <a href="{{ route('register') }}">Sign up</a>
                </h4>
            </div>


        </div>
    </div>
</div>
<!-- global js -->
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/frontend/register.js') }}"></script>
<!-- end of global js -->
</body>
</html>