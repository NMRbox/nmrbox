@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Sign in
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{asset('assets/vendors/iCheck/skins/all.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/nmr.css') }}" rel="stylesheet">
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
<div class="container">
    <div class="row">
        <div class="panel-header">
            <img class="center-block" src="{{ asset('assets/img/logo/nmrbox-logo-sm.png') }}">
            <h2 class="text-center text-primary logo-text">NMRbox</h2>
            <h4 class="text-center">Forgot Password?</h4>
        </div>
        <div class="panel-body social">
            <div class="clearfix">

                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <!-- Notifications -->
                    @include('notifications')

                    <form action="{{ route('forgot-password') }}" class="omb_loginForm"  autocomplete="off" method="POST">
                        {!! Form::token() !!}
                        <div class="input-group {{ $errors->first('email', 'has-error') }}">
                            <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                            <input type="email" class="form-control email" name="email" placeholder="Institutional Email"
                                   value="{!! Input::old('email') !!}">

                        </div>
                        <span class="help-block errors">{{ $errors->first('email', 'Please enter your institutional email address.') }}</span>
                        <input type="submit" class="btn btn-block btn-primary" value="Reset Your Password" style="margin-top:10px;">
                    </form>

                    <div class="panel-header">
                        <h4 class="text-center text-primary">
                            <a href="{{ route('login') }}">Sign in</a> or
                            <a href="{{ route('register') }}">Sign up</a>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <br><br><br><br>


@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/register.js') }}"></script>

@stop
