@extends('emails/layouts/default')

@section('content')
    <p>Hello {{ $user['first_name'] }},</p>

    <p>Welcome to NMRbox!

    <br>This is a test email for group emiling system.

    <br>Thank you for Contacting NMRbox!</p>

    <p>Best regards,

    <br>@lang('general.site_name') Team</p>
@stop
