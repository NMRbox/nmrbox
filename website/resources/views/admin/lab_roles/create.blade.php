@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Create Lab Role :: @parent
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Create Lab Role
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Lab Roles</li>
        <li class="active">
             Create Lab Role
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
                        Create Lab Role
                    </h4>
                </div>
                <div class="panel-body">
{{--                    {!! Form::open(array('url' => URL::to('admin/vm/create'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}--}}
                    {!! BootForm::horizontal() !!}
                        <div class="col-sm-12 col-md-8">
{{--                            {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>'Category name')) !!}--}}
{{--                            {!! BootForm::number('major', "Major Version Number", "", array('class' => 'input-lg', 'required' => 'false', 'placeholder'=>'integer'))!!}--}}
                            {!! BootForm::text('name', "Lab Role Name", null, array('class' => 'input-lg', 'required' => 'required', 'placeholder' => 'eg. Developer, Researcher, Co-author'))!!}
                            {!! BootForm::submit('Save') !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop
