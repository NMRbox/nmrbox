@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
People Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <style type="text/css">
        table tr.selected td {
            background: #9FAFD1;
        }

        table thead tr th input {
            margin:0;
            padding:0;
            width: 150px;
        }

        body{
            width: 100%;
            position: relative;
            bottom: 0;
            overflow-x: scroll;
        }

        /* overflow scrollbar styling */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
        }
        .panel{
            border: 0px solid #eff0ef;
        }

        .fancy-checkbox-holder { display: block; }
        .fancy-checkbox-holder label { display: block; line-height: 1.2em; }
        .fancy-checkbox-holder label i.fa:before { content: "\f096";
            /* Unchecked */ }
        .fancy-checkbox-holder label.partial-checked i.fa:before { content: "\f147";
            /* Minus */ }
        .fancy-checkbox-holder label.checked i.fa:before { content: "\f046";
                                      /* Checked */ }

    </style>
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>People</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> People</li>
        <li class="active">Index</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <i class="fa fa-fw fa-list"></i>
                        People List
                    </h4>
                    <div class="pull-right">
                        <div>
                            <a href="{{ URL::to('admin/people/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add Person</a>
                            <a href="javascript:" id="btn_select_all" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-check"></span> Select All</a>
                            <a href="javascript:" id="btn_deselect_all" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-refresh"></span> Deselect</a>
                            <a href="#" data-toggle="modal" data-target="#email_modal" class="btn btn-sm btn-primary" id="email_utility"><span class="glyphicon glyphicon-envelope"></span> Send Email</a>
                            <a href="#" data-toggle="modal" data-target="#user_classification_modal" class="btn btn-sm btn-primary" id="user_classification"><span class="glyphicon glyphicon-user"></span> Assign Classification</a>
                            <a href="#" data-target="#adv_search_box" class="btn btn-sm btn-primary" id="adv_search_box_button"><span class="glyphicon glyphicon-search"></span> Search by ID</a>
                            <input type="hidden" name="_token" id="user_csrf_token" value="{!! csrf_token() !!}" />
                        </div>
                        <br>
                        <div id="adv_search_box" class="hidden text-right">
                            <form class="form-inline" method="post" action="">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" name="adv_search" placeholder="1, 2, 3, 4, 5" id="search_input">
                                </div>
                                <button class="btn btn-sm btn-primary" id="adv_search_button">Search</button>
                            </form>
                        </div>
                    </div>
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
                <br />
                <div class="panel-body table_fluid">
                    <table id="vm-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="hidden"></th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Account Name</th>
                                <th>Institution</th>
                                <th class="col-md-1">Principal<br>Investigator</th>
                                <th>Department</th>
                                <th>Category</th>
                                <th>Classifications</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Zip</th>
                                <th>NMRbox Account #</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th class="no-search ref_search hidden"></th>
                                <th class="col-md-1 ref_search">First Name</th>
                                <th class="col-md-1 ref_search">Last Name</th>
                                <th class="col-md-1 ref_search">Email</th>
                                <th class="col-md-1 ref_search">Account Name</th>
                                <th class="col-md-1 ref_search">Institution</th>
                                <th class="col-md-1 ref_search">PI</th>
                                <th class="col-md-1 ref_search">Department</th>
                                <th class="col-md-1 ref_search">Category</th>
                                <th class="col-md-1 ref_search">Classifications</th>
                                <th class="col-md-1 ref_search">Address</th>
                                <th class="col-md-1 ref_search">City</th>
                                <th class="col-md-1 ref_search">State</th>
                                <th class="col-md-1 ref_search">Zip</th>
                                <th class="col-md-1 no-search ref_search"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($all_people))
                            @foreach ($all_people as $person)
                                <tr id="{!! $person->id !!}">
                                    <td class="hidden">{!! $person->id !!}</td>
                                    <td class="col-md-1">{!! $person->first_name !!}</td>
                                    <td class="col-md-1">{!! $person->last_name !!}</td>
                                    <td class="col-md-1">{!! $person->email !!}</td>
                                    <td class="col-md-1">{!! $person->nmrbox_acct !!}</td>
                                    <td class="col-md-1">{!! $person->institution()->get()->first() !!}</td>
                                    <td class="col-md-1">{!! $person->pi !!}</td>
                                    <td class="col-md-1">{!! $person->department !!}</td>
                                    <td class="col-md-1">{!! $person->category !!}</td>
                                    <td class="col-md-1">
                                        @foreach($person->classification as $group)
                                            <div>{!! $group->name !!}</div>
                                        @endforeach
                                    </td>
                                    <td class="col-md-1">{!! $person->address1 !!}</td>
                                    <td class="col-md-1">{!! $person->city !!}</td>
                                    <td class="col-md-1">{!! $person->state_province !!}</td>
                                    <td class="col-md-1">{!! $person->zip_code !!}</td>
                                    <td class="col-md-1">
                                        <a href="{!! URL::to('admin/people/' . $person->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="Update person"></i></a>
                                        <a href="#" ><i class="fa fa-fw fa-times text-danger delete-person" data-url="{!! route("person.delete", array('person' => $person->id)) !!}" data-person_name="{!! $person->first_name . " " . $person->last_name !!}" title="Delete person"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>

