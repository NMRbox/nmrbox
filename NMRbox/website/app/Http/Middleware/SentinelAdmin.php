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

        /*if(empty(Session::get('person')) &&  empty(Session::get('token')) && empty(Session::get('user_is_admin'))) {
            //return Redirect::route('login/'.$request->user);
            Session::flush();
            return Redirect::route('login');
        }*/

        return $next($request);
    }
}
