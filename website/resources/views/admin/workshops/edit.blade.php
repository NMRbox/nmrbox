@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit Workshop
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit Workshop
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Workshop</li>
        <li class="active"> Edit Workshop</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Edit Workshop
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal(array('model'=>$workshop, 'store'=>'workshop.store', 'update'=>'workshop.update')) !!}
                    <div class="col-sm-12 col-md-10">
                        {!! BootForm::horizontal() !!}

                        <div class="col-sm-12 col-md-10">
                            {{--{!! BootForm::text('name', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}--}}
                            {{--{!! BootForm::select('name', 'Name', $classifications, null, array('class' => 'input-lg'))!!}--}}
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2 col-md-3">Name</label>
                                <div class="col-sm-3 col-md-9">
                                    <select class="form-control input-lg" id="name" name="name" required>
                                        <option value=""> Select workshop classification</option>
                                        @foreach($classifications as $classification)
                                            @if($classification->name == $workshop->name)
                                                <option value="{!! $classification->name !!}" selected = 'selected'>{!! $classification->name !!}</option>
                                            @else
                                                <option value="{!! $classification->name !!}">{!! $classification->name !!}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {!! BootForm::text('title', "Title", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::date('start_date', "Start Date", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::date('end_date', "End Date", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::text('url', "URL", null, array('class' => 'input-lg'))!!}
                            {!! BootForm::textarea('location', "Location", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::textarea('attendance_max', "Max Attendance", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::submit('Save') !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <h3>Registered users list: </h3>
                </div>
                <div class="panel-body table_fluid">
                    <table id="vm-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="20%">ID</th>
                            <th>Fullname</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($workshop_classification->person as $user)
                                <tr>
                                    <td>{!! $user->id !!}</td>
                                    <td>{!! $user->first_name !!} &nbsp;{!! $user->last_name !!}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        <h4> No users registered yet. </h4>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</section>
@stop


{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="application/javascript">

    </script>
@stop