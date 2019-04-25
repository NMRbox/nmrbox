@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Add Classification :: @parent
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Add Classification
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Classification Listings</li>
        <li class="active">
            Add a classification
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
                        Create A Classification
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal() !!}
                        <div class="col-sm-12 col-md-8">
                            {!! BootForm::text('name', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::text('definition', "Definition", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::select('web_role', 'Web Role', array('true' => 'True', 'false' => 'False'), 'false', array('class' => 'input-lg'))!!}
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

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
@stop
