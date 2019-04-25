@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Lab Role Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>Lab Roles </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Lab Roles </li>
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
                        Lab Roles List
                    </h4>
                    <div class="pull-right">
                    <a href="{{ URL::to('admin/lab_roles/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create New Lab Role</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <table id="vm-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($lab_roles))
                            @foreach ($lab_roles as $lab_role)
                                <tr>
                                    <td>{!! $lab_role->name !!}</td>
                                    <td></td>
                                    <td>
                                        <a href="{!! URL::to('admin/lab_roles/' . $lab_role->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="update vm name"></i></a>
                                        <a href="#">
                                            <i class="fa fa-fw fa-times text-danger delete-lab_role" data-url="{!! route("lab_role.delete", $lab_role->id) !!}" data-name="{!! $lab_role->name !!}" !!}></i>
                                        </a>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom_js/lab_role_index.js') }}" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            $('#vm-table').DataTable();
        });
    </script>
@stop
