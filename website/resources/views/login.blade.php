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
    <style type="text/css">
        .hidden {
            display: none !important;
        }
    </style>
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container">
        <div class="row" >
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

                <img class="center-block" src="{{ asset('assets/img/logo/nmrbox-logo-sm.png') }}"><hr>
                <!-- Notifications -->
                @include('notifications')
                <form role="form" action="{{ route('login') }}" class="omb_loginForm"  autocomplete="off" method="POST">
                    {!! Form::token() !!}
                    <fieldset>
                        <h2>Please Sign In</h2>
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" value="{!! $user['username'] !!}" readonly>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <span class="button-checkbox">
                            <input type="checkbox" name="remember_me" id="remember_me"> Remember Me
                            <a href="{!! route('forgot-password') !!}" class="btn btn-link pull-right">Forgot Password?</a>
				        </span>
                        <br><br>
                        <div class="form-group row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <a href="{{ route('register') }}" class="btn btn-lg btn-primary btn-block" style="color: #fff;">Sign Up</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <br><br><br><br>


@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/register.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('.button-checkbox').each(function(){
                var $widget = $(this),
                    $button = $widget.find('button'),
                    $checkbox = $widget.find('input:checkbox'),
                    color = $button.data('color'),
                    settings = {
                        on: {
                            icon: 'glyphicon glyphicon-check'
                        },
                        off: {
                            icon: 'glyphicon glyphicon-unchecked'
                        }
                    };

                $button.on('click', function () {
                    $checkbox.prop('checked', !$checkbox.is(':checked'));
                    $checkbox.triggerHandler('change');
                    updateDisplay();
                });

                $checkbox.on('change', function () {
                    updateDisplay();
                });

                function updateDisplay() {
                    var isChecked = $checkbox.is(':checked');
                    // Set the button's state
                    $button.data('state', (isChecked) ? "on" : "off");

                    // Set the button's icon
                    $button.find('.state-icon')
                        .removeClass()
                        .addClass('state-icon ' + settings[$button.data('state')].icon);

                    // Update the button's color
                    if (isChecked) {
                        $button
                            .removeClass('btn-default')
                            .addClass('btn-' + color + ' active');
                    }
                    else
                    {
                        $button
                            .removeClass('btn-' + color + ' active')
                            .addClass('btn-default');
                    }
                }
                function init() {
                    updateDisplay();
                    // Inject the icon if applicable
                    if ($button.find('.state-icon').length == 0) {
                        $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                    }
                }
                init();
            });
        });
    </script>
@stop
