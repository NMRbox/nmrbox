<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>

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
                <br>
                {!! BootForm::open(array('url'=>route('register'), 'class' => 'form-horizontal' )) !!}

                    {!! BootForm::text('first_name', "First Name", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                    {!! BootForm::text('last_name', "Last Name", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                    {!! BootForm::email('email_institution', "Email (institutional account)", null, array('class' => 'input-lg', 'maxlength'=> 255, 'required' => 'required')) !!}
                    {!! BootForm::email('email', "Preferred contact email (if different than institutional email)", null, array('class' => 'input-lg', 'maxlength'=> 255)) !!}

                    {!! BootForm::select('job_title', "Job Title",
                            [null=>'Please Select'] + $person_positions, null, array('class' => 'input-lg select_pi', 'maxlength'=> 32, 'required' => 'required')) !!}

                    {!! BootForm::text('institution', "Institution", null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                    {!! BootForm::select('institution_type', "Institution Type",
                            [null=>'Please Select'] + $person_institution_types, null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required')) !!}

                    {!! BootForm::text('department', "Department", null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                    {!! BootForm::text('pi', "PI", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}

                    {!! BootForm::text('address1', "Address Line 1", null, array('class' => 'input-lg', 'maxlength'=> 128, 'required' => 'required'))!!}
                    {!! BootForm::text('address2', "Address Line 2", null, array('class' => 'input-lg', 'maxlength'=> 128))!!}
                    {!! BootForm::text('address3', "Address Line 3", null, array('class' => 'input-lg', 'maxlength'=> 128))!!}
                    {!! BootForm::text('city', "City", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                    {!! BootForm::text('state_province', "State or Province", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                    {!! BootForm::text('zip_code', "Zip Code", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                    {!! BootForm::text('country', "Country", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                    {!! BootForm::select('time_zone_id', "Time Zone",
                            $timezones_for_select, 169, array('required' => 'required')) !!}

                    {!! BootForm::submit('Save', array('class'=>'btn btn-primary btn-lg btn-block ')) !!}
                    {{--{!! BootForm::submit('Reset', array('class'=>'btn btn-primary btn-lg btn-block')) !!}--}}

                {!! BootForm::close() !!}
            </div>
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