@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Add FAQ :: @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" />
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Add FAQ
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> People</li>
        <li class="active">
            Add a FAQ
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        <strong>Create A New FAQ</strong>
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::open() !!}
                        <div class="col-sm-12 col-md-12">
                            {!! BootForm::text('question', "Question", null, array('placeholder' => 'Enter Question', 'class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::textarea('answer', "Answer", null, array('class' => 'input-lg textarea form-control note-placeholder', 'required' => 'required', 'rows' => '5', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"'))!!}
                            {!! BootForm::text('slug', "Slug", null, array('placeholder' => 'Enter Slug', 'class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::submit('Save', array('class' => 'input-lg btn btn-block btn-primary ')) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
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

    {{-- external js files --}}
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    {{-- WYSING Editor--}}
    <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('assets/js/custom_js/summernote_ext.js') }}" type="text/javascript" ></script>

@stop
