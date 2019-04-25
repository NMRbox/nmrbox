@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit Search Keyword
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit Search Keyword
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Search Keyword</li>
        <li class="active"> Edit Search Keyword</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Edit Search Keyword
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal(array('model'=>$search_keyword, 'store'=>'search_keyword.store', 'update'=>'search_keyword.update')) !!}
                    <div class="col-sm-12 col-md-10">
                        {!! BootForm::text('metadata', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                        {!! BootForm::submit('Save', array('class' => 'input-lg btn btn-block btn-primary', )) !!}
                    </div>
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
@stop


{{-- Body Bottom confirm modal --}}
@section('footer_scripts')

@stop