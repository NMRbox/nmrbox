@extends('emails/layouts/default')

@section('content')
<p>Dear {!! $person->first_name !!},</p>

<p>Thank you for registering for an NMRbox account!</p>

<p>The creation of new accounts is not a fully automatic system, as NMRbox staff must validate the academic, government, or not-for-profit status of each registrant.  Please allow one to three business days for your account to be validated, at which time you will receive an email containing your username, password, and instructions for accessing NMRbox.  If you do not receive a reply from us within three business days, please contact us at <a href= "mailto:support@nmrbox.org">support@nmrbox.org</a>.</p>

<p>Kindly,</p>

<p>The NMRbox Staff</p>
@stop
