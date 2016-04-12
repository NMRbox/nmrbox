@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Home
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
    @stop


    {{-- Page content --}}
    @section('content')
            <!-- Container Section Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="content">
                    <div class="row homepage">
                        <div class="jumbotron">


                            <div class="row">
                                <div class="Media col-xs-12">
                                    <img class="Media-figure" src="{{ asset('assets/img/logo/nmrbox-logo-md.png') }}" alt="nmr-logo">
                                    <div class="Media-body text-right logo-text">
                                        <h1>NMRbox</h1>
                                        <h1 class="org">.org</h1>
                                    </div>
                                </div>

                                <span class="lead">Reproducible computing for Bio-NMR</span>

                                <br><br>

                                <p class="text-center"><a class="button button-flat" href="{{ route('register-person') }}" role="button">Register</a></p>
                                {{--<a class="button button-flat" href="#" role="button">Register</a>--}}

                            </div>




                            <br>
                            <br>
                            <hr>
                            <br>

                            <h2>Our Mission</h2>
                            <p class="text-left">
                                The mission of the Center for NMR Data Processing and Analysis is to facilitate access to existing software tools and computational resources used by the bio-NMR community as well as to improve the quality of NMR processing, analysis and data depositions.
                            </p>

                            <br>
                            <br>
                            <hr>
                            <br>



                            <p class="text-left">
                                NMRbox is a shared computational platform for NMR developed by the National Center for Biomolecular NMR Data Processing and Analysis, a collaboration among UConn Health, University of Wisconsin, and University of Illinois. The Center is a Biomedical Technology Research Resource (BTRR), supported by the National Institutes of Health (NIH) / National Institute of General Medical Sciences (NIGMS), grant 1P41GM111135.
                            </p>

                            <img class="index-image" src="{{ asset('assets/img/index-footer-logos/UCH.png') }}" alt="">
                            <img class="index-image" src="{{ asset('assets/img/index-footer-logos/UW.png') }}" alt="">
                            <img class="index-image" src="{{ asset('assets/img/index-footer-logos/UI.png') }}" alt="">
                            <img class="index-image" src="{{ asset('assets/img/index-footer-logos/nigms_logo_sm.png') }}" alt="">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
