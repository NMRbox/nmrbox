@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit Category
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit Category
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Categories</li>
        <li class="active"> Edit Category</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Edit Category
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal(array('model'=>$category, 'store'=>'category.store', 'update'=>'category.update')) !!}
                    <div class="col-sm-12 col-md-8">
                        {!! BootForm::text('name', "Name", $category->name, array('class' => 'input-lg', 'required' => 'required'))!!}
                    </div>
                    <div class="col-md-8">
                        <div class="col-md-12 col-md-push-3"><h4>Select Keywords: </h4><hr></div>
                        @foreach ($all_keywords as $keyword)
                            {!! BootForm::hidden($keyword->id, "off", [ ]) !!}
                            {!! BootForm::checkbox($keyword->id, $keyword->label, null, $keyword->present) !!}
                        @endforeach
                    </div>
                    {!! BootForm::submit('Save') !!}
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
    <div class="row">
        <div class="col-lg-12">
            {{--@include('admin.categories.category_keywords')--}}
        </div>
    </div>
    <!-- row-->


</section>

@stop