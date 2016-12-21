{!! BootForm::open(array('model'=>$software, 'store'=>'software.store', 'update'=>'software.updatelegal', 'files' => true)) !!}

{!! BootForm::select('free_to_redistribute', "Is the software free to be redistributed?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->free_to_redistribute), array()) !!}

{!! BootForm::select('devel_contacted', "Has the developer been contacted?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->devel_contacted), array()) !!}

{!! BootForm::textarea('license_comment', "License Comment", null,
    array('class' => 'textarea', 'rows'=>'5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"')) !!}

{!! BootForm::select('devel_include', "Does the developer intend to include the software in NMRbox?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->devel_include), array()) !!}

{!! BootForm::select('nfp_release', "Permission for not-for-profit release?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->nfp_release), array()) !!}

{!! BootForm::select('academic_release', "Permission for academic release?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->academic_release), array()) !!}

{!! BootForm::select('government_release', "Permission for government release?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->government_release), array()) !!}

{!! BootForm::select('commercial_release', "Permission for commercial release?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->commercial_release), array()) !!}

{!! BootForm::select('devel_redistrib_doc', "Has developer given permission to redistribute documentation?",
    array("null"=>"Unknown", "false"=>"No", "true"=>"Yes"), $software->boolToString($software->devel_redistrib_doc), array()) !!}

{!! BootForm::submit('Save', array("class"=>"btn btn-primary btn-lg")) !!}
{!! BootForm::close() !!}
