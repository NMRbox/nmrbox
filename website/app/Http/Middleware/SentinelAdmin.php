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
        /*if(!Sentinel::check())
            return Redirect::to('login')->with('error', 'You must be logged in!');
        elseif(!Session::has('user_is_admin'))
            return Redirect::to('my-account');*/
        //dd($request->user);
        /* if request coming with username from Angular frontend*/
        if($request->username)
            Session::put('username', $request->username);

        // Checking session data.
        //$session_data = NmrboxSession::where('id', $id)->get()->first();
        echo "<pre>";
        print_r(Session::get('person'));
        echo "</pre>";

        echo "<pre>";
        print_r(Session::get('user_is_admin'));
        echo "</pre>";

        if(!Session::has('person') and !Session::has('user_is_admin'))
            //return Redirect::route('login/'.$request->user);
            return Redirect::route('login');

        return $next($request);
    }
}
