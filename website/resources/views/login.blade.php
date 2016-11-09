
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-3.3.4-dist/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/nmr-favicon/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="{{asset('assets/vendors/iCheck/skins/all.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend/login.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/nmr.css') }}" rel="stylesheet">
    <!-- end of page level styles-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="box">
            <img class="center-block" src="{{ asset('assets/img/logo/nmrbox-logo-sm.png') }}">
            <h2 class="text-center text-primary logo-text">NMRbox</h2>
            <h4 class="text-primary"><strong>Login</strong></h4>
            <!-- Notifications -->
            @include('notifications')

            <form action="{{ route('login') }}" class="omb_loginForm"  autocomplete="off" method="POST">
                {!! Form::token() !!}
                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{!! Input::old('email') !!}">
                </div>
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                    <label for="Password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                <div class="checkbox">
                    <label>
                        <input type="checkbox">  Remember Password
                    </label>
                    <a href="{{ route('forgot-password') }}" class="pull-right">Forgot Password?</a>
                </div>
                <input type="submit" class="btn btn-block btn-primary" value="Login">
                Don't have an account? <a href="{{ route('register') }}"><strong> Sign up</strong></a>
            </form>
        </div>
    </div>
</div>
<!-- global js -->
<script type="text/javascript" src="{{ asset('assets/js/frontend/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/frontend/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/frontend/register.js') }}"></script>
<!-- end of global js -->
</body>
</html>