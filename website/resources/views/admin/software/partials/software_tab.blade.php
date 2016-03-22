{!! BootForm::open(array('model'=>$software, 'store'=>'software.store', 'update'=>'software.update', 'files' => true)) !!}

{!! BootForm::text('name', null, null,
    array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'Software Name', "onkeyup"=>"javascript:this.value=this.value.toUpperCase();"))!!}

{!! BootForm::select('public_release', "Display this package publicly on the website?",
    array("0"=>"No", "1"=>"Yes"), $software->public_release, array()) !!}

{!! BootForm::text('short_title', "Short Title", null,
    array('class' => 'input-lg', 'required' => 'false', 'placeholder'=>'Short title for software'))!!}

{!! BootForm::text('long_title', 'Long Title', null,
    array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'Long title for software'))!!}

{!! BootForm::text('synopsis', null, null,
    array('class' => 'input-lg', 'required' => 'required', 'placeholder'=>'Synopsis'))!!}

{!! BootForm::textarea('description', null, null,
    array('class' => 'textarea', 'rows'=>'5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"')) !!}

{!! BootForm::submit('Save Software Info', array("class"=>"btn btn-primary btn-lg")) !!}
{!! BootForm::close() !!}

