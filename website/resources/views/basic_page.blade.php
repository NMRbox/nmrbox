@extends('layouts.default')

{{-- Page title --}}
@section('title')
    {{ $page->title  }}
    @parent
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

                <div class="research-header">
                    <h1>{{ $page->title  }}</h1>

                    @if ($user = Sentinel::getUser())
                        @if(Sentinel::inRole('admin'))
                            <span>
                                <a href="{{ route('update/page', $page->slug) }}">Edit this page</a>
                            </span>
                        @endif
                    @endif


                </div>

                <div class="research-container">

                    {!! $page->content  !!}

                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
