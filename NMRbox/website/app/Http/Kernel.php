<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        //\App\Http\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\Cors::class,
        \App\Http\Middleware\ForceHttps::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'SentinelUser' => \App\Http\Middleware\SentinelUser::class,
        'SentinelAdmin' => \App\Http\Middleware\SentinelAdmin::class,
        'auth.jwt' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'auth.jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
        'cors' => \App\Http\Middleware\Cors::class,
        'session' => \Illuminate\Session\Middleware\StartSession::class,
    ];
}