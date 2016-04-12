@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Registry
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
            <div class="col-lg-10 col-lg-offset-1">
                <div class="content">
                    <h1 class="page-header">Software Registry</h1>
                    <div class="row row-registry">


                        @forelse ($all_software as $software)
                            @if($software->display == true)
                            <div class="col-sm-3 registry-package">
                                <div class="registry-package-wrapper">
                                    <h3>
                                        {{--route("software.edit", array("software"=>$software->slug));--}}
                                        <a href="{{ route('software-page',  ['software' => $software->id] ) }}">
                                            {{$software->name}}
                                        </a>
                                    </h3>
                                    <p class="description">
                                        {{ $software->synopsis }}
                                    </p>
                                    {{--<span class="usage">Usage: </span>--}}
                                    <a href="#">
                                    </a>
                                </div>
                            </div>
                            @endif
                        @empty
                            <h2>No software entered yet</h2>
                        @endforelse



                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
