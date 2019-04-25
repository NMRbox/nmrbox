@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit Lab Role
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit Lab Role
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Blog Categories</li>
        <li class="active"> Edit Lab Role</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Edit Lab Role
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal(array('model'=>$lab_role, 'store'=>'lab_role.store', 'update'=>'lab_role.update')) !!}
                    <div class="col-sm-12 col-md-8">
                        {!! BootForm::text('name', "Lab Role Name", null, array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'eg. 1'))!!}
                        {!! BootForm::submit('Save') !!}
                    </div>
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>

@stop