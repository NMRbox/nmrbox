@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Create New User
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/validation/dist/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/iCheck/skins/minimal/blue.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/select2/select2.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/select2/select2-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/custom_css/addnew_user.css') }}" rel="stylesheet">
@stop


{{-- Page content --}}
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add New User</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>Users</li>
            <li>
                <a href="{{ route('users.create') }}">Add New User</a>
            </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-fw fa-users"></i>
                            Add New User
                        </h3>
                                    <span class="pull-right">
                                        <i class="fa fa-fw fa-times removepanel clickable"></i>
                                        <i class="fa fa-fw fa-chevron-up clickable"></i>
                                    </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <div class="position-center">
                            @if($errors->has())
                                @foreach ($errors->all() as $error)
                                    <div class="text-danger">{{ $error }}</div>
                                @endforeach
                            @endif
                            <div>
                                <h3 class="text-primary">Personal Information</h3>
                            </div>
                            <form role="form" id="tryitForm" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('users.create') }}">
                                {!! Form::token() !!}
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Avatar</label>
                                    <div class="col-lg-6">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="http://placehold.it/200x150" alt="..."></div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                            <div>
                                                            <span class="btn btn-primary btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="pic" id="pic" />
                                                            </span>
                                                <a href="#" class="btn btn-primary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cd-block">
                                    <div class="cd-content">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="first_name">First Name</label>
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-fw fa-user-md text-primary"></i>
                                                                </span>
                                                    <input type="text" placeholder="first name" name="first_name" id="first_name" class="form-control" value="{!! Input::old('first_name') !!}" required="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="last_name">Last Name</label>
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-fw fa-user-md text-primary"></i>
                                                                </span>
                                                    <input type="text" placeholder="last name" name="last_name" id="last_name" class="form-control" value="{!! Input::old('last_name') !!}" required="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="password">Password</label>
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-fw fa-key text-primary"></i>
                                                                </span>
                                                    <input type="password" name="password" placeholder="" id="password" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="password_confirm">Confirm Password</label>
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-fw fa-key text-primary"></i>
                                                                </span>
                                                    <input type="password" name="password_confirm" placeholder=" " id="password_confirm" class="form-control" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label" for="email">Email</label>
                                            <div class="col-lg-6">
                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-fw fa-envelope text-primary"></i>
                                                                </span>
                                                    <input type="text" placeholder="" id="email" name="email" class="form-control" value="{!! Input::old('email') !!}"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="group" class="col-md-2 control-label">Group</label>
                                            <div class="col-md-6">
                                                <select class="form-control " title="Select group..." name="group" id="group" required="">
                                                    <option value="">Select</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" @if($role->id == Input::old('group')) selected="selected" @endif >{{ $role->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{--<div class="form-group">--}}
                                            {{--<label for="activate" class="col-md-2 control-label"> Activate User</label>--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<input id="activate" name="activate" type="checkbox" class="pos-rel p-l-30" value="1" @if(Input::old('activate')) checked="checked" @endif  >--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="form-group">--}}
                                            {{--<div class="col-lg-offset-2 col-lg-10">--}}
                                                {{--<input type="submit" class="btn btn-primary" name="save" value="Save" />--}}
                                                {{--<a href="{{ URL::previous() }}" class="btn btn-default" role="button">Cancel</a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--main content end--> </div>
                </div>
            </div>
        </div>
        <!--row end-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/iCheck/icheck.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/validation/dist/js/bootstrapValidator.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('assets/vendors/select2/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/vertical-timeline/js/modernizr.js') }}"></script>
    <script src="{{ asset('assets/js/custom_js/addnew_user.js') }}" type="text/javascript"></script>
@stop