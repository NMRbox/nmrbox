@extends('layouts.default')

{{-- Page title --}}
@section('title')
Portfolio Item
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bxslider/jquery.bxslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/portfolio.css') }}">    
@stop


{{-- Page content --}}
@section('content')
    <div class="container">
        <div class="row services">
            <h2>
                <label class="border-bottom">Portfolio Item
                </label>
            </h2>
        </div>
        <!-- Project Description Section Satrt -->
        <h3 class="text-primary">
            PROJECT DESCRIPTION
        </h3>
        <!-- //Project Description Section End -->
        <!-- Row Start -->
        <div class="row">
            <!-- Paragraph Text Start -->
            <div class="col-md-6">
                <p class="text-justify">
                    This year, in this election, we are called to reaffirm our values and our commitments, to hold them against a hard reality and see how we are measuring up, to the legacy of our forbearers, and the promise of future generations. We have real enemies in the world. We can pounce on some gaffe by a Hillary supporter as evidence that she's playing the race card, or we can speculate on whether white men will all flock to John McCain in the general election regardless of his policies. They have not served a Red America or a Blue America - they have served the United States of America.
                </p>
                <br />
                <div>
                    <h4><span class="text-success"><i class="fa fa-html5"></i></span>&nbsp;&nbsp;HTML5&CSS3</h4>
                    <h4><span class="text-success"><i class="fa fa-bell"></i></span>&nbsp;&nbsp;WEB DEISGN</h4>
                    <h4><span class="text-success"><i class="fa fa-globe"></i></span>&nbsp;&nbsp;WEB DEVELOPMENT</h4>
                    <h4><span class="text-success"><i class="fa fa-comments"></i></span>&nbsp;&nbsp;AWESOME UI</h4>
                    <h4><span class="text-success"><i class="fa fa-cog"></i></span>&nbsp;&nbsp;FREE STORAGE</h4>
                </div>
            </div>
            <!-- //Paragraph Text End -->
            <!-- Slider Section Start -->
            <div class="col-md-6">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="{{ asset('assets/images/port_1.jpg') }}" alt="portfolio image" class="img-responsive">
                        </div>
                        <div class="item">
                            <img src="{{ asset('assets/images/port_2.jpg') }}" alt="portfolio image" class="img-responsive">
                        </div>
                        <div class="item">
                            <img src="{{ asset('assets/images/port_3.jpg') }}" alt="portfolio image" class="img-responsive">
                        </div>
                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- //Slider Section End -->
        </div>
        <!-- //Row End -->
        <!-- Realated Work Section Start -->
        <div class="row marg-btm10">
            <div class="text-center">
                <h3 class="text-primary">Related Works</h3>
                <div class="slider1">
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/1.jpg') }}" class="img-responsive"></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/2.jpg') }}" class="img-responsive"></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/3.jpg') }}" class="img-responsive"></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/4.jpg') }}" class="img-responsive"></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/5.jpg') }}" class="img-responsive">></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/6.jpg') }}" class="img-responsive"></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/7.jpg') }}" class="img-responsive"></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/8.jpg') }}" class="img-responsive"></div>
                    <div class="slide"><img src="{{ asset('assets/images/portfolio/port_item/9.jpg') }}" class="img-responsive"></div>
                </div>
            </div>
        </div>
        <!-- //Realated Work Section End -->
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/bxslider/jquery.bxslider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/portfolio_item.js') }}"></script>
@stop
