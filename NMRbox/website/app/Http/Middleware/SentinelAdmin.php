<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use Session;
use App\NmrboxSession;

class SentinelAdmin {
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {
		/* if request coming with username from Angular frontend*/
		if ( $request->username ) {
			Session::put( 'username', $request->username );
		}

		echo "<pre>";
		print_r(Session::all());
		echo "</pre>";

		if ( Session::has( 'user_is_admin' ) === false ) {
			var_dump(Session::get('user_id_admin'));
			var_dump(Session::has('user_id_admin'));
			die;
			// Destroying the session
			Session::flush();

			return Redirect::route( 'login' );
		}


		return $next( $request );
	}
}
