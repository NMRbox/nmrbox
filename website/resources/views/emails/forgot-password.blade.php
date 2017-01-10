@extends('emails/layouts/default')

@section('content')
<p>Dear {!! $user->first_name !!},</p>

<p>We received a request to reset your password for NMRBox username - <b>{!! $user->nmrbox_acct !!}</b></p>
<p>Please <a href="{!! $forgotPasswordUrl !!}">click here</a> and follow the prompts to update your password.</p>
<p>If you did not request a password reset, please contact us at: <a href= "mailto:support@nmrbox.org">support@nmrbox.org</a></p>

<p>Best regards,</p>
<p>@lang('general.site_name') Team</p>
@stop
