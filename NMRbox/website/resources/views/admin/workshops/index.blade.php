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
    <h1>Workshops</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Workshops</li>
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
                        Workshops List
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/workshop/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create new workshop</a>
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
                                <th>Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Location</th>
                                {{--<th>Registered Users</th>--}}
                                <th>Action #</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($all_workshops as $workshop)
                                <tr id="{!! $workshop->name !!}">
                                    <td class="hidden">{!! $workshop->name !!}</td>
                                    <td class="col-md-1">{!! $workshop->name !!}</td>
                                    <td class="col-md-1">{!! $workshop->title !!}</td>
                                    <td class="col-md-1">{!! $workshop->start_date !!}</td>
                                    <td class="col-md-1">{!! $workshop->end_date !!}</td>
                                    <td class="col-md-1">{!! $workshop->location !!}</td>
                                    {{--<td class="col-md-1">{!! $workshop->classification->person !!}</td>--}}
                                    <td class="col-md-1">
                                        <a href="{!! URL::to('admin/workshop/' . $workshop->name . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="Update email template"></i></a>
                                        {{-- As template deletion has reference entry with email_person table,
                                             the delete link should not be available though it has conditional check and popup messages. --}}
                                        {{--<a href="#" ><i class="fa fa-fw fa-times text-danger delete_workshop" data-url="{!! route("workshop.delete", array('workshop' => $workshop->name)) !!}" data-template_name="{!! $workshop->title !!}" title="Delete"></i></a>--}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        No workshop entries available.
                                    </td>
                                </tr>
                            @endforelse
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
    <script type="text/javascript" src="{{ asset('assets/js/custom_js/workshops.js') }}"></script>

@stop 
