@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Publications
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
                    <h1>Publications</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <cite>CONNJUR R: an annotation strategy for fostering reproducibility in bio-NMR-protein spectral assignment.</cite>
                    <br>
                    Fenwick M, Hoch JC, Ulrich E, Gryk MR.
                    <br>
                    J Biomol NMR. 2015 Oct;63(2):141-50.
                    <br>
                    doi: 10.1007/s10858-015-9964-1. Epub 2015 Aug 8.
                    <br>
                    PMID: 26253947
                    <br>
                    <br>


                    <cite>Software as Data: Bringing Order to the Chaotic NMR Software Environment</cite>
                    <br>
                    Gryk MR, Maciejewski MW, Schuyler AD, Ulrich EL, Eghbalnia HR, Hoch JC
                    <br>
                    IEEE Transactions on Biomedical Engineering
                    <br>
                    Special Issue on Model Sharing & Reproducibility
                    <br>
                    Scheduled for fall 2016
                    <br>


                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
