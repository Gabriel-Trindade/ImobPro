<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class Super
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->auth()->check() || !$request->auth()->user()->isSuper()) {
            dd('tem q parar aqui');
            abort(403, 'Acesso restrito ao super usuário!');
        }
        return $next($request);
    }
}
