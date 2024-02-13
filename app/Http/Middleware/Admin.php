<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (is_user_role('Admin' ) || is_user_role( 'SuperAdmin')){
            return $next($request);
        }
        return redirect('error');
    }
}
