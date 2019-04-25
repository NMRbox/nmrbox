@extends('layouts.default')

{{-- Page title --}}
@section('title')
Contact
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/contact.css') }}">
    
@stop


{{-- Page content --}}
@section('content')
    <!-- Map Section Start -->
    <div class="container">
        <div class="services">
            <h2>
                <label class="border-bottom">Contact Us</label>
            </h2>
        </div>
    </div>
    <div class="" style="margin-top:2px;">
        <div id="map" style="width:100%; height:500px;"></div>
    </div>
    <!-- //Map Section Start -->
    <!--  Container Form Section Start -->
    <div class="container">
        <!-- Row Section Start -->
        <div class="row">
            <!-- Contact Form Section Start -->
            <div class="col-md-9">
                <h3>Contact Form</h3>
                <!-- Notifications -->
                @include('notifications')

                <form id="contact" action="{{ route('contact') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="input-group">
                    <label>Name:</label>
                        <input type="text" name="contact-name" class="form-control" required>
                    </div>
                    <div class="input-group">
                    <label>E-mail:</label>
                        <input type="email" name="contact-email" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <label>Message:</label>
                        <textarea name="contact-msg" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="input-group">
                        <button class="btn btn-primary">submit</button>
                        <button class="btn btn-danger">cancel</button>
                    </div>
                </form>
            </div>
            <!-- //Contact Form Section End -->
            <!-- Address Section Start -->
            <div class="col-md-3 addr">
                <h3>Our Contacts</h3>
                <h5><b>Loop, Inc.</b></h5>
                <p> Gieringer Robert E MD 2751 Debarr Rd #320 Anchorage, AK(Alaska) 99508 
                    <br>P:  (907) 563-3232 </p>
                <h5><b>E-mail:</b> <a href="mailto:">Info@domain.com</a></h5>
                <h3>About Us</h3>
                <h5>I'm talking about something more substantial.</h5>
                <ul>
                    <li><i class="fa fa-arrow-right"></i>&nbsp;Lorem ipsum dolor sit amet</li>
                    <li><i class="fa fa-arrow-right"></i>&nbsp;Lorem ipsum dolor sit amet</li>
                    <li><i class="fa fa-arrow-right"></i>&nbsp;Lorem ipsum dolor sit amet</li>
                    <li><i class="fa fa-arrow-right"></i>&nbsp;Lorem ipsum dolor sit amet</li>
                </ul>
            </div>
            <!-- //Address Section End -->
        </div>
        <!-- //Row Section End -->
    </div>
    <!-- //Container Section End -->
@stop

{{-- page level scripts --}}
@section('footer_scripts')    
    <!-- //page level js Start  -->
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/gmap.js') }}"></script>
@stop