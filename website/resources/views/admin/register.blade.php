<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- end of global css-->
    <!-- page level styles-->
    <link href="{{ asset('assets/vendors/iCheck/skins/minimal/red.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/iCheck/skins/flat/red.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendors/select2/select2.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/select2/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom_css/login.css') }}" rel="stylesheet" type="text/css">
    <!-- end of page level styles-->
</head>
<body>
    <div class="container">
        <div class="row " id="form-login">
            <div class="panel-header">
                <img class="center-block" src="{{ asset('assets/img/logo/nmrbox-logo-sm.png') }}">
                <h2 class="text-center text-primary logo-text">NMRbox</h2>
                <h2 class="text-center text-primary">
                    Register  or
                    <a href="{{ route('admin-login') }}">Sign in</a>
                </h2>
            </div>
            <div class="panel-body social col-sm-offset-3">
                <div class="col-xs-12 col-sm-8 ">
                    <!-- Notifications -->
                    @include('notifications')
                    @if($errors->has())
                        @foreach ($errors->all() as $error)
                            <div class="text-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <br />
                    <form class="form-horizontal" method="POST" action="{{ route('admin-register') }}">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                            <label class="control-label col-xs-3" for="first_name">First Name:</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <span class="input-group-addon"> <i class="fa fa-fw fa-user-md text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" value="{!! Input::old('first_name') !!}" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                            <label class="control-label col-xs-3" for="last_name">Last Name:</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" value="{!! Input::old('last_name') !!}" required />
                                    <span class="input-group-addon"> <i class="fa fa-fw fa-user-md text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                            <label class="control-label col-xs-3" for="email">Email:</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" placeholder="Email Address" class="form-control" name="email" id="email" value="{!! Input::old('email') !!}" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('email_confirm', 'has-error') }}">
                            <label class="control-label col-xs-3" for="email_confirm">Confirm Email:</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" placeholder="Email Address" class="form-control" name="email_confirm" id="email_confirm"  value="{!! Input::old('email_confirm') !!}" required/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('password', 'has-error') }}">
                            <label class="control-label col-xs-3" for="password">Password:</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-fw fa-key text-primary"></i>
                                    </span>
                                    <input type="password" placeholder="Password" class="form-control" name="password" id="password" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                            <label class="control-label col-xs-3" for="password_confirm">Confirm Password:</label>
                            <div class="col-xs-9">
                                <div class="input-group">
                                    <input type="password" placeholder="Confirm Password" class="form-control" name="password_confirm" id="password_confirm" required />
                                    <span class="input-group-addon">
                                        <i class="fa fa-fw fa-key text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-xs-offset-3 col-xs-9">
                                <input type="submit" class="btn btn-primary" value="Submit" name="submit" />
                                <input type="reset" class="btn btn-default" value="Reset" />
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>

    </div>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- end of global js -->
    <!-- begining of page level js -->
    <script src="{{ asset('assets/vendors/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/iCheck/icheck.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom_js/register.js') }}" type="text/javascript"></script>
    <!-- end of page level js -->
</body>
</html>