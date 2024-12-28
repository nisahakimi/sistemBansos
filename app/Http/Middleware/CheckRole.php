<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,  $role): Response
    {
        // dd(Auth::user());
        if (Auth::user() && Auth::user()->role === $role) {
            return $next($request);
        }

        // return redirect('/home');
        return redirect()->route('not.authorized')->with('error', 'You are not authorized to access this page.');
     }
}
