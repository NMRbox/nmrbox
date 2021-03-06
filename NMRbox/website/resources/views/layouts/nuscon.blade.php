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
                {{--<a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/images/nuscon.png') }}"></a>--}}
                <a class="navbar-brand" href="{{ route('home') }}">
                    <span class="word-logo">NUScon</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-right">

                    {{--based on anyone login or not display menu items--}}
                    @if(Sentinel::guest())
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
