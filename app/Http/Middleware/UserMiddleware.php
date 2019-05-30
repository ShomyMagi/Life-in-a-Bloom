<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use function abort;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if($request->session()->has('user'))
        {
            return $next($request);
        }
        abort(404);
        \Log::error('Pokusaj upada preko ' . $request->get()->ip() . ' adrese');
    }
}