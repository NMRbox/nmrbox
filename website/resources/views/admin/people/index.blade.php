@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
People Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
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
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <i class="fa fa-fw fa-list"></i>
                        People List
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/people/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add Person</a>
                        <a href="javascript:" id="btn_select_all" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-check"></span> Select All</a>
                        <a href="javascript:" id="btn_deselect_all" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-refresh"></span> Deselect</a>
                        <a href="javascript:" id="btn_send_email" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-envelope"></span> Send Email</a>
                        <a href="#" data-toggle="modal" data-target="#email_modal" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-envelope"></span> Send Group Email</a>
                        {{--<a href="#" data-toggle="modal" data-target="#user_details_modal" data-id="{!! $person->id !!}" id="show_user"><i class="fa fa-fw fa-info text-warning" title="View details"></i></a>--}}
                        <input type="hidden" name="_token" id="user_csrf_token" value="{!! csrf_token() !!}" />
                    </div>
                </div>
                <div class="row">
                    <div class="alert alert-success hidden" id="success-alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success! </strong>
                            <span id="success_msg"></span>
                    </div>
                    
                    <div class="alert alert-danger hidden" id="error-alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
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
                                <th>Institution</th>
                                <th class="col-md-1">Principal<br>Instructor</th>
                                <th>Department</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Zip</th>
                                <th>NMRbox Account #</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="no-search hidden"></th>
                                <th class="col-md-1">First Name</th>
                                <th class="col-md-1">Last Name</th>
                                <th class="col-md-1">Email</th>
                                <th class="col-md-1">Institution</th>
                                <th class="col-md-1">PI</th>
                                <th class="col-md-1">Department</th>
                                <th class="col-md-1">Category</th>
                                <th class="col-md-1">Address</th>
                                <th class="col-md-1">City</th>
                                <th class="col-md-1">State</th>
                                <th class="col-md-1">Zip</th>
                                <th class="col-md-1 no-search"></th>
                            </tr>

                        </tfoot>
                        <tbody>
                        @if(!empty($all_people))
                            @foreach ($all_people as $person)
                                <tr id="{!! $person->id !!}">
                                    <td class="hidden">{!! $person->id !!}</td>
                                    <td class="col-md-1">{!! $person->first_name !!}</td>
                                    <td class="col-md-1">{!! $person->last_name !!}</td>
                                    <td class="col-md-1">{!! $person->email !!}</td>
                                    <td class="col-md-1">{!! $person->institution()->get()->first()->name !!}</td>
                                    <td class="col-md-1">{!! $person->pi !!}</td>
                                    <td class="col-md-1">{!! $person->department !!}</td>
                                    <td class="col-md-1">{!! $person->category !!}</td>
                                    <td class="col-md-1">{!! $person->address1 !!}</td>
                                    <td class="col-md-1">{!! $person->city !!}</td>
                                    <td class="col-md-1">{!! $person->state_province !!}</td>
                                    <td class="col-md-1">{!! $person->zip_code !!}</td>
                                    <td class="col-md-1">
                                        <a href="{!! URL::to('admin/people/' . $person->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="Update person"></i></a>
                                        <a href="#" ><i class="fa fa-fw fa-times text-danger delete-person" data-url="{!! route("person.delete", array('person' => $person->id)) !!}" data-person_name="{!! $person->first_name . " " . $person->last_name !!}" title="Delete person"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#user_details_modal" data-id="{!! $person->id !!}" id="show_user"><i class="fa fa-fw fa-info text-warning" title="View details"></i></a>
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

    {{-- email modal --}}
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

    {{-- single user details modal --}}
    <div class="modal fade" id="email_modal" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
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



                        <form class="form-horizontal">
                            <fieldset>

                                <!-- Form Name -->
                                <legend>Email Customization</legend>

                                <!-- Text input-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="Subject">Subject</label>
                                    <div class="col-md-8">
                                        <input id="Subject" name="Subject" type="text" placeholder="Email Subject"
                                               class="form-control input-md" required="">

                                    </div>
                                </div>

                                <!-- Button Drop Down -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="email_template">Email Template</label>

                                    <div class="col-md-8">
                                        <select id="email_template" name="tmplt">
                                            <option value="">Select Template</option>
                                            <option value="1">Value1</option>
                                            <option value="2">Value2</option>
                                            <option value="3">Value3</option>
                                        </select>
                                    </div>
                                    {{--<div class="col-md-4">
                                        <div class="input-group">
                                            <input id="email_template" name="email_template" class="form-control"
                                                   placeholder="Email Template" type="text" required="">
                                            <div class="input-group-btn">
                                                --}}{{--<button type="button" class="btn btn-default dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    Select
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu pull-right" id="email_template">
                                                    <li><a href="#" value="1">Option one</a></li>
                                                    <li><a href="#" value="2">Option two</a></li>
                                                    <li><a href="#" value="3">Option three</a></li>
                                                </ul>--}}{{--

                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="message">Select email fields</label>
                                    <div class="col-md-8" id="template_area">
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="first_name">First Name</a>
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="last_name">Last Name</a>
                                        <a href="#" class="btn btn-xs btn-default" data-field-name="email">Email</a>
                                    </div>
                                </div>

                                <!-- Textarea -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="message">Message</label>
                                    <div class="col-md-8" id="template_area">
                                        <textarea class="form-control" id="message" name="message">Email Message</textarea>
                                    </div>
                                </div>

                                <!-- Button (Double) -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="send_email">Send Email</label>
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

    {{-- send mail --}}

    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom_js/people_index.js') }}" type="text/javascript"></script>
    <style type="text/css">
        table tr.selected td {
            background: #9FAFD1;
        }

        table tfoot input{
            width: 100%;
        }

        .table_fluid{
            overflow-x: scroll;

        }
    </style>
    <script>
        $(document).ready(function() {
            $("#success-alert").hide().removeClass('hidden');
            $("#error-alert").hide().removeClass('hidden');

            //$('#vm-table').DataTable();
            var selected = [];

            // Setup - add a text input to each footer cell
            $('#vm-table tfoot th').each( function (index) {
                if(!$(this).hasClass('no-search')) {
                    var title = $(this).text();
                    if (title.length > 0) {
                        $(this).html('<input type="text" size="10" placeholder=" ' + title + '" class="advanced-search" id="advanced_search_' + index + '" />');
                    }
                }
            } );

            // DataTable
            var table = $('#vm-table').DataTable( {
                "order": [[ 1, "asc" ]],
                "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        }
                    ]
            });
            var all_rows = table.rows().data();
            //console.log(table.rows().data());

            /* Advance search option based on particular db fields*/
            $('input.advanced-search').on('keyup change', function(){
                var col_index = $(this).attr('id').substr('advanced_search_'.length);
                table.column(col_index).search($(this).val()).draw();
            });

            /* Selecting/Deselecting particular single rows */
            $('#vm-table tbody').on('click', 'tr', function() {
                var id = this.id;
                var index = $.inArray(id, selected);
                if(index === -1) {
                    selected.push(id);
                } else {
                    selected.splice(index, 1);
                }

                $(this).toggleClass('selected');
            });

            /* Select all the refined field*/
            $('a#btn_select_all').on('click', function(e) {
                e.preventDefault();
                selected = [];
                $(all_rows).each(function(key, row) {
                    selected.push(row[0]);
                });
                $('#vm-table tbody tr').addClass('selected');
            });

            /* Deselect all the refined field*/
            $('a#btn_deselect_all').on('click', function(e) {
                e.preventDefault();
                selected = [];
                $('#vm-table tbody tr').removeClass('selected');
            });

            /* populating Email template */
            $(document).on("change", '#email_template', function(e) {
                e.preventDefault();
                var template_id = $(this).val();
                console.log(template_id);

                $.ajax({
                    type: "POST",
                    url: 'people/email_template',
                    data: 'id=' + template_id + '&_token=' + $('input#user_csrf_token').val(),
                    success: function(data) {
                        $('textarea#message').val(data.message);

                        /*
                        var $el = $("#name");
                        $el.empty(); // remove old options
                        $el.append($("<option></option>")
                                .attr("value", '').text('Please Select'));
                        $.each(json, function(value, key) {
                            $el.append($("<option></option>")
                                    .attr("value", value).text(key));
                        });
                        */
                    }
                });

            });

            /* Email all the selected person*/
            $('a#btn_send_email').on('click', function(e) {
                e.preventDefault();
                if(selected.length > 0) {
                    $.ajax({
                        type: "POST",
                        url: 'people/send_email',
                        data: 'ids=' + JSON.stringify(selected) +'&selected=' + selected.toString() + '&_token=' + $('input#user_csrf_token').val(),
                        success: function (data) {
                            $('#success_msg').html(data.message);
                            show_alert('success');
                        },
                        error: function (data) {
                            $('#error_msg').html('Something went wrong. Please try again.');
                            show_alert('error');
                        }
                    })
                }
            });

        });

        function show_alert(alert_type) {

                $("#"+alert_type+"-alert").alert();
                $("#"+alert_type+"-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $("#"+alert_type+"-alert").slideUp(500);
                });
        }
        
        /* signle row view */
        $(document).on("click", "#show_user", function () {
            var id = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url: 'people/show',
                data: 'id=' + id +'&_token=' + $('input#user_csrf_token').val(),
                dataType: 'JSON',
                success: function(response) {
                    console.log(response);
                    $("#modal-header-title").text( response.user['first_name'] + ' ' + response.user['last_name'] );
                    //Show content within modal body
                    $("#user_details_modal .modal-body").html(
                            'First Name:&nbsp;' + response.user['first_name'] + '<br>' +
                            'last Name:&nbsp;' + response.user['last_name'] + '<br>' +
                            'Email:&nbsp;' + response.user['email'] + '<br>'

                    )
                },
                error: function (data) {
                    $('#error_msg').html('Something went wrong. Please try again.');
                    show_alert('error');
                }
            })

        });
    </script>
@stop 
