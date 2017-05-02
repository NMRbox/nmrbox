@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Edit File
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_css/fileinput.css') }}" />
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


{{-- Page content --}}
@section('content')
<section class="content-header">
    <!--section starts-->
    <h1>Edit File</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Home
            </a>
        </li>
        <li>
            <a href="#">File</a>
        </li>
        <li class="active">Edit File</li>
    </ol>
</section>
<!--section ends-->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="the-box no-border">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>File info of - {!! $file->label !!}</strong></div>
                <div class="panel-body">

                    <!-- Standar Form -->
                    <form enctype='multipart/form-data' action="" method="post" id="file_edit_form">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <div class="row">

                                <h3></h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Label</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{!! $file->label !!}</td>
                                            <td>{!! $file->name !!}</td>
                                            <td>{!! $file->slug !!}</td>
                                            <td>{!! $file->mime_type !!}</td>
                                            <td>{!! round(($file->size/1024)/1024, 2) !!} MB (aprox.)</td>
                                            <td><a href="{!! URL::to('admin/files/' . $file->slug ) !!}" target="_blank" class="btn btn-success">Preview</a></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="file_name">File label</label>
                            <input type="text" name="label" id="file_name" placeholder="Enter file label" class="form-control">
                        </div>
                        <div class="form-group">
                            <input id="file-1" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="1">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 software-scroll">
                                    <h4>Select Search Keywords: </h4><hr>
                                    @foreach ($all_search_keywords as $keyword)
                                        {!! BootForm::hidden('metadata['.$keyword->id.']', "off", [ ]) !!}
                                        {!! BootForm::checkbox('metadata['.$keyword->id.']', $keyword->metadata, null, $keyword->present) !!}
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="form-group text-capitalize text-center">
                            {!! BootForm::submit('Update', array('class' => 'btn btn-block btn-primary ', 'id' => 'update_file_edit')) !!}
                        </div>


                    </form>
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
{{-- page level scripts --}}
@section('footer_scripts')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom_js/files_index.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom_js/fileinput.js') }}" type="text/javascript"></script>
    <script type="application/javascript">

        var file_upload = $("#file-1").fileinput({
            uploadUrl: 'edit', // you must set a valid URL here else you will get an error
            uploadExtraData: function(previewId, index) {
                var extra_data = {_token:"{{csrf_token()}}", data:$("#file_edit_form").serialize()};
                return extra_data;
            },
            overwriteInitial: false,
            validateInitialCount: true,
            maxFileSize: 1000000,
            maxFileCount: 1,
            minFileCount: 1,
            allowedFileTypes: ['image', 'html', 'text', 'video', 'audio', 'flash', 'object'],
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });

        // Updating all the input and passing to controller
        $('#update_file_edit').on('click', function(e){
            e.preventDefault();
            file_upload.fileinput('upload');
        });


        $(".btn-warning").on('click', function () {
            var $el = $("#file-4");
            if ($el.attr('disabled')) {
                $el.fileinput('enable');
            } else {
                $el.fileinput('disable');
            }
        });
        $(".btn-info").on('click', function () {
            $("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
        });

    </script>

@stop