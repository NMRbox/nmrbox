<!-- Popular Tags Secttion Start -->
<div class="row">
    <div class="panel panel-default martop13">
        <div class="panel-heading">
            <h4><b>POPULAR TAGS</b></h4>
        </div>
        <div class="panel-body right-blog">
            @foreach($tags as $tag)
                <span class="btn btn-primary">{{ $tag }}</span>
            @endforeach
        </div>
    </div>
</div>
<!-- //Popular Tags Section End -->