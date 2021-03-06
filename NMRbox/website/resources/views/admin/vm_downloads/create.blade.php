@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    Add Email Template :: @parent
@stop

{{-- Content --}}

@section('content')
<section class="content-header">
    <h1>
        Add Email Template
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> People</li>
        <li class="active">
            Add an Email Template
        </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Create A New Template
                    </h4>
                </div>
                <div class="panel-body">
                    {!! BootForm::horizontal() !!}
                        <div class="col-sm-12 col-md-10">
                            {!! BootForm::text('name', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            {!! BootForm::text('subject', "Email subject", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="template_area">Select email fields</label>
                                <div class="col-md-7" id="template_area">
                                    <a href="#" class="btn btn-xs btn-default" data-field-name="first_name">First Name</a>
                                    <a href="#" class="btn btn-xs btn-default" data-field-name="last_name">Last Name</a>
                                    <a href="#" class="btn btn-xs btn-default" data-field-name="preferred_email">Preferred Email</a>
                                    <a href="#" class="btn btn-xs btn-default" data-field-name="institutional_email">Institutional Email</a>
                                    <a href="#" class="btn btn-xs btn-default" data-field-name="institution">Institution</a>
                                </div>
                            </div>

                            {!! BootForm::textarea('content', "Template body", null, array('class' => 'input-lg', 'id' => 'template_area', 'required' => 'required'))!!}

                            {!! BootForm::submit('Save') !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
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
        })
    </script>
@stop
