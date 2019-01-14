<?php

namespace App\Http\Middleware;

use Closure;

class AuthGuardAdministrator
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
        if (auth()->guard('administrator')->check()) {
            return $next($request);
        }

        return redirect()->route('adm.auth.login.from');
    }
}
