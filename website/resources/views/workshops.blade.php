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
            <div class="row"><br>
                @forelse($upcoming_workshops as $workshop)
                    {!! BootForm::open(array('url' => URL::to('register_person_workshop'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
                    {{--{!! Form::open() !!}--}}
                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                {!! $workshop->title !!}
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
                                    <a href="{!! $workshop->url !!}" target="_blank">Program flyer</a> <br>
                                    register by email to:&nbsp;<a href="mailto:workshop@nmrbox.org">workshop@nmrbox.org</a>
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
                            </div>
                        </div>
                    </div>
                    {!! BootForm::close() !!}
                @empty
                    <div class="panel col-md-12">
                        <div class="panel-body">
                            <p>Stay tuned for upcoming workshops update. Thank you.</p>
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
                    {!! BootForm::open(array('url' => URL::to('register_person_workshop'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
                    {{--{!! Form::open() !!}--}}
                    <div class="col-md-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                {!! $workshop->title !!}
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
                                    <a href="{!! $workshop->url !!}" target="_blank">Program flyer</a> <br>
                                    register by email to:&nbsp;<a href="mailto:workshop@nmrbox.org">workshop@nmrbox.org</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    {!! BootForm::close() !!}
                @empty
                    <div class="panel col-md-12">
                        <div class="panel-body">
                            <p>Stay tuned for workshops update. Thank you.</p>
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
    <script src="{{ asset('assets/js/custom_js/datatables.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* register for workshop */
            $('button.btn_register_workshop').on('click', function(e){
                e.preventDefault();

                /* workshop name*/
                var name = $(this).attr('data-workshop');

                /* ajax request for workshop register */
                $.ajax({
                    type: "POST",
                    url: 'register_person_workshop',
                    data: 'name=' + name + '&_token=' + $('input#user_csrf_token').val(),
                    dataType: 'json',
                    success: function(response) {
                        $('#success_msg').html(response.message);
                        show_alert('success');
                    },
                    error: function (response) {
                        $('#error_msg').html(" You already have been registered for this workshop.");
                        show_alert('error');
                    }
                })

            });

        })



    </script>
@stop
