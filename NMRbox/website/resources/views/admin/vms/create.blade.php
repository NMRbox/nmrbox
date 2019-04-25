@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Create VM :: @parent
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Create VM
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Blog Categories</li>
        <li class="active">
             Create VM
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
                        Create VM
                    </h4>
                </div>
                <div class="panel-body">
{{--                    {!! Form::open(array('url' => URL::to('admin/vm/create'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}--}}
                    {!! BootForm::horizontal() !!}
                        <div class="col-sm-12 col-md-8">
{{--                            {!! Form::text('title', null, array('class' => 'form-control', 'placeholder'=>'Category name')) !!}--}}
{{--                            {!! BootForm::number('major', "Major Version Number", "", array('class' => 'input-lg', 'required' => 'false', 'placeholder'=>'integer'))!!}--}}
                            {!! BootForm::number('major', "Major Version Number", null, array('class' => 'input-lg', 'required' => 'required', 'placeholder' => 'eg. 4'))!!}
                            {!! BootForm::number('minor', "Minor Version Number", null, array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'eg. 2'))!!}
                            {!! BootForm::number('variant', "Variant Number", null, array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'eg. 1'))!!}
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
