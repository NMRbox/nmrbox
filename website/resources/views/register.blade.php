@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Sign in
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/iCheck/skins/minimal/red.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/iCheck/skins/flat/red.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/datepicker/css/datepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendors/select2/select2.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/select2/select2-bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom_css/login.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        form label{
            color: #000000;
        }
        p {
            font-size: inherit;
        }
    </style>
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container-fluid">
        <section class="container">
            <div class="container-page" id="form-login">
                {{-- header/logo --}}
                <div class="panel-header">
                    <a href="{!! url('homepage') !!}"><img class="center-block" src="{{ asset('assets/img/logo/nmrbox-logo-sm.png') }}"></a>
                    <h2 class="text-center text-primary logo-text"><a href="{!! url('homepage') !!}">NMRbox</a></h2>
                    <h2 class="text-center text-primary">
                        Sign up  or
                        <a href="{{ route('login') }}">Sign in</a>
                    </h2>
                </div>
                {{-- eof header/logo--}}
                <div class="col-md-12">
                    <!-- Notifications -->
                    @include('notifications')
                    <br>
                </div>

                <div class="col-md-6">
                    <h3 class="dark-grey">Sign up</h3><hr>
                    <div class="row">

                        {!! BootForm::open(array('url'=>route('register'), 'class' => 'form ' )) !!}

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('first_name', "First Name", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('last_name', "Last Name", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-12">
                            {!! BootForm::email('email_institution', "Email (institutional account)", null, array('class' => 'form-control', 'maxlength'=> 255, 'required' => 'required')) !!}
                        </div>

                        <div class="form-group col-lg-12">
                            {!! BootForm::email('email', "Preferred contact email (if different than institutional email)", null, array('class' => 'form-control', 'maxlength'=> 255)) !!}
                        </div>

                        <div class="form-group col-lg-12">
                            {!! BootForm::select('job_title', "Job Title",
                                    [null=>'Please Select'] + $person_positions, null, array('class' => 'form-control select_pi', 'maxlength'=> 32, 'required' => 'required')) !!}
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('institution', "Institution", null, array('class' => 'form-control', 'maxlength'=> 256, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::select('institution_type', "Institution Type",
                                    [null=>'Please Select'] + $person_institution_types, null, array('class' => 'form-control', 'maxlength'=> 256, 'required' => 'required')) !!}
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('department', "Department", null, array('class' => 'form-control', 'maxlength'=> 256, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('pi', "PI", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-12">
                            {!! BootForm::text('address1', "Address Line 1", null, array('class' => 'form-control', 'maxlength'=> 128, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('address2', "Address Line 2", null, array('class' => 'form-control', 'maxlength'=> 128))!!}
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('address3', "Address Line 3", null, array('class' => 'form-control', 'maxlength'=> 128))!!}
                        </div>

                        <div class="form-group col-lg-12">
                            {!! BootForm::text('city', "City", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-6">
                            {{--{!! BootForm::text('state_province', "State or Province", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}--}}
                            <label for="state_province" class="control-label">State or Province</label>
                            <div class="form-group">
                                <select name='state_province' class="form-control" id="ct" data-show-default-option="true" data-default-option="Select State or Province" data-default-value="Connecticut" required></select>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">
                            {!! BootForm::text('zip_code', "Zip Code", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}
                        </div>

                        <div class="form-group col-lg-12">
                            {{--{!! BootForm::text('country', "Country", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}--}}
                            <label for="country" class="control-label">Country</label>
                            <div class="form-group">
                                <select name='country' class="crs-country form-control" data-region-id="ct" data-default-value-option="true" data-default-value="United States" required></select>
                            </div>
                        </div>

                        <div class="form-group col-lg-12">
                            {!! BootForm::select('time_zone_id', "Time Zone",
                                    $timezones_for_select, 169, array('required' => 'required')) !!}
                        </div>

                        {{--<div class="form-group col-lg-12">
                            {!! ReCaptcha::render() !!}
                            {!! $errors->first('g-recaptcha-response','<p class="alert alert-danger">:message</p>')!!}
                        </div>--}}

                        <div class="form-group col-lg-12">
                            {!! BootForm::submit('Register', array('class'=>'btn btn-primary btn-lg btn-block ')) !!}

                        </div>

                        {!! BootForm::close() !!}
                    </div>

                </div>
                <div class="col-md-6">
                    <h3 class="dark-grey">Instructions</h3><hr>

                    <ol>
                        <li>Please fill out the form.</li>
                        <li>You will receive a confirmation email shortly.</li>
                        <li>Accounts are validated manually, generally within 2 business days.</li>
                        <li>When your account is validated, you will receive instructions on how to access your account and connect to NMRbox.</li>
                    </ol>
                    <p>
                        If you have any questions or do not receive any of the emails referenced above, please contact us at <a href="mailto:support@nmrbox.org">support@nmrbox.org</a>  to ensure that your account request is properly handled.
                    </p>

                </div>
            </div>
        </section>
    </div>
    <br><br><br><br>


@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/register.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/country-region-list/jquery.crs.min.js') }}"></script>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
@stop
