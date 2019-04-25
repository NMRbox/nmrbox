@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Keyword Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>Keyword</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Keyword</li>
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
                        Keyword List
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/keyword/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add Keyword</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <table id="keyword-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Keyword</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($all_keywords))
                            @foreach ($all_keywords as $keyword)
                                <tr>
                                    <td>{!! $keyword->label !!}</td>
                                    <td>
                                        <a href="{!! URL::to('admin/keyword/' . $keyword->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="update keyword"></i></a>


                                        <a href="#">
                                            <i class="fa fa-fw fa-times text-danger delete-keyword" data-url="{!! route("keyword.delete", array('keyword' => $keyword->id)) !!}" data-keyword_label="{!! $keyword->label !!}"></i>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <i class="fa fa-fw fa-list"></i>
                        Category List
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/categories/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add Category</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <table id="keyword-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Keywords</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($all_categories))
                            @foreach ($all_categories as $category)
                                <tr>
                                    <td>{!! $category->name !!}</td>
                                    <td>
                                        @foreach ($category->keywords()->get() as $keyword)
                                            {!! $keyword->label !!}<span class="table-comma">,</span>   {{-- trailing commas hidden in edit_software.css--}}
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{!! URL::to('admin/categories/' . $category->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="update keyword"></i></a>


                                        <a href="#">
                                            <i class="fa fa-fw fa-times text-danger delete-keyword" data-url="{!! route("category.delete", array('keyword' => $category->id)) !!}" data-keyword_label="{!! $category->name !!}"></i>
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
    <script src="{{ asset('assets/js/custom_js/keyword_index.js') }}" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            $('#keyword-table').DataTable();
        });
    </script>
@stop
