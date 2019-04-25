@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Initiating a Collaboration
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
                    <h1>Initiating a Collaboration</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <p>Collaborations with the NMRbox Team may take several forms:</p>

                    <h2>Driving Biological Projects</h2>
                    <p>DBPs are biomolecular projects that require the development of novel computational technologies or resources. DBPs align closely with one of the three Technology Research and Development components and "drive" the developments.</p>
                    
                    <h2>Collaboration & Service Projects</h2>
                    <p>CS projects are also biomolecular in nature, but are able to benefit from existing software or resources provided by the Center.</p>
                    
                    <h2>Tailored versions of NMRbox</h2>
                    <p>Some bio-NMR computing applications require downloadable virtual machines that are small, and have a "light footprint". Examples include VMs to support a class or workshop. For projects that are relevant to our mission we are able to produce NMRbox VMs containing curated subsets of the full complement of software.</p>
                    
                    <h2>Software developers</h2>
                    <p>If you have developed or are developing NMR software, we can provide an NMRbox development platform and work with you to deploy your software on NMRbox.</p>

                    <p>To explore the possibility of a collaboration with the NMRbox Team further, send an email to Jeff Hoch (<a href="mailto:hoch@uchc.edu">hoch@uchc.edu</a>)</p>

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
