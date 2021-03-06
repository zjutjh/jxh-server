<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class AdminCheck
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
        if (!$user = Auth::user()) {
            return RJM(null, -1, '用户过期');
        }
        if (!$user->isAdmin()) {
            return RJM(null, -1, '用户无权限');
        }
        return $next($request);
    }
}
