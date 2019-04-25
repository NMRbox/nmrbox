@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')Invoice@parent

@stop
    {{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/css/custom_css/invoice.css') }}" rel="stylesheet" type="text/css"/>
    @stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
                    <h1>Invoice</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-fw fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>Pages</li>
                        <li>
                            <a href="invoice">Invoice</a>
                        </li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content paddingleft_right15">
                        <div class="row">
                            <div class="col-sm-10">
                                <h3>Invoice #11013/11/R1</h3>
                                <h3>Order  #16118</h3>
                                <p>
                                    Date:
                                    <span class="text-primary">12/12/2014</span>
                                </p>
                                <p>
                                    Due By:
                                    <span class="text-danger">26/12/2014</span>
                                </p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <img src=" {{ asset('assets/img/gallery/full/invoice.png') }}" alt="photo" width="64" height="64" class="img-circle">
                                <h3>From</h3>
                                <address>
                                    <p >Mark</p>
                                    <p>234 Laurier Avenue West</p>
                                    <p>K1A 0G9 Ottawa</p>
                                    <p >Canada</p>
                                    <p>
                                        <small>
                                            <span>Phone:</span>
                                            (+121) 123 456 789
                                        </small>
                                    </p>
                                    <p>
                                        <small>
                                            <span>E-mail:</span>
                                            <a href="#">Markotto@example.com</a>
                                        </small>
                                    </p>
                                </address>
                            </div>
                            <div class="col-sm-6 text-right">
                             <img src=" {{ asset('assets/img/authors/avatar5.jpg') }}" alt="photo" width="64" height="64" class="img-circle">
                                <h3>To</h3>
                                <address>
                                    <p>JacobThornton, Thornton</p>
                                    <p>234 Laurier Avenue West</p>
                                    <p>Ottawa, Ontario, Canada</p>
                                    <p>K1A 0G9</p>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-vcenter">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="width: 60%;">Product</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>
                                                    <h4>Corporate Wordpress Website </h4>
                                                    <span class="label label-info">
                                                        <i class="fa fa-clock-o"></i>
                                                        3 weeks
                                                    </span>
                                                    <span class="label label-info">4 Revisions Available</span>
                                                </td>
                                                <td class="text-center">
                                                    <strong>x
                                                        <span class="badge">1</span></strong> 
                                                </td>
                                                <td class="text-center">
                                                    <strong>$ 1.000</strong>
                                                </td>
                                                <td class="text-right">
                                                    <span class="label label-primary">$ 10.000</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td>
                                                    <h4>Corporate Wordpress Website 2</h4>
                                                    <span class="label label-info">
                                                        <i class="fa fa-clock-o"></i>
                                                        1 month
                                                    </span>
                                                    <span class="label label-info">2 Revisions Available</span>
                                                </td>
                                                <td class="text-center">
                                                    <strong>x
                                                        <span class="badge">1</span></strong> 
                                                </td>
                                                <td class="text-center">
                                                    <strong>$ 1.000</strong>
                                                </td>
                                                <td class="text-right">
                                                    <span class="label label-primary">$ 10.000</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td>
                                                    <h4>Apple iPad Air With Wi-Fi 16GB - </h4>
                                                    <span class="label label-info">
                                                        <i class="fa fa-clock-o"></i>
                                                        2 months
                                                    </span>
                                                    <span class="label label-info">Mobile</span>
                                                </td>
                                                <td class="text-center">
                                                    <strong>
                                                        x
                                                        <span class="badge">3</span>
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <strong>$ 2.000</strong>
                                                </td>
                                                <td class="text-right">
                                                    <span class="label label-primary">$ 20.000</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td>
                                                    <h4>Apple iPad 4th Gen with Retina display with Wi-Fi 16GB </h4>
                                                    <span class="label label-info">
                                                        <i class="fa fa-clock-o"></i>
                                                        6 months
                                                    </span>
                                                    <span class="label label-info">Mobile</span>
                                                </td>
                                                <td class="text-center">
                                                    <strong>
                                                        x
                                                        <span class="badge">3</span>
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <strong>$ 5.000</strong>
                                                </td>
                                                <td class="text-right">
                                                    <span class="label label-primary">$ 15.000</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td>
                                                    <h4>Apple iPad Air With Wi-Fi + Cellular </h4>
                                                    <span class="label label-info">
                                                        <i class="fa fa-clock-o"></i>
                                                        1 month
                                                    </span>
                                                    <span class="label label-info">Social + Ads</span>
                                                </td>
                                                <td class="text-center">
                                                    <strong>
                                                        x
                                                        <span class="badge">3</span>
                                                    </strong>
                                                </td>
                                                <td class="text-center">
                                                    <strong>$ 3.000</strong>
                                                </td>
                                                <td class="text-right">
                                                    <span class="label label-primary">$ 30.000</span>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td colspan="4" class="text-right">
                                                    <span class="h5">SUBTOTAL</span>
                                                </td>
                                                <td class="text-right">
                                                    <span class="h5">$ 85.000</span>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td colspan="4" class="text-right">
                                                    <span class="h5">VAT RATE</span>
                                                </td>
                                                <td class="text-right">
                                                    <span class="h5">25%</span>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td colspan="4" class="text-right">
                                                    <span class="h5">VAT DUE</span>
                                                </td>
                                                <td class="text-right">
                                                    <span class="h5">13.3% </span>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td colspan="4" class="text-right">
                                                    <span class="h5">
                                                        <strong>TOTAL DUE</strong>
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <span class="h5">
                                                        <strong>$ 28.750</strong>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="pull-right">
                                <a href="" class="btn btn-primary">
                                    <i class="fa fa-print"></i>
                                    Print
                                </a>

                                <a href="" class="btn btn-primary">
                                    <i class="fa fa-angle-right"></i>
                                    Send Invoice
                                </a>
                            </div>
                        </div>
                   </section>
                <!-- /.content --> </aside>
            <!-- /.right-side --> </div>
        <!-- /.right-side -->
        <!-- ./wrapper -->
        <!-- global js -->
        <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/custom_js/app.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/custom_js/metisMenu.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/custom_js/style-switcher.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/custom_js/rightside_bar.js') }}" type="text/javascript"></script>
        @stop