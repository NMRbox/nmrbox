@extends('layouts.default')

{{-- Page title --}}
@section('title')
    TRD 1
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
                    <h1>Registration Successful</h1>
                    <br>
                    <br>
                    <br>
                    <br>
                    <span>Thanks for registering! We'll be in touch when we're ready.</span>
                    <br>
                    <br><br>
                    <br>
                    <img style="max-width:600px;" class="" src="{{ asset('assets/img/logo/nmrbox-full-horizontal-md.png') }}" alt="nmr-logo">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>


                </div>

                <div class="research-container">
                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script>
        setTimeout(function(){
            window.location.href="{{ route("home") }}";
        }, 4000);
    </script>
@stop
