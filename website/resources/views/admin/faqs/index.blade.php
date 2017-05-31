@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
FAQ Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>FAQ</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> FAQs</li>
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
                        FAQ List
                    </h4>
                    <div class="pull-right">
                        <a href="{{ URL::to('admin/faq/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Create new FAQ</a>
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
                                <th>Question</th>
                                <th class="hidden">Answer</th>
                                <th>Softwares</th>
                                <th>Search Keywords</th>
                                <th>Feedback Count</th>
                                <th>Action #</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($all_faqs))
                            @foreach ($all_faqs as $faq)
                                <tr id="{!! $faq->id !!}">
                                    <td class="col-md-5">{!! $faq->question !!}</td>
                                    <td class="hidden">{!! $faq->answer !!}</td>
                                    <td class="col-md-2">
                                        @foreach($faq->softwares as $software)
                                            {!! $software->name !!} <br>
                                        @endforeach
                                    </td>
                                    <td class="col-md-2">
                                        @foreach($faq->search_keywords as $keyword)
                                            {!! $keyword->metadata !!} <br>
                                        @endforeach
                                    </td>
                                    <td class="col-md-2">
                                        {{--@foreach($faq->ratings as $key => $rating)--}}
                                            {!! $faq->ratings->count() !!} <br>
                                        {{--@endforeach--}}
                                    </td>
                                    <td class="col-md-1">
                                        <a href="{!! URL::to('admin/faq/' . $faq->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="Update FAQ"></i></a>
                                        {{-- As template deletion has reference entry with email_person table,
                                             the delete link should not be available though it has conditional check and popup messages. --}}
                                        <a href="#" ><i class="fa fa-fw fa-times text-danger delete_faq" data-url="{!! route("faq.delete", array('email' => $faq->id)) !!}" data-template_name="{!! $faq->id !!}" title="Delete"></i></a>
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
    <div class="modal fade" id="delete_faq" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id="modal-header-title">Modify FAQ</span>
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
    <script type="text/javascript" src="{{ asset('assets/js/custom_js/faq.js') }}"></script>
@stop 
