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
                        Create Person
                    </h4>
                </div>
                <div class="panel-body">
{{--                    {!! Form::open(array('url' => URL::to('admin/vm/create'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}--}}
                    {!! BootForm::horizontal() !!}
                        <div class="col-sm-12 col-md-8">
                            {!! BootForm::text('first_name', "First Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::text('last_name', "Last Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::email('email', "Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                            {!! BootForm::select('job_title', "Job Title",
                                $person_positions, null, array('maxlength'=> 32, 'required' => 'required')) !!}

                            {!! BootForm::text('institution', "Institution", null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                            {!! BootForm::select('institution_type', "Institution Type",
                                $person_institution_types, 0, array( 'maxlength'=> 256, 'required' => 'required')) !!}

                            {!! BootForm::text('department', "Department", null, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                            {!! BootForm::text('pi', "PI", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}

                            {!! BootForm::text('address1', "Address Line 1", null, array('class' => 'input-lg', 'maxlength'=> 128, 'required' => 'required'))!!}
                            {!! BootForm::text('address2', "Address Line 2", null, array('class' => 'input-lg', 'maxlength'=> 128))!!}
                            {!! BootForm::text('address3', "Address Line 3", null, array('class' => 'input-lg', 'maxlength'=> 128))!!}
                            {!! BootForm::text('city', "City", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                            {!! BootForm::text('state_province', "State or Province", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                            {!! BootForm::text('zip_code', "Zip Code", null, array('class' => 'input-lg', 'maxlength'=> 32, 'required' => 'required'))!!}
                            {!! BootForm::text('country', "Country", null, array('class' => 'input-lg', 'maxlength'=> 64, 'required' => 'required'))!!}
                            {!! BootForm::select('time_zone_id', "Time Zone",
                                $timezones_for_select, 169, array('required' => 'required')) !!}
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
