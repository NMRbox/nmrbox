@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Add/Upload New resource
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_css/fileinput.css') }}" />
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Add/Upload New resource</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="#"> Page</a>
            </li>
            <li class="active"> Add/Upload new resource</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border">
                <div class="panel panel-primary">
                    <div class="panel-heading"><strong>Add/Upload Files</strong></div>
                    <div class="panel-body">

                        <!-- Standar Form -->
                        {{--<form enctype='multipart/form-data' action="" method="post">--}}
                        <form enctype='multipart/form-data' action="" method="post" id="file_upload_form">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="file_name">File label</label>
                                <input type="text" name="label" id="file_name" placeholder="Enter file label. e.g. Document" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="file_slug">File Slug</label>
                                <input type="text" name="slug" id="file_slug" placeholder="Enter file slug. e.g. document (excluding file extension)" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <input id="file-1" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="1">
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

        $("#file-1").fileinput({
            uploadUrl: 'create', // you must set a valid URL here else you will get an error
            /*uploadExtraData: function(previewId, index) {
                var extra_data = {_token:"{{csrf_token()}}", label:$("input[name='label']").val(), slug:$("input[name='slug']").val()};
                return extra_data;
            },*/
            uploadExtraData: function(previewId, index) {
                var extra_data = {_token:"{{csrf_token()}}", data:$("#file_upload_form").serialize()};
                return extra_data;
            },
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            overwriteInitial: false,
            validateInitialCount: true,
            maxFileSize: 1000000,
            maxFileCount: 10,
            minFileCount: 1,
            allowedFileTypes: ['image', 'html', 'text', 'video', 'audio', 'flash', 'object'],
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });

        /*$(".btn-warning").on('click', function () {
            var $el = $("#file-4");
            if ($el.attr('disabled')) {
                $el.fileinput('enable');
            } else {
                $el.fileinput('disable');
            }
        });
        $(".btn-info").on('click', function () {
            $("#file-4").fileinput('refresh', {previewClass: 'bg-info'});
        });*/

    </script>

@stop


