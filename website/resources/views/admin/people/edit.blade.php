@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    Edit VM
    @parent
@stop

{{-- Content --}}
@section('content')
    <section class="content-header">
        <h1>
            Edit VM
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-fw fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li> People</li>
            <li class="active"> Edit Person</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary ">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                            Edit Person
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! BootForm::horizontal(array('model'=>$person, 'store'=>'person.store', 'update'=>'person.update')) !!}
                        <div class="col-sm-12 col-md-8">
                            {!! BootForm::text('first_name', "First Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::text('last_name', "Last Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::email('email', "Preferred Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                            {!! BootForm::email('email_institution', "Institutional Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                            {!! BootForm::select('job_title', "Job Title",
                                $person_positions, null, array('maxlength'=> 32, 'required' => 'required')) !!}

                            {!! BootForm::text('institution', "Institution", $person->institution()->get()->first()->name, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
                            {!! BootForm::select('institution_type', "Institution Type",
                                $person_institution_types, $person_institution_type_number, array( 'maxlength'=> 256, 'required' => 'required')) !!}

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
                        {!! BootForm::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- row-->
    </section>

@stop