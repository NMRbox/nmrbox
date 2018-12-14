<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use Session;
use App\NmrboxSession;

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
        /* if request coming with username from Angular frontend*/
        if($request->username)
            Session::put('username', $request->username);
        echo "<pre>";
        print_r(Session::get('person'));
        echo "</pre>";

        echo "<pre>";
        print_r(Session::get('user_is_admin'));
        echo "</pre>";

        echo "<pre>";
        print_r(Session::get('token'));
        echo "</pre>";

        die();

        if(!Session::has('person') &&  !Session::has('token') && !Session::has('user_is_admin')) {
            //return Redirect::route('login/'.$request->user);
            return Redirect::route('login');
        }

        return $next($request);
    }
}
