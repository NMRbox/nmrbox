@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Collaboration and Service
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
                    <h1>Collaboration and Service</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <p>CS components of the Center utilize existing, mature capabilities to advance a biomedically important project. In contrast, DPBs involve development of new methodologies and tools, within the context of the TRD components.</p>

                    <div class="table-responsive">
                        <table class="table-bordered cs-table">
                            <tbody>
                            <tr>
                                <td>
                                    <div>
                                        David Rovnyak
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Bucknell
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        A Curated NMR Data Processing Social Media Presence
                                    </div>
                                    <div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        Angela Gronenborn
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Pittsburgh
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Investigation of amide proton chemical shift outliers
                                    </div>
                                    <div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        Tatyana Polenova
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Delaware
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Nonuniform Sampling and Maximum Entropy Reconstruction for Magic Angle Spinning NMR Spectroscopy of Large Protein Assemblies
                                    </div>
                                    <div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        Homayoun Valafar&nbsp;
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        South Carolina
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Software for RDC analysis
                                    </div>
                                    <div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        Mark Foster&nbsp;
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Ohio State
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        GUARDD: Graphical User-friendly Analysis of Relaxation Dispersion Data
                                    </div>
                                    <div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        Gerhard Wagner
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Harvard
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        Practical implementation of non-uniform sampling in advanced multidimensional NMR experiments for biological macromolecules
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
