@extends('layouts.default')

{{-- Page title --}}
@section('title')
Blog Item
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/blog.css') }}">
@stop


{{-- Page content --}}
@section('content')
    <div class="container">
        <div class="services">
            <h2><label class="border-bottom mrg_lft12"> Blog Item</label></h2>
        </div>
        <!-- Popular Section Start -->
        <div class="col-sm-4 col-md-3 col-full-width-left">

            {{-- popular --}}
            @include('blog._popular')

            <!-- Client Meeting Section Start -->
            <div class="thumbnail">
                <img src="{{ asset('assets/images/v2.jpg') }}" class="img-responsive">
                <h3>Client Meeting</h3>
                <p class="text-justify">
                    Out of many, one. The hope of a millworker's son who dares to defy the odds. So one Sunday, I put on one of the few clean jackets I had, and went over to Trinity United Church of Christ on 95th Street on the South Side of Chicago. Or, at this moment, in this election, we can come together and say, "Not this time."
                    <br>
                    <br>This time we want to talk about the crumbling schools that are stealing the future of black children and white children and Asian children and Hispanic children and Native American children. As the Holy Koran tells us, "Be conscious of God and speak always the truth."
                </p>
            </div>
            <!-- //Client Meeting Section End -->
        </div>
        <!-- Project Description Start -->
        <div class="col-md-9 col-sm-8">
            <div class="thumbnail">
                <h3 class="text-primary">{{ $blog->title }}</h3>
                @if($blog->image)
                    <img src="{{ URL::to('/uploads/blog/'.$blog->image)  }}" class="img-responsive author" alt="Image">
                @endif
                    {!! $blog->content !!}
                <p>
                    <strong>Tags: </strong>
                    @forelse($blog->tags as $tag)
                        <a href="{{ URL::to('blog/'.$tag.'/tag') }}">{{ $tag }}</a>,
                    @empty
                        No Tags
                    @endforelse
                </p>
            </div>

            {{-- comments --}}
            @include('blog._comments')

        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
