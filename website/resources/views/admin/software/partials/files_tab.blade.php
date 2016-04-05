{!! BootForm::open(array('url'=>route('software.files', array('software'=>$software->id)), 'files' => true)) !!}

@unless( $files->contains("label", "Original_License"))
    <h2>This software record does not contain an original license. <a href="#" class="add-license">Click here</a> to add one.</h2>
@endunless

@foreach ($files as $file)
    @unless( str_contains($file->label, "image") )
        <div class="form-group nmr-file">
            <h4>{!! $file->label !!}</h4>
            <div class="file-box">
                <p>
                    {!! $file->name !!}
                </p>
                <a class="btn btn-primary download-file" href="{{ route('software.downloadfile', array('software'=>$software->id, 'file'=>$file->slug) ) }}">Download</a>
                <a href="#" class="btn btn-danger delete-file" data-filename="{!! $file->name !!}" data-label="{!! $file->label !!}" data-url="{{ route('software.deletefile', array('software'=>$software, 'file'=>$file->slug) ) }}">Delete</a>
            </div>
        </div>
    @endunless
@endforeach

<div class="form-group">
    <div>
        <button type="button" class="btn btn-success add-file"><span class="glyphicon glyphicon-plus"></span> Add another file</button>
    </div>
</div>

{!! BootForm::submit('Save', array("class"=>"btn btn-primary btn-lg")) !!}
{!! BootForm::close() !!}