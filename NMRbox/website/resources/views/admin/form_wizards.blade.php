@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Form Wizards
    @parent
@stop
{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/twitter-bootstrap-wizard/prettify.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/css/custom_css/form_wizard.css') }}" type="text/css" rel="stylesheet"/>
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Form Wizards</h1>
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
                <a href="form_wizards">Form Wizards</a>
            </li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <!--main-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-fw fa-arrows-alt"></i>
                            Basic Form wizard
                        </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <div class="row">
                            <section id="wizard">
                                <form id="commentForm" method="get" action="form_wizards" class="form-horizontal">
                                    <div id="rootwizard">
                                        <ul>
                                            <li>
                                                <a href="#tab1" data-toggle="tab">User Profile</a>
                                            </li>
                                            <li>
                                                <a href="#tab2" data-toggle="tab">Profile Details</a>
                                            </li>
                                            <li>
                                                <a href="#tab3" data-toggle="tab">Contact Details</a>
                                            </li>
                                        </ul>
                                        <hr>
                                        <div class="tab-content">
                                            <div class="tab-pane" id="tab1">

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">User Name</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" id="namefield" name="namefield"
                                                               placeholder="Enter your name"
                                                               class="form-control required"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Password</label>

                                                    <div class="col-sm-4">
                                                        <input type="password" id="passwordfield" name="passwordfield"
                                                               placeholder="Enter your password" class="form-control">
                                                    </div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Confirm Password</label>

                                                    <div class="col-sm-4">
                                                        <input type="password" placeholder="Confirm your Password "
                                                               class="form-control"></div>
                                                </div>

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Email</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" id="emailfield"
                                                               placeholder="Enter your email " name="emailfield"
                                                               class="form-control required email"></div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab2">
                                                <!-- Form Name -->

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">First Name</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" id="fnamefield" name="namefield"
                                                               placeholder="First Name" class="form-control required">
                                                    </div>
                                                    <label class="col-sm-2 control-label">Last Name</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" id="lnamefield" name="lnamefield"
                                                               placeholder="Last Name" class="form-control required">
                                                    </div>
                                                </div>
                                                <!-- select-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Gender</label>

                                                    <div class="col-sm-8">
                                                        <select class="form-control">
                                                            <option value="">select</option>
                                                            <option value="male">MALE</option>
                                                            <option value="female">FEMALE</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Line 1</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" id="linefield" name="linefield"
                                                               placeholder="Address Line 1"
                                                               class="form-control required"></div>
                                                </div>

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">City</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" id="cityfield" name="cityfield"
                                                               placeholder="City" class="form-control required"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">State</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" id="statefield" name="statefield"
                                                               placeholder="State" class="form-control required"></div>
                                                    <label class="col-sm-2 control-label">Postcode</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" id="postcodefield" name="postcodefield"
                                                               placeholder="Post Code" class="form-control required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab3">

                                                <!-- Form Name -->

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Home Number</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" id="phonefield" name="phonefield"
                                                               placeholder="Home Number" class="form-control"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Personal Number</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" id="phone1field" name="phone1field"
                                                               placeholder="Personal Number" class="form-control"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Aleternate Number</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Aleternate Number"
                                                               class="form-control"></div>
                                                </div>
                                            </div>
                                            <ul class="pager wizard">
                                                <li class="previous">
                                                    <a href="#">Previous</a>
                                                </li>
                                                <li class="next">
                                                    <a href="#">Next</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>

                            </section>
                        </div>

                        <!--main content end--> </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-fw fa-arrows-alt"></i>
                            Form wizard with First and Last buttons
                        </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <div class="row">
                            <div id="rootwizard1">
                                <ul>
                                    <li>
                                        <a href="#tab11" data-toggle="tab">User Profile</a>
                                    </li>
                                    <li>
                                        <a href="#tab22" data-toggle="tab">Profile Details</a>
                                    </li>
                                    <li>
                                        <a href="#tab33" data-toggle="tab">Contact Details</a>
                                    </li>
                                </ul>
                                <hr>
                                <div class="tab-content">
                                    <div class="tab-pane" id="tab11">

                                        <form class="form-horizontal" role="form">
                                            <fieldset>
                                                <!-- Form Name -->

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">User Name</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Enter your name"
                                                               class="form-control"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Password</label>

                                                    <div class="col-sm-4">
                                                        <input type="password" placeholder="Enter your password"
                                                               class="form-control"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Confirm Password</label>

                                                    <div class="col-sm-4">
                                                        <input type="password" placeholder="Confirm your Password "
                                                               class="form-control"></div>
                                                </div>

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Email</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Enter your email "
                                                               class="form-control"></div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab22">

                                        <form class="form-horizontal" role="form">
                                            <fieldset>
                                                <!-- Form Name -->

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">First Name</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" placeholder="First Name"
                                                               class="form-control"></div>
                                                    <label class="col-sm-2 control-label">Last Name</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" placeholder="Last Name" class="form-control">
                                                    </div>
                                                </div>
                                                <!-- select-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Gender</label>

                                                    <div class="col-sm-8">
                                                        <select class="form-control">
                                                            <option value="">select</option>
                                                            <option value="male">MALE</option>
                                                            <option value="female">FEMALE</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Line 1</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" placeholder="Address Line 1"
                                                               class="form-control"></div>
                                                </div>

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">City</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" placeholder="City" class="form-control">
                                                    </div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">State</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" placeholder="State" class="form-control">
                                                    </div>
                                                    <label class="col-sm-2 control-label">Postcode</label>

                                                    <div class="col-sm-3">
                                                        <input type="text" placeholder="Post Code" class="form-control">
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab33">

                                        <form class="form-horizontal" role="form">
                                            <fieldset>
                                                <!-- Form Name -->

                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Home Number</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Home Number"
                                                               class="form-control"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Personal Number</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Personal Number"
                                                               class="form-control"></div>
                                                </div>
                                                <!-- Text input-->
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Aleternate Number</label>

                                                    <div class="col-sm-4">
                                                        <input type="text" placeholder="Aleternate Number"
                                                               class="form-control"></div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div style="float:left">
                                        <input type='button' class='btn btn-info button-first btn-responsive'
                                               name='first' value='First'/>
                                        <input type='button' class='btn btn-info button-previous btn-responsive'
                                               name='previous' value='Previous'/>
                                    </div>
                                    <div style="float:right">
                                        <input type='button' class='btn btn-info button-next btn-responsive' name='next'
                                               value='Next'/>
                                        <input type='button' class='btn btn-info button-last btn-responsive' name='last'
                                               value='Last'/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--main content end--> </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content --> @stop
{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js') }}"></script>
    <script src="{{ asset('assets/vendors/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('assets/vendors/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom_js/form_wizards.js') }}"></script>
@stop