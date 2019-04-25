@extends('layouts.default')

{{-- Page title --}}
@section('title')
    TRD2 - People
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
                    <h1>TRD2</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <h2>
                        Investigators
                    </h2>
                    <ul>
                        <li>
                            Michael Gryk
                        </li>
                        <li>
                            Eldon Ulrich
                        </li>
                        <li>
                            Pedro R. Romero
                        </li>
                    </ul>
                    <h2>
                        Staff
                    </h2>
                    <ul>
                        <li>
                            Dimitri Maziuk
                        </li>
                        <li>
                            Jon Wedell
                        </li>
                        <li>
                            Kumaran Baskaram
                        </li>
                        <li>
                            Gerard Weatherby
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
