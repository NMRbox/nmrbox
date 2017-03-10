<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use Session;

class SentinelAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Sentinel::check())
            return Redirect::to('login')->with('error', 'You must be logged in!');
        elseif(!Session::has('user_is_admin'))
            return Redirect::to('my-account');

        return $next($request);
    }
}
