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
                <h3>My Account</h3>
            </div>

            <div class="row">
                {{--<div class="col-md-12">--}}


                <div class="col-sm-12 col-md-6 toppad">


                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Profile - {!! $person->first_name."&nbsp;".$person->last_name !!}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 col-lg-3 " align="center">
                                    @if($user->pic)
                                        <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" alt="img" class="img-circle"/>
                                    @else
                                        <img alt="User Pic" src="http://www.doppelme.com/DM1430605JCH/crop.gif" class="img-circle img-responsive">
                                    @endif
                                </div>

                                <div class=" col-md-9 col-lg-9 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>Email</td>
                                                <td><a href="mailto:info@support.com">{!! $person->email !!}</a></td>
                                            </tr>
                                            <tr>
                                                <td>Institution:</td>
                                                <td>{!! $person->institution()->get()->first()->name !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Department</td>
                                                <td>{!! $person->department !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Principle Instructor:</td>
                                                <td>{!! $person->pi !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{!! $person->address1.'&nbsp;<br>'.$person->city.'&nbsp;,'.$person->state_province.'&nbsp;'. $person->zip_code!!}</td>
                                            </tr>
                                            {{--<tr>
                                                <td>Phone Number</td>
                                                <td>123-4567-890(Landline)<br><br>555-4567-890(Mobile)
                                                </td>
                                            </tr>--}}

                                        </tbody>
                                    </table>

                                    {{--<a href="#" class="btn btn-primary">My Sales Performance</a>
                                    <a href="#" class="btn btn-primary">Team Sales Performance</a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                            <span class="pull-right">
                            <a href="{{ URL::to('update_profile') }}" data-original-title="Edit user profile" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            {{--<a data-original-title="Remove this user" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>--}}
                        </span>
                        </div>

                    </div>
                </div>

                {{-- bio-science box --}}
                <div class="col-sm-12 col-md-6 toppad">


                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Bio-science Account</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                {{--<div class="col-md-3 col-lg-3 " align="center">
                                    <div>Software listing</div>
                                </div>--}}

                                <div class=" col-md-12 col-lg-12 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                        <tr>
                                            <td>Bio Science ID:</td>
                                            <td>{!! $person->nmrbox_acct !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Email: </td>
                                            <td><a href="mailto:info@support.com">{!! $person->email !!}</a></td>
                                        </tr>
                                        <tr>
                                            <td>Password: </td>
                                            <td>Password123!</td>
                                        </tr>
                                        <tr>
                                            <td>Role</td>
                                            <td>General/Admin</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>Active/Inactive<br>&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                            <span class="pull-right">
                            {{--<a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>--}}
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row">

                {{-- bio-science box --}}
                <div class="col-sm-12 col-md-12 toppad">


                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Software Listings</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                {{--<div class="col-md-3 col-lg-3 " align="center">--}}
                                    {{--<div>Software listing</div>--}}
                                {{--</div>--}}

                                <div class=" col-md-12 col-lg-12 ">
                                    <table class="table table-user-information">
                                        <thead>
                                            <tr>
                                                <th>Software Name</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>ABCD</td>
                                                <td>Lorem ipsum dollor sit amet.</td>
                                                <td>
                                                    <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button"
                                                       class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a data-original-title="Remove this user" data-toggle="tooltip" type="button"
                                                       class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>MNOP</td>
                                                <td>Lorem ipsum dollor sit amet.</td>
                                                <td>
                                                    <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button"
                                                       class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a data-original-title="Remove this user" data-toggle="tooltip" type="button"
                                                       class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>XYZ</td>
                                                <td>Lorem ipsum dollor sit amet.</td>
                                                <td>
                                                    <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button"
                                                       class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a data-original-title="Remove this user" data-toggle="tooltip" type="button"
                                                       class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            &nbsp;<br>&nbsp;
                            {{--<a data-original-title="Broadcast Message" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                            <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button"
                               class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>--}}
                        </span>
                        </div>

                    </div>
                </div>


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
