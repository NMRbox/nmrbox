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
                        {{--<div class="form-group">--}}
                            {{--<label>Featured image</label>--}}
                            {{--<div class="fileupload fileupload-new" data-provides="fileupload">--}}
                                {{--<span class="btn btn-primary btn-file">--}}
                                    {{--<span class="fileupload-new">Select file</span>--}}
                                    {{--<span class="fileupload-exists">Change</span>--}}
                                     {{--{!! Form::file('image', null, array('class' => 'form-control')) !!}--}}
                                {{--</span>--}}
                                {{--<span class="fileupload-preview"></span>--}}
                                {{--<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
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
<script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript" ></script>
<script src="{{ asset('assets/vendors/select2/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/iCheck/icheck.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/custom_js/add_newpage.js') }}" type="text/javascript"></script>
@stop