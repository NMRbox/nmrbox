@extends('layouts.default')

{{-- Page title --}}
@section('title')
Grid
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/panel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/features.css') }}">
    
@stop


{{-- Page content --}}
@section('content')
<div class="container">
        <div class="services">
            <h2>
                <label class="border-bottom">Grid System</label>
            </h2>
        </div>
        <!-- Bootstrap Grid Section Start -->
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="star-half" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Bootstrap grid Examples
                    </h3>
                </div>
                <div class="panel-body" id="slim1">
                    <div class="row">
                        <p>
                            we created some grid samples now you can examine in your browser. This first grid is using all 4 grid sizes combined in a single row. second grid indicates xs Grid,Third grid indicates sd Grid,fourth grid indicates md,fifth grid indicates lg.
                        </p>
                        <div class="panel-heading">
                            <p class="visible-lg">
                                lg indicates that the large grid displaying. The grid stacks horizontally &lt; 1200px.
                            </p>
                            <p class="visible-md">
                                md indicates that the medium grid displaying. The grid stacks horizontally &lt; 992px.
                            </p>
                            <p class="visible-sm">
                                sm indicates that the small grid displaying. The grid stacks horizontally &lt; 768px.
                            </p>
                            <p class="visible-xs">
                                xs indicates that the extra small grid displaying. This grid is always horizontal.
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-1 col-sm-3 col-xs-4 text-center bar-primary ">
                                <span class="visible-lg">.col-lg-4</span>
                                <span class="visible-md">.col-md-1</span>
                                <span class="visible-sm">.col-sm-3</span>
                                <span class="visible-xs">.col-xs-4</span>
                            </div>
                            <div class="col-lg-4 col-md-5 col-sm-3 col-xs-4 text-center bar-success ">
                                <span class="visible-lg">.col-lg-4</span>
                                <span class="visible-md">.col-md-5</span>
                                <span class="visible-sm">.col-sm-3</span>
                                <span class="visible-xs">.col-xs-4</span>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-4 text-center bar-danger">
                                <span class="visible-lg">.col-lg-4</span>
                                <span class="visible-md">.col-md-6</span>
                                <span class="visible-sm">.col-sm-6</span>
                                <span class="visible-xs">.col-xs-4</span>
                            </div>
                        </div>
                        <div class="row">
                            <h3>xs Grid</h3>
                            <div class="col-xs-5 bar-primary">
                                <span>.col-xs-5</span>
                            </div>
                            <div class="col-xs-4 bar-success">
                                <span>.col-xs-4</span>
                            </div>
                            <div class="col-xs-3 bar-danger">
                                <span>.col-xs-3</span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <h3>sm Grid</h3>
                            <div class="col-sm-2 bar-primary">
                                <span>.col-sm-2</span>
                            </div>
                            <div class="col-sm-4 bar-success">
                                <span>.col-sm-4</span>
                            </div>
                            <div class="col-sm-6 text-center bar-danger">
                                <span>.col-sm-6</span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <h3>md Grid</h3>
                            <div class="col-md-1 bar-primary">
                                <span>.col-md-1</span>
                            </div>
                            <div class="col-md-5 bar-success">
                                <span>.col-md-5</span>
                            </div>
                            <div class="col-md-6 bar-danger">
                                <span>.col-md-6</span>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <h3>lg Grid</h3>
                            <div class="col-lg-4 bar-primary">
                                <span>.col-lg-4</span>
                            </div>
                            <div class="col-lg-4 bar-success">
                                <span>.col-lg-4</span>
                            </div>
                            <div class="col-lg-4 bar-danger">
                                <span>.col-lg-4</span>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- //Bootstrap Grid Section End -->
    </div>
@stop
    
{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/frontend/grid.js') }}"></script>
@stop    