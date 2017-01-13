<?php
/**
* Language file for auth error messages
*
*/

return array(

    'account_already_exists' => 'An account with this email already exists.',
    'account_not_found'      => 'Username or password is incorrect.',
    'account_not_activated'  => 'This user account is not activated.',
    'account_suspended'      => 'User account suspended because of too many login attempts. Try again later.',
    'account_banned'         => 'This user account is banned.',

    'login' => array(
        'error'   => 'There was a problem while trying to log you in, please try again.',
        'success' => 'You have successfully logged in.',
    ),

    'signup' => array(
        'error'   => 'There was a problem while trying to create your account, please try again.',
        'success' => 'Account sucessfully created.',
    ),

    'forgot-password' => array(
        'error'   => 'There was a problem while trying to get a reset password link, please enter institutional email address associated with your account and try again.',
        'success' => 'Password recovery email successfully sent.',
    ),

    'forgot-password-confirm' => array(
        'account_error'       => 'NMRbox usename do not match, please try again.',
        'complexity_error'    => "Password does not meet complexity rules, please try again. Password hint: Minimum 8 characters with mix of upper case, lower case, numbers and punctuation marks except '&' and '$''.",
        'request_expired'     => 'Looks like your password reset request has expired, please try again.',
        'success'             => 'Your password has been successfully reset.',
    ),

    'activate' => array(
        'error'   => 'There was a problem while trying to activate your account, please try again.',
        'success' => 'Your account has been successfully activated.',
    ),

    'contact' => array(
        'error'   => 'There was a problem while trying to submit the contact form, please try again.',
        'success' => 'Your contact details has been successfully sent. ',
    ),
);
