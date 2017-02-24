@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Registry
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
    @stop


    {{-- Page content --}}
    @section('content')
    <!-- Container Section Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="alert alert-success hidden" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success! </strong>
                <span id="success_msg"></span>
            </div>

            <div class="alert alert-danger hidden" id="error-alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error! </strong>
                <span id="error_msg"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="content">
                    <h1 class="page-header">Software Registry</h1>

                    {{-- Advance search button --}}
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="btn btn-sm btn-default" id="software_registry_search"><span class="glyphicon glyphicon-search"></span> &nbsp; Filter Software Registry</a>
                            <a href="#" class="btn btn-sm btn-default clear_filter_box" id="clear_filters"> Clear Filters</a>
                        </div>
                    </div>

                    {{-- Advance search form --}}
                    <div class="row row-registry" id="search_form">
                        <form class="form form-horizontal col-md-12" method="post" id="soft_reg_search"/>
                        {!! csrf_field() !!}
                            <div class="form_row">
                                <div class="form-group row">
                                    <div class="col-md-5 form_options">
                                        <select name="field[]" class="form-control select_field">
                                            <option value="">-- Select option --</option>
                                            <option value="name">Software Name</option>
                                            <option value="software_category">Software Category</option>
                                            <option value="author_name">Author Name</option>
                                            <option value="vm_version">NMRbox version</option>
                                        </select>
                                    </div>
                                    <div class="form_input_field col-md-5">

                                    </div>
                                    <div class="form_button col-md-2">
                                        <a href="#" class="btn btn-sm btn-info add_now_button" style="display: none;"><span class="glyphicon glyphicon-plus"></span></a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" id="search_button">
                                {{--<div class="col-md-2" id="apply_filters">
                                    <button name="search" value="search" class="btn btn-primary">Apply Filters</button>
                                </div>--}}
                            </div>
                        </form>
                    </div>

                    {{-- Software Registry --}}
                    <div class="row row-registry" id="filter_result">
                        @forelse ($all_software as $software)
                            @if($software->display == true)
                            <div class="col-sm-3 registry-package">
                                <div class="registry-package-wrapper">
                                    <h3>
                                        {{--route("software.edit", array("software"=>$software->slug));--}}
                                        <a href="{{ route('software-page',  ['software' => $software->slug] ) }}">
                                            {{$software->name}}
                                        </a>
                                    </h3>
                                    <p class="description">
                                        {{ $software->synopsis }}
                                    </p>
                                    {{--<span class="usage">Usage: </span>--}}
                                    <a href="#">
                                    </a>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div class="col-md-12">
                                <h2>No software found</h2>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    {{-- Add external script --}}
    <script type="text/javascript" src="{{ asset('assets/js/frontend/software_registry.js') }}"></script>
@stop
