@if ($errors->any())
<div class="alert alert-danger alert-dismissable">
  <a href="#" class="close" data-dismiss="alert">&times;</a>
  <strong>Error:</strong> Please check the form below for errors
</div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Success:</strong> {!! $message !!}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Error:</strong> {!! $message !!}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissable">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Warning:</strong> {!! $message !!}
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissable">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Info:</strong> {!! $message !!}
</div>
@endif
