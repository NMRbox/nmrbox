@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Toastr Notifications @parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/toastr/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom_css/toastr.css') }}" rel="stylesheet" type="text/css" />
    @stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <h1>Toastr Notifications</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#">UI features</a>
                        </li>
                        <li>
                            <a href="toastr_notifications">Toastr Notifications</a>
                        </li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-bell-o"></i>
                                        Toastr Notifications
                                    </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label" for="title">
                                                    <h3>Title</h3>
                                                </label>
                                                <input id="title" type="text" class="form-control" value="Toastr Notifications" placeholder="Enter a title ..."></div>
                                            <div class="form-group">
                                                <label class="control-label" for="message">Message</label>
                                                <textarea class="form-control" id="message" rows="3" placeholder="Enter a message ...">Gnome &amp; Growl type non-blocking notifications</textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox-list">
                                                    <label for="closeButton">
                                                        <div class="checker" id="uniform-closeButton">
                                                            <span class="checked">
                                                                <input id="closeButton" type="checkbox" value="checked" checked="" class="input-small"></span>
                                                        </div>
                                                        Close Button
                                                    </label>
                                                    <label for="addBehaviorOnToastClick">
                                                        <div class="checker" id="uniform-addBehaviorOnToastClick">
                                                            <span>
                                                                <input id="addBehaviorOnToastClick" type="checkbox" value="checked" class="input-small"></span>
                                                        </div>
                                                        Add behavior on toast click
                                                    </label>
                                                    <label for="debugInfo">
                                                        <div class="checker" id="uniform-debugInfo">
                                                            <span>
                                                                <input id="debugInfo" type="checkbox" value="checked" class="input-small"></span>
                                                        </div>
                                                        Debug
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" id="toastTypeGroup">
                                                <h3>Toast Type</h3>
                                                <div class="radio-list">
                                                    <label>
                                                        <div class="radio">
                                                            <span class="checked">
                                                                <input type="radio" name="toasts" value="success" checked=""></span>
                                                        </div>
                                                        Success
                                                    </label>
                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="toasts" value="info"></span>
                                                        </div>
                                                        Info
                                                    </label>
                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="toasts" value="warning"></span>
                                                        </div>
                                                        Warning
                                                    </label>
                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="toasts" value="error"></span>
                                                        </div>
                                                        Error
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group" id="positionGroup">
                                                <h3>Position</h3>
                                                <div class="radio-list">
                                                    <label>
                                                        <div class="radio">
                                                            <span class="checked">
                                                                <input type="radio" name="positions" value="toast-top-right" checked=""></span>
                                                        </div>
                                                        Top Right
                                                    </label>
                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="positions" value="toast-bottom-right"></span>
                                                        </div>
                                                        Bottom Right
                                                    </label>
                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="positions" value="toast-bottom-left"></span>
                                                        </div>
                                                        Bottom Left
                                                    </label>
                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="positions" value="toast-top-left"></span>
                                                        </div>
                                                        Top Left
                                                    </label>

                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="positions" value="toast-top-full-width"></span>
                                                        </div>
                                                        Top Full Width
                                                    </label>
                                                    <label>
                                                        <div class="radio">
                                                            <span>
                                                                <input type="radio" name="positions" value="toast-bottom-full-width"></span>
                                                        </div>
                                                        Bottom Full Width
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="control-label" for="showEasing">
                                                        <h3>Show Easing</h3>
                                                    </label>
                                                    <input id="showEasing" type="text" placeholder="swing, linear" class="form-control input-small" value="swing">
                                                    <label class="control-label" for="hideEasing">Hide Easing</label>
                                                    <input id="hideEasing" type="text" placeholder="swing, linear" class="form-control input-small" value="linear">
                                                    <label class="control-label" for="showMethod">Show Method</label>
                                                    <input id="showMethod" type="text" placeholder="show, fadeIn, slideDown" class="form-control input-small" value="fadeIn">
                                                    <label class="control-label" for="hideMethod">Hide Method</label>
                                                    <input id="hideMethod" type="text" placeholder="hide, fadeOut, slideUp" class="form-control input-small" value="fadeOut"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="control-label" for="showDuration">
                                                        <h3>Show Duration</h3>
                                                    </label>
                                                    <input id="showDuration" type="text" placeholder="ms" class="form-control input-small" value="1000">
                                                    <label class="control-label" for="hideDuration">Hide Duration</label>
                                                    <input id="hideDuration" type="text" placeholder="ms" class="form-control input-small" value="1000">
                                                    <label class="control-label" for="timeOut">Time out</label>
                                                    <input id="timeOut" type="text" placeholder="ms" class="form-control input-small" value="5000">
                                                    <label class="control-label" for="timeOut">Extended time out</label>
                                                    <input id="extendedTimeOut" type="text" placeholder="ms" class="form-control input-small" value="1000"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-responsive button-alignment btn-success" id="showtoast" style="margin-bottom:7px;">Show Toast</button>
                                            <button type="button" class="btn btn-responsive button-alignment btn-danger" id="cleartoasts" style="margin-bottom:7px;">Clear Toasts</button>
                                            <button type="button" class="btn btn-responsive button-alignment btn-danger" id="clearlasttoast" style="margin-bottom:7px;">Clear Last Toast</button>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row margin-top-10">
                                        <div class="col-md-12">
                                            <pre id="toastrOptions">Settings...</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   </section>
                <!-- /.content --> @stop
{{-- page level scripts --}}
@section('footer_scripts')
        <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}" type="text/javascript"></script>
         <script src="{{ asset('assets/js/custom_js/toastr.js') }}" type="text/javascript"></script>
        @stop