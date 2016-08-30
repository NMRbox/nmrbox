<div class="panel panel-primary ">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
            Edit Category Keywords
        </h4>
    </div>
    <div class="panel-body">
        <div class="col-sm-12 col-md-8">
            {!! BootForm::horizontal(array('model'=>$category, 'store'=>'category.store', 'update'=>'category.update')) !!}
                @foreach ($all_keywords as $keyword)
                    {!! BootForm::hidden($keyword->label, "off", [ ]) !!}
                    {!! BootForm::checkbox($keyword->label, $keyword->label, null, $keyword->present) !!}
                @endforeach
                {!! BootForm::submit('Save') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
</div>
