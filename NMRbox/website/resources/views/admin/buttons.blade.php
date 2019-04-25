@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Buttons @parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/Hover/css/hover.css') }}" rel="stylesheet" media="all" type="text/css">
    <link href="{{ asset('assets/vendors/Buttons/css/buttons.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/custom_css/advbuttons.css') }}" rel="stylesheet" type="text/css">
    @stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <!--section starts-->
                    <h1>Buttons</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#">UI Features</a>
                        </li>
                        <li>
                            <a href="buttons">Buttons</a>
                        </li>
                    </ol>
                </section>
                <section class="content">
                    <!--main content-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-gear"></i>
                                        2D Transforms Flat Buttons
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div class="flatbuttons">
                                        <div class="text-left">
                                            Radiused Buttons
                                            <br />
                                            <ul>
                                                <li>
                                                    <a href="#" class="button button-rounded button-flat buzz">buzz</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-rounded button-flat-primary hang">hang</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-rounded button-flat-action sink">sink</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-rounded button-flat-highlight pop">pop</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-rounded button-flat-caution float">float</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-rounded button-flat-royal rotate">rotate</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="text-left">
                                            Rounded Buttons
                                            <br />
                                            <ul>
                                                <li>
                                                    <a href="#" class="button button-pill button-flat grow">grow button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-pill button-flat-primary shrink">shrink</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-pill button-flat-action pulse">pulse button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-pill button-flat-highlight pulse-grow">pulse-grow</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-pill button-flat-caution pulse-shrink">pulse-shrink</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-pill button-flat-royal push">push button</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="text-left">
                                            Rectangle Box
                                            <br />
                                            <ul>
                                                <li>
                                                    <a href="#" class="button button-flat wobble-skew">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-flat-primary wobble-bottom">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-flat-action wobble-to-top-right">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-flat-highlight wobble-to-top-right">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-flat-caution wobble-horizontal">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-flat-royal skew-backward">button</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="text-left">
                                            Cirlce Buttons
                                            <br />
                                            <ul>
                                                <li>
                                                    <a href="#" class="button button-circle button-flat wobble-top">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-circle button-flat-primary skew">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-circle button-flat-action skew-forward">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-circle button-flat-highlight pulse-grow">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-circle button-flat-caution grow">button</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="button button-circle button-flat-royal buzz-out">button</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-bell-o"></i>
                                        Shadow and Glow Transitions Buttons
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div class="flatbuttons_small">
                                        <ul>
                                            <li>
                                                <a href="#" class="button glow button-rounded button-flat glow">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button glow button-rounded button-flat-primary box-shadow-outset">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button glow button-rounded button-flat-action box-shadow-inset">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button glow button-rounded button-flat-highlight float-shadow">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button glow button-rounded button-flat-caution hover-shadow">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button glow button-rounded button-flat-royal shadow-radial">button</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-rocket"></i>
                                        Quick Shortcuts
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-6">
                                            <a href="#" class="btn btn-danger btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-list-alt"></span>
                                                <br/>
                                                Apps
                                            </a>
                                            <a href="#" class="btn btn-warning btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-bookmark"></span>
                                                <br/>
                                                Bookmarks
                                            </a>
                                            <a href="#" class="btn btn-primary btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-signal"></span>
                                                <br/>
                                                Reports
                                            </a>
                                            <a href="#" class="btn btn-primary btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-comment"></span>
                                                <br/>
                                                Comments
                                            </a>
                                        </div>
                                        <div class="col-xs-6 col-md-6">
                                            <a href="#" class="btn btn-success btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-user"></span>
                                                <br/>
                                                Users
                                            </a>
                                            <a href="#" class="btn btn-info btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-file"></span>
                                                <br/>
                                                Notes
                                            </a>
                                            <a href="#" class="btn btn-primary btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-picture"></span>
                                                <br/>
                                                Photos
                                            </a>
                                            <a href="#" class="btn btn-primary btn-sm btn-responsive" role="button">
                                                <span class="glyphicon glyphicon-tag"></span>
                                                <br/>
                                                Tags
                                            </a>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-success btn-lg btn-block" role="button">
                                        <span class="glyphicon glyphicon-globe"></span>
                                        Website
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-rocket"></i>
                                        3-D Buttons
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div class="flatbuttons">
                                        <ul>
                                            <li>
                                                <a href="#" class="button button-3d">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button button-3d-primary button-rounded">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button button-3d-action button-pill">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button button-3d-highlight button-circle">button</a>
                                            </li>
                                            <li>
                                                <a href="#" class="button button-3d-caution">
                                                    <i class="fa fa-camera"></i>
                                                    button
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="button button-3d-royal">button</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-bullhorn"></i>
                                        Group buttons
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="ui-group-buttons">
                                                <a href="#" class="btn btn-success" role="button">
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                </a>
                                                <div class="or"></div>
                                                <a href="#" class="btn btn-danger" role="button">
                                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                                </a>
                                            </div>
                                            <div class="ui-group-buttons">
                                                <a href="#" class="btn btn-success" role="button">
                                                    <span class="glyphicon glyphicon-floppy-disk"></span>
                                                </a>
                                                <div class="or"></div>
                                                <a href="#" class="btn btn-danger" role="button">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </div>
                                            <br />
                                            <br />
                                            <div class="ui-group-buttons">
                                                <a href="#" class="btn btn-success" role="button">
                                                    <span class="glyphicon glyphicon-ok"></span>
                                                    Sign Up
                                                </a>
                                                <div class="or"></div>
                                                <a href="#" class="btn btn-default" role="button">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                    Reset
                                                </a>
                                            </div>
                                            <br />
                                            <br />
                                            <div class="ui-group-buttons">
                                                <button type="button" class="btn btn-primary btn-lg">Large button</button>
                                                <div class="or or-lg"></div>
                                                <button type="button" class="btn btn-success btn-lg">Large button</button>
                                            </div>
                                            <br />
                                            <br />
                                            <div class="ui-group-buttons">
                                                <button type="button" class="btn btn-primary">Default</button>
                                                <div class="or"></div>
                                                <button type="button" class="button btn btn-success">Success</button>
                                            </div>
                                            <br />
                                            <br />
                                            <div class="ui-group-buttons">
                                                <button type="button" class="btn btn-primary btn-sm">Small button</button>
                                                <div class="or or-sm"></div>
                                                <button type="button" class="btn btn-success btn-sm">Small button</button>
                                            </div>
                                            <br />
                                            <br />
                                            <div class="ui-group-buttons">
                                                <button type="button" class="btn btn-primary btn-xs">Extra small button</button>
                                                <div class="or or-xs"></div>
                                                <button type="button" class="btn btn-success btn-xs">Extra small button</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-clock-o"></i>
                                        Buttons With Labels
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <h2>Cool Buttons With Labels</h2>
                                        <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                            <button type="button" class="btn btn-labeled btn-success">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </span>
                                                Success
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-warning">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-bookmark"></i>
                                                </span>
                                                Bookmark
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-default">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-chevron-left"></i>
                                                </span>
                                                Left
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-success">
                                                <span class="btn-label">
                                                    <i class="fa fa-fw fa-thumbs-o-up"></i>
                                                </span>
                                                Up
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-info">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-refresh"></i>
                                                </span>
                                                Refresh
                                            </button>
                                            <br />
                                            <a class="btn btn-success btn-labeled" role="button">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-info-sign"></i>
                                                </span>
                                                Info Web
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-xs-6 col-sm-6">
                                            <button type="button" class="btn btn-labeled btn-danger">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </span>
                                                Cancel
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-primary">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-camera"></i>
                                                </span>
                                                Camera
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-default">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-chevron-right"></i>
                                                </span>
                                                Right
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-danger">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-thumbs-down"></i>
                                                </span>
                                                Down
                                            </button>
                                            <br />
                                            <button type="button" class="btn btn-labeled btn-danger">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </span>
                                                Trash
                                            </button>
                                            <br />
                                            <a class="btn btn-success btn-labeled" role="button">
                                                <span class="btn-label">
                                                    <i class="glyphicon glyphicon-info-sign"></i>
                                                </span>
                                                Info Web
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--main content ends-->
                    </section>
                <!--section ends-->
                <!-- /.content --> @stop
{{-- page level scripts --}}
@section('footer_scripts')
        
        @stop