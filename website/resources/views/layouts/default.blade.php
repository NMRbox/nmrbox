<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @section('title') | NMRbox
        @show
    </title>
    <!-- global css Start -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/Buttons/css/buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/nmr.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/nmr-favicon/favicon-32x32.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/img/nmr-favicon/favicon.ico') }}" type="image/x-icon">
    <!-- //global css End -->
    <!-- page level css Start -->
    @yield('header_styles')
    <!-- //page level css End -->

</head>

<body>
    <!-- Header Section Start -->
    <header>
        <nav class="navbar ">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bars"></span>
                </button>
                {{--<a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/images/logo2.png') }}"></a>--}}
                <a class="navbar-brand" href="{{ route('home') }}">
                    <span class="word-logo">NMRbox</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-right">
                    {{--<li {{ (Request::is('/') ? 'class=active' : '') }}><a href="{{ route('home') }}"> Home</a>--}}
                    {{--</li>--}}

                    <li class="dropdown {{ (Request::is('research') ||
                                            Request::is('overview') ||
                                            Request::is('trd1') ||
                                            Request::is('trd2') ||
                                            Request::is('trd3') ||
                                            Request::is('dbps') ||
                                            Request::is('c-s') ||
                                            Request::is('initiating-a-collaboration') ||
                                            Request::is('acknowledge-us') ||
                                            Request::is('publications')
                                        ? 'active' : '') }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Research</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('overview') }}">Overview</a></li>
                            <li><a href="{{ URL::to('trd1') }}">TR&amp;D 1</a></li>
                            <li><a href="{{ URL::to('trd2') }}">TR&amp;D 2</a></li>
                            <li><a href="{{ URL::to('trd3') }}">TR&amp;D 3</a></li>
                            <li><a href="{{ URL::to('dbps') }}">DBPs</a>
                            </li>
                            <li><a href="{{ URL::to('c-s') }}">C&S</a>
                            </li>
                            <li><a href="{{ URL::to('initiating-a-collaboration') }}">Initiating a collaboration</a></li>
                            <li><a href="{{ URL::to('acknowledge-us') }}">How to acknowledge us</a></li>
                            <li><a href="{{ URL::to('publications') }}">Publications</a>
                        </ul>
                    </li>

                    <li class="dropdown {{ (Request::is('resources') ||
                                            Request::is('documentation') ||
                                            Request::is('licensing') ||
                                            Request::is('nihresources')
                                        ? 'active' : '') }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Resources</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('documentation') }}">Documentation</a></li>
                            <li><a href="{{ URL::to('licensing') }}">Licensing</a></li>
                            <li><a href="{{ URL::to('nihresources') }}">NIH Biomedical Technology Resources</a></li>
                            <li><a href="{{ URL::to('faq') }}">FAQ</a></li>
                        </ul>
                    </li>

                    {{--<li class="dropdown {{ (Request::is('outreach') ||
                                            Request::is('workshops') ||
                                            Request::is('meetings')
                                        ? 'active' : '') }}">
                        <a href="{{ URL::to('events') }}" class="dropdown-toggle" data-toggle="dropdown"> Outreach</a>
                        --}}{{--<ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('workshops') }}">Workshops</a></li>
                            <li><a href="{{ URL::to('meetings') }}">Meetings</a></li>
                        </ul>--}}{{--
                    </li>--}}
                    <li {{ (Request::is('events') ? 'class=active' : '') }}><a href="{{ URL::to('events') }}"> Outreach</a></li>

                    <li class="dropdown {{ (Request::is('people-leadership') ||
                                            Request::is('people-trd1') ||
                                            Request::is('people-trd2') ||
                                            Request::is('people-trd3') ||
                                            Request::is('people-eab') ||
                                            Request::is('people-administration') ||
                                            Request::is('people-technical-staff') ||
                                            Request::is('contact-us')
                                        ? 'active' : '') }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> People</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('people-leadership') }}">Leadership</a></li>
                            <li><a href="{{ URL::to('people-trd1') }}">TR&amp;D 1</a></li>
                            <li><a href="{{ URL::to('people-trd2') }}">TR&amp;D 2</a></li>
                            <li><a href="{{ URL::to('people-trd3') }}">TR&amp;D 3</a></li>
                            <li><a href="{{ URL::to('people-eab') }}">EAB</a></li>
                            <li><a href="{{ URL::to('people-administration') }}">Administration</a></li>
                            <li><a href="{{ URL::to('people-technical-staff') }}">Technical Staff</a></li>
                            <li><a href="{{ URL::to('contact-us') }}">Contact Us</a></li>
                        </ul>
                    </li>

                    <li {{ (Request::is('registry') ? 'class=active' : '') }}><a href="{{ URL::to('registry') }}"> Registry</a></li>

                    {{--based on anyone login or not display menu items--}}
                    @if(!Session::has('person'))
                        <li><a href="{{ URL::to('login') }}">Sign in</a>
                    @else
                        <li {{ (Request::is('my-account') ? 'class=active' : '') }}><a href="{{ URL::to('my-account') }}">My Account</a>
                        </li>
                        <li><a href="{{ URL::to('logout') }}">Sign out</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </header>
    <!-- //Header Section Start -->

    {{-- alert box section --}}
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <div class="alert alert-success hidden" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! </strong>
                    <span id="success_msg"></span>
                </div>

                <div class="alert alert-danger hidden" id="error-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>
                    <span id="error_msg"></span>
                </div>

                <div class="alert alert-info hidden" id="info-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong> </strong>
                    <span id="info_msg"></span>
                </div>
            </div>
        </div>
        <br />
    </section>

    <!-- Content -->
    @yield('content')

    <!-- Footer Section Start -->
    <br><br><br>
    <footer>
        <div class="container ftr-txt">
            <div class="row">

            </div>
        </div>
    </footer>
    <!-- //Footer Section End -->
    <!-- Copyright Section Start -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a href="http://www.btrportal.org/">NIH Biomedical Technology Resource Portal</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a href="{{ URL::to('contact-us') }}">Contact Us</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a href="{{ URL::to('register') }}">Register for an account</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <span>NMRbox {!! date('Y') !!}</span>
                </div>
            </div>

            </div>
        </div>
    </div>
    <!-- //Copyright Section End -->
    <!-- global js Start -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-1.11.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/chandra.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
    </script>
    <!-- //global js End -->
    <!-- page level js Start -->
    @yield('footer_scripts')
    <!-- //page level js End -->
</body>

</html>
