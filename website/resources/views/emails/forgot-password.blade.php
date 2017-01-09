@extends('emails/layouts/default')

@section('content')
<p>Hello {!! $user->first_name !!} {!! $user->last_name !!},</p>

<p>Please click on the following link to update your password:</p>

<p><a href="{!! $forgotPasswordUrl !!}">Reset password</a></p>

<p>Best regards,</p>

<p>@lang('general.site_name') Team</p>
@stop
