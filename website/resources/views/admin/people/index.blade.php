@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
People Index
@parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>People</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> People</li>
        <li class="active">Index</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left">
                        <i class="fa fa-fw fa-list"></i>
                        People List
                    </h4>
                    <div class="pull-right">
                    <a href="{{ URL::to('admin/people/create') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add Person</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    <table id="vm-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Institution</th>
                                <th>NMRbox Account #</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($all_people))
                            @foreach ($all_people as $person)
                                <tr>
                                    <td>{!! $person->first_name !!}</td>
                                    <td>{!! $person->last_name !!}</td>
                                    <td>{!! $person->email !!}</td>
                                    <td>{!! $person->institution !!}</td>
                                    <td>
                                        <a href="{!! URL::to('admin/people/' . $person->id . '/edit' ) !!}"><i class="fa fa-fw fa-pencil text-warning" title="update person"></i></a>


                                            <a href="#">
                                                <i class="fa fa-fw fa-times text-danger delete-person" data-url="{!! route("person.delete", $person->id) !!}" data-personname="{!! $person->name !!}"></i>
                                            </a>
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
</section>

@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom_js/people_index.js') }}" type="text/javascript"></script>
    
    <script>
        $(document).ready(function() {
            $('#vm-table').DataTable();
        });
    </script>
@stop
