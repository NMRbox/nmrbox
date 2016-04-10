@extends('layouts.default')

{{-- Page title --}}
@section('title')
    EAB
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
                    <h1>External Advisory Board</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <br>

                    <div class="contact-info">
                        <span class="bold">Kevin Gardner, Ph.D. (Chair)</span>
                        <br>
                        Einstein Professor of Chemistry
                        <br>
                        City University of New York
                        <br>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Jean Baum, Ph.D.</span>
                        <br>
                        Professor of Chemistry
                        <br>
                        Rutgers University
                        <br>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Arthur Edison, Ph.D.</span>
                        <br>
                        Professor of Biochemistry and Molecular Biology
                        <br>
                        University of Georgia
                        <br>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Jane Dyson, Ph.D.</span>
                        <br>
                        Professor of Integrative Structural and Computational Biology
                        <br>
                        The Scripps Research Institute
                        <br>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Lila Gierasch, Ph.D.</span>
                        <br>
                        Professor of Biochemistry
                        <br>
                        University of Massachusetts, Amherst
                        <br>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Robert G. Griffin, Ph.D.</span>
                        <br>
                        Professor of Chemistry
                        <br>
                        MIT
                        <br>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Les Loew, Ph.D. (ex officio)</span>
                        <br>
                        XXX Professor of Cell Biology
                        <br>
                        UConn Health
                        <br>
                    </div>





                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
