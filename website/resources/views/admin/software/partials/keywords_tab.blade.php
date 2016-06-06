<h2>Keywords</h2>

@if($errors->has())
    @foreach ($errors->all() as $error)
        <div class="text-danger">{{ $error }}</div>
    @endforeach
@endif

<ul class="admin-item-ul">
    @forelse($keywords as $keyword)
        <li>
            <span class="keyword-display-edit-box" data-url="{!! route("software.keywords-edit", array('software'=>$software,'keyword'=>$keyword->id)) !!}">{!! $keyword->label !!}</span>
            <div class="btn-group inline pull-right" data-toggle="buttons-checkbox">
                <div class="btn btn-warning btn-small edit-keyword hide">Edit</div>
                <div class="btn btn-primary btn-small save-edit-keyword" style="display: none;">Save</div>
                <div class="btn btn-danger btn-small cancel-edit-keyword" style="display: none;">Cancel</div>
                <div class="btn btn-danger btn-small detach-keyword" data-url="{!! route("software.detach-keyword", array('software'=>$software, 'keyword'=>$keyword->id)) !!}" data-name="{!! $keyword->label !!}">Detach from this Software</div>
            </div>
        </li>
    @empty
        <li id="add-nag">No keywords associated with this software yet! Add one below.</li>
    @endforelse
</ul>


<br>


<div class="form-group keyword-add-buttons">
    <div>
        <button type="button" class="btn btn-success add-keyword-new"><span class="glyphicon glyphicon-plus"></span> Add a new keyword</button>
        <span>or</span>
        <button type="button" class="btn btn-success add-keyword-existing"><span class="glyphicon glyphicon-plus"></span> Add an existing keyword</button>
    </div>
</div>


{{--<div class="form-group keyword-add-buttons">--}}
    {{--<div>--}}
        {{--<button type="button" class="btn btn-success add-keyword-existing"><span class="glyphicon glyphicon-plus"></span> Add an existing keyword</button>--}}
    {{--</div>--}}
{{--</div>--}}


{!! BootForm::open(array('url'=>route('software.add-new-keyword', array('software'=>$software->slug)), 'style'=>'display:none;', 'class' => 'add-keyword-new-form add-keyword-container')) !!}
<div class="col-sm-12 col-md-8">
    {!! BootForm::text('label', "Label", null, array('class' => 'input-lg', 'required' => 'required'))!!}
    {!! BootForm::submit('Save', array('class'=>'btn btn-primary btn-lg ')) !!}
    <div class="form-group">
        <div>
            <button type="button" class="btn btn-lg btn-danger add-keyword-cancel">Cancel</button>
        </div>
    </div>
</div>
{!! Form::close() !!}




{!! BootForm::open(array('url'=>route('software.add-existing-keyword', array('software'=>$software->slug)), 'style'=>'display:none;', 'class' => 'add-keyword-existing-form add-keyword-container')) !!}

{!! BootForm::select('existing_keyword', "Choose a keyword already in the database",
    $keywords_for_select, null, array()) !!}

{!! BootForm::submit('Save', array("class"=>"btn btn-primary btn-lg")) !!}
<button type="button" class="btn btn-lg btn-danger add-keyword-cancel">Cancel</button>
{!! BootForm::close() !!}