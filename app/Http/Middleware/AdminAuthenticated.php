<?php

namespace Sweet\Http\Middleware;

use Closure;

class AdminAuthenticated
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
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }else if(auth()->check()){
            return redirect('/' . strtolower(auth()->user()->userType->id));
        }

        return redirect('/login');
    }
}
