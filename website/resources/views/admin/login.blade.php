<!DOCTYPE html>
<html>
<head>
    <title>Login | Chandra Admin Template</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- global level css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="{{ asset('assets/css/custom_css/login.css') }}" rel="stylesheet" type="text/css">
    <!-- end of page level styles-->
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="panel-header">
                <h2 class="text-center">
                    Login or
                    <a href="{{ route('admin-register') }}">Sign up</a>
                </h2>
            </div>
            <div class="panel-body social">
                <div class="clearfix">

                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        <!-- Notifications -->
                        @include('notifications')

                        <form action="{{ route('admin-login') }}" class="omb_loginForm"  autocomplete="off" method="POST">
                            {!! Form::token() !!}
                            <div class="input-group {{ $errors->first('email', 'has-error') }}">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input type="email" class="form-control" name="email" placeholder="email address" value="{!! Input::old('email') !!}"></div>
                                <span class="help-block">{{ $errors->first('email', ':message') }}</span>

                            <div class="input-group {{ $errors->first('password', 'has-error') }}">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" name="password" placeholder="Password"></div>
                            <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">
                                    Remember Me
                                </label>
                            </div>
                            <input type="submit" class="btn btn-md btn-primary btn-block" value="Login" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
</body>
</html>