@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
File Metadata Index
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
        <li> File Metadata</li>
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
                        Metadata List
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/file_metadata/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create new file metadata</a>
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
                                <th>Name</th>
                                {{--<th>Content body</th>--}}
                                <th>Action #</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($all_metadata))
                            @foreach ($all_metadata as $metadata)
                                <tr id="{!! $metadata->metadata !!}">
                                    <td class="hidden">{!! $metadata->metadata !!}</td>
                                    <td class="col-md-1">{!! $metadata->metadata !!}</td>
                                    {{--<td class="col-md-1">{!! $email_template->content !!}</td>--}}
                                    <td class="col-md-1">
                                        <a href="{!! URL::to('admin/file_metadata/' . $metadata->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="Update file metadata"></i></a>
                                        {{-- As template deletion has reference entry with email_person table,
                                             the delete link should not be available though it has conditional check and popup messages. --}}
                                        <a href="#" ><i class="fa fa-fw fa-times text-danger delete_file_metadata" data-url="{!! route("file_metadata.delete", array('file_metadata' => $metadata->id)) !!}" data-template_name="{!! $metadata->id !!}" title="Delete"></i></a>
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


    {{-- send mail --}}
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
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

            // deleting confirmation
            $('.delete_file_metadata').on("click", function(event) {
                event.preventDefault();
                var button = $(event.target);
                var template_name = button.attr("data-name");
                var url = button.attr("data-url");

                var m = $('#admin-modal');
                m.find('.modal-title').text('Delete Confirmation');
                m.find('.modal-body').html('Are you sure you want to delete this file metadata? <br><span  class="modal-highlight">' + name + '</span><span class="modal-highlight"></span>');

                var mbutton = m.find('.modal-action');
                mbutton.attr("onclick", "window.location.href='" + url + "'");
                mbutton.removeClass();
                mbutton.addClass("btn btn-danger");
                mbutton.text("Delete");
                m.modal();
            });

        });
    </script>

@stop 
