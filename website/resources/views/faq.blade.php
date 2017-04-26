@extends('layouts.default')

{{-- Page title --}}
@section('title')
    FAQ
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
        <style type="text/css">
            div.container{

            }
        </style>
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
                    @if(!empty($all_faqs))
                        @foreach ($all_faqs as $faq)
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
                        @endforeach
                    @endif
                    {{-- original faqs --}}

                </div>
            </div>
            <div class="col-md-3">
                <p class="lead">Useful Links</p>
                <div class="list-group">
                    <a href="{{ URL::to('documentation') }}"class="list-group-item">Documentation</a>
                    <a href="{{ URL::to('licensing') }}"class="list-group-item">Licensing</a>
                    <a href="{{ URL::to('nihresources') }}"class="list-group-item">NIH Biomedical Technology Resources</a>

                    {{--<a href="#" class="list-group-item active">Printable</a>
                    <a href="#" class="list-group-item">Cupcake Wrappers</a>
                    <a href="#" class="list-group-item">Authentic Dragon Bones</a>--}}
                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script>
        $(document).ready(function () {

            /*$('div#modal').dialog({ autoOpen: false })
            $('#thelink').click(function(){ $('div#thedialog').dialog('open'); });
*/
            $('a.btn-yes, a.btn-no').on('click', function (e) {
                e.preventDefault();
                $('#success_msg').html('Thanks for your feedback.');
                show_alert('success');

                /*var m = $('#thanks_modal');
                m.modal();*/
            })
        })


        $('.carousel').carousel({
            interval: 3000
        })
    </script>
@stop
