@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Add New Software
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" />
    <link href="{{ asset('assets/vendors/select2/select2.min.css') }}" type="text/css" />
    <link href="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/iCheck/skins/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom_css/blog.css') }}" rel="stylesheet" type="text/css" />

@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Add new software</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="#"> Software</a>
            </li>
            <li class="active"> Add new software</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                {!! BootForm::open() !!}
                <div class="row">
                    <div class="col-sm-8">
                        {!! BootForm::text('name', null, "", array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'Software Name', "onkeyup"=>"javascript:this.value=this.value.toUpperCase();"))!!}
                        {!! BootForm::select('public_release', "Display this package publicly on the website?", array("false"=>"No", "Yes"=>"true"), "false", array()) !!}
                        {!! BootForm::text('short_title', "Short Title", "", array('class' => 'input-lg', 'required' => 'false', 'placeholder'=>'Short title for software'))!!}
                        {!! BootForm::text('long_title', 'Long Title', "", array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'Long title for software'))!!}
                        {!! BootForm::text('synopsis', null, "", array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'Synopsis'))!!}
                        {!! BootForm::textarea('description', null, null, array('class' => 'textarea', 'rows'=>'5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"')) !!}
                        {!! BootForm::textarea('license_comment', null, null, array('class' => 'textarea', 'rows'=>'5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"')) !!}

                        {{-- Stuff that appears in a separate tab on edit --}}

                        {!! BootForm::select('devel_contacted', "Has the developer been contacted?",
                            array("false"=>"No", "true"=>"Yes"), null, array()) !!}

                        {!! BootForm::select('free_to_redistribute', "Is the software free to be redistributed?",
                            array('maybe'=>'Unknown', "false"=>"No", "true"=>"Yes"), null, array()) !!}

                        {!! BootForm::select('custom_license', "Has license been modified to allow for redistribution?",
                            array("null"=>"Not Needed", "false"=>"No", "true"=>"Yes"), null, array()) !!}

                        {!! BootForm::textarea('license_comment', "License Comment", null,
                            array('class' => 'textarea', 'rows'=>'5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"')) !!}

                        {!! BootForm::select('devel_include', "Does the developer intend to include the software in NMRbox?",
                        array('maybe'=>'Unknown', "false"=>"No", "true"=>"Yes"), null, array()) !!}

                        {!! BootForm::select('uchc_legal_approve', "Has UConn legal has signed off on the license?",
                            array("null"=>"Not Needed", "false"=>"No", "true"=>"Yes"), null, array()) !!}

                        {!! BootForm::select('devel_redistrib_doc', "Has developer given permission to redistribute documentation?",
                            array('maybe'=>'Unknown', "false"=>"No", "true"=>"Yes"), null, array()) !!}

                        {!! BootForm::select('devel_active', "Is the developer is still actively maintaining the software?",
                            array('maybe'=>'Unknown', "false"=>"Orphaned", "true"=>"Active"), null, array()) !!}

                        {!! BootForm::select('devel_status', "How does the Developer feel today? (I don't know what devel_status is supposed to represent since we already have devel_active in previous form)",
                            array('maybe'=>'Unknown', "false"=>"Bad", "true"=>"Good"), null, array()) !!}

                        {!! BootForm::submit('Save') !!}
                    </div>
                {!! BootForm::close() !!}
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
    <script src="{{ asset('assets/js/custom_js/add_newsoftware.js') }}" type="text/javascript"></script>
@stop