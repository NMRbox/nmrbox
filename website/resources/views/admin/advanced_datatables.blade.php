@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Advanced Tables @parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    @stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <h1>Advanced Tables</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>Tables</li>
                        <li>
                            <a href="advanced_datatables">Advanced Tables</a>
                        </li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-success filterable">
                                <div class="panel-heading clearfix  ">
                                    <div class="panel-title pull-left">
                                        <i class="fa fa-fw fa-file-text-o"></i>
                                        Want to export data?
                                    </div>
                                    <div class="tools pull-right"></div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered" id="table1">
                                        <thead>
                                            <tr>

                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>User Name</th>
                                                <th>User E-mail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Markotto</td>
                                                <td>Markotto@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>

                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-success filterable" style="overflow:auto;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i class="fa fa-fw fa-file-text-o"></i>
                                        Re-order Columns
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered" id="table2">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>User Name</th>
                                                <th>User E-mail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>3.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>4.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>5.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>6.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>7.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>8.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>9.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>10.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>11.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>12.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>13.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>14.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>15.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>16.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>17.</td>
                                                <td>Larryss</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-success filterable">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title pull-left">
                                        <i class="fa fa-fw fa-file-text-o"></i>
                                        Add / Remove rows
                                    </h3>
                                    <div class="pull-right">

                                        <button type="button" class="btn btn-primary btn-sm" id="addButton">Add row</button>
                                        <button type="button" class="btn btn-danger btn-sm" id="delButton">Delete row</button>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered" id="table3">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>User Name</th>
                                                <th>User E-mail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>JacobThornton</td>
                                                <td>JacobThornton@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>3.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>4.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>5.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>6.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>7.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>8.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>9.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>10.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>11.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>12.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>13.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>14.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>15.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>16.</td>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                            <tr>
                                                <td>17.</td>
                                                <td>Larryss</td>
                                                <td>the Bird</td>
                                                <td>Larrythe Bird</td>
                                                <td>LarrytheBird@test.com</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    </section>
            @stop
{{-- page level scripts --}}
@section('footer_scripts')
        <script src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/vendors/datatables/extensions/TableTools/js/dataTables.tableTools.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/vendors/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" type="text/javascript" ></script>
        <script src="{{ asset('assets/js/custom_js/advanced_datatables.js') }}" type="text/javascript" ></script>
        @stop