@extends('layouts.default')

{{-- Page title --}}
@section('title')
Blank
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    
@stop


{{-- Page content --}}
@section('content')
<div class="container">
        <div class="welcome">
            <h3>Welcome to Chandra</h3>
            <h4 class="text-dark ">Professional html Template Perfect for Admin Dashboard</h4>
        </div>
        <div class="row">
            <h3>Write your content here</h3>
        </div>
        <div style="height:500px;"></div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    @stop
