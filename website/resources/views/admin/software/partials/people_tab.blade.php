<h2>People</h2>

<ul class="people-ul">
    @forelse($people as $person)
        <li>
            <span class="person-display-edit-box" data-url="{!! route("software.people-edit", array('software'=>$software,'person'=>$person->id)) !!}">{!! $person->name !!}</span>
            <div class="btn-group inline pull-right" data-toggle="buttons-checkbox">
                <div class="btn btn-warning btn-small edit-person">Edit</div>
                <div class="btn btn-primary btn-small save-edit-person" style="display: none;">Save</div>
                <div class="btn btn-danger btn-small cancel-edit-person" style="display: none;">Cancel</div>
                <div class="btn btn-danger btn-small detach-person" data-url="{!! route("software.detach-person", array('software'=>$software, 'person'=>$person->id)) !!}" data-name="{!! $person->name !!}">Detach from this Software</div>
            </div>
        </li>
    @empty
        <li id="add-nag">No people associated with this software yet! Add one below.</li>
    @endforelse
</ul>




<div class="form-group person-add-buttons">
    <div>
        <button type="button" class="btn btn-success add-person-new"><span class="glyphicon glyphicon-plus"></span> Add a new person</button>
        <span>or</span>
        <button type="button" class="btn btn-success add-person-existing"><span class="glyphicon glyphicon-plus"></span> Add an existing person</button>
    </div>
</div>



{!! BootForm::open(array('url'=>route('software.add-new-person', array('software'=>$software->id)), 'style'=>'display:none;', 'class' => 'add-person-new-form add-person-container')) !!}
<div class="col-sm-12 col-md-8">
    {!! BootForm::text('name', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
    {!! BootForm::email('email', "Email", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
    {!! BootForm::text('institution', "Institution", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
    {!! BootForm::text('nmrbox_acct', "NMRbox Account Number", null, array('class' => 'form-control input-lg', 'required' => 'required')) !!}
    {!! BootForm::submit('Save', array('class'=>'btn btn-primary btn-lg ')) !!}
    <div class="form-group">
        <div>
            <button type="button" class="btn btn-lg btn-danger add-person-cancel">Cancel</button>
        </div>
    </div>
</div>
{!! Form::close() !!}




{!! BootForm::open(array('url'=>route('software.add-existing-person', array('software'=>$software->id)), 'style'=>'display:none;', 'class' => 'add-person-existing-form add-person-container')) !!}

{!! BootForm::select('existing_person', "Choose a person already in the database",
    $people_for_select, null, array()) !!}

{!! BootForm::submit('Save', array("class"=>"btn btn-primary btn-lg")) !!}
<button type="button" class="btn btn-lg btn-danger add-person-cancel">Cancel</button>
{!! BootForm::close() !!}