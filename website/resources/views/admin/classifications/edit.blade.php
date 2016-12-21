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
        Edit Classification
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-fw fa-home"></i>
                Dashboard
            </a>
        </li>
        <li> Classification</li>
        <li class="active"> Edit Classification</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-fw fa-plus"></i>
                        Edit Classification
                    </h4>
                </div>
                <div class="panel-body">

                    {!! BootForm::horizontal(array('model'=>$classification, 'store'=>'classification.store', 'update'=>'classification.update')) !!}
                    <div class="col-sm-12 col-md-10">
                        {!! BootForm::text('name', "Name", null, array('class' => 'input-lg', 'required' => 'required'))!!}
                        {!! BootForm::text('definition', "Definition", null, array('class' => 'input-lg', 'id' => 'template_area', 'required' => 'required'))!!}
                        {!! BootForm::select('web_role', 'Web Role', array(1 => 'True', 0 => 'False'), $web_role , array('class' => 'input-lg'))!!}
                        {!! BootForm::submit('Save') !!}
                    </div>
                    {!! BootForm::close() !!}
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