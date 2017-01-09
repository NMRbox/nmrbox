@extends('emails/layouts/default')

@section('content')
<p>Dear {!! $user->first_name !!} {!! $user->last_name !!},</p>

<p>We received a request to reset your password for NMRBox username - <b>{!! $user->nmrbox_acct !!}</b></p>
<p>Please <a href="{!! $forgotPasswordUrl !!}">click here</a> and follow the prompts to update your password.</p>
<p>If you did not make the request, just ignore this email or contact NMRBox support. </p>

<p>Best regards,</p>
<p>@lang('general.site_name') Team</p>
@stop
