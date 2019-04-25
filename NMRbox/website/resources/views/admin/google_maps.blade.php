@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Google Maps @parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/gmaps/examples.css') }}" rel="stylesheet" type="text/css" />
    <!-- end of page level css-->
@stop
{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <h1>Google Maps</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>Maps</li>
                        <li>
                            <a href="google_maps">Google Maps</a>
                        </li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Basic
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-top" class="gmap"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Terrain
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-terrain" class="gmap"></div>
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
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Satellite
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-satellite" class="gmap"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Markers
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-markers" class="gmap"></div>
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
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Styled Maps
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-styled" class="gmap"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Events
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-events" class="gmap"></div>
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
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Static Markers
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-fusion" class="gmap"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Basic charts strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-fw fa-map-marker"></i>
                                        Maps Types
                                    </h4>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up showhide clickable"></i>
                                        <i class="glyphicon glyphicon-remove removepanel"></i>
                                    </span>
                                </div>
                                <div class="panel-body" style="padding:10px !important;">
                                    <div id="gmap-types" class="gmap"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                    </section>
            @stop
{{-- page level scripts --}}
@section('footer_scripts')
        <script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript" ></script>
        <script src="{{ asset('assets/vendors/gmaps/gmaps.min.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/js/custom_js/custommaps.js') }}" type="text/javascript" ></script>
        <script>
    $(function() {
        CompMaps.init();
    });
    </script>
        @stop