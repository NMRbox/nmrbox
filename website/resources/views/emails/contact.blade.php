@extends('emails/layouts/default')

@section('content')
    <p>Hello {{ $data['contact-name'] }},</p>

    <p>Welcome to SiteNameHere! We have received your details.</p>

    <p>The provided details are:</p>

    <p>  {{ $data['contact-msg'] }}  </p>

    <p> Thank you for Contacting SiteNameHere! We will revert you shortly.</p>

    <p>Best regards,</p>

    <p>@lang('general.site_name') Team</p>
@stop
