@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Edit VM
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
        Edit VM
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Email Templates</li>
        <li class="active"> Edit Email Template</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Edit Email Template
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal(array('model'=>$email, 'store'=>'email.store', 'update'=>'email.update')) !!}
                    <div class="col-sm-12 col-md-10">
                        {!! BootForm::text('name', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                        {!! BootForm::text('subject', "Email subject", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="template_area">Select email fields</label>
                            <div class="col-md-7" id="template_area">
                                <a href="#" class="btn btn-xs btn-default" data-field-name="first_name">First Name</a>
                                <a href="#" class="btn btn-xs btn-default" data-field-name="last_name">Last Name</a>
                                <a href="#" class="btn btn-xs btn-default" data-field-name="nmrbox_acct">NMRBox Account</a>
                                <a href="#" class="btn btn-xs btn-default" data-field-name="preferred_email">Preferred Email</a>
                                <a href="#" class="btn btn-xs btn-default" data-field-name="institutional_email">Institutional Email</a>
                                <a href="#" class="btn btn-xs btn-default" data-field-name="institution">Institution</a>
                            </div>
                        </div>
                        {!! BootForm::textarea('content', "Template body", null, array('class' => 'input-lg', 'id' => 'template_area', 'required' => 'required'))!!}

                        {!! BootForm::submit('Save') !!}
                    </div>
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <h3>Email Log: </h3>
                </div>
                <div class="panel-body table_fluid">
                    <table id="vm-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="20%">Delivery Date</th>
                            <th>Receiver</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($email_log))
                            @foreach ($email_log as $key => $log)
                                <tr>
                                    <td>{!! $key !!}</td>
                                    <td>Sent to - <a href="#" id="show_recipient">{!! count($log) !!} Recipients </a>
                                        <div class="hidden">
                                            <hr>
                                            <table class="table table-horizental">
                                                <thead>
                                                <tr>
                                                    <th>Name </th>
                                                    <th>Email </th>
                                                    <th>NMRbox Account</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($log as $key => $user_data)
                                                    <tr>
                                                        <td>{!! $user_data['person_name'] !!}</td>
                                                        <td>{!! $user_data['person_email'] !!}</td>
                                                        <td>{!! $user_data['person_nmrbox_acct'] !!}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">
                                    <h4> No email log found. </h4>
                                </td>
                            </tr>

                        @endif
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

@stop


{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}"></script>
    <script type="application/javascript">

        jQuery.fn.extend({
            insertAtCaret: function(myValue){
                return this.each(function(i) {
                    if (document.selection) {
                        //For browsers like Internet Explorer
                        this.focus();
                        var sel = document.selection.createRange();
                        sel.text = myValue;
                        this.focus();
                    }
                    else if (this.selectionStart || this.selectionStart == '0') {
                        //For browsers like Firefox and Webkit based
                        var startPos = this.selectionStart;
                        var endPos = this.selectionEnd;
                        var scrollTop = this.scrollTop;
                        this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                        this.focus();
                        this.selectionStart = startPos + myValue.length;
                        this.selectionEnd = startPos + myValue.length;
                        this.scrollTop = scrollTop;
                    } else {
                        this.value += myValue;
                        this.focus();
                    }
                });
            }
        });

        $('#template_area a').click(function(){
            var val = $(this).attr('data-field-name');
            $('textarea').insertAtCaret( "%%" + val + "%%");
        });

        $('a#show_recipient').on('click', function (e) {
            e.preventDefault();
            $(this).next('div').toggleClass('hidden');
        });
    </script>
@stop