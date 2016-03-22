{!! BootForm::open(array('model'=>$software, 'update'=>'software.updatelegal', 'files' => true)) !!}

{!! BootForm::select('devel_contacted', "Has the developer been contacted?",
    array("false"=>"No", "true"=>"Yes"), $software->devel_contacted, array()) !!}

{!! BootForm::select('free_to_redistribute', "Is the software free to be redistributed?",
    array('maybe'=>'Unknown', "false"=>"No", "true"=>"Yes"), $software->free_to_redistribute, array()) !!}

{!! BootForm::select('custom_license', "Has license been modified to allow for redistribution?",
    array("null"=>"Not Needed", "false"=>"No", "true"=>"Yes"), $software->custom_license, array()) !!}

{!! BootForm::textarea('license_comment', "License Comment", null,
    array('class' => 'textarea', 'rows'=>'5', 'placeholder'=>'Place some text here', 'style'=>'style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"')) !!}

{!! BootForm::select('devel_include', "Does the developer intend to include the software in NMRbox?",
array('maybe'=>'Unknown', "false"=>"No", "true"=>"Yes"), $software->devel_include, array()) !!}

{!! BootForm::select('uchc_legal_approve', "Has UConn legal has signed off on the license?",
    array("null"=>"Not Needed", "false"=>"No", "true"=>"Yes"), $software->uchc_legal_approve, array()) !!}

{!! BootForm::select('devel_redistrib_doc', "Has developer given permission to redistribute documentation?",
    array('maybe'=>'Unknown', "false"=>"No", "true"=>"Yes"), $software->devel_redistrib_doc, array()) !!}

{!! BootForm::select('devel_active', "Is the developer is still actively maintaining the software?",
    array('maybe'=>'Unknown', "false"=>"Orphaned", "true"=>"Active"), $software->devel_active, array()) !!}

{!! BootForm::select('devel_status', "How does the Developer feel today? (I don't know what devel_status is supposed to represent since we already have devel_active in previous form)",
    array('maybe'=>'Unknown', "false"=>"Bad", "true"=>"Good"), $software->devel_status, array()) !!}

{!! BootForm::submit('Save', array("class"=>"btn btn-primary btn-lg")) !!}
{!! BootForm::close() !!}