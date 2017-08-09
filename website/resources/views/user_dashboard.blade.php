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
                <br>
            </div>
            <div class="row">
                <div class="alert alert-success hidden" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! </strong>
                    <span id="success_msg"></span>
                </div>

                <div class="alert alert-danger hidden" id="error-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>
                    <span id="error_msg"></span>
                </div>
            </div>

            {{-- Accouncement --}}

            <div class="row">
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <p>Welcome to your NMRbox user dashboard!  This interface is under active development and additional tools / panels that provide user-specific information will be posted here.</p>
                </div>
            </div>

            @if(Session::has('user_is_admin') == true)
            <div class="row">
                <div class="alert alert-info">
                    <p>Access the administrative section using the button - <a href="{!! url("/admin") !!}" class="btn btn-md btn-warning"><i class="fa fa-cog fa-lg"> Admin Panel</i></a></p>
                </div>
            </div>
            @endif

            <div class="row">
                {{--<div class="col-md-12">--}}
                <div class="col-sm-12 col-md-6 toppad">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Profile - {!! $person->first_name."&nbsp;".$person->last_name !!}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class=" col-md-12 col-lg-12 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>Preferred Email:</td>
                                                <td><a href="mailto:{!! $person->email_institution !!}">{!! $person->email !!}</a></td>
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
                                                <td>Principal Investigator:</td>
                                                <td>{!! $person->pi !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{!! $person->address1.'&nbsp;<br>'.$person->city.'&nbsp;,'.$person->state_province.'&nbsp;'. $person->zip_code!!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    {{--<a href="#" class="btn btn-primary">My Sales Performance</a>
                                    <a href="#" class="btn btn-primary">Team Sales Performance</a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="text-right">
                                <a href="{{ URL::to('update_profile') }}" data-original-title="Edit user profile" data-toggle="tooltip" type="button"
                                   class="btn btn-sm btn-warning"><i class="fa fa-pencil fa-2x"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- bio-science box --}}
                <div class="col-sm-12 col-md-6 toppad">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">User Account</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class=" col-md-12 col-lg-12 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>User ID:</td>
                                                <td>{!! $person->nmrbox_acct !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Institutional Email: </td>
                                                <td><a href="mailto:{!! $person->email_institution !!}">{!! $person->email_institution !!}</a></td>
                                            </tr>
                                            <tr>
                                                <td>Password: </td>
                                                <td>
                                                    <input type="hidden" name="password" id="ldap_pass" class="password">
                                                    <span id="show_pass_box" style="display: none; cursor:pointer;">
                                                        <i data-target="ldap_pass" class="fa fa-eye fa-1x showHide"></i>
                                                    </span>
                                                    <span id="pass_asterisk">******</span>

                                                </td>
                                            </tr>
                                            <tr id="conf_pass_box" style="display: none;">
                                                <td>Confirm Password: </td>
                                                <td>
                                                    <input type="password" name="conf_password" id="conf_pass">
                                                    <span id="show_pass_box" style="cursor:pointer;">
                                                        <i data-target="conf_pass" class="fa fa-eye fa-1x showHide"></i>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Classification Group</td>
                                                <td>
                                                    @foreach($person->classification as $group)
                                                        <div>{!! $group->name !!}</div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>Active<br>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="text-right">
                                {{-- Password reset button --}}
                                <a href="#" role="button" rel="tooltip" data-original-title="Reset account password" data-toggle="modal" data-target="#pass_confirm_modal" class="btn btn-sm btn-warning" id="edit_ldap_pass"><i class="fa fa-key fa-2x"></i></a>
                                {{-- form saving button, toggle when password reset authentication pass --}}
                                <input type="hidden" name="change-password" value="Save" id="save_ldap_pass" class="btn btn-primary">
                                {{-- csrf token --}}
                                <input type="hidden" name="_token" id="user_csrf_token" value="{!! csrf_token() !!}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- workshops tiles --}}
            <div class="row">
                <div class="welcome text-left">
                    <h3 class="text-left">Upcoming workshops</h3>
                </div>
                <div class="row"><br></div>
                @forelse($workshops as $workshop)
                    {!! BootForm::open(array('url' => URL::to('register_person_workshop'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
                        {{--{!! Form::open() !!}--}}
                        <div class="col-md-4">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4>{!! $workshop->title !!}</h4>
                                </div>
                                <div class="panel-body">
                                    <p>
                                        @if(date('d', strtotime($workshop->start_date)) == date('d', strtotime($workshop->end_date)))
                                            {!! date('F d, Y', strtotime($workshop->start_date))  !!}
                                        @else
                                            {!! date('F d, Y - ', strtotime($workshop->start_date)) !!}
                                            {!! date('F d, Y', strtotime($workshop->end_date)) !!}
                                        @endif
                                        <br>
                                        {!! $workshop->location !!}<br>
                                        @if($workshop->url)
                                        <a href="{!! $workshop->url !!}" target="_blank">Program flyer</a>
                                        @endif
                                    </p>
                                    {{-- checking whether the user is already registered --}}
                                    <button
                                    @foreach($person->classification as $group)
                                        @if($group->name == $workshop->name)
                                             disabled
                                        @endif
                                    @endforeach
                                        name="register" class="btn btn-warning btn_register_workshop" data-workshop="{!! $workshop->name !!}" value="{!! $workshop->name !!}">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </div>
                    {!! BootForm::close() !!}
                @empty
                    <div class="panel col-md-12">
                        <div class="panel-body">
                            <div class="row">
                                <div class="alert alert-info">
                                    <p>Stay tuned for upcoming workshops update. You can explore <a href="workshops">workshop</a> page for completed workshops and available resources.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforelse
            </div>

            {{-- VM download tiles --}}
            <div class="row">
                <div class="welcome text-left">
                    <h3 class="text-left">Request Downloadable VM</h3>
                </div>
                <div class="row"><br>

                    {!! BootForm::open(array('url'=>route('download_vm'), 'class' => 'form ' )) !!}

                    <div class="form-group col-lg-4">
                        {!! BootForm::text('vm_username', "VM username", $person->nmrbox_acct , array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required', 'disabled'))!!}
                    </div>

                    <div class="form-group col-lg-4">
                        {!! BootForm::select('vm', "VM Versions",
                                [null=>'Please Select'] + [1=>'Version 1'] + [2=>'Version 2'] + [3=>'Version 3'], null, array('class' => 'form-control select_pi', 'maxlength'=> 32, 'required' => 'required')) !!}
                    </div>

                    <div class="form-group col-lg-4">
                        {!! BootForm::text('vm_password', "VM Password", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}
                    </div>

                    <div class="form-group col-lg-4">
                        {!! BootForm::submit('Request for Downloadable VM', array('class'=>'btn btn-primary btn-lg btn-block ')) !!}
                    </div>
                    {!! BootForm::close() !!}

                </div>
            </div>


            @stop

{{-- page level scripts --}}
@section('footer_scripts')
    {{-- email modal --}}
    <div class="modal fade" id="pass_confirm_modal" tabindex="-1" role="dialog" aria-labelledby="user_pass_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id="modal-header-title">Password Reset</span>
                    </h4>

                </div>
                <form id="pass_verify_form">
                    <div class="modal-body row">
                        <table class="table table-user-information col-md-12">
                            <tr>
                                <td>
                                    {{-- Password input box --}}
                                    <div class="form-group">
                                        <label for="ldap_pass"> Please enter your current password - </label>
                                        <div class="col-md-8">
                                            <input type="password" name="password" id="auth_pass" class="password">
                                            <span id="show_pass_box" style="cursor:pointer;">
                                                <i data-target="auth_pass" class="fa fa-eye fa-1x showHide"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- Button (Double) -->
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <button id="verify_pass" name="send_email" class="btn btn-success">Verify
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- All the page scripts --}}
    <script type="text/javascript" src="{{ asset('assets/js/custom_js/user_dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/holder/holder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/user_account.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datepicker/js/bootstrap-datepicker.js') }}"></script>

@stop 
