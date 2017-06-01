<?php
/**
* Language file for auth error messages
*
*/

return array(

    'account_already_exists' => 'An account with this email already exists.',
    'account_not_found'      => 'Username or password is incorrect, please try again.',
    'account_not_activated'  => 'This user account is not activated.',
    'account_suspended'      => 'User account suspended because of too many login attempts. Try again later.',
    'account_banned'         => 'This user account is banned.',

    'login' => array(
        'error'   => 'Username or password is incorrect, please try again.',
        'success' => 'You have successfully logged in.',
    ),

    'signup' => array(
        'error'   => 'There was a problem while trying to create your account, please try again.',
        'success' => 'Account successfully created.',
    ),

    'forgot-password' => array(
        'error'   => 'Email address not found.  Please enter your institutional email address associated with your account and try again.',
        'success' => 'Password recovery email successfully sent.',
    ),

    'forgot-password-confirm' => array(
        'account_error'       => 'The username you entered does not match the username that requested the password reset.',
        'complexity_error'    => "Password does not meet complexity rules, please try again. Password must be a minimum of 8 characters and include a character from 3 of the following 4 groups: upper case, lower case, numbers, and punctuation marks ('&' and '$' not allowed).",
        'request_expired'     => 'Your password reset link has already been used. Please request a new reset by entering your institutional email below.',
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
