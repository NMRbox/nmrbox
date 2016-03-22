@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Form Editors @parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" >
    @stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <!--section starts-->
                    <h1>Form Editors</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#">Forms</a>
                        </li>
                        <li>
                            <a href="form_editors">Form Editors</a>
                        </li>
                    </ol>
                </section>
                <!--section ends-->
                <section class="content">
                    <!--main content-->
                    <!-- /.box -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-file-text-o"></i>
                                        Bootstrap WYSIHTML5
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>

                                <div class="panel-body">
                                    <form>
                                        <textarea class="textarea edi-css" placeholder="Place some text here"></textarea>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-file-text-o"></i>
                                        Summernote Editor
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <form>
                                        <textarea class="summernote edi-css" placeholder="Place some text here"></textarea>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-file-text-o"></i>
                                        CKEditor
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="bootstrap-admin-panel-content">
                                    <textarea id="ckeditor_full"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-file-text-o"></i>
                                        Inline Editor
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="bootstrap-admin-panel-content">
                                    <div contenteditable="true" class="right-padding text-info">
                                        <p>
                                            Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies.
                                        </p>
                                        <p>
                                            Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac.
                                        </p>
                                        <p>
                                            Fusce vitae porttitor a, euismod convallis nisl, blandit risus tortor, pretium. Vehicula vitae, imperdiet vel, ornare enim vel sodales rutrum
                                        </p>
                                    </div>
                                    <div contenteditable="true" class="right-padding text-danger">
                                        <p>
                                            Pellentesque nunc. Donec suscipit erat. Pellentesque habitant morbi tristique ullamcorper.
                                        </p>
                                        <p>Mauris mattis feugiat lectus nec mauris. Nullam vitae ante.</p>

                                        <p>
                                            In hac habitasse platea dictumst. Praesent wisi accumsan sit amet nibh. Maecenas orci luctus a, lacinia quam sem, posuere commodo, odio condimentum tempor, pede semper risus. Suspendisse pede. In hac habitasse platea dictumst. Nam sed laoreet sit amet erat. Integer.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>
                <!-- /.content --> @stop
{{-- page level scripts --}}
@section('footer_scripts')
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ asset('assets/vendors/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/ckeditor/ckeditor.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/vendors/ckeditor/adapters/jquery.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/vendors/bootstrap-wysihtml5/wysihtml5.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/js/custom_js/form_editors.js') }}" type="text/javascript"></script>
        @stop