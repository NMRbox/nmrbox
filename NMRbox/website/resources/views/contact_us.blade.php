@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Contact Us
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
                    <h1>Contact Us</h1>
                    <span></span>
                </div>

                <div class="research-container">

                    <p>For NMRbox support or general questions, email <a href="mailto:support@nmrbox.org">support@nmrbox.org</a></p>

                    <p>For developers with questions related to provisioning NMRbox software, email <a href="mailto:developer@nmrbox.org">developer@nmrbox.org</a></p>

                    <p>For questions about the NMRbox.org web site, email <a href="mailto:webmaster@nmrbox.org">webmaster@nmrbox.org</a></p>

                    <p>To inquire about a possible collaboration with the NMRbox Team, email <a href="mailto:director@nmrbox.org">director@nmrbox.org</a></p>

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
