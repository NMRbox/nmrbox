{!! BootForm::open(array('url'=>route('software.files', array('software'=>$software->slug)), 'files' => true)) !!}

@unless( $files->contains("label", "Original_License"))
    <h2>This software record does not contain an original license. <a href="#" class="add-license">Click here</a> to add one.</h2>
@endunless

@foreach ($files as $file)
    @unless( str_contains($file->label, "image") )
        <div class="form-group nmr-file">
            <h4>{!! $file->label !!}</h4>
            <div class="file-box">
                <p>
                    {!! $file->slug !!}
                </p>
                {{--To be consistent, for the time being we'll use the slug as the download name--}}
                <a class="btn btn-primary download-file" href="{{ route('file.downloadfile', array('file'=>$file->slug) ) }}"
                   download="{{ $file->slug }}"
                >Download</a>
                <a href="#" class="btn btn-danger delete-file" data-filename="{!! $file->slug !!}" data-label="{!! $file->label !!}"
                   data-url="{{ route('software.deletefile', array('software'=>$software, 'file'=>$file->slug) ) }}">Delete</a>
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