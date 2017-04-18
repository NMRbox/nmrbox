@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Files List
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Files Index</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li> Files</li>
            <li>
                <a href="{{ route('admin/files') }}">Files Index</a>
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="col-lg-12">
                {{--<div class="btn-group" role="group" aria-label="...">--}}
                    {{--<a class="btn btn-default btn-sm" href="{{ route('adminFiles') }}" role="button">Show Active all_files</a>--}}
                    {{--<a class="btn btn-success btn-sm" href="{{ route('adminFiles') }}?withTrashed=true" role="button">Include Deleted all_files</a>--}}
                    {{--<a class="btn btn-danger btn-sm" href="{{ route('adminFiles') }}?onlyTrashed=true">Show Only Deleted all_files</a>--}}
                {{--</div>--}}
                <br />&nbsp;
                <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left">
                    </h3>
                    <div class="pull-right">
                        {{--<a href="{{ URL::to('admin/files/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>--}}

                        {{--<button type="button" class="btn btn-success add-file"><span class="glyphicon glyphicon-plus"></span> Add another file</button>--}}
                        <a href="{{ URL::to('admin/files/create') }}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Another Files</a>

                    </div>
                </div>
                <div class="panel-body">
                    <table class="table" id="table">
                        <thead>
                        <tr class="filters">
                            <th>Label</th>
                            <th>Type</th>
                            <th>Slug</th>
                            <th>Size</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($all_files as $file)
                            <tr>
                                <td><a href="{!! URL::to('admin/files/' . $file->slug ) !!}" target="_blank">{!! $file->label !!}</a></td>
                                <td>{!! $file->mime_type !!}</td>
                                <td>{!! $file->slug !!}</td>
                                <td>{!! round(($file->size/1024)/1024, 2) !!} MB</td>
                                <td>
                                    {{--<a href="{{ URL::to('admin/files/' . $file->slug . '/delete' ) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-fw fa-times text-danger" title="delete files"></i></a>--}}
                                    <a href="#">
                                        <a href="{{ URL::to('admin/files/' . $file->id . '/edit' ) }}"><i class="fa fa-fw fa-pencil text-warning" title="update blog"></i></a>
                                        <i class="fa fa-fw fa-times text-danger delete-item" data-url="{!! route("file.delete", array('file' => $file->id)) !!}" data-file_name="{!! $file->slug !!}"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No Files Yet!</td>
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

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom_js/files_index.js') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="files_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop