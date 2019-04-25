@extends('layouts.default')

{{-- Page title --}}
@section('title')
    Registry
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
        <link href="{{ asset('assets/css/registry.css') }}" rel="stylesheet" type="text/css" />
    @stop


    {{-- Page content --}}
    @section('content')
    <!-- Container Section Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="content">
                    <div class="research-header">
                        <h1>{{$software->name}}</h1>

                        @if ($user = Sentinel::getUser())
                            @if(Session::has('user_is_admin') == true)
                            <span>
                                <a href="{{ route('software.edit',  ['software' => $software->slug] ) }}">
                                    Edit this package
                                </a>
                            </span>
                            @endif
                        @endif
                        
                    </div>

                    <div class="row">
                        <div class="package-detail">
                            {{--<h3>--}}
                                {{--{{ $software->name }}--}}
                            {{--</h3>--}}

                            @if($software->long_title)
                                <h3>
                                    {{ $software->long_title }}
                                </h3>
                            @endif

                            @foreach ($all_files as $file)
                                @if( str_contains($file->label, "image") )

                                    {{--<div class="form-group nmr-file">--}}
                                        {{--<h4>{!! $file->label !!}</h4>--}}
                                        {{--<div class="file-box">--}}
                                            {{--<p>--}}
                                                {{--{!! $file->name !!}--}}
                                            {{--</p>--}}
                                            <img class="img-responsive" src="{{ route('file.get', array('file'=>$file->slug) ) }}">
                                            {{--<a class="btn btn-primary download-file" href="{{ route('software.downloadfile', array('software'=>$software->slug, 'file'=>$file->slug) ) }}">Download</a>--}}
                                            {{--<a href="#" class="btn btn-danger delete-file" data-filename="{!! $file->name !!}" data-label="{!! $file->label !!}" data-url="{{ route('software.deletefile', array('software'=>$software, 'file'=>$file->slug) ) }}">Delete</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                @endif
                            @endforeach

                            {{--{{# each image in images}}--}}
                            {{--<div class="image" style="background-image: url({{ image.url }})"></div>--}}
                            {{--{{/ each }}--}}

                            <br>

                            <h3>Synopsis</h3>
                            <p>{{ $software->synopsis }}</p>

                            <h3>Description</h3>
                            <p>{!! $software->description !!} </p>

                            @if($software->url != null)
                            <h3>URL</h3>
                            <p>
                                <a href="{!! $software->url !!}">{!! $software->url !!}</a>
                            </p>
                            @endif

                            <h3>Versions</h3>

                            <div class="row">
                                <div class="well col-sm-offset-3 col-sm-6 col-xs-12">
                                    <table class="table index-table">
                                        <thead>
                                        <tr role="row">
                                            <th>NMRbox Version</th>
                                            <th>Software Version</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @forelse($vm_version_pairs as $vm => $svArray)
                                            <tr>
                                                <td>{!! $vm !!}</td>
                                                <td>

                                                    @forelse($svArray as $sv)
                                                        {!! $sv !!}<span class="table-comma">,</span>   {{-- trailing commas hidden in edit_software.css--}}
                                                    @empty
                                                    @endforelse

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>No VMs yet!</td>
                                                <td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h3>Keywords</h3>
                            <ul>

                                @forelse ($all_keywords as $kw)
                                    <li>{!! $kw->label !!}</li>
                                @empty
                                    <p>No keywords recorded for this software package yet.</p>
                                @endforelse

                            </ul>

                            {{--<h3>Developer Lab</h3>--}}
                            {{--<p>{{ $software->developer_lab }}</p>--}}

                            {{--<h3>Keywords</h3>--}}
                            {{--{{# each keyword in keywords}}--}}
                            {{--<p>{{ keyword }}</p>--}}
                            {{--{{/ each }}--}}

                            {{--<h3>Workflows</h3>--}}
                            {{--{{# each workflow in workflows}}--}}
                            {{--<p>{{ workflow }}</p>--}}
                            {{--{{/ each }}--}}

                            {{--<h3>Documentation Link</h3>--}}
                            {{--<p>--}}
                                {{--<a href={{documentation_link}}>Documentation</a>--}}
                            {{--</p>--}}

                            {{--<h3>License</h3>--}}
                            {{--<p><a href={{ license_file }}>{{ license_description }}</a></p>--}}

                            @forelse($attached_citations as $citation)
                            <h3>Citations</h3>
                            <div class="citation">
                                <cite>{{ $citation->title }}</cite><br>
                                <div class="authors">
                                    @forelse($citation->authors as $author)
                                        {{ $author->last_name }} {{ $author->first_name }}<span class="table-comma">,</span>
                                    @empty
                                    @endforelse
                                </div>
                                {{ $citation->journal }}. {{ $citation->year }}; {{ $citation->volume }}({{ $citation->issue }}): {{ $citation->pages }}
                            </div>
                            {{--{{/ each }}--}}
                            {{--<p>--}}
                                {{--<small>Package entry by {{ getCreator.profile.name }}</small>--}}
                            {{--</p>--}}
                            @empty
                            @endforelse

                        </div>



                        {{--@forelse ($all_software as $software)--}}
                            {{--<div class="col-sm-3 registry-package">--}}
                                {{--<div class="registry-package-wrapper">--}}
                                    {{--<h3>--}}
                                        {{--<a href="{{ URL::to('registry/' . $software->slug ) }}">--}}
                                            {{--{{$software->name}}--}}
                                        {{--</a>--}}
                                    {{--</h3>--}}
                                    {{--<p class="description">--}}
                                        {{--{{ $software->synopsis }}--}}
                                    {{--</p>--}}
                                    {{--<span class="usage">Usage: </span>--}}
                                    {{--<a href="#">--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@empty--}}
                            {{--<h2>No software entered yet</h2>--}}
                        {{--@endforelse--}}



                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
