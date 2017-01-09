@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Pages List
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Pages</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li>Page</li>
        <li class="active">Pages</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        {{--<div class="btn-group" role="group" aria-label="...">--}}
            {{--<a class="btn btn-default btn-sm" href="{{ route('pages') }}" role="button">Show Active Pages</a>--}}
            {{--<a class="btn btn-success btn-sm" href="{{ route('pages') }}?withTrashed=true" role="button">Include Deleted Pages</a>--}}
            {{--<a class="btn btn-danger btn-sm" href="{{ route('pages') }}?onlyTrashed=true">Show Only Deleted Pages</a>--}}
        {{--</div>--}}
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left"><i class="fa fa-fw fa-book"></i>
                    Page List
                </h4>
                <div class="pull-right">
                    <a href="{{ URL::to('admin/pages/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                </div>
            </div>
            <br />
            <div class="panel-body">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr class="filters">
                            <th>URL</th>
                            <th>@lang('blog/table.title')</th>
                            <th>Last Edited By</th>
                            <th>Last Updated</th>
                            <th>@lang('blog/table.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($pages))
                        @foreach ($pages as $page)
                            <tr>
                                <td> <a href="{{ URL::to('/' . $page->slug ) }}">/{{ $page->slug }}</a> </td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->author()->get()->first()->email }}</td>
                                <td>{{ $page->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ URL::to('admin/pages/' . $page->slug . '/edit' ) }}"><i class="fa fa-fw fa-pencil text-warning" title="update blog"></i></a>
                                    <a href="{{ route('confirm-delete/page', $page->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-fw fa-times text-danger" title="delete page"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
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

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="page_delete_confirm_title" aria-hidden="true">
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