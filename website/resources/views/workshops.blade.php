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

                    <p>
                        NMRbox Summer Workshop
                    </p>
                    <div>
                        <ul>
                            <li>
                                Date: June 20-24, 2016
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li>
                                Location: UConn Health, Farmington, CT
                            </li>
                        </ul>
                    </div>
                    <p>
                        <br/>
                        <br/>
                    </p>


                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
