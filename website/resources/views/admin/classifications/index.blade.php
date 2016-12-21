@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Classification Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>Classification</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Classification</li>
        <li class="active">Index</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-primary ">
                @if ($errors->has())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <i class="fa fa-fw fa-list"></i>
                        Classification List
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/classification/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create new classification</a>
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
                                <th>Definition</th>
                                <th>Web Role</th>
                                <th>No. of Users</th>
                                <th>Action #</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($classifications))
                            @foreach ($classifications as $classification)
                                <tr id="{!! $classification->name !!}">
                                    <td class="hidden">{!! $classification->name !!}</td>
                                    <td class="col-md-1">{!! $classification->name !!}</td>
                                    <td class="col-md-1">{!! $classification->definition !!}</td>
                                    <td class="col-md-1"><i class="fa fa-fw @if($classification->web_role){!! 'fa-check text-success' !!}@else{!! 'fa-ban text-danger' !!}@endif"></i></td>
                                    <td class="col-md-1">{!! $classification->person->count() !!}</td>
                                    <td class="col-md-1">
                                        <a href="{!! URL::to('admin/classification/' . $classification->name . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="Update classification details"></i></a>
                                        @if($classification->name !== 'admin' && $classification->name !== 'user' && $classification->name !== 'developer')
                                            <a href="#" ><i class="fa fa-fw fa-times text-danger delete_email_template" data-url="{!! route("classification.delete", array('classification' => $classification->name)) !!}" data-template_name="{!! $classification->name !!}" title="Delete"></i></a>
                                        @endif
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
            $('.delete_email_template').on("click", function(event) {
                event.preventDefault();
                var button = $(event.target);
                var template_name = button.attr("data-name");
                var url = button.attr("data-url");

                var m = $('#admin-modal');
                m.find('.modal-title').text('Delete Confirmation');
                m.find('.modal-body').html('Are you sure you want to delete this entry? <br><span  class="modal-highlight">' + name + '</span><span class="modal-highlight"></span>');

                var mbutton = m.find('.modal-action');
                mbutton.attr("onclick", "window.location.href='" + url + "'");
                mbutton.removeClass();
                mbutton.addClass("btn btn-danger");
                mbutton.text("Delete");
                m.modal();
            });
        });



    </script>
    <script type="application/javascript">
        jQuery.fn.extend({
            insertAtCaret: function(myValue){
                return this.each(function(i) {
                    if (document.selection) {
                        //For browsers like Internet Explorer
                        this.focus();
                        var sel = document.selection.createRange();
                        sel.text = myValue;
                        this.focus();
                    }
                    else if (this.selectionStart || this.selectionStart == '0') {
                        //For browsers like Firefox and Webkit based
                        var startPos = this.selectionStart;
                        var endPos = this.selectionEnd;
                        var scrollTop = this.scrollTop;
                        this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                        this.focus();
                        this.selectionStart = startPos + myValue.length;
                        this.selectionEnd = startPos + myValue.length;
                        this.scrollTop = scrollTop;
                    } else {
                        this.value += myValue;
                        this.focus();
                    }
                });
            }
        });

        $('#template_area a').click(function(){
            var val = $(this).attr('data-field-name');
            $('textarea').insertAtCaret( "%%" + val + "%%");
        })
    </script>

@stop 
