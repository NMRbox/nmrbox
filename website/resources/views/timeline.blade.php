@extends('layouts.default')

{{-- Page title --}}
@section('title')
Timeline
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/vendors/vertical-timeline/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/vertical-timeline/css/reset.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/timeline.css') }}" type="text/css">
    
@stop


{{-- Page content --}}
@section('content')
	<div class="bg">
        <div class="container">
            <div class="services">
                <h2> <label class="border-bottom mrg_lft12"> Timeline</label></h2>
            </div>
            <div class="row">
                <section id="cd-timeline" class="cd-container">
                   <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-movie">
                             <img src="{{ asset('assets/images/d1.jpg') }}" alt="Picture" width="60" height="60" class="img-circle">
                        </div>
                        <div class="cd-timeline-content">
                            <h2>Title of section 1</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.
                            </p>
                            <a href="#" class="btn btn-md btn-success">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <!-- cd-timeline-block -->
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-movie">
                            <img src="{{ asset('assets/images/d2.jpg') }}" alt="Picture" width="60" height="60" class="img-circle">
                        </div>
                        <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Title of section 2</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde?
                            </p>
                            <a href="#" class="btn btn-md btn-primary">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <!-- cd-timeline-block -->
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-picture">
                           <img src="{{ asset('assets/images/d3.jpg') }}" alt="Picture" width="60" height="60" class="img-circle"></div>
                        <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Title of section 3</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, obcaecati, quisquam id molestias eaque asperiores voluptatibus cupiditate error assumenda delectus odit similique earum voluptatem doloremque dolorem ipsam quae rerum quis. Odit, itaque, deserunt corporis vero ipsum nisi eius odio natus ullam provident pariatur temporibus quia eos repellat consequuntur perferendis enim amet quae quasi repudiandae sed quod veniam dolore possimus rem voluptatum eveniet eligendi quis fugiat aliquam sunt similique aut adipisci.
                            </p>
                            <a href="#" class="btn btn-md btn-danger">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <!-- cd-timeline-block -->
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-location">
                           <img src="{{ asset('assets/images/profile1.jpg') }}" alt="Picture" width="60" height="60" class="img-circle"></div>
                        <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Title of section 4</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut.
                            </p>
                            <a href="#" class="btn btn-md btn-default">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <!-- cd-timeline-block -->
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-location">
                            <img src="{{ asset('assets/images/profile2.jpg') }}" alt="Picture" width="60" height="60" class="img-circle"></div>
                        <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Title of section 5</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum.
                            </p>
                            <a href="#" class="btn btn-md btn-warning">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <!-- cd-timeline-block -->
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-movie">
                           <img src="{{ asset('assets/images/profile3.jpg') }}" alt="Picture" width="60" height="60" class="img-circle"></div>
                        <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Title of section 6</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum.</p>
                            <a href="#" class="btn btn-md btn-primary">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-location">
                            <img src="{{ asset('assets/images/profile4.jpg') }}" alt="Picture" width="60" height="60" class="img-circle"></div>
                        <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Title of section 7</h2>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum.
                            </p>
                            <a href="#" class="btn btn-md btn-danger">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <!-- cd-timeline-block -->
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-movie">
                           <img src="{{ asset('assets/images/d1.jpg') }}" alt="Picture" width="60" height="60" class="img-circle"></div>
                        <!-- cd-timeline-img -->

                        <div class="cd-timeline-content">
                            <h2>Final Section</h2>
                            <p>This is the content of the last section</p>
                            <a href="#" class="btn btn-md btn-success">Read more</a>
                        </div>
                        <!-- cd-timeline-content --> </div>
                    <!-- cd-timeline-block --> 
                </section>
                <!-- cd-timeline -->
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/vertical-timeline/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/vertical-timeline/js/modernizr.js') }}" type="text/javascript"></script>
@stop
