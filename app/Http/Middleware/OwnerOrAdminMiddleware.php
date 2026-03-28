<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerOrAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login-form');
        }

        if (!auth()->user()->isOwner() && !auth()->user()->isAdmin()) {
            return redirect()->back(fallback: route('dashboard'));
        }

        return $next($request);
    }
}
