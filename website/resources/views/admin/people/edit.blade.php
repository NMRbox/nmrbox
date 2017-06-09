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
                        <div class="row">
                            {{--{!! BootForm::open(array('url'=>route('register'), 'class' => 'form ' )) !!}--}}
                            {!! BootForm::open(array('model'=>$person, 'store'=>'person.store', 'update'=>'person.update_profile', 'class' => 'form')) !!}

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('first_name', "First Name", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('last_name', "Last Name", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::email('email_institution', "Email (institutional account)", null, array('class' => 'form-control', 'maxlength'=> 255, 'required' => 'required')) !!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::email('email', "Preferred contact email (if different than institutional email)", null, array('class' => 'form-control', 'maxlength'=> 255)) !!}
                            </div>

                            <div class="form-group col-lg-12">
                                {!! BootForm::select('job_title', "Job Title",
                                        [null=>'Please Select'] + $person_positions, null, array('class' => 'form-control select_pi', 'maxlength'=> 32, 'required' => 'required')) !!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('institution', "Institution", null, array('class' => 'form-control', 'maxlength'=> 256, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::select('institution_type', "Institution Type",
                                        [null=>'Please Select'] + $person_institution_types, null, array('class' => 'form-control', 'maxlength'=> 256, 'required' => 'required')) !!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('department', "Department", null, array('class' => 'form-control', 'maxlength'=> 256, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('pi', "PI", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-12">
                                {!! BootForm::text('address1', "Address Line 1", null, array('class' => 'form-control', 'maxlength'=> 128, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('address2', "Address Line 2", null, array('class' => 'form-control', 'maxlength'=> 128))!!}
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('address3', "Address Line 3", null, array('class' => 'form-control', 'maxlength'=> 128))!!}
                            </div>

                            <div class="form-group col-lg-12">
                                {!! BootForm::text('city', "City", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-6">
                                {{--{!! BootForm::text('state_province', "State or Province", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}--}}
                                <label for="state_province" class="control-label">State or Province</label>
                                <div class="form-group">
                                    <select name='state_province' class="form-control" id="ct" data-show-default-option="true" data-default-option="Select State or Province" data-default-value="Connecticut" required></select>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                {!! BootForm::text('zip_code', "Zip Code", null, array('class' => 'form-control', 'maxlength'=> 32, 'required' => 'required'))!!}
                            </div>

                            <div class="form-group col-lg-12">
                                {{--{!! BootForm::text('country', "Country", null, array('class' => 'form-control', 'maxlength'=> 64, 'required' => 'required'))!!}--}}
                                <label for="country" class="control-label">Country</label>
                                <div class="form-group">
                                    <select name='country' class="crs-country form-control" data-region-id="ct" data-default-value-option="true" data-default-value="United States" required></select>
                                </div>
                            </div>

                            <div class="form-group col-lg-12">
                                {!! BootForm::select('time_zone_id', "Time Zone",
                                        $timezones_for_select, 169, array('required' => 'required')) !!}
                            </div>

                            <div class="form-group col-lg-12">
                                {!! BootForm::submit('Register', array('class'=>'btn btn-primary btn-lg btn-block ')) !!}
                            </div>

                            {!! BootForm::close() !!}
                        </div>
                        {{--{!! BootForm::horizontal(array('model'=>$person, 'store'=>'person.store', 'update'=>'person.update')) !!}
                        <div class="col-sm-12 col-md-8">
                            {!! BootForm::text('first_name', "First Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::text('last_name', "Last Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::email('email', "Preferred Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                            {!! BootForm::email('email_institution', "Institutional Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
                            {!! BootForm::select('job_title', "Job Title",
                                $person_positions, $person_positions, array('maxlength'=> 32, 'required' => 'required', 'selected' => 'selected')) !!}

                            {!! BootForm::text('institution', "Institution", $person->institution()->get()->first()->name, array('class' => 'input-lg', 'maxlength'=> 256, 'required' => 'required'))!!}
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
                            {!! BootForm::submit('Update profile') !!}
                        </div>
                        {!! BootForm::close() !!}--}}
                    </div>
                </div>
            </div>
        </div>
        <!-- row-->
    </section>

@stop


{{-- page level scripts --}}
@section('footer_scripts')
    {{-- Country/state list script --}}
    <script type="text/javascript" src="{{ asset('assets/vendors/country-region-list/jquery.crs.min.js') }}"></script>
@stop
