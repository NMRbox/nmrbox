<div class="form-group">
    @foreach ($files as $file)
        @if( str_contains($file->label, "image") )

            <div class="form-group nmr-file">
                <h4>{!! $file->label !!}</h4>
                <div class="file-box">
                    <p>
                        {!! $file->name !!}
                    </p>
                    <img class="img-responsive" src="{{ route('software.getfile', array('software'=>$software->slug, 'file'=>$file->slug) ) }}">
                    <a class="btn btn-primary download-file" href="{{ route('software.downloadfile', array('software'=>$software->slug, 'file'=>$file->slug) ) }}">Download</a>
                    <a href="#" class="btn btn-danger delete-file" data-filename="{!! $file->name !!}" data-label="{!! $file->label !!}" data-url="{{ route('software.deletefile', array('software'=>$software, 'file'=>$file->slug) ) }}">Delete</a>
                </div>
            </div>

        @endif
    @endforeach
</div>

{!! BootForm::open(array('url'=>route('software.files', array('software'=>$software->slug)), 'files' => true)) !!}
<div class="form-group">
    <div>
        <button type="button" class="btn btn-success add-image"><span class="glyphicon glyphicon-plus"></span> Add another image</button>
    </div>
</div>

{!! BootForm::submit('Save', array("class"=>"btn btn-primary btn-lg")) !!}
{!! BootForm::close() !!}