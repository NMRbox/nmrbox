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

                                <p class="text-center"><a class="button button-flat" href="{{ route('register') }}" role="button">Register</a></p>
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

                            {{--Feel free to add text in the format of the grant abstracts below--}}
                            {{--Put an <hr> and <br> between posts for visual separation, see above--}}


                            {{--<p class="text-left">--}}
                                {{--The broad aim of this proposal is to simplify and integrate dissemination,--}}
                                {{--maintenance, support, and application of NMR data processing and analysis software packages. By facilitating--}}
                                {{--the discovery, use, and persistence of advanced software for biomolecular NMR, the proposed resource will--}}
                                {{--advance the application of biomolecular NMR for challenging applications in biomedicine, including structural--}}
                                {{--biology, drug discovery, and metabolomics. A unifying theme is to foster reproducible research in bio-NMR.--}}
                            {{--</p>--}}

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
