@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit FAQ
@parent
@stop


{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_css/fileinput.css') }}" />
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
                        {!! BootForm::text('question', "Question", $faq->question, array('class' => 'input-lg', 'required' => 'required'))!!}
                        {!! BootForm::textarea('answer', "Answer", $faq->answer, array('class' => 'input-lg', 'required' => 'required'))!!}

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <h4>Select Keywords: </h4><hr>
                                @foreach ($all_keywords as $keyword)
                                    {!! BootForm::hidden('keyword['.$keyword->id.']', "off", [ ]) !!}
                                    {!! BootForm::checkbox('keyword['.$keyword->id.']', $keyword->name, null, $keyword->present) !!}
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h4>Select Metadata: </h4><hr>
                                {{--@foreach ($all_metadata as $metadata)
                                    {!! BootForm::hidden('metadata['.$metadata->id.']', "off", [ ]) !!}
                                    {!! BootForm::checkbox('metadata['.$metadata->id.']', $metadata->metadata, null, $metadata->present) !!}
                                @endforeach--}}
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
@stop