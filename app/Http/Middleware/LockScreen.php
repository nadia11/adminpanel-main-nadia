<?php

namespace App\Http\Middleware;

use Closure;

class LockScreen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }

    public function handle($request, Closure $next)
    {
        if ( time() - Session::get('last_activity') >= 600 ) {
            return redirect('lockscreen');
        }

        if ($request->session()->has('lockscreen')) {
            return redirect('/lockscreen');
        }
        return $next($request);
    }
}




