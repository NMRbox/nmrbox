@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Add New Page
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" />
    <link href="{{ asset('assets/vendors/select2/select2.min.css') }}" type="text/css" />
    <link href="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/iCheck/skins/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom_css/blog.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/nmr.css') }}" rel="stylesheet" type="text/css" />

@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <!--section starts-->
    <h1>Add new page</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Home
            </a>
        </li>
        <li>
            <a href="#"> Page</a>
        </li>
        <li class="active"> Add new page</li>
    </ol>
</section>
<!--section ends-->
<section class="content paddingleft_right15">
    <!--main content-->
    <div class="row">
        <div class="the-box no-border">
            {!! Form::open(array('url' => URL::to('admin/pages/create'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('title', 'Title', array('class' => 'h3')) !!}
                            {!! Form::text('title', null, array('class' => 'form-control input-lg', 'required' => 'required', 'placeholder'=>'Page title here...'))!!}
                            <p></p>
                            {!! Form::label('slug', 'URL', array('class' => 'h3')) !!}
                            {!! Form::text('slug', null, array('class' => 'form-control input-lg', 'required' => 'false', 'placeholder'=>'Desired URL'))!!}
                            <p>We'll try to make a web-safe version of the URL you ask for here. If that url is taken, you may see your url with a number at the end.</p>
                            {!! Form::label('subheader', 'Subheader', array('class' => 'h3')) !!}
                            {!! Form::text('subheader', null, array('class' => 'form-control input-lg', 'placeholder'=>'Page title here...'))!!}
                            <p></p>
                        </div>
                        {!! Form::label('content', 'Content', array('class' => 'h3')) !!}
                        <div class='box-body pad'>
                            {!! Form::textarea('content', null, array('class' => 'textarea form-control', 'rows'=>'5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"')) !!}
                        </div>
                    </div>
                 </div>
                <div class="row">
                    <div class="col-sm-12 crud-options-box">
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-success">Publish</button>
                            <a href="{!! URL::to('admin/pages') !!}" class="btn btn-lg btn-danger">Discard</a>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!--main content ends-->
</section>
@stop

{{-- page level scripts --}}
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
                        <table class="table" id="table table-bordered">
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

    <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('assets/vendors/select2/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/iCheck/icheck.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom_js/add_newpage.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom_js/summernote_ext.js') }}" type="text/javascript" ></script>
@stop