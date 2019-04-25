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
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($attached_citations))
                        @foreach ($attached_citations as $citation)
                            <tr>
                                <td>{!! $citation->title !!}</td>
                                <td>{!! $citation->journal !!}</td>
                                <td>{!! $citation->year !!}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    <!-- row-->

<script>
    $(document).ready(function() {
        $('#attached-citations-table').DataTable();
        $('#citations-table').DataTable();
    });
</script>