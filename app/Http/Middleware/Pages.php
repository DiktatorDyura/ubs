<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Pages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $pageName): Response
    {
        if ($pageName == "adminandteacher") {
            if ($request->user()->role == "admin" || $request->user()->role == "teacher") {
                return $next($request);
            } else {
                return redirect('forbidden');
            }
        }


        return $next($request);
    }
}
