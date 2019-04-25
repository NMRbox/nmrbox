@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit Keywords
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit Keywords
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Keywords</li>
        <li class="active"> Edit Keyword</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Edit Keyword
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal(array('model'=>$keyword, 'store'=>'keyword.store', 'update'=>'keyword.update')) !!}
                    <div class="col-sm-12 col-md-8">
                        {!! BootForm::text('label', "Label (menu item name)", null, array('class' => 'input-lg', 'required' => 'required'))!!}
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