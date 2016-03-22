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

    <script src="{{ asset('assets/js/jquery-2.2.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <!-- global css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/custom_css/chandra.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom_css/metisMenu.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom_css/panel.css') }}" rel="stylesheet" type="text/css"/>
    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
            <!--end of page level css-->
</head>
<body class="skin-chandra">
<!-- header logo: style can be found in header-->
<header class="header">
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="{{ route('dashboard')}}" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <img src="{{ asset('assets/images/logo2.png') }}" alt="logo"/>
        </a>

        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <i
                        class="fa fa-fw fa-hand-o-left"></i>
            </a>
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav">

                {{-- User Account --}}
                @include('admin.layouts._user_menu')

            </ul>
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

                <ul class="navigation">
                    <li {{ (Request::is('admin') ? 'class="active"' : '') }}>
                        <a href="{{ route('dashboard') }}">
                            <i class="menu-icon fa fa-fw fa-home"></i>
                            <span class="mm-text ">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-dropdown  {!! ((Request::is('admin/pages') ||  Request::is('admin/pages/create')) || Request::is('admin/pages/*') ? 'active' : '') !!}">
                        <a href="#">
                            <i class="menu-icon fa fa-fw fa-newspaper-o"></i>
                            <span class="title">Pages</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {!! (Request::is('admin/page') ? 'class="active"' : '') !!}>
                                <a href="{{ URL::to('admin/pages') }}">
                                    <i class="fa fa-fw fa-th-list"></i>
                                    Page List
                                </a>
                            </li>
                            <li {!! (Request::is('admin/pages/create') ? 'class="active"' : '') !!}>
                                <a href="{{ URL::to('admin/pages/create') }}">
                                    <i class="fa fa-fw fa-pencil-square-o"></i>
                                    Add New Page
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/software') || Request::is('admin/software/create') || Request::is('admin/software/*') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon  fa fa-fw fa-laptop"></i>
                            <span>Software</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/software') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/software') }}">
                                    Software Index
                                </a>
                            </li>
                            <li {{ (Request::is('admin/software/create') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/software/create') }}">
                                    Add New Software
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/vm') || Request::is('admin/vm/create') || Request::is('admin/vm/*') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon  fa fa-fw fa-cubes"></i>
                            <span>VM Versions</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/vm') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/vm') }}">
                                    VM Index
                                </a>
                            </li>
                            <li {{ (Request::is('admin/vm/create') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/vm/create') }}">
                                    Add New VM
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon  fa fa-fw fa-user"></i>
                            <span>Users</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/users') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/users') }}">
                                    Users
                                </a>
                            </li>
                            <li {{ (Request::is('admin/users/create') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/users/create') }}">
                                    Add New User
                                </a>
                            </li>
                            <li {{ ((Request::is('admin/users/*')) && !(Request::is('admin/users/create')) ? 'class=active' : '') }}>
                                <a href="{{ URL::route('users.show',Sentinel::getUser()->id) }}">
                                    User Profile
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/groups') || Request::is('admin/groups/create') || Request::is('admin/groups/*') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon  fa fa-fw fa-users"></i>
                            <span>Groups</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/groups') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/groups') }}">
                                    <i class="fa fa-fw fa-users"></i>
                                    Groups
                                </a>
                            </li>
                            <li {{ (Request::is('admin/groups/create') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/groups/create') }}">
                                    <i class="fa fa-fw fa-user"></i>
                                    Add New Group
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/people') || Request::is('admin/people/create') || Request::is('admin/people/*') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon  fa fa-fw fa-smile-o"></i>
                            <span>People</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/people') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/people') }}">
                                    <i class="fa fa-fw fa-users"></i>
                                    People Index
                                </a>
                            </li>
                            <li {{ (Request::is('admin/people/create') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/people/create') }}">
                                    <i class="fa fa-fw fa-user"></i>
                                    Add New Person
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/lab_roles') || Request::is('admin/lab_roles/create') || Request::is('admin/lab_roles/*') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon  fa fa-fw fa-user"></i>
                            <span>Lab Roles</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/lab_roles') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/lab_roles') }}">
                                    <i class="fa fa-fw fa-users"></i>
                                    Lab Role Index
                                </a>
                            </li>
                            <li {{ (Request::is('admin/lab_role/create') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/lab_roles/create') }}">
                                    <i class="fa fa-fw fa-user"></i>
                                    Add New Lab Role
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if(Sentinel::inRole('dillon'))
                    <li class="menu-dropdown  {!! ((Request::is('admin/blogcategory') || Request::is('admin/blogcategory/create') || Request::is('admin/blog') ||  Request::is('admin/blog/create')) || Request::is('admin/blog/*') || Request::is('admin/blogcategory/*') ? 'active' : '') !!}">
                        <a href="#">
                            <i class="menu-icon fa fa-fw fa-newspaper-o"></i>
                            <span class="title">Blog</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {!! (Request::is('admin/blogcategory') ? 'class="active"' : '') !!}>
                                <a href="{{ URL::to('admin/blogcategory') }}">
                                    <i class="fa fa-fw fa-list"></i>
                                    Blog Category List
                                </a>
                            </li>
                            <li {!! (Request::is('admin/blog') ? 'class="active"' : '') !!}>
                                <a href="{{ URL::to('admin/blog') }}">
                                    <i class="fa fa-fw fa-th-list"></i>
                                    Blog List
                                </a>
                            </li>
                            <li {!! (Request::is('admin/blog/create') ? 'class="active"' : '') !!}>
                                <a href="{{ URL::to('admin/blog/create') }}">
                                    <i class="fa fa-fw fa-pencil-square-o"></i>
                                    Add New Blog
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/charts') || Request::is('admin/flot_charts') || Request::is('admin/nvd3_charts') || Request::is('admin/chartjs_charts') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-bar-chart-o"></i>
                            <span>Charts</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/flot_charts') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/flot_charts') }}">
                                    <i class="fa fa-fw fa-area-chart"></i>
                                    Flot Charts
                                </a>
                            </li>
                            <li {{ (Request::is('admin/nvd3_charts') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/nvd3_charts') }}">
                                    <i class="fa fa-fw fa-line-chart"></i>
                                    NVD3 Charts
                                </a>
                            </li>
                            <li {{ (Request::is('admin/chartjs_charts') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/chartjs_charts') }}">
                                    <i class="menu-icon fa fa-bar-chart-o"></i>
                                    Chart js
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/form_elements') || Request::is('admin/form_editors') || Request::is('admin/form_validations') || Request::is('admin/form_layouts') || Request::is('admin/form_wizards') || Request::is('admin/x-editable') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-check-square"></i>
                            <span>Forms</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/form_elements') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/form_elements') }}">
                                    <i class="fa fa-fw fa-fire"></i>
                                    Form Elements
                                </a>
                            </li>
                            <li {{ (Request::is('admin/form_editors') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/form_editors') }}">
                                    <i class="fa fa-fw fa-file-text-o"></i>
                                    Form Editors
                                </a>
                            </li>
                            <li {{ (Request::is('admin/form_validations') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/form_validations') }}">
                                    <i class="fa fa-fw fa-warning"></i>
                                    Form Validations
                                </a>
                            </li>
                            <li {{ (Request::is('admin/form_layouts') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/form_layouts') }}">
                                    <i class="fa fa-fw fa-fire"></i>
                                    Form Layouts
                                </a>
                            </li>
                            <li {{ (Request::is('admin/form_wizards') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/form_wizards') }}">
                                    <i class="fa fa-fw fa-cog"></i>
                                    Form Wizards
                                </a>
                            </li>
                            <li {{ (Request::is('admin/x-editable') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/x-editable') }}">
                                    <i class="fa fa-fw fa-eyedropper"></i>
                                    X-editable
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-dropdown {{ (Request::is('admin/general_components') || Request::is('admin/pickers') || Request::is('admin/buttons') || Request::is('admin/panels') || Request::is('admin/tabs_accordions') || Request::is('admin/font_icons') || Request::is('admin/grid_layout') || Request::is('admin/tags_input') || Request::is('admin/nestable_list') || Request::is('admin/toastr_notifications') || Request::is('admin/session_timeout') || Request::is('admin/draggable_portlets') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-desktop"></i>
                                <span>
                                    UI Features
                                </span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/general_components') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/general_components') }}">
                                    <i class="fa fa-fw fa-plug"></i>
                                    General Components
                                </a>
                            </li>
                            <li {{ (Request::is('admin/pickers') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/pickers') }}">
                                    <i class="fa fa-fw fa-paint-brush"></i>
                                    Pickers
                                </a>
                            </li>
                            <li {{ (Request::is('admin/buttons') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/buttons') }}">
                                    <i class="fa fa-fw fa-delicious"></i>
                                    Buttons
                                </a>
                            </li>
                            <li {{ (Request::is('admin/panels') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/panels') }}">
                                    <i class="fa fa-fw fa-gift"></i>
                                    Panels
                                </a>
                            </li>
                            <li {{ (Request::is('admin/tabs_accordions') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/tabs_accordions') }}">
                                    <i class="fa fa-fw fa-copy"></i>
                                    Tabs &amp; Accordions
                                </a>
                            </li>
                            <li {{ (Request::is('admin/font_icons') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/font_icons') }}">
                                    <i class="fa fa-fw fa-font"></i>
                                    Font Icons
                                </a>
                            </li>
                            <li {{ (Request::is('admin/grid_layout') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/grid_layout') }}">
                                    <i class="fa fa-fw fa-columns"></i>
                                    Grid Layout
                                </a>
                            </li>
                            <li {{ (Request::is('admin/tags_input') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/tags_input') }}">
                                    <i class="fa fa-fw fa-tag"></i>
                                    Tags Input
                                </a>
                            </li>
                            <li {{ (Request::is('admin/nestable_list') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/nestable_list') }}">
                                    <i class="fa fa-fw fa-navicon"></i>
                                    Nestable List
                                </a>
                            </li>
                            <li {{ (Request::is('admin/toastr_notifications') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/toastr_notifications') }}">
                                    <i class="fa fa-fw fa-desktop"></i>
                                    Toastr Notifications
                                </a>
                            </li>
                            <li {{ (Request::is('admin/session_timeout') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/session_timeout') }}">
                                    <i class="fa fa-fw fa-rocket"></i>
                                    Session Timeout
                                </a>
                            </li>
                            <li {{ (Request::is('admin/draggable_portlets') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/draggable_portlets') }}">
                                    <i class="fa fa-fw fa-random"></i>
                                    Draggable Portlets
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/timeline') || Request::is('admin/transitions') || Request::is('admin/circle_sliders') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-briefcase"></i>
                                <span>
                                    UI Components
                                </span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">

                            <li {{ (Request::is('admin/timeline') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/timeline') }}">
                                    <i class="fa fa-fw fa-clock-o"></i>
                                    Timeline
                                </a>
                            </li>
                            <li {{ (Request::is('admin/transitions') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/transitions') }}">
                                    <i class="fa fa-fw fa-star-half-empty"></i>
                                    Transitions
                                </a>
                            </li>
                            <li {{ (Request::is('admin/circle_sliders') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/circle_sliders') }}">
                                    <i class="fa fa-fw fa-sun-o"></i>
                                    Circle Sliders
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/simple_tables') || Request::is('admin/datatables') || Request::is('admin/advanced_datatables') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-table"></i>
                            <span>DataTables</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/simple_tables') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/simple_tables') }}">
                                    <i class="fa fa-fw fa-tasks"></i>
                                    Simple tables
                                </a>
                            </li>
                            <li {{ (Request::is('admin/datatables') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/datatables') }}">
                                    <i class="fa fa-fw fa-database"></i>
                                    Data Tables
                                </a>
                            </li>
                            <li {{ (Request::is('admin/advanced_datatables') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/advanced_datatables') }}">
                                    <i class="fa fa-fw fa-table"></i>
                                    Advanced Tables
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li {{ (Request::is('admin/calendar') ? 'class=active' : '') }}>
                        <a href="{{ URL::to('admin/calendar') }}">
                            <i class=" menu-icon fa fa-fw fa-calendar"></i>
                            <span>Calendar</span>
                            <small class="badge">4</small>
                        </a>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/mail_box') || Request::is('admin/compose') || Request::is('admin/view_mail') ? 'active' : '') }}">
                        <a href="#">
                            <i class="fa fa-fw fa-envelope"></i>
                            <span>Email</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/mail_box') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/mail_box') }}">
                                    <i class="fa fa-inbox"></i>
                                    Mail box
                                </a>
                            </li>
                            <li {{ (Request::is('admin/compose') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/compose') }}">
                                    <i class="fa fa-pencil"></i>
                                    Compose Message
                                </a>
                            </li>
                            <li {{ (Request::is('admin/view_mail') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/view_mail') }}">
                                    <i class="fa fa-eye"></i>
                                    Single Mail
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li {{ (Request::is('admin/task') ? 'class=active' : '') }}>
                        <a href="{{ URL::to('admin/task') }}">
                            <i class="fa fa-fw fa-list-ul"></i>
                            <span>Tasks</span>
                            <small class="badge">10</small>
                        </a>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/gallery') || Request::is('admin/masonry_gallery') || Request::is('admin/multiplefile_upload') || Request::is('admin/image_magnifier') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-fw fa-photo"></i>
                            <span>Gallery</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/gallery') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/gallery') }}">
                                    <i class="fa fa-fw fa-file-image-o"></i>
                                    Gallery
                                </a>
                            </li>
                            <li {{ (Request::is('admin/masonry_gallery') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/masonry_gallery') }}">
                                    <i class="fa fa-fw fa-file-image-o"></i>
                                    Masonry Gallery
                                </a>
                            </li>
                            <li {{ (Request::is('admin/multiplefile_upload') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/multiplefile_upload') }}">
                                    <i class="fa fa-fw fa-cloud-upload"></i>
                                    Multiple File Upload
                                </a>
                            </li>
                            <li {{ (Request::is('admin/image_magnifier') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/image_magnifier') }}">
                                    <i class="fa fa-fw fa-search"></i>
                                    Image Magnifier
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/google_maps') || Request::is('admin/vector_maps')? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-map-marker"></i>
                            <span>Maps</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/google_maps') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/google_maps') }}">
                                    <i class="fa fa-fw fa-globe"></i>
                                    Google Maps
                                </a>
                            </li>
                            <li {{ (Request::is('admin/vector_maps') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/vector_maps') }}">
                                    <i class="fa fa-fw fa-map-marker"></i>
                                    Vector Maps
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown {{ (Request::is('admin/faq') || Request::is('admin/invoice') || Request::is('admin/blank') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-files-o"></i>
                            <span>Pages</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/faq') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/faq') }}">
                                    <i class="fa fa-fw fa-question"></i>
                                    FAQ
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('admin/lockscreen') }}">
                                    <i class="fa fa-fw fa-lock"></i>
                                    Lockscreen
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('admin/invoice') }}">
                                    <i class="fa fa-fw fa-newspaper-o"></i>
                                    Invoice
                                </a>
                            </li>
                            <li {{ (Request::is('admin/blank') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/blank') }}">
                                    <i class="fa fa-fw fa-file-o"></i>
                                    Blank
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('admin/login') }}">
                                    <i class="fa fa-fw fa-sign-in"></i>
                                    Login
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('admin/register') }}">
                                    <i class="fa fa-fw fa-sign-in"></i>
                                    Register
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('admin/404') }}">
                                    <i class="fa fa-fw fa-unlink"></i>
                                    404 Error
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('admin/500') }}">
                                    <i class="fa fa-fw fa-frown-o"></i>
                                    500 Error
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Menus generated by CRUD generator --}}
                    @include('admin/layouts/menu')

                    <li class="menu-dropdown {{ (Request::is('admin/boxed') || Request::is('admin/layout_fixed_header') || Request::is('admin/layout_boxed_fixed_header') || Request::is('admin/layout_fixed') ? 'active' : '') }}">
                        <a href="#">
                            <i class="menu-icon fa fa-th"></i>
                            <span>Layouts</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li {{ (Request::is('admin/boxed') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/boxed') }}">
                                    <i class="fa fa-fw fa-th-large"></i>
                                    Boxed Layout
                                </a>
                            </li>
                            <li {{ (Request::is('admin/layout_fixed_header') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/layout_fixed_header') }}">
                                    <i class="fa fa-fw fa-th-list"></i>
                                    Fixed Header
                                </a>
                            </li>
                            <li {{ (Request::is('admin/layout_boxed_fixed_header') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/layout_boxed_fixed_header') }}">
                                    <i class="fa fa-fw fa-th"></i>
                                    Boxed &amp; Fixed Header
                                </a>
                            </li>
                            <li {{ (Request::is('admin/layout_fixed') ? 'class=active' : '') }}>
                                <a href="{{ URL::to('admin/layout_fixed') }}">
                                    <i class="fa fa-fw fa-indent"></i>
                                    Fixed Header &amp; Menu
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-dropdown">
                        <a href="#">
                            <i class="menu-icon fa fa-sitemap"></i>
                                <span>
                                    Menu levels
                                </span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-sitemap"></i>
                                    Level 1
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-sitemap"></i>
                                            Level 2
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-sitemap"></i>
                                            Level 2
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-sitemap"></i>
                                            Level 2
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="sub-menu sub-submenu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-fw fa-sitemap"></i>
                                                    Level 3
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-fw fa-sitemap"></i>
                                                    Level 3
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-fw fa-sitemap"></i>
                                                    Level 3
                                                    <span class="fa arrow"></span>
                                                </a>
                                                <ul class="sub-menu sub-submenu">
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-fw fa-sitemap"></i>
                                                            Level 4
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-fw fa-sitemap"></i>
                                                            Level 4
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="fa fa-fw fa-sitemap"></i>
                                                            Level 4
                                                            <span class="fa arrow"></span>
                                                        </a>
                                                        <ul class="sub-menu sub-submenu">
                                                            <li>
                                                                <a href="#">
                                                                    <i class="fa fa-fw fa-sitemap"></i>
                                                                    Level 5
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <i class="fa fa-fw fa-sitemap"></i>
                                                                    Level 5
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="#">
                                                                    <i class="fa fa-fw fa-sitemap"></i>
                                                                    Level 5
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-fw fa-sitemap"></i>
                                                    Level 4
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-sitemap"></i>
                                            Level 2
                                            <span class="fa arrow"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-sitemap"></i>
                                    Level 1
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-sitemap"></i>
                                    Level 1
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-sitemap"></i>
                                            Level 2
                                            <span class="fa arrow"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-sitemap"></i>
                                            Level 2
                                            <span class="fa arrow"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-fw fa-sitemap"></i>
                                            Level 2
                                            <span class="fa arrow"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
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