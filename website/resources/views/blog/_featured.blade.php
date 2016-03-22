@if(isset($featured))
    <div class="blog row">
        <h3 class="primary">FEATURED ARTICLE</h3>
        @if($featured->image)
            <div class="col-md-7">
                <img src="{{ URL::to('/uploads/blog/'.$blog->image)  }}" class="img-responsive blog-image">
            </div>
            <div class="col-md-5">
                <h4 class="primary"><a href="{{ URL::to('blog/'.$featured->slug) }}">{!! $featured->title !!}</a> </h4>
                <p class="text-justify">{!! $featured->content !!}</p>
                <a href="{{ URL::to('blog/'.$featured->slug) }}" class="btn btn-primary pull-right">Read more</a>
            </div>
        @else
            <div class="col-md-12">
                <h4 class="primary"><a href="{{ URL::to('blog/'.$featured->slug) }}">{!! $featured->title !!}</a> </h4>
                <p class="text-justify">{!! $featured->content !!}</p>
                <a href="{{ URL::to('blog/'.$featured->slug) }}" class="btn btn-primary pull-right">Read more</a>
            </div>
        @endif
    </div>
@endif