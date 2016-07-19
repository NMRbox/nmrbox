<?php
/**
 * Created by PhpStorm.
 * User: djones
 * Date: 7/19/16
 * Time: 9:12 AM
 */

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!app()->environment('local') || true) {
            // for Proxies
            Request::setTrustedProxies([$request->getClientIp()]);

            if (!$request->isSecure()) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}