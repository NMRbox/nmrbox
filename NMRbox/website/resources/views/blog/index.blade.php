@extends('layouts.default')

{{-- Page title --}}
@section('title')
Blog
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/blog.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.css') }}" />
    
@stop


{{-- Page content --}}
@section('content')
    <div class="container">
        <div class="services">
            <h2> <label class="border-bottom mrg_lft12"> Blog</label></h2>
        </div>
        <!-- Information Gathering Section Start -->
        <div class="row">
            <div class="col-md-8">

                {{-- featured section --}}
                @include('blog._featured')
                <br />

                {{-- blog posts --}}
                @forelse($blogs as $blog)
                    <div class="thumbnail">
                        @if($blog->image)
                            <img src="{{ URL::to('/uploads/blog/'.$blog->image)  }}" class="img-responsive" alt="Image">
                        @endif
                    <div class="featured-text relative-left">
                        <h3 class="text-primary"><a href="{{ URL::to('blog/'.$featured->slug) }}">{{$blog->title}}</a></h3>
                        <p>
                            {!! $blog->content !!}
                        </p>
                        <p>
                            <strong>Tags: </strong>
                            @forelse($blog->tags as $tag)
                                <a href="{{ URL::to('blog/'.$tag.'/tag') }}">{{ $tag }}</a>,
                            @empty
                                No Tags
                            @endforelse
                        </p>
                        <div class="april">
                            by&nbsp;<i class="fa fa-user"></i>&nbsp;<a href="#">{{$blog->author->first_name . ' ' . $blog->author->last_name}}</a> &nbsp;
                            <i class="fa fa-clock-o"></i>&nbsp;<a href="#">{{$blog->created_at->diffForHumans()}}</a> &nbsp;
                            <i class="fa fa-comments"></i>&nbsp;<a href="#">{{$blog->comments->count()}} comments</a>
                        </div>
                        <hr>
                        <p class="text-right">
                            <a href="{{ URL::to('blog/'.$blog->slug) }}" class="btn btn-primary">Read more</a>
                        </p>
                    </div>
                    <!-- featured-text start -->
                </div>
                @empty
                    <h3>No Posts Exists!</h3>
                @endforelse

                <ul class="pager">
                    {!! $blogs->render() !!}
                </ul>

            </div>
            <!-- //Information Gathering Section End -->
            <!-- latest Post Section Start -->
            <div class="col-md-4">
                <!-- Latest posts-->
                @include('blog._latest')

                <!-- News-letter -->
                <div class="row">
                    <!-- News Latter Secttion Start -->
                    <div class="panel panel-default martop13">
                        <div class="panel-heading">
                            <h4><b>JOIN NEWSLETTER</b></h4>
                        </div>
                        <div class="panel-body right-blog">
                            <p>Sign up for our daily Newslatter</p>
                            <form role="form">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter email" required>
                                        </div>
                                    </div>
                                    <!-- /.col-xs-8 -->
                                    <div class="col-xs-4 col-full-width-left">
                                        <button type="submit" class="btn btn-danger btn-block">Sign up</button>
                                    </div>
                                    <!-- /.col-xs-4 -->
                                </div>
                                <!-- /.row -->
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Popular Tags -->
                @include('blog._tagcloud')
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/tags/dist/bootstrap-tagsinput.js') }}"></script>
    <!-- //page level js End -->
@stop
