@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit FAQ
@parent
@stop


{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" />
    <style t type="text/css">
        .software-scroll{
            border: none;
            height: 500px;
            overflow-x: scroll;
        }

        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f5f5f5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background: #ccc;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
    </style>
@stop


{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit FAQ
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> FAQs</li>
        <li class="active"> Edit FAQ</li>
    </ol>
</section>

<!-- Main content -->

<!-- row-->
<section class="content ">
    <div class="row">
        <div class="the-box no-border">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Update FAQ</strong></div>
                <div class="panel-body">
                    {!! BootForm::open() !!}
                    <div class="col-sm-12 col-md-12 form-group">
                        {!! BootForm::text('question', "Question", $faq->question, array('placeholder' => 'Enter Question', 'class' => 'input-lg', 'required' => 'required'))!!}
                        {!! BootForm::textarea('answer', "Answer", $faq->answer, array('class' => 'input-lg textarea form-control', 'required' => 'required', 'rows' => '2', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"'))!!}
                    </div>
                    {{-- software / metadata section --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 text-left software-scroll">
                                <h4>Select Softwares: </h4><hr>
                                @foreach ($all_softwares as $software)
                                    {!! BootForm::hidden('software['.$software->id.']', "off", [ ]) !!}
                                    {!! BootForm::checkbox('software['.$software->id.']', $software->name, null, $software->present) !!}
                                @endforeach
                            </div>
                            <div class="col-md-6 software-scroll">
                                <h4>Select Search Keywords: </h4><hr>
                                @foreach ($all_search_keywords as $keyword)
                                    {!! BootForm::hidden('metadata['.$keyword->id.']', "off", [ ]) !!}
                                    {!! BootForm::checkbox('metadata['.$keyword->id.']', $keyword->metadata, null, $keyword->present) !!}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- FAQ section --}}

                    <div class="panel">
                        <div class="panle-header"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 software-scroll">
                            <h3>FAQ Feedback</h3>
                            <hr>
                            <table id="vm-table" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Person ID - Full Name</th>
                                    <th>Rating</th>
                                    <th>Comments</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($all_feedback))
                                    @foreach ($all_feedback as $feedback)
                                        <tr id="{!! $faq->id !!}">
                                            <td class="col-md-4">{!! $feedback['person_id'] . '    - ' . $feedback['person_name'] !!}</td>
                                            <td class="col-md-2">
                                            @if($feedback['upvote'])
                                                &nbsp;&nbsp;<i class="fa fa-thumbs-up"></i>
                                            @else
                                                &nbsp;&nbsp;<i class="fa fa-thumbs-down"></i>
                                            @endif
                                            </td>
                                            <td class="col-md-4">{!! $feedback['comment'] !!}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="3">
                                            No feedback received yet.
                                        </td></tr>
                                @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                    {{--<div class="form-group">
                        &nbsp;
                    </div>--}}
                    <div class="form-group col-md-12 panel">
                        <div class="panel-body">
                            {!! BootForm::checkbox('remove_feedback', 'Reset all the feedback', 'yes', false) !!}
                        </div>
                    </div>
                    {{--<div class="form-group">
                        &nbsp;
                    </div>--}}
                    <div class="form-group text-capitalize text-left col-md-12">
                        {!! BootForm::submit('Update', array('class' => 'btn btn-block btn-primary ', 'id' => 'update_file_edit')) !!}
                    </div>
                    {!! BootForm::close() !!}

                </div>
            </div>
        </div>
        {{-- test --}}
        <div class="container">

        </div> <!-- /container -->
        {{-- eof test --}}
    </div>
    <!--main content ends-->
</section>



@stop


{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    {{-- resource/file modal --}}
    <div class="modal fade" id="resource_modal" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id="modal-header-title">Select files to insert - </span>
                    </h4>

                </div>
                <div class="modal-body row">
                    <form action="insert_files" method="post" id="file_form">
                        <table class="table" id="table table-striped" style="width: 100%;">
                            <thead>
                            <tr class="filters">
                                <th>&nbsp;</th>
                                <th>Label</th>
                                <th>Slug/URL</th>
                                {{--<th>Slug/URL</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($all_files as $file)
                                <tr>
                                    <td class="col-md-1 text-center">
                                        <input type="checkbox" name="files" value="{!! URL::to('files/' . $file->slug) !!}" data-name="{!! $file->label !!}" class="modal_files form-group">&nbsp;&nbsp;

                                    </td>
                                    <td class="col-md-6">{!! $file->label !!}</td>
                                    <td class="col-md-5">{!! $file->slug !!}</td>
                                    {{--<td class="col-md-3">{!! $file->mime_type !!}</td>--}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Files Yet!</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td class="text-center" colspan="3">
                                    <button type="button" class="btn btn-primary btn-lg col-md-12" value="Insert" id="insert_files">Insert Files</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    {{-- WYSING Editor--}}
    <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('assets/js/custom_js/summernote_ext.js') }}" type="text/javascript" ></script>
@stop