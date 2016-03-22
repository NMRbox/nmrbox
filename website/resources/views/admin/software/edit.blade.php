@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Edit Software
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" />
    <link href="{{ asset('assets/vendors/select2/select2.min.css') }}" type="text/css" />
    <link href="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/iCheck/skins/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom_css/blog.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom_css/edit_software.css') }}" rel="stylesheet" type="text/css" />

@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Editing </h1>
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
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li {{ (Request::is('admin/software/*/edit') ? 'class=active' : '') }}><a href="#software-tab" data-toggle="tab">Software</a></li>
                        <li {{ (Request::is('admin/software/*/edit/versions') ? 'class=active' : '') }}><a href="#versions-tab" data-toggle="tab">Versions</a></li>
                        <li {{ (Request::is('admin/software/*/edit/legal') ? 'class=active' : '') }}><a href="#legal-tab" data-toggle="tab">Legal</a></li>
                        <li {{ (Request::is('admin/software/*/edit/people') ? 'class=active' : '') }}><a href="#people-tab" data-toggle="tab">People</a></li>
                        <li {{ (Request::is('admin/software/*/edit/files') ? 'class=active' : '') }}><a href="#files-tab" data-toggle="tab">Files</a></li>
                        <li {{ (Request::is('admin/software/*/edit/images') ? 'class=active' : '') }}><a href="#images-tab" data-toggle="tab">Images</a></li>
                    </ul>
                    <div class="tab-content col-sm-8">
                        <div class="tab-pane fade {{ (Request::is('admin/software/*/edit') ? 'active in' : '') }}" id="software-tab">
                            @include('admin.software.partials.software_tab')
                        </div>
                        <div class="tab-pane fade {{ (Request::is('admin/software/*/edit/versions') ? 'active in' : '') }}" id="versions-tab">
                            @include('admin.software.partials.versions_tab')
                        </div>
                        <div class="tab-pane fade {{ (Request::is('admin/software/*/edit/legal') ? 'active in' : '') }}" id="legal-tab">
                            @include('admin.software.partials.legal_tab')
                        </div>
                        <div class="tab-pane fade {{ (Request::is('admin/software/*/edit/people') ? 'active in' : '') }}" id="people-tab">
                            @include('admin.software.partials.people_tab')
                        </div>
                        <div class="tab-pane fade {{ (Request::is('admin/software/*/edit/files') ? 'active in' : '') }} " id="files-tab">
                            @include('admin.software.partials.files_tab')
                        </div>
                        <div class="tab-pane fade {{ (Request::is('admin/software/*/edit/images') ? 'active in' : '') }}" id="images-tab">
                            @include('admin.software.partials.images_tab')
                        </div>
                    </div>

                </div>
            </div>
            <!--main content ends-->
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('assets/vendors/select2/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/iCheck/icheck.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom_js/edit_software_nav.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom_js/edit_software.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom_js/edit_software_people_tab.js') }}" type="text/javascript"></script>
@stop