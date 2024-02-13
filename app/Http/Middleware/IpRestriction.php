<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IpRestriction
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
        if( Auth::user()->ip_access == true ){
            if (Auth::user()->ip_address == $request->ip() ){
                return $next($request);
            }
            return redirect('403');
        }
        else{
            return $next($request);
        }
    }
}
