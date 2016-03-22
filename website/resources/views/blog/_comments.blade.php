<div class="thumbnail">
    <h3 class="comments">{{$blog->comments->count()}} Comments</h3><br />
    <ul class="media-list">
        @foreach($blog->comments as $comment)
            <li class="media">
                <div class="media-body">
                    <h4 class="media-heading"><i>{{$comment->name}}</i></h4>
                    <p>{{$comment->comment}}</p>
                    <p class="text-danger">
                        <small> {!! $comment->created_at!!}</small>
                    </p>
                </div>
            </li>
        @endforeach
    </ul>
    <hr />
    <h4 class="text-primary">LEAVE A COMMENT</h4>
    {!! Form::open(array('url' => URL::to('blog/'.$blog->id.'/comment'), 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}

    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        {!! Form::text('name', null, array('class' => 'form-control input-lg','required' => 'required', 'placeholder'=>'Your name')) !!}
        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
    </div>
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        {!! Form::text('email', null, array('class' => 'form-control input-lg','required' => 'required', 'placeholder'=>'Your email')) !!}
        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
    </div>
    <div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
        {!! Form::text('website', null, array('class' => 'form-control input-lg', 'placeholder'=>'Your website')) !!}
        <span class="help-block">{{ $errors->first('website', ':message') }}</span>
    </div>
    <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
        {!! Form::textarea('comment', null, array('class' => 'form-control input-lg no-resize','required' => 'required', 'style'=>'height: 200px', 'placeholder'=>'Your comment')) !!}
        <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-comment"></i>
            Submit
        </button>
    </div>

    {!! Form::close() !!}
</div>