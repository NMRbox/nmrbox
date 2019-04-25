@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Acknowledge Us
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
                    <h1>How to acknowledge NMRbox</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <p>
                        Acknowledging use of NMRbox is important for continuing financial support from NIH.
                    </p>

                    <p>
                        If you use NMRbox for a published study, please consider including the acknowledgment:
                        <br><br>
                        "This study made use of NMRbox, the National Center for Biomolecular NMR Data Processing and Analysis, which is supported by NIH grant P41GM111135 (NIGMS)."
                    </p>

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
