<h2>Citations</h2>

<br>

@if($errors->has())
    @foreach ($errors->all() as $error)
        <div class="text-danger">{{ $error }}</div>
    @endforeach
@endif

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left">
                    <i class="fa fa-fw fa-list"></i>
                    Attached Citations
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <table id="attached-citations-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Journal</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($attached_citations))
                        @foreach ($attached_citations as $citation)
                            <tr>
                                <td>{!! $citation->title !!}</td>
                                <td>{!! $citation->journal !!}</td>
                                <td>{!! $citation->year !!}</td>
                                <td>
                                    <a href="{!! route('software.detach-citation', array("software" => $software->id, "citation"=> $citation->id)) !!}" class="btn btn-md btn-danger" title="Attach Citation">Detach Citation</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    <!-- row-->


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary ">
            <div class="panel-heading clearfix">
                <h4 class="panel-title pull-left">
                    <i class="fa fa-fw fa-list"></i>
                    Available Citations
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <table id="citations-table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Journal</th>
                        <th>Year</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($all_citations))
                        @foreach ($all_citations as $citation)
                            <tr>
                                <td>{!! $citation->title !!}</td>
                                <td>{!! $citation->journal !!}</td>
                                <td>{!! $citation->year !!}</td>
                                <td>

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

                                </td>
                                <td>
                                    <a href="{!! route('software.attach-citation', array("software" => $software->id, "citation"=> $citation->id)) !!}" class="btn btn-md btn-primary" title="Attach Citation">Attach Citation</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    <!-- row-->


@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#attached-citations-table').DataTable();
            $('#citations-table').DataTable();
        });
    </script>
@stop