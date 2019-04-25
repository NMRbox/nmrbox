@extends('layouts.default')

{{-- Page title --}}
@section('title')
    TRD1 - People
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
                    <h1>TRD1</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <h2>
                        Investigators
                    </h2>
                    <ul>
                        <li>
                            Mark Maciejewski
                        </li>
                        <li>
                            Adam Schuyler
                        </li>
                        <li>
                            Ion Moraru
                        </li>
                    </ul>
                    <h2>
                        Staff
                    </h2>
                    <ul>
                        <li>
                            Dillon Jones
                        </li>
                        <li>
                            Gerard Weatherby
                        </li>
                        <li>
                            Terry Wright
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
