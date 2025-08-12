<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user() && auth()->user()->role == 'admin'){
            return $next($request);
        }
        // Kalau sudah login tapi bukan admin
        if(auth()->check()){
            return redirect()->route('login')->with('error', 'Anda bukan administrator');
        }

        // Kalau belum login, langsung redirect login
        return redirect()->route('login');
    }
}
