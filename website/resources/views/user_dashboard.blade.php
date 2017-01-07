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
                    <p class="text-center">Welcome to your NMRbox user dashboard!  This interface is under active development and additional tools / panels that provide user-specific information will be posted here.</p>
                </div>
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
                                {{--<div class="col-md-3 col-lg-3 " align="center">
                                    <div>Software listing</div>
                                </div>--}}

                                <div class=" col-md-12 col-lg-12 ">
                                    <table class="table table-user-information">
                                        <tbody>
                                            <tr>
                                                <td>User ID:</td>
                                                <td>{!! $person->nmrbox_acct !!}</td>
                                            </tr>
                                            <tr>
                                                <td>Email: </td>
                                                <td><a href="mailto:info@support.com">{!! $person->email !!}</a></td>
                                            </tr>
                                            <tr>
                                                <td>Password: </td>
                                                <td>
                                                    <input type="hidden" name="password" id="ldap_pass" >
                                                    <span id="pass_asterisk">******</span>
                                                </td>
                                            </tr>
                                            <tr id="conf_pass_box" style="display: none;">
                                                <td>Confirm Password: </td>
                                                <td>
                                                    <input type="password" name="conf_password" id="conf_pass">
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
                                <a href="{{ URL::to('update_profile') }}" data-original-title="Reset account password" data-toggle="tooltip" type="button"
                                   class="btn btn-sm btn-warning" id="edit_ldap_pass"><i class="fa fa-key fa-2x"></i></a>

                                <input type="hidden" name="change-password" value="Save" id="save_ldap_pass" class="btn btn-primary">
                                {{-- csrf token --}}
                                <input type="hidden" name="_token" id="user_csrf_token" value="{!! csrf_token() !!}" />
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{--<div class="row">
                --}}{{-- software listing box --}}{{--
                <div class="col-sm-12 col-md-12 toppad">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Software Listings</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
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

                        </div>

                    </div>
                </div>
            </div>--}}
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

    <script type="text/javascript">
        function show_alert(alert_type) {
            console.log(alert_type);
            $("#"+alert_type+"-alert").removeClass('hidden');
            $("#"+alert_type+"-alert").alert();
            $("#"+alert_type+"-alert").fadeTo(5000, 500).slideUp(500, function(){
                $("#"+alert_type+"-alert").slideUp(500);
            });
        }

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
            });

            /* Enabling the fields for entering password */
            $('#edit_ldap_pass').on('click', function (e) {
                e.preventDefault();

                $('input#ldap_pass').attr('type', 'password');
                $('#pass_asterisk').hide();
                $('#conf_pass_box').show();
                $('#edit_ldap_pass').hide();
                $('input#reset_ldap_pass').attr('type', 'reset');
                $('input#save_ldap_pass').attr('type', 'submit');
            });

            /* saving the data into LDAP */
            $("#save_ldap_pass").on("click", function (e) {
                e.preventDefault();
                var pass = $('#ldap_pass').val();
                var conf_pass = $('#conf_pass').val();

                if(pass != conf_pass){
                    $('#error_msg').html('Password and Confirm password did not match. Please try again.');
                    show_alert('error');
                } else {

                    $('#ldap_pass').after('<span id="ldap_pass_loading">Saving Password...</span>');

                    $('input#ldap_pass').attr('type', 'hidden');
                    $('input#save_ldap_pass').attr('type', 'hidden');


                    $.ajax({
                        type: "POST",
                        url: 'change-password',
                        data: 'pass=' + pass +'&_token=' + $('input#user_csrf_token').val(),
                        dataType: 'JSON',
                        success: function(data) {
                            $('#ldap_pass_loading').remove();
                            $('#pass_asterisk').show();
                            $('#conf_pass_box').hide();
                            $('#edit_ldap_pass').show();
                            if(data.type == 'success'){
                                $('#success_msg').html(data.message);
                                show_alert('success');
                            } else {
                                $('#error_msg').html(data.message);
                                $('#error_msg').html('Password '+ pass+ ' does not meet Active Directory Complexity Rules');
                                show_alert('error');
                            }
                        },
                        error: function (data) {
                            $('#ldap_pass_loading').remove();
                            $('#pass_asterisk').show();
                            $('#conf_pass_box').hide();
                            $('#edit_ldap_pass').show();
                            $('#error_msg').html(data.message);
                            $('#error_msg').html('Password '+ pass+ ' does not meet Active Directory Complexity Rules');
                            show_alert('error');
                        }
                    })
                }
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
