@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Leadership
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
                    <h1>Leadership</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <h2>Director</h2>
                    <div class="contact-info">
                        <span class="bold">Jeffrey C. Hoch, Ph.D.</span>
                        <br>
                        Professor of Molecular Biology and Biophysics
                        <br>
                        UConn Health
                        <br>
                        <a href="mailto:hoch@uchc.edu">hoch@uchc.edu</a>
                    </div>

                    <h2>Associate Director</h2>
                    <div class="contact-info">
                        <span class="bold">Mark W. Maciejewski, Ph.D.</span>
                        <br>
                        Assistant Professor of Molecular Biology and Biophysics
                        <br>
                        <a href="mailto:markm@uchc.edu">markm@uchc.edu</a>
                    </div>

                    <h2>TRD 1 Co-Directors</h2>
                    <div class="contact-info">
                        <span class="bold">Mark W. Maciejewski, Ph.D.</span>
                        <br>
                        Assistant Professor of Molecular Biology and Biophysics
                        <br>
                        <a href="mailto:markm@uchc.edu">markm@uchc.edu</a>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Adam D. Schuyler, Ph.D.</span>
                        <br>
                        Assistant Professor of Molecular Biology and Biophysics
                        <br>
                        <a href="mailto:schuyler@uchc.edu">schuyler@uchc.edu</a>
                    </div>

                    <h2>TRD 2 Co-Directors</h2>
                    <div class="contact-info">
                        <span class="bold">Pedro Romero, Ph.D.</span>
                        <br>
                        Staff Scientist and Director, BMRB
                        <br>
                        Department of Biochemistry
                        <br>
                        University of Wisconsin, Madison
                        <br>
                        <a href="mailto:promero@wisc.edu">promero@wisc.edu</a>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Michael R. Gryk, Ph.D.</span>
                        <br>
                        Associate Professor of Molecular Biology and Biophysics
                        <br>
                        UConn Health
                        <br>
                        <a href="mailto:gryk@uchc.edu">gryk@uchc.edu</a>
                    </div>

                    <h2>TRD 3 Director</h2>
                    <div class="contact-info">
                        <span class="bold">Hamid R. Eghbalnia, Ph.D.</span>
                        <br>
                        Staff Scientist
                        <br>
                        Department of Biochemistry
                        <br>
                        University of Wisconsin, Madison
                        <br>
                        <a href="mailto:hamid.eghbalnia@wisc.edu">hamid.eghbalnia@wisc.edu</a>
                    </div>

                    <h2>Chief Technology Officer</h2>
                    <div class="contact-info">
                        <span class="bold">Ion Moraru, M.D., Ph.D.</span>
                        <br>
                        Professor of Cell Biology
                        <br>
                        UConn Health
                        <br>
                        <a href="mailto:moraru@uchc.edu">moraru@uchc.edu</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
