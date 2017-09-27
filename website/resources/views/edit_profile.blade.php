@extends('layouts.default')

{{-- Page title --}}
@section('title')
    User Account
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/iCheck/skins/minimal/blue.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/user_account.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datepicker/css/datepicker.css') }}">

    <style type="text/css">
        .user-row {
            margin-bottom: 14px;
        }

        .user-row:last-child {
            margin-bottom: 0;
        }

        .dropdown-user {
            margin: 13px 0;
            padding: 5px;
            height: 100%;
        }

        .dropdown-user:hover {
            cursor: pointer;
        }

        .table-user-information > tbody > tr {
            border-top: 1px solid rgb(221, 221, 221);
        }

        .table-user-information > tbody > tr:first-child {
            border-top: 0;
        }

        .table-user-information > tbody > tr > td {
            border-top: 0;
        }

        .toppad {
            margin-top: 20px;
        }

    </style>

@stop

{{-- Page content --}}
@section('content')
    <div class="container">

        <div class="row">
            <div class="welcome">
                <h3>Update Profile</h3>
            </div>

            <div class="col-md-12">
                <br>
                @include('notifications')
            </div>

            <div class="row">

                {!! BootForm::open(array('model'=>$person, 'store'=>'person.store', 'update'=>'person.update_profile', 'class' => 'form')) !!}

                <div class="form-group col-lg-6">
                    {!! BootForm::text('first_name', "First Name", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}
                </div>

                <div class="form-group col-lg-6">
                    {!! BootForm::text('last_name', "Last Name", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}
                </div>

                <div class="form-group col-lg-6">
                    {!! BootForm::email('email_institution', "Email (institutional account)", null, array('class' => 'form-control', 'maxlength'=> 255, 'required' => 'required')) !!}
                </div>

                <div class="form-group col-lg-6">
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
                    <label for="country" class="control-label">Country</label>
                    <div class="form-group">
                        <select name='country' class="crs-country form-control" data-region-id="ct" data-default-value-option="true" data-default-value="United States" required></select>
                    </div>
                </div>

                <div class="form-group col-lg-12">
                    {!! BootForm::select('time_zone_id', "Time Zone",
                            $timezones_for_select, 169, array('required' => 'required')) !!}
                </div>

                <div class="form-group col-lg-12">
                    {!! BootForm::submit('Update', array('class'=>'btn btn-primary btn-lg btn-block ')) !!}
                </div>

                {!! BootForm::close() !!}
            </div>

        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

    <script type="text/javascript">
        $(document).ready(function () {
            var panels = $('.user-infos');
            var panelsButton = $('.dropdown-user');
            panels.hide();

            //Click dropdown
            panelsButton.click(function () {
                //get data-for attribute
                var dataFor = $(this).attr('data-for');
                var idFor = $(dataFor);

                //current button
                var currentButton = $(this);
                idFor.slideToggle(400, function () {
                    //Completed slidetoggle
                    if (idFor.is(':visible')) {
                        currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
                    }
                    else {
                        currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
                    }
                })
            });


            $('[data-toggle="tooltip"]').tooltip();

            $('button').click(function (e) {
                e.preventDefault();
                alert("This is a demo.\n :-)");
            });
        });
    </script>

    <script type="text/javascript"
            src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/holder/holder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/user_account.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/country-region-list/jquery.crs.min.js') }}"></script>

@stop
