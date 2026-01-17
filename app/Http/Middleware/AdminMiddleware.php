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
    public function handle(Request $request, Closure $next): Response
    {
        // Skontroluj či je user prihlásený a či má admin rolu
        if (!auth()->check() || !auth()->user()->is_admin()) {
            abort(403, 'Nemáš povolenie pristúpiť na túto stránku.');
        }

        return $next($request);
    }
}

