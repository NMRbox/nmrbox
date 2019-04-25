@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Image Magnifier @parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/magnifier/css/imgmagnify.css') }}" rel="stylesheet" type="text/css">
    @stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <h1>Image Magnifier</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>Gallery</li>
                        <li>Image Magnifier</li>
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary" style="padding-bottom:70px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-eye"></i>
                                        Image Magnifier
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" class="mag-style" src="{{ asset('assets/img/img_holder/small/small_1.jpg') }}" alt=""></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_5.jpg') }}" alt="" class="mag-style"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_4.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_6.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                    </div>
                                    <!--row-->
                                    <div class="row">
                                        <!--/span-->
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_3.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_2.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_1.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_5.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_4.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_6.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_3.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_2.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" class="mag-style" src="{{ asset('assets/img/img_holder/small/small_1.jpg') }}" alt=""></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_5.jpg') }}" alt="" class="mag-style"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_4.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="mag img-responsive">
                                                <br />
                                                <img data-toggle="magnify" src="{{ asset('assets/img/img_holder/small/small_6.jpg') }}" alt="" class="mag-style img-responsive"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--row-->
                    </section>
            @stop
{{-- page level scripts --}}
@section('footer_scripts')
        <script src="{{ asset('assets/vendors/magnifier/imgmagnify.js') }}" type="text/javascript" ></script>
        @stop