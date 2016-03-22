@if(isset($latest))
    <div class="row">
        <div class="panel panel-default martop13">
            <div class="panel-heading">
                <h4><b>LATEST POSTS</b></h4>
            </div>
            <div class="panel-body right-blog">
                @foreach($latest as $post)
                    <a href="{{ $post->slug }}"><h5 class="text-primary">{{ $post->title }}</h5></a>
                    <h6>{{ $post->created_at->diffForHumans() }}</h6>
                @endforeach
            </div>
        </div>
    </div>
@endif