@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
VM Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>Virtual Machine Versions</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Virtual Machine Versions</li>
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
                        Virtual Machine Version List
                    </h4>
                    <div class="pull-right">
                    <a href="{{ URL::to('admin/vm/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                        <table id="vm-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>"Name"</th>
                                    <th>Major Version</th>
                                    <th>Minor Version</th>
                                    <th>Variant</th>
                                    <th>Software Packages</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($all_vms))
                                @foreach ($all_vms as $vm)
                                    <tr>
                                        <td>{!! $vm->name !!}</td>
                                        <td>{!! $vm->major !!}</td>
                                        <td>{!! $vm->minor !!}</td>
                                        <td>{!! $vm->variant !!}</td>
                                        <td>{!! $vm->softwareVersions()->count() !!}</td>
                                        <td></td>
                                        <td>
                                            <a href="{!! URL::to('admin/vm/' . $vm->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="update vm name"></i></a>


                                                <a href="#">
                                                    <i class="fa fa-fw fa-times text-danger delete-vm" data-url="{!! route("vm.delete", $vm->id) !!}" data-vmname="{!! $vm->name !!}" data-software-count="{!! $vm->softwareVersions()->count() !!}"></i>
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
    <script src="{{ asset('assets/js/custom_js/vm_index.js') }}" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            $('#vm-table').DataTable();
        });
    </script>
@stop
