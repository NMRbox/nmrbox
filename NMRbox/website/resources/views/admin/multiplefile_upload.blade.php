@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Multiple File Upload @parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/jQuery-File-Upload/css/jquery.fileupload.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/jQuery-File-Upload/css/jquery.fileupload-ui.css') }}" />
    @stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <h1>Multiple File Upload</h1>

                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>Gallery</li>
                        <li>
                            <a href="multiplefile_upload">Multiple File Upload</a>
                        </li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- First Basic Table strats here-->
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-eye"></i>
                                        Uplaod Multiple Files
                                    </h3>
                                </div>
                                <div class="panel-body" style="padding:30px;">
                                    <div class="row">

                                        <p>
                                            File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview images, audio and video for jQuery.
                                            <br>
                                            Supports cross-domain, chunked and resumable file uploads and client-side image resizing.
                                            <br>
                                            Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.
                                        </p>

                                        <form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
                                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                            <noscript>
                                                <input type="hidden" name="redirect" value=""></noscript>
                                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                            <div class="row fileupload-buttonbar">
                                                <div class="col-lg-7">
                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                    <span class="btn btn-success fileinput-button">
                                                        <i class="icon ion-plus qwe" data-pack="default" data-tags="add, include, new, invite, +"></i>
                                                        <span>Add files...</span>
                                                        <input type="file" name="files[]" multiple></span>
                                                    <button type="submit" class="btn btn-primary start">
                                                        <span>Start upload</span>
                                                    </button>
                                                    <button type="reset" class="btn btn-warning cancel">
                                                        <i class="icon ion-ios7-close qwe" data-pack="ios7" data-tags="delete, remove, trash, end, stop, x"></i>
                                                        <span>Cancel upload</span>
                                                    </button>
                                                    <button type="button" class="btn btn-danger delete">
                                                        <i class="icon ion-ios7-trash qwe" data-pack="ios7" data-tags="delete, remove, dispose, waste, basket, dump, kill"></i>
                                                        <span>Delete</span>
                                                    </button>
                                                    <input type="checkbox" class="toggle">
                                                    <!-- The global file processing state -->
                                                    <span class="fileupload-process"></span>
                                                </div>
                                                <!-- The global progress state -->
                                                <div class="col-lg-5 fileupload-progress fade">
                                                    <!-- The global progress bar -->
                                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                    </div>
                                                    <!-- The extended global progress state -->
                                                    <div class="progress-extended">&nbsp;</div>
                                                </div>
                                            </div>
                                            <!-- The table listing the files available for upload/download -->
                                            <table role="presentation" class="table table-striped">
                                                <tbody class="files"></tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>
                <!-- /.content --> @stop
{{-- page level scripts --}}
@section('footer_scripts')
        <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="fa fa-fw fa-eye"></i>
                    <span>Start</span>
                </button>
                {% } %} {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="icon ion-ios7-close qwe" data-pack="ios7" data-tags="delete, remove, trash, end, stop, x"></i>
                    <span>Cancel</span>
                </button>
                {% } %}
            </td>
        </tr>
        {% } %}
    </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade">
            <td>
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
                        <img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                </span>
            </td>
            <td>
                <p class="name">
                    {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a>
                    {% } else { %}
                    <span>{%=file.name%}</span>
                    {% } %}
                </p>
                {% if (file.error) { %}
                <div>
                    <span class="label label-danger">Error</span>{%=file.error%}</div>
                {% } %}
            </td>
            <td>
                <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td>
                {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}' {% } %}>
                    <i class="icon ion-ios7-trash qwe" data-pack="ios7" data-tags="delete, remove, dispose, waste, basket, dump, kill"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">{% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="icon ion-ios7-close qwe" data-pack="ios7" data-tags="delete, remove, trash, end, stop, x"></i>
                    <span>Cancel</span>
                </button>
                {% } %}
            </td>
        </tr>
        {% } %}
    </script>
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/vendor/jquery.ui.widget.js') }}" type="text/javascript"></script>
        <!-- The Templates plugin is included to render the upload/download listings -->
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/tmpl.min.js') }}" type="text/javascript"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/load-image.min.js') }}" type="text/javascript"></script>
        <!-- The basic File Upload plugin -->
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/jquery.fileupload.js') }}" type="text/javascript"></script>
        <!-- The File Upload processing plugin -->
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/jquery.fileupload-process.js') }}" type="text/javascript"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/jquery.fileupload-image.js') }}" type="text/javascript"></script>
        <!-- The File Upload user interface plugin -->
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/jquery.fileupload-ui.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/vendors/jQuery-File-Upload/js/main.js') }}" type="text/javascript"></script>
        @stop