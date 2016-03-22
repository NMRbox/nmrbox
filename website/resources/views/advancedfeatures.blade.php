@extends('layouts.default')

{{-- Page title --}}
@section('title')
Advanced Features
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/panel.css') }}">
    <link href="{{ asset('assets/vendors/flippant/flippant.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/features.css') }}">
    
@stop


{{-- Page content --}}
@section('content')
<div class="container">
        <div class="services">
            <h2>
                <label class="border-bottom">Advanced Features</label>
            </h2>
        </div>
        <!-- Panels Section Start -->
        <!-- Row Section Start -->
        <div class="row">
            <h3 class="mrg_lft12">PANELS</h3>
            <!-- Primary header Section start -->
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Primary Header Panel</h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            Crema filter seasonal, robusta, mug decaffeinated extraction robusta single origin roast latte arabica. Organic, shop mocha, filter, flavour arabica affogato instant plunger pot cup robusta. Beans redeye wings robust extra seasonal beans froth americano latte.Medium mocha variety ristretto as doppio cappuccino bar extra siphon cappuccino. In, crema, est blue mountain et saucer beans cultivar. Affogato extra, americano at brewed whipped sweet aroma et sweet cappuccino.
                        </p>
                    </div>
                </div>
            </div>
            <!-- //Primary header Section End -->
            <!-- Success header Section Start -->
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">Success Header Panel</h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            Crema filter seasonal, robusta, mug decaffeinated extraction robusta single origin roast latte arabica. Organic, shop mocha, filter, flavour arabica affogato instant plunger pot cup robusta. Beans redeye wings robust extra seasonal beans froth americano latte.Medium mocha variety ristretto as doppio cappuccino bar extra siphon cappuccino. In, crema, est blue mountain et saucer beans cultivar. Affogato extra, americano at brewed whipped sweet aroma et sweet cappuccino.
                        </p>
                    </div>
                </div>
            </div>
            <!-- //Success header Section End -->
        </div>
        <!-- //Row Scetion End -->
        <!-- Row Section Start -->
        <div class="row">
            <!-- Danger header Section start -->
            <div class="col-sm-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4 class="panel-title">Danger Header Panel</h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            Crema filter seasonal, robusta, mug decaffeinated extraction robusta single origin roast latte arabica. Organic, shop mocha, filter, flavour arabica affogato instant plunger pot cup robusta. Beans redeye wings robust extra seasonal beans froth americano latte.Medium mocha variety ristretto as doppio cappuccino bar extra siphon cappuccino. In, crema, est blue mountain et saucer beans cultivar. Affogato extra, americano at brewed whipped sweet aroma et sweet cappuccino.
                        </p>
                    </div>
                </div>
            </div>
            <!-- //Danger header Section End -->
            <!-- Warning header Section start -->
            <div class="col-sm-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">Warning Header Panel</h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            Crema filter seasonal, robusta, mug decaffeinated extraction robusta single origin roast latte arabica. Organic, shop mocha, filter, flavour arabica affogato instant plunger pot cup robusta. Beans redeye wings robust extra seasonal beans froth americano latte.Medium mocha variety ristretto as doppio cappuccino bar extra siphon cappuccino. In, crema, est blue mountain et saucer beans cultivar. Affogato extra, americano at brewed whipped sweet aroma et sweet cappuccino.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- //Row Section Start -->
        <!-- Tool Tips Section Start -->
        <div class="row">
            <!-- Tool Tips Start -->
            <div class="col-md-6 tooltips">
                <h3>Tool Tips</h3>
                <p>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Tooltip on left">Tooltip on left</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Tooltip on top</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">Tooltip on bottom</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</button>
                </p>
            </div>
            <!-- Tool tips End -->
            <!-- Popover start -->
            <div class="col-md-6 pop">
                <h3>Popover</h3>
                <button type="button" class="btn btn-default " title="Popover title" data-container="body" data-toggle="popover" data-placement="left" data-content="Some content in Popover on left">Popover on left</button>
                <button type="button" class="btn btn-primary " title="Popover title" data-container="body" data-toggle="popover" data-placement="top" data-content="Some content in Popover on top">Popover on top</button>
                <button type="button" class="btn btn-success " title="Popover title" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Some content in Popover on bottom">Popover bottom</button>
                <button type="button" class="btn btn-warning " title="Popover title" data-container="body" data-toggle="popover" data-placement="right" data-content="Some content in Popover on right">Popover on right</button>
            </div>
            <!-- Popover End -->
        </div>
        <!-- //Tool tip Section End -->
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/frontend/advfeatures.js') }}"></script>
@stop
