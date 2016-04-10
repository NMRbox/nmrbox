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
                    <h1>Technical Staff</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <br>


                    <span class="bold">Sophan Iv</span>
                    <br>
                    <span class="bold">Dillon Jones</span>
                    <br>
                    <span class="bold">Steven King</span>
                    <br>
                    <span class="bold">Gerard Weatherby</span>
                    <br>
                    <span class="bold">Terry Wright</span>
                    <br>





                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
