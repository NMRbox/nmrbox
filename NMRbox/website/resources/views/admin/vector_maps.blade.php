@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Vector Maps @parent

@stop
    <!-- page level css-->
    <link href="{{ asset('assets/vendors/vectormaps/jqvmap.css') }}" mediaff="screen" rel="stylesheet" type="text/css" />
    <!-- end of page level css-->

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <h1>Vector Maps</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>Maps</li>
                        <li>
                            <a href="vector_maps">Vector Maps</a>
                        </li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-tint"></i>
                                        World
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="vmapworld" style="width:100%; height:350px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-tint"></i>
                                        USA
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="vmapusa" style="width:100%; height:350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-tint"></i>
                                        Europe
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="vmapeurope" style="width:100%; height:350px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-tint"></i>
                                        Germany
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="vmapgermany" style="width:100%; height:350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-tint"></i>
                                        Russia
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="vmaprussia" style="width:100%; height:350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                   </section>
                <!--page wrapper--> @stop
{{-- page level scripts --}}
@section('footer_scripts')
        <script src="{{ asset('assets/vendors/vectormaps/jquery.vmap.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/vectormaps/jquery.vmap.world.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/vectormaps/jquery.vmap.usa.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/vectormaps/jquery.vmap.europe.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/vectormaps/jquery.vmap.germany.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/vectormaps/jquery.vmap.russia.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/vectormaps/data/jquery.vmap.sampledata.js') }}"></script>
        <script src="{{ asset('assets/js/custom_js/vector-maps.js') }}" type="text/javascript"></script>
        @stop