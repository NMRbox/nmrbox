@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Workshops
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

                <div class="research-header">
                    <h1>Workshops</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <h2>Experimental NMR Conference Mini-workshop</h2>

                    <ul>
                        <li><span class="bold">Date</span>: April 13, 6 &ndash; 9pm</li>
                        <li><span class="bold">Location</span>: Pittsburgh, PA</li>
                        <li><a href="{{ asset('assets/files/workshop-flyers/flyer-enc.pdf') }}">More information</a></li>
                    </ul>

                    <h2>NMRbox Summer Workshop</h2>

                    <ul>
                        <li><span class="bold">Date</span>: June 20 - 24, 2016</li>
                        <li><span class="bold">Location</span>: UConn Health, Farmington, CT</li>
                        <li><a href="{{ asset('assets/files/workshop-flyers/flyer-workshop.pdf') }}">Tentative Syllabus</a></li>
                        <li>To register, email Jeff Hoch (<a href="mailto:hoch@uchc.edu">hoch@uchc.edu</a>)</li>
                    </ul>


                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
