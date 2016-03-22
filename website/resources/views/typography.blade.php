@extends('layouts.default')

{{-- Page title --}}
@section('title')
Typography
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/features.css') }}">
    
@stop


{{-- Page content --}}
@section('content')
<div class="container">
    <div class="services">
        <h2>
            <label class="border-bottom">Typography</label>
        </h2>
    </div>
    <!-- Headings and Text Section Start -->
    <div class="row">
        <!-- Heading Section Start -->
        <div class="col-md-6 headings">
            <h3 class="text-primary">Headings</h3>
            <h1>h1. Bootstrap heading</h1>
            <h2>h2. Bootstrap heading</h2>
            <h3>h3. Bootstrap heading</h3>
            <h4>h4. Bootstrap heading</h4>
            <h5>h5. Bootstrap heading</h5>
            <h6>h6. Bootstrap heading</h6>
        </div>
        <!-- //Heading Section End -->
        <!-- Text Section Start -->
        <div class="col-md-6">
            <h3 class="text-success">Texts</h3>
            <ul class="list-unstyled text">
                <li class="warning">The ship set ground on the shore of this uncharted desert isle with Gilliganthe Skippertoo the millionaire and his wife. Just two good ol' boys Fightin' the system</li>
                <li class="success">like a truemodern day Robin Hood. So join us here each week my friends you're sure to get a smile from seven stranded castaways here on Gilligans Isle.It's time</li>
                <li class="text-primary"> to put on makeup. It's time to dress up right. It's time to raise the curtain on the Muppet Show tonight.As long as we live its you and me baby.There ain't nothin' </li>
                <li class="danger">Minions ipsum butt baboiii aaaaaah. Gelatooo tank yuuu! Hahaha underweaaar tatata bala tu bee do bee do bee do tank yuuu! Pepete po kass daa. Tank yuuu</li>
            </ul>
        </div>
        <!-- //Text Section End -->
    </div>
    <!-- //Headings and Text Section End -->
    <!-- Blockquote Section Start -->
    <div class="row">
        <!-- Default Blockquote Section Start -->
        <div class="col-md-6">
            <h3 class="text-danger">Default blockquote</h3>
            <blockquote>
                <h5>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                </h5>
                <div class="foot">Someone famous in
                    <cite title="Source Title">Source Title</cite>
                </div>
            </blockquote>
        </div>
        <!-- //Default Blockquote Section End -->
        <!-- Alternate Blockquote Section Start -->
        <div class="col-md-6">
            <h3 class="text-danger">Alternate displays</h3>
            <blockquote class="blockquote-reverse">
                <h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</h5>
                <div class="foot">Someone famous in
                    <cite title="Source Title">Source Title</cite>
                </div>
            </blockquote>
        </div>
        <!-- //Alternate Blockqoute Section End -->
    </div>
    <!-- //Blockquote Section End -->
    <!-- Align Section Start -->
    <div class="row">
        <!-- Text-Align Section Start -->
        <div class="col-md-7">
            <h3 class="text-primary">Alignment Text</h3>
            <h4 class="text-left"><b>Left aligned text.</b></h4>
            <p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <h4 class="text-center"><b>Center aligned text.</b></h4>
            <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <h4 class="text-right"><b>Right aligned text.</b></h4>
            <p class="text-right">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            <h4 class="text-justify"><b>Justified text.</b></h4>
            <p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic.</p>
            <h4 class="text-nowrap"><b>No wrap text.</b></h4>
            <textarea class="text-nowrap">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</textarea>
        </div>
        <!-- //Text-Align Section End -->
        <!-- Horizontal description Section Start -->
        <div class="col-md-5">
            <h3 class="text-success">Horizontal description</h3>
            <dl class="dl-horizontal">
                <dt>Description lists</dt>
                <dd>A description list is perfect for defining terms.</dd>
                <dt>Euismod</dt>
                <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit. Donec id elit non mi porta gravida at eget metus.</dd>
                <dt>Malesuada porta</dt>
                <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
                <dt>Felis euismod sempe</dt>
                <dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>
            </dl>
        </div>
        <!-- //Horizontal description Section End -->
    </div>
    <!-- //Align Section End -->
    <!-- Default Text Section Start -->
    <div class="row marg-btm10">
        <!-- Marked Teaxt Section Start -->
        <div class="col-md-4">
            <h3 class="text-danger">Marked text</h3> You can use the mark tag to
            <mark>highlight</mark> text.
        </div>
        <!-- //Marked Teaxt Section Start -->
        <!-- Deleted text Section Start -->
        <div class="col-md-4">
            <h3 class="text-warning">Deleted text</h3>
            <del>This line of text is meant to be treated as deleted text.</del>
        </div>
        <!-- //Deleted text Section End -->
        <!-- Inserted text Section Start -->
        <div class="col-md-4">
            <h3 class="text-primary">Inserted text</h3>
            <ins>This line of text is meant to be treated as an addition to the document.</ins>
        </div>
        <!-- //Inserted text Section End -->
    </div>
    <!-- //Default Text Section End-->
</div>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
@stop
