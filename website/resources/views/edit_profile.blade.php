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

            <div class="row">


                <!-- left column -->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="text-center">
                        <img src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="avatar img-circle img-thumbnail" alt="avatar">
                        <h6>Upload a different photo...</h6>
                        <input type="file" class="text-center center-block well well-sm">
                    </div>
                </div>
                <!-- edit form column -->
                {!! BootForm::horizontal(array('model'=>$person, 'store'=>'person.store', 'update'=>'person.update')) !!}
                <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                    @include('notifications')
                    {{--<div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a>
                        <i class="fa fa-coffee"></i>
                        This is an <strong>.alert</strong>. Use this to show important messages to the user.
                    </div>--}}
                    <h3>Personal info</h3>


                    {!! BootForm::text('first_name', "First Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                    {!! BootForm::text('last_name', "Last Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                    {!! BootForm::email('email', "Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                    {!! BootForm::select('job_title', "Job Title",
                        $person_positions, null, array('maxlength'=> 32, 'required' => 'required')) !!}

                    {!! BootForm::text('institution', "Institution", null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                    {!! BootForm::select('institution_type', "Institution Type",
                        $person_institution_types, 0, array( 'maxlength'=> 256, 'required' => 'required')) !!}

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
                    {!! BootForm::submit('Save') !!}




                    {{--
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First name:</label>
                            <div class="col-lg-8">
                                <input class="form-control" value="Jane" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last name:</label>
                            <div class="col-lg-8">
                                <input class="form-control" value="Bishop" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-8">
                                <input class="form-control" value="janesemail@gmail.com" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Program Instructor:</label>
                            <div class="col-lg-8">
                                <input class="form-control" value="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Time Zone:</label>
                            <div class="col-lg-8">
                                <div class="ui-select">
                                    <select id="user_time_zone" class="form-control">
                                        <option value="Hawaii">(GMT-10:00) Hawaii</option>
                                        <option value="Alaska">(GMT-09:00) Alaska</option>
                                        <option value="Pacific Time (US & Canada)">(GMT-08:00) Pacific Time (US & Canada)</option>
                                        <option value="Arizona">(GMT-07:00) Arizona</option>
                                        <option value="Mountain Time (US & Canada)">(GMT-07:00) Mountain Time (US & Canada)</option>
                                        <option value="Central Time (US & Canada)" selected="selected">(GMT-06:00) Central Time (US & Canada)</option>
                                        <option value="Eastern Time (US & Canada)">(GMT-05:00) Eastern Time (US & Canada)</option>
                                        <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        --}}{{--<div class="form-group">
                            <label class="col-md-3 control-label">Username:</label>
                            <div class="col-md-8">
                                <input class="form-control" value="janeuser" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Password:</label>
                            <div class="col-md-8">
                                <input class="form-control" value="11111122333" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm password:</label>
                            <div class="col-md-8">
                                <input class="form-control" value="11111122333" type="password">
                            </div>
                        </div>--}}{{--
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-8">
                                <input class="btn btn-primary" value="Save Changes" type="button">
                                <span></span>
                                <input class="btn btn-default" value="Cancel" type="reset">
                            </div>
                        </div>
                    </form>--}}
                </div>
                {!! BootForm::close() !!}
                {{--
                <div class="position-left">
                    <!-- Notifications -->
                    @include('notifications')

                    --}}{{--<div>
                        <h3 class="text-primary">Personal Information</h3>
                    </div>--}}{{--
                    <form role="form" id="tryitForm" class="form-horizontal" enctype="multipart/form-data"
                          action="{{ route('my-account') }}" method="post">
                        --}}{{--{!!  Form::model($user, array('route' => 'my-account', $user->id))  !!}--}}{{--
                        --}}{{--<input type="hidden" name="_token" value="">--}}{{--
                        {!! Form::token() !!}
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Avatar:</label>
                            <div class="col-lg-6">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 100px; max-height: 75px;">
                                        @if($user->pic)
                                            <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" alt="img"/>
                                        @else
                                            <img src="http://placehold.it/100x75" alt="..."/>
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="pic" id="pic"/>
                                                            </span>
                                        <a href="#" class="btn btn-primary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cd-block">
                            <div class="cd-content">
                                <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                    <label class="col-lg-2 control-label">
                                        First Name:
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-fw fa-user-md text-primary"></i>
                                            </span>
                                            <input type="text" placeholder=" " name="first_name" id="first_name"
                                                   class="form-control"
                                                   value="{!! Input::old('first_name',$person->first_name) !!}"></div>
                                        <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                                    </div>

                                </div>

                                <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                    <label class="col-lg-2 control-label">
                                        Last Name:
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-fw fa-user-md text-primary"></i>
                                            </span>
                                            <input type="text" placeholder=" " name="last_name" id="last_name"
                                                   class="form-control"
                                                   value="{!! Input::old('last_name',$person->last_name) !!}"></div>
                                        <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                            <label class="col-lg-2 control-label">
                                Email:
                                <span class='require'>*</span>
                            </label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-fw fa-envelope text-primary"></i>
                                                                </span>
                                    <input type="text" placeholder=" " id="email" name="email" class="form-control"
                                           value="{!! Input::old('email',$user->email) !!}"></div>
                                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <h5 class="text-danger"><strong>If you don't want to change password, leave both fields
                                        empty</strong></h5>
                            </div>
                        </div>
                        <div class="cd-block">
                            <div class="cd-content">
                                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                    <label class="col-lg-2 control-label">
                                        Password:
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-fw fa-key text-primary"></i>
                                            </span>
                                            <input type="password" name="password" placeholder=" " id="pwd"
                                                   class="form-control"></div>
                                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cd-block">
                            <div class="cd-content">
                                <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                    <label class="col-lg-2 control-label">
                                        Confirm Password:
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-fw fa-key text-primary"></i>
                                            </span>
                                            <input type="password" name="password_confirm" placeholder=" " id="cpwd"
                                                   class="form-control"></div>
                                        <span class="help-block">{{ $errors->first('password_confirm', ':message') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cd-block">
                            <div class="cd-content">
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button class="btn btn-primary btn-lg" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>--}}{{--{!!  Form::close()  !!}--}}{{--
                </div>--}}

                {{--</div>--}}
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

@stop
