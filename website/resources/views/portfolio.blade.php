@extends('layouts.default')

{{-- Page title --}}
@section('title')
Portfolio
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/source/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/source/helpers/jquery.fancybox-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/portfolio.css') }}">    
@stop


{{-- Page content --}}
@section('content')
<div class="container">
        <!-- Imags Section Start -->
        <div class="row services">
            <h2>
                <label class="border-bottom">Portfolio
                </label>
            </h2>
        </div>
        <div class="row">
            <div id="gallery">
                <div>
                    <button class=" btn filter btn-primary" data-filter="all">ALL</button>
                    <button class="btn filter btn-primary" data-filter=".category-1">HTML</button>
                    <button class=" btn filter btn-primary" data-filter=".category-2">BOOTSTRAP</button>
                </div>
                <div>
                    <div class="mix category-1" data-my-order="1">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/1.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/1.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-1" data-my-order="2">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/2.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/2.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-2" data-my-order="3">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/3.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/3.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-1" data-my-order="4">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/4.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/4.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-2" data-my-order="5">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/5.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/5.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-2" data-my-order="6">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/6.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/6.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-1" data-my-order="7">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/7.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/7.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-2" data-my-order="8">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/8.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/8.jpg') }}" class="img-responsive"> </div>
                    </div>
                    <div class="mix category-2" data-my-order="9">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/portfolio/big/9.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/portfolio/small/9.jpg') }}" class="img-responsive"> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //Imags Section Start End -->
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/mixitup/src/jquery.mixitup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/source/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/source/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/source/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/portfolio.js') }}"></script>
@stop
