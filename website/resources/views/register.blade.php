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

            {!! BootForm::open(array('url'=>route('register') )) !!}

                {!! BootForm::text('first_name', "First Name", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                {!! BootForm::text('last_name', "Last Name", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                {!! BootForm::email('email', "Email", null, array('class' => 'input-lg', 'maxlength'=> 255, 'required' => 'required')) !!}

                {!! BootForm::select('job_title', "Job Title",
                        $person_positions, null, array('maxlength'=> 32, 'required' => 'required')) !!}

                {!! BootForm::text('institution', "Institution", null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                {!! BootForm::select('institution_type', "Institution Type",
                        $person_institution_types, null, array( 'maxlength'=> 256, 'required' => 'required')) !!}

                {!! BootForm::text('department', "Department", null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                {!! BootForm::text('pi', "PI", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}

                {!! BootForm::text('address1', "Address Line 1", null, array('class' => 'input-lg', 'maxlength'=> 128, 'required' => 'required'))!!}
                {!! BootForm::text('address2', "Address Line 2", null, array('class' => 'input-lg', 'maxlength'=> 128))!!}
                {!! BootForm::text('address3', "Address Line 3", null, array('class' => 'input-lg', 'maxlength'=> 128))!!}
                {!! BootForm::text('city', "City", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                {!! BootForm::text('state_province', "State_province", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                {!! BootForm::text('zip_code', "Zip_code", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                {!! BootForm::text('country', "Country", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                {!! BootForm::select('time_zone_id', "Time Zone",
                        $timezones_for_select, 169, array('required' => 'required')) !!}

                {!! BootForm::submit('Save', array('class'=>'btn btn-primary btn-lg ')) !!}

            {!! BootForm::close() !!}

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