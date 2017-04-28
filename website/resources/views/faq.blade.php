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
                                    </div>
                                    <div class="panel-footer">
                                        <div class="btn-group btn-group-xs"><span class="btn">Was this question useful?</span>
                                            <a class="btn btn-success btn-yes" href="#"><i class="fa fa-thumbs-up"></i> Yes</a>
                                            <a class="btn btn-danger btn-no" href="#"><i class="fa fa-thumbs-down"></i> No</a>
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
            <div class="col-md-3">
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
            // top level msg box
            $('a.btn-yes, a.btn-no').on('click', function (e) {
                e.preventDefault();
                $('#info_msg').html('Thank you for your feedback.');
                show_alert('info');
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
