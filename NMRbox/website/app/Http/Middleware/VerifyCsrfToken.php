<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/signin',
        '/signup',
        '/updateProfile/*',
        '/password-forgot',
        '/password-forgot-confirm',
        '/password-reset',
        '/downloadable-vm',
        '/events_register',
        '/person/*'
    ];
}