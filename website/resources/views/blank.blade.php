@extends('layouts.default')

{{-- Page title --}}
@section('title')

    @if (strtolower($page->title) == "homepage")
        {{-- Special case (no page name in title) for homepage, refactor if more special cases arise --}}
        NMRbox
    @else
        {{ $page->title  }}
        @parent
    @endif

@stop

{{-- page level styles --}}
@section('header_styles')
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">

                @if ($user = Sentinel::getUser())
                    @if(Sentinel::inRole('admin'))
                        <a href="{{ route('update/page', $page->slug) }}">
                            <h2 class="text-center">Edit this page</h2>
                        </a>
                    @endif
                @endif

                <div class="content">
                    {!! $page->content  !!}
                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
