@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Workshop
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
        <style type="text/css">
            .table-borderless td,
            .table-borderless th {
                border: 0 !important;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    @stop

    {{-- Page content --}}
    @section('content')
    <!-- Container Section Start -->
    <div class="container">
        <div class="page-header">
            <h1>Workshops</h1>
        </div>
        {{-- Upcoming workshops --}}
        <div class="row">
            @if($person == null)
                <div class="alert alert-info text-center">Please <a href="login"><b>sign in</b></a> / <a href="register"><b>Sign up</b></a> first to register for workshops.</div>
            @endif
            <div class="welcome">
                <h3 class="text-left">Upcoming workshops</h3>
            </div>
            <div class="row">
                <div class="alert alert-success hidden" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success! </strong>
                    <span id="success_msg"></span>
                </div>

                <div class="alert alert-danger hidden" id="error-alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error! </strong>
                    <span id="error_msg"></span>
                </div>
            </div>
            <div class="row"><br>
                @forelse($upcoming_workshops as $workshop)
                    {!! BootForm::open(array('url' => URL::to('register_person_workshop'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>{!! $workshop->title !!}</h4>
                            </div>
                            <div class="panel-body">
                                <p>
                                    @if(date('d', strtotime($workshop->start_date)) == date('d', strtotime($workshop->end_date)))
                                        {!! date('F d, Y', strtotime($workshop->start_date))  !!}
                                    @else
                                        {!! date('F d, Y - ', strtotime($workshop->start_date)) !!}
                                        {!! date('F d, Y', strtotime($workshop->end_date)) !!}
                                    @endif
                                    <br>
                                    {!! $workshop->location !!}<br>
                                    @if($workshop->url)
                                    <a href="{!! $workshop->url !!}" target="_blank">More infomation</a>
                                    @endif
                                </p>
                                {{-- checking whether the user is already registered --}}
                                @if($person != null)
                                    <button
                                        @foreach($person->classification as $group)
                                            @if($group->name == $workshop->name)
                                            disabled
                                            @endif
                                        @endforeach
                                        name="register" class="btn btn-warning btn_register_workshop" data-workshop="{!! $workshop->name !!}" value="{!! $workshop->name !!}">
                                        Register
                                    </button>
                                @endif
                                {{-- csrf token --}}
                                <input type="hidden" name="_token" id="user_csrf_token" value="{!! csrf_token() !!}" />
                            </div>
                        </div>
                    </div>
                    {!! BootForm::close() !!}
                @empty
                    <div class="panel col-md-12">
                        <div class="panel-body">
                            <div class="row">
                                <div class="alert alert-info">
                                    <p>Stay tuned for upcoming workshops.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Completed workshops --}}
        <div class="row">
            <div class="welcome">
                <h3 class="text-left">Completed workshops</h3>
            </div>
            <div class="row"><br>
                @forelse($completed_workshops as $workshop)
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading heading">
                                <h4>{!! $workshop->title !!}</h4>
                            </div>
                            <div class="panel-body">
                                <p>
                                    @if(date('d', strtotime($workshop->start_date)) == date('d', strtotime($workshop->end_date)))
                                        {!! date('F d, Y', strtotime($workshop->start_date))  !!}
                                    @else
                                        {!! date('F d, Y - ', strtotime($workshop->start_date)) !!}
                                        {!! date('F d, Y', strtotime($workshop->end_date)) !!}
                                    @endif
                                    <br>
                                    {!! $workshop->location !!}<br>
                                    @if($workshop->url)
                                        <a href="{!! $workshop->url !!}" target="_blank">More information</a>
                                    @endif

                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="panel col-md-12">
                        <div class="panel-body">
                            <div class="row">
                                <div class="alert alert-info">
                                    <p>Stay tuned for completed workshops.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/custom_js/datatables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/custom_js/workshops.js') }}"></script>
@stop
