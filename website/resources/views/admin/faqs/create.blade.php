@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Add FAQ :: @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" media="screen" type="text/css" />
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Add FAQ
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> People</li>
        <li class="active">
            Add a FAQ
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        <strong>Create A New FAQ</strong>
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::open() !!}
                        <div class="col-sm-12 col-md-12">
                            {!! BootForm::text('question', "Question", null, array('placeholder' => 'Enter Question', 'class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::textarea('answer', "Answer", null, array('class' => 'input-lg textarea form-control note-placeholder', 'required' => 'required', 'rows' => '5', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"'))!!}
                            {!! BootForm::submit('Save', array('class' => 'input-lg btn btn-block btn-primary ')) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
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
                placeholder: 'Enter Answer text. ',
            });
        });
    </script>
@stop
