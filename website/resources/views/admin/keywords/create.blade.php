@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Add Keyword :: @parent
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Add Keyword
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Keywords</li>
        <li class="active">
            Add Keyword
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
                        Create Keyword
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal() !!}
                        <div class="col-sm-12 col-md-8">
                            {!! BootForm::text('label', "Label (menu item name)", null, array('class' => 'input-lg', 'required' => 'required', 'autofocus' => 'autofocus'))!!}
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
