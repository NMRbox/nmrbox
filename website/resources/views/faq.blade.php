@extends('layouts.default')

{{-- Page title --}}
@section('title')
    FAQ
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
            <h1>FAQ -
                <small>Frequently Asked Questions</small>
            </h1>
        </div>
        <div class="row">
            <div id="faq" class="col-md-9">
                <div class="panel-group" id="accordion">
                    {{-- Search input field --}}
                    <div class="form-group panel-heading">
                        <input type="text" class="form-control input-lg" id="faqSearchField" placeholder="Have a question? Enter a search term here.">
                    </div>

                    {{-- FAQ listings --}}
                    <table class="table table-borderless display" id="vm-table">
                        <thead>
                        <tr><th></th></tr>
                        </thead>
                        <tbody>
                        @if(!empty($all_faqs))
                            @foreach ($all_faqs as $faq)
                            <tr>
                                <td>

                                <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                           href="{!! '#'.$faq->id !!}">
                                            Q:&nbsp;{!! $faq->question !!}
                                        </a>
                                    </h4>
                                </div>
                                <div id="{!! $faq->id !!}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <h5><span class="label label-primary">Answer</span></h5>
                                        <p>
                                            {!! html_entity_decode($faq->answer) !!}
                                        </p>

                                        <div class="hidden" id="box-{!! $faq->id !!}">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    Feedback box
                                                </div>
                                                <div class="panel-body">
                                                    <div class="text-right">
                                                        {{--<form class="form" id="faqForm">--}}
                                                        {!! Form::open(array('class' => 'faqForm')) !!}
                                                            {!! Form::text('feedback_'.$faq->id, null, array('class' => 'input-lg col-md-12 form-group', 'id' => 'feedback_'.$faq->id, 'placeholder'=>'Your comments')) !!}
                                                            {!! Form::hidden('faq-id_'.$faq->id, $faq->id, array('id' => 'faq-id_'.$faq->id)) !!}
                                                            {!! Form::hidden('voteup_'.$faq->id, 0, array('id' => 'voteup_'.$faq->id)) !!}
                                                            <br><br>
                                                            <button class="btn btn-primary submit_feedback" value="feedback-submit" id="submit_feedback_{!! $faq->id !!}" data-id="{!! $faq->id !!}">Submit Feedback</button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="btn-group btn-group-xs"><span class="btn">Was this question useful?</span>
                                            <a class="btn btn-success btn-yes" href="#" data-id="{!! $faq->id !!}" data-value="true"><i class="fa fa-thumbs-up"></i> Yes</a>
                                            <a class="btn btn-danger btn-no" href="#" data-id="{!! $faq->id !!}" data-value="false"><i class="fa fa-thumbs-down"></i> No</a>
                                            <input type="hidden" name="_token" id="user_csrf_token" value="{!! csrf_token() !!}" />
                                        </div>
                                        {{--<div class="btn-group btn-group-xs pull-right"><a class="btn btn-primary" href="#">Report this question</a></div>--}}
                                    </div>
                                </div>
                                </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-md-3" style="padding-top: 10px;">
                <div class="panel panel-default">
                    <div class="panel-heading">Useful Links</div>
                    <div class="panel-body list-group">
                        <a href="{{ URL::to('documentation') }}"class="list-group-item">Documentation</a>
                        <a href="{{ URL::to('licensing') }}"class="list-group-item">Licensing</a>
                        <a href="{{ URL::to('nihresources') }}"class="list-group-item">NIH Biomedical Technology Resources</a>
                    </div>
                </div>
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

             /* Thumbs up feedback */
            $('a.btn-yes').on('click', function (e) {
                e.preventDefault();
                // faq id
                var id = $(this).attr('data-id');
                var vote = $(this).attr('data-value');
                console.log(id);
                /* ajax request for FAQ ratings */
                $.ajax({
                    type: "POST",
                    url: 'faq-ratings',
                    data: 'id=' + id +'&vote=' + vote +'&_token=' + $('input#user_csrf_token').val(),
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.message);
                        $('#success_msg').html(response.message);
                        show_alert('success');
                    },
                    error: function (response) {
                        console.log(response.message);
                        $('#error_msg').html("Sorry! Your feedback for this FAQ already received. Thank you.");
                        show_alert('error');
                    }
                })

            });

            // top level msg box
            $('a.btn-no').on('click', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $('#box-'+id).toggleClass('hidden');
                //$('#faqForm').append('<input type="hidden" name="faq-id" value='+ id +' id="faq-id">');
            });

            /* Thumbs down feedback */
            $('button.submit_feedback').on('click', function (e) {
                e.preventDefault();
                var faq_id = $(this).attr('data-id');

                // faq id
                var id = $('#faq-id_'+faq_id).val();
                var vote = $('#voteup_'+faq_id).val();
                var comment = $('#feedback_'+faq_id).val();

                /* ajax request for FAQ ratings */
                $.ajax({
                    type: "POST",
                    url: 'faq-ratings',
                    data: 'id=' + id +'&vote=' + vote +'&comment=' + comment +'&_token=' + $('input#user_csrf_token').val(),
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.message);
                        $('#box-'+id).toggleClass('hidden');
                        $('#success_msg').html(response.message);
                        show_alert('success');
                    },
                    error: function (response) {
                        console.log(response.message);
                        $('#box-'+id).toggleClass('hidden');
                        $('#error_msg').html("Sorry! Your feedback for this FAQ already received. Thank you. ");
                        show_alert('error');
                    }
                })


            });

            // initiating accordion carousel for collapse/hide
            $('.carousel').carousel({
                interval: 3000
            });


            /* Initializing Datatable for search option*/
            var faq_table = $('#vm-table').DataTable({
                paging: false,
                ordering: false,
                responsive: true,
                "bFilter": true,
                "sDom": 't'

            });

            $('#faqSearchField').on('keyup change', function(){
                faq_table.search($(this).val()).draw();
            })


        })



    </script>
@stop
