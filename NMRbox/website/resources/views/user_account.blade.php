@extends('layouts.default')

{{-- Page title --}}
@section('title')
User Account
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/iCheck/skins/minimal/blue.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/user_account.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datepicker/css/datepicker.css') }}">

@stop

{{-- Page content --}}
@section('content')
    <div class="container">

        <div class="row">
            <div class="welcome">
                <h3>My Account</h3>
            </div>

            <div class="row">
                <div class="col-md-12">
{{--
                    --}}{{-- test section --}}{{--
                    <div class="row">

                        <div class="col-md-6 box">
                            <div class="panel panel-primary text-left">
                                <div class="panel-heading">Personal Information</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-3" style="border: 1px solid blue;">
                                                @if($user->pic)
                                                    <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" alt="img" class="img-circle"/>
                                                @else
                                                    <img src="http://placehold.it/100x75" alt="..." class="img-circle" />
                                                @endif

                                            </div>
                                            <div class="col-md-3 text-right" style="border: 1px solid red;">
                                                <button class="btn btn-primary">Edit Profile</button>
                                            </div>

                                        </div>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-sm-2 text-right">First Name: </td>
                                                    <td class="col-md-4 text-left">{{ $person->first_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-2 text-right">Last Name: </td>
                                                    <td class="col-md-4 text-left">{{ $person->last_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-2 text-right">Email : </td>
                                                    <td class="col-md-4 text-left">{{ $person->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-2 text-right">Institution: </td>
                                                    <td class="col-md-4 text-left">{{ $person->institution_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-2 text-right">Principal Investigator: </td>
                                                    <td class="col-md-4 text-left">{{ $person->first_name }}</td>
                                                </tr>

                                                <tr>
                                                    <td class="col-md-2 text-right">Department: </td>
                                                    <td class="col-md-4 text-left">{{ $person->department }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-2 text-right">Category: </td>
                                                    <td class="col-md-4 text-left">{{ $person->category }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 box">
                            <div class="panel panel-primary text-left">
                                <div class="panel-heading">Bio-science Information</div>
                                <div class="panel-body">Bio Science software information goes here</div>
                            </div>

                        </div>
                    </div>--}}


                    <div class="position-left">
                        <!-- Notifications -->
                        @include('notifications')

                        {{--<div>
                            <h3 class="text-primary">Personal Information</h3>
                        </div>--}}
                        <form role="form" id="tryitForm" class="form-horizontal" enctype="multipart/form-data" action="{{ route('my-account') }}" method="post" >
                            {{--{!!  Form::model($user, array('route' => 'my-account', $user->id))  !!}--}}
                            {{--<input type="hidden" name="_token" value="">--}}
                            {!! Form::token() !!}
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Avatar:</label>
                                <div class="col-lg-6">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="max-width: 100px; max-height: 75px;">
                                            @if($user->pic)
                                                <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" alt="img"/>
                                            @else
                                                <img src="http://placehold.it/100x75" alt="..." />
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="pic" id="pic" />
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
                                                <input type="text" placeholder=" " name="first_name" id="first_name" class="form-control" value="{!! Input::old('first_name',$person->first_name) !!}"></div>
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
                                                <input type="text" placeholder=" " name="last_name" id="last_name" class="form-control" value="{!! Input::old('last_name',$person->last_name) !!}"></div>
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
                                        <input type="text" placeholder=" " id="email" name="email" class="form-control" value="{!! Input::old('email',$user->email) !!}"></div>
                                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-6">
                                    <h5 class="text-danger"><strong>If you don't want to change password, leave both fields empty</strong></h5>
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
                                                <input type="password" name="password" placeholder=" " id="pwd" class="form-control"></div>
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
                                                <input type="password" name="password_confirm" placeholder=" " id="cpwd" class="form-control"></div>
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
                        </form>{{--{!!  Form::close()  !!}--}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

<style type="text/css">
    .table {
        border-bottom:0px !important;
    }
    .table th, .table td {
        border: 1px !important;
    }
    .fixed-table-container {
        border:0px !important;
    }
</style>

<script type="text/javascript" src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/holder/holder.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/select2/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/frontend/user_account.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datepicker/js/bootstrap-datepicker.js') }}"></script>

@stop 
