<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | Admin Panel
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


    <meta name="csrf-token" content="{{ csrf_token() }}">



    <script src="{{ asset('assets/js/jquery-2.2.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <!-- global css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/custom_css/chandra.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom_css/metisMenu.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom_css/panel.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/edit_software.css') }}" rel="stylesheet" type="text/css" />
    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
            <!--end of page level css-->
</head>
<body class="skin-chandra">
<!-- header logo: style can be found in header-->
<header class="header">
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="{{ route('home')}}" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <img src="{{ asset('assets/images/logo2.png') }}" alt="logo"/>
        </a>

        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <i
                        class="fa fa-fw fa-hand-o-left"></i>
            </a>
        </div>

        <div class="navbar-right">
            <span style="color: white; font-weight: bold;">Welcome, {!! Session::get('person')->first_name !!} {!! Session::get('person')->last_name !!}</span>
            &nbsp; | &nbsp;
            <a href="{{ URL::to('my-account') }}" class="btn btn-outline-primaryy" style="color: white;">
                <i class="fa fa-fw fa-2x fa-cog"></i>
                <b>My Account</b>
            </a>
            &nbsp; | &nbsp;
            <a href="{{ URL::to('logout') }}" class="btn btn-outline-primaryy" style="color: white;">
                <i class="fa fa-fw fa-2x fa-sign-out"></i>
                <b>Sign out</b>
            </a>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar-->
        <section class="sidebar">
            <div id="menu" role="navigation">

                {{-- user bio --}}
                @include('admin.layouts._left_bio')
                <!-- / .navigation -->
            </div>
            <!-- menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <aside class="right-side right-padding">

        <!-- Notifications -->
        @include('notifications')

                <!-- Content -->
        @yield('content')
                <!-- /.content -->
    </aside>
    <!-- /.right-side -->
</div>
<!-- /.right-side -->
<!-- ./wrapper -->

<div class="modal" id="admin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary modal-action">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- global js -->

@if (Request::is('admin/draggable_portlets'))
    <script src="{{ asset('assets/js/custom_js/jquery.ui.min.js') }}" type="text/javascript"></script>
@endif

<script src="{{ asset('assets/js/custom_js/metisMenu.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/custom_js/app.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
</script>


<!-- begin page level js -->
@yield('footer_scripts')
        <!-- end page level js -->
</body>
</html>