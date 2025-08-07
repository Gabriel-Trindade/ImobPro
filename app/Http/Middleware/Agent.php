<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Agent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isAgent()) {
            return redirect('/auth/login')->with('error', 'Você não tem acesso de agente.');
        }

        if ($request->user()->isAgent()) {
            return $next($request);
        }
        return $next($request);
    }
}
