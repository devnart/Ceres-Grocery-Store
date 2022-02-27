<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role == 'client') {
            return $next($request);
        } 

        if (Auth::user()->role == 'admin') {
            return response([
                'message' => 'You are not authorized to access this page'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
