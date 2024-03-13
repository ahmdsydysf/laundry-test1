<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless(auth()->user()->isAdministrator(), 401);

        return $next($request);
    }
}
