<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->user()->accepted && config('auth.accept_invite_only')) {
            return redirect()->route('settings.profile')
                ->with('error', 'You need to accept the terms and conditions to access this page.');
        }

        return $next($request);
    }
}
