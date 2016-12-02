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
                        </ul>
                    </li>

                    <li class="dropdown {{ (Request::is('outreach') ||
                                            Request::is('workshops') ||
                                            Request::is('meetings')
                                        ? 'active' : '') }}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Outreach</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('workshops') }}">Workshops</a></li>
                            <li><a href="{{ URL::to('meetings') }}">Meetings</a></li>
                        </ul>
                    </li>

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




                    @if ($user = Sentinel::getUser())
                        @if(Sentinel::inRole('admin'))
                            <li>
                                <a href="{{ URL::to('admin') }}">Admin</a>
                            </li>
                        @endif

                        @if(Sentinel::inRole('dillon'))
                        <li class="dropdown {{ (Request::is('aboutus') || Request::is('timeline') || Request::is('blank') ? 'active' : '') }}"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Pages</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL::to('aboutus') }}">About Us</a></li>
                                <li><a href="{{ URL::to('timeline') }}">Timeline</a></li>
                                <li><a href="{{ URL::to('404') }}">404 Page</a>
                                </li>
                                <li><a href="{{ URL::to('500') }}">500 Page</a>
                                </li>
                                <li><a href="{{ URL::to('blank') }}">Blank</a></li>
                            </ul>
                        </li>
                        <li class="dropdown {{ (Request::is('typography') || Request::is('advancedfeatures') || Request::is('grid') ? 'active' : '') }}"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Features</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL::to('typography') }}">Typography</a>
                                </li>
                                <li><a href="{{ URL::to('advancedfeatures') }}">Advanced Features</a>
                                </li>
                                <li><a href="{{ URL::to('grid') }}">Grid System</a>
                                </li>
                                <li class="hidden-xs hidden-lg hidden-md"><a href="{{ URL::to('price') }}">Price</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{ (Request::is('portfolio') || Request::is('portfolioitem') ? 'active' : '') }}"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Portfolio</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL::to('portfolio') }}">Portfolio</a>
                                </li>
                                <li><a href="{{ URL::to('portfolioitem') }}">Portfolio Item</a>
                                </li>
                            </ul>
                        </li>
                        <li class="hidden-sm {{ (Request::is('price') ? 'active' : '') }}">
                            <a href="{{ URL::to('price') }}">Price</a>
                        </li>
                        <li {{ (Request::is('blog') || Request::is('blog/*') ? 'class=active' : '') }}><a href="{{ URL::to('blog') }}">Blog</a>
                        <li {{ (Request::is('contact') ? 'class=active' : '') }}><a href="{{ URL::to('contact') }}">Contact</a>
                        </li>
                        @endif
                    @endif
                    {{--based on anyone login or not display menu items--}}
                    @if(Sentinel::guest())
                        <li><a href="{{ URL::to('login') }}">Login</a>
                        {{--<li><a href="{{ URL::to('admin/login') }}">Login</a>--}}
                        {{--</li>--}}
                        {{--<li><a href="{{ URL::to('register') }}">Register</a>--}}
                        {{--</li>--}}
                    @else
                        <li {{ (Request::is('my-account') ? 'class=active' : '') }}><a href="{{ URL::to('my-account') }}">My Account</a>
                        </li>
                        <li><a href="{{ URL::to('logout') }}">Logout</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    </header>
    <!-- //Header Section Start -->

    <!-- Content -->
    @yield('content')

    <!-- Footer Section Start -->
    <footer>
        <div class="container ftr-txt">
            <div class="row">
                {{--<!-- About Us Section Start -->--}}
                {{--<div class="col-sm-3 col-xs-12">--}}
                    {{--<h3>About us</h3>--}}
                    {{--<p>--}}
                        {{--There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum.--}}
                    {{--</p>--}}
                {{--</div>--}}
                {{--<!-- //About Us Section End -->--}}
                {{--<!-- Recent post Section Start -->--}}
                {{--<div class="col-sm-3 col-xs-12 recen-post">--}}
                    {{--<h3>Recent Posts</h3>--}}
                    {{--<ul class="list-unstyled recen-post">--}}
                        {{--<li>--}}
                            {{--<img src="{{ asset('assets/images/c2.jpg') }}" class="ftr-image-small" /> <span class="fotr-post">Lorem Ipsum is simply dummy text of the printing industry.--}}
                            {{--</span>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<img src="{{ asset('assets/images/c3.jpg') }}" class="ftr-image-small" /> <span class="fotr-post">Lorem Ipsum is simply dummy text of the printing industry.--}}
                            {{--</span>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<img src="{{ asset('assets/images/c4.jpg') }}" class="ftr-image-small" /> <span class="fotr-post">Lorem Ipsum is simply dummy text of the printing industry.--}}
                            {{--</span>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<!-- //Recent Post Section End -->--}}
                {{--<!-- GetIn Touch Section Start -->--}}
                {{--<div class="col-sm-3 col-xs-12">--}}
                    {{--<h3>get in touch</h3>--}}
                    {{--<p>--}}
                        {{--<i class="fa  fa-map-marker"></i>&nbsp;Gieringer Robert E MD 2751 Debarr Rd #320 Anchorage, AK(Alaska) 99508--}}
                    {{--</p>--}}
                    {{--<p>--}}
                        {{--<i class="fa fa-mobile-phone"></i> Phone:&nbsp;(907) 563-3232 --}}
                    {{--</p>--}}
                    {{--<p>--}}
                        {{--<i class="fa fa-envelope-o"></i> E-mail:&nbsp; <a href="mailto:"><span class="text-white">info@domain.com</span></a>--}}
                    {{--</p>--}}
                    {{--<p>--}}
                        {{--<i class="fa fa-skype"></i> Skype:&nbsp;<span class="text-white">domain</span>--}}
                    {{--</p>--}}
                {{--</div>--}}
                {{--<!-- //GetIn Touch Section End -->--}}
                {{--<!-- Subscribe Section Start -->--}}
                {{--<div class="col-sm-3 col-xs-12">--}}
                    {{--<h3>Subscribe</h3>--}}
                    {{--<p>--}}
                        {{--The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced.--}}
                    {{--</p>--}}
                    {{--<form class="ftr-form">--}}
                        {{--<div class="input-group">--}}
                            {{--<input type="email" class="form-control" placeholder="E-mail" />--}}
                            {{--<a href="#">--}}
                                {{--<input type="button" class="btn btn-primary" value="Submit" />--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
                {{--<!-- //Subscribe Section End -->--}}
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
                    <span>NMRbox 2015</span>
                </div>
            </div>

            <!-- Icon Section Start -->
            {{--<div class="pad_top10">--}}
            {{--<ul class="list-inline" id="icon_section">--}}
                {{--<li>--}}
                    {{--<a href="#"> <i class="fa fa-facebook"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#"> <i class="fa fa-google-plus"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#"> <i class="fa fa-twitter"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#"> <i class="fa fa-linkedin"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#"> <i class="fa fa-rss"></i>--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
            {{--</div>--}}
        <!-- //Icon Section End -->
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
