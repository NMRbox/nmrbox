<!-- Popular Section Start -->
<div class="the-box text-center">
    <h3><b>POPULAR</b></h3>
    <h4 class="primary">
        <a href="{{ URL::to('blog/show/'.$popular->slug) }}">
            {!! $popular->title !!}
        </a>
    </h4>
    <a href="{{ URL::to('blog/'.$popular->slug) }}" class="btn btn-success btn-block">Read more</a>
</div>
<!--Popular Section End -->