@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Software List
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Software Index</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li> Software</li>
            <li>
                <a href="{{ route('adminSoftware') }}">Software Index</a>
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="col-lg-12">
                {{--<div class="btn-group" role="group" aria-label="...">--}}
                    {{--<a class="btn btn-default btn-sm" href="{{ route('adminSoftware') }}" role="button">Show Active all_software</a>--}}
                    {{--<a class="btn btn-success btn-sm" href="{{ route('adminSoftware') }}?withTrashed=true" role="button">Include Deleted all_software</a>--}}
                    {{--<a class="btn btn-danger btn-sm" href="{{ route('adminSoftware') }}?onlyTrashed=true">Show Only Deleted all_software</a>--}}
                {{--</div>--}}
                <br />&nbsp;
                <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left">
                    </h3>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/software/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table" id="table">
                        <thead>
                        <tr class="filters">
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($all_software as $software)
                            <tr>
                                <td>{!! $software->name !!}</td>
                                <td>
                                    <a href="{{ URL::to('admin/software/' . $software->id . '/edit' ) }}"><i class="fa fa-fw fa-pencil text-warning" title="update software"></i></a>
                                    <a href="{{ URL::to('admin/software/' . $software->id . '/delete' ) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-fw fa-times text-danger" title="delete software"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>No Software Yet!</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="software_delete_confirm_title" aria-hidden="true">
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