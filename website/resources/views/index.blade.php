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

                            {{--Feel free to add text in the format of the grant abstracts below--}}
                            {{--Put an <hr> and <br> between posts for visual separation, see above--}}

                            {{--<h2>Grant Abstracts</h2>--}}
                            {{--<p class="text-left">--}}
                                {{--Computation plays a critical role in biomolecular applications of nuclear magnetic--}}
                                {{--resonance spectroscopy (NMR), such as structural biology, metabolic studies, disease diagnosis, and drug--}}
                                {{--discovery. Powerful software packages from a variety of sources facilitate computation in bio-NMR, but--}}
                                {{--challenges include the difficulty of disseminating and maintaining a diverse set of software for a diverse set of--}}
                                {{--computer platforms, communication between software packages, and the lack of persistence of software. The--}}
                                {{--aim of this proposal is to establish a national Center for NMR Data Processing and Analysis that will simplify--}}
                                {{--discovery, dissemination, support, and use of a broad range of widely-used NMR software, develop tools for--}}
                                {{--data capture, abstraction, interoperation and workflow management, and provide novel analysis tools, all with--}}
                                {{--the goal of enhancing reproducibility of bio-NMR studies. An archive of the software platform will ensure--}}
                                {{--persistence that is essential for reproducible research. The Center will establish a publically accessible website--}}
                                {{--for discovery, evaluation, and access to a diverse set of NMR software. In addition to a single, unified--}}
                                {{--downloadable package, all the resources will be made available as a cloud-based platform. Three technology--}}
                                {{--research and development components encompass the computing platform, data, and analytic resources for--}}
                                {{--bio-NMR to be developed by the proposed Center. By facilitating the deployment, utilization, interoperation,--}}
                                {{--and persistence of advanced software for biomolecular NMR, the proposed resource will advance the--}}
                                {{--application of biomolecular NMR for a wide range of challenging applications in biomedicine, and help ensure--}}
                                {{--the reproducibility of bio-NMR studies. An extensive array of collaborations will provide specific challenges as--}}
                                {{--exemplars of biomedical applications of NMR and drive the technology development.--}}
                            {{--</p>--}}

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
