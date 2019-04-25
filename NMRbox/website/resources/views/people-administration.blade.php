@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Administration
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
                    <h1>Administrative Staff</h1>
                    <span></span>
                </div>

                <div class="research-container">


                    <div class="contact-info">
                        <span class="bold">Jenifer Gilman, Administrative Officer</span>
                        <br>
                        Department of Molecular Biology and Biophysics
                        <br>
                        UConn Health
                        <br>
                        <a href="mailto:gilman@uchc.edu">gilman@uchc.edu</a>
                    </div>

                    <div class="contact-info">
                        <span class="bold">Oksana Gorbatyuk, Research Assistant</span>
                        <br>
                        Department of Molecular Biology and Biophysics
                        <br>
                        UConn Health
                        <br>
                        <a href="mailto:gorbatyuk@uchc.edu">gorbatyuk@uchc.edu</a>
                    </div>


                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
