@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit FAQ
@parent
@stop


{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" />
    <style t type="text/css">
        .software-scroll{
            border: none;
            height: 500px;
            overflow-x: scroll;
        }

        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f5f5f5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background: #ccc;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
    </style>
@stop


{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit FAQ
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> FAQs</li>
        <li class="active"> Edit FAQ</li>
    </ol>
</section>

<!-- Main content -->

<!-- row-->
<section class="content ">
    <div class="row">
        <div class="the-box no-border">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Update FAQ</strong></div>
                <div class="panel-body">
                    {!! BootForm::open() !!}
                    <div class="col-sm-12 col-md-12 form-group">
                        {!! BootForm::text('question', "Question", $faq->question, array('placeholder' => 'Enter Question', 'class' => 'input-lg', 'required' => 'required'))!!}
                        {!! BootForm::textarea('answer', "Answer", $faq->answer, array('class' => 'input-lg textarea form-control', 'required' => 'required', 'rows' => '5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"'))!!}
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 text-left software-scroll">
                                <h4>Select Softwares: </h4><hr>
                                @foreach ($all_softwares as $software)
                                    {!! BootForm::hidden('software['.$software->id.']', "off", [ ]) !!}
                                    {!! BootForm::checkbox('software['.$software->id.']', $software->name, null, $software->present) !!}
                                @endforeach
                            </div>
                            <div class="col-md-6 software-scroll">
                                <h4>Select Search Keywords: </h4><hr>
                                @foreach ($all_search_keywords as $keyword)
                                    {!! BootForm::hidden('metadata['.$keyword->id.']', "off", [ ]) !!}
                                    {!! BootForm::checkbox('metadata['.$keyword->id.']', $keyword->metadata, null, $keyword->present) !!}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-capitalize text-left col-md-12">
                        {!! BootForm::submit('Update', array('class' => 'btn btn-block btn-primary ', 'id' => 'update_file_edit')) !!}
                    </div>
                    {!! BootForm::close() !!}

                </div>
            </div>
        </div>
        {{-- test --}}
        <div class="container">

        </div> <!-- /container -->
        {{-- eof test --}}
    </div>
    <!--main content ends-->
</section>



@stop


{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    {{-- WYSING Editor--}}
    <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript" ></script>
    <script type="text/javascript">
        $(document).ready(function() {
            /* defining the editor buttons & tabs*/
            $('.textarea').summernote({
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table', 'hr']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ],
                placeholder: "Enter answer text."
            });
        });
    </script>
@stop