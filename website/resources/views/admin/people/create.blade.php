@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Add Person :: @parent
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Add Person
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
            Add Person
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
                            {!! BootForm::text('name', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::email('email', "Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                            {!! BootForm::text('institution', "Institution", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                            {!! BootForm::text('nmrbox_acct', "NMRbox Account Number", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
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