@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    {{-- delete user modal --}}
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    {{-- Delete confirm modal --}}
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id="modal-header-title">Modify Group Email</span>
                    </h4>

                </div>
                <div class="modal-body">
                    Loading user data...
                </div>
            </div>
        </div>
    </div>

    {{-- Email modal --}}
    <div class="modal fade" id="email_modal" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Notifications -->
                        @include('notifications')


                        <form class="form-horizontal" id="email_template_form">
                            <fieldset>

                                {{-- Form Title --}}
                                <legend>Email Customization</legend>

                                {{-- user details --}}
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Total Recipient</label>
                                    <div class="col-md-8"  id="user_details">

                                    </div>
                                </div>

                                {{-- Email Template Drop Down --}}
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email_template">Recipient Address</label>
                                    <div class="col-md-8">
                                        <select id="email_template" name="recipient">
                                            <option value="email">Preferred Email</option>
                                            <option value="email_institution">Institutional Email</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Email Template Drop Down --}}
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email_template">Email Template</label>

                                    <div class="col-md-8">
                                        <select id="email_template" name="tmplt">
                                            <option value="0">Select Template</option>
                                            @foreach ($email_templates as $email_template)
                                                <option value="{!! $email_template->id !!}">{!! $email_template->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Email Subject --}}
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="subject">Subject</label>
                                    <div class="col-md-8">
                                        <input name="subject" type="text" placeholder="Email Subject" id="email_subject"
                                               class="form-control input-md" required="">
                                    </div>
                                </div>

                                {{-- Available database fields --}}
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="template_area">Select email fields</label>
                                    <div class="col-md-8" id="template_area">
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="first_name">First Name</a>
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="last_name">Last Name</a>
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="nmrbox_acct">NMRBox Account</a>
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="preferred_email">Preferred Email</a>
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="institutional_email">Institutional Email</a>
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="institution">Institution</a>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="message">Message</label>
                                    <div class="col-md-8" id="template_area">
                                        <textarea class="form-control" id="message" name="message" rows="20">Email Message</textarea>
                                    </div>
                                </div>
                                {{-- new template saving option--}}
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="save_template">Save as new template?</label>
                                    <div class="col-md-8" id="save_template_option">
                                        <input type="radio" name="save_template" value="yes"> Yes
                                        <input type="radio" name="save_template" value="no" checked="checked"> No
                                    </div>
                                </div>

                                {{-- Saving a new template with a name --}}
                                <div class="form-group" style="display: none;" id="template_name_box">
                                    <label class="col-md-4 control-label" for="email_template_name">Template Name</label>
                                    <div class="col-md-8">
                                        <input name="email_template_name" type="text" placeholder="Email Template Name"
                                               class="form-control input-md" required="">
                                    </div>
                                </div>

                                <!-- Button (Double) -->
                                <div class="form-group">
                                    <div class="col-md-4">&nbsp;</div>
                                    <div class="col-md-8">
                                        <button id="send_email" name="send_email" class="btn btn-success">Send Email
                                        </button>
                                        <button id="reset" name="reset" class="btn btn-inverse">Reset</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- eof single user modal --}}

    {{-- assign user classification modal --}}
    <div class="modal fade" id="user_classification_modal" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </h4>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Notifications -->
                        @include('notifications')

                        <form class="form-horizontal" id="assign_classification_form">
                            <fieldset>

                                {{-- Form Title --}}
                                <legend>Assign Classification</legend>

                                {{-- Email Subject --}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="subject">Available List</label>
                                    <div class="col-md-9 fancy-checkbox-holder">
                                        @foreach ($classifications as $classification)

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <label id="group_check_{{ strtolower(str_replace(' ', '_', $classification->name)) }}">
                                                        <input type="checkbox"  name="classifications[]" value="{!! $classification->name !!}" /> {!! $classification->name !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </label>
                                                    {{--<input type="checkbox" name="classifications[]" value="{!! $classification->name !!}" id="group_name" class="unchecked">&nbsp;{!! $classification->name !!}&nbsp;&nbsp;--}}
                                                </div>
                                                <div class="col-md-7">
                                                    {!! $classification->definition !!}
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- new template saving option--}}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="save_template">Assign new tag?</label>
                                    <div class="col-md-9" id="save_option">
                                        <input type="radio" name="save_classification" value="yes"> Yes
                                        <input type="radio" name="save_classification" value="no" checked="checked"> No
                                    </div>
                                </div>

                                {{-- Saving a new template with a name and definitation--}}
                                <div style="display: none;" id="name_box">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="classification_name">Name</label>
                                        <div class="col-md-8">
                                            <input name="classification_name" type="text" placeholder="Classification Title"
                                                   class="form-control input-md" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="classification_definition">Definition</label>
                                        <div class="col-md-8">
                                            <input name="classification_definition" type="text" placeholder="Classification Definition"
                                                   class="form-control input-md" required="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Button (Double) -->
                                <div class="form-group">
                                    <div class="col-md-4">&nbsp;</div>
                                    <div class="col-md-8">
                                        <button id="assign_classification" name="assign_classification" class="btn btn-success">Assign Classification Tags</button>
                                        <button id="reset" name="reset" class="btn btn-inverse">Reset</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- eof user assign classification modal --}}

    {{-- Add external scripts --}}
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/custom_js/people_index.js') }}"></script>
@stop
