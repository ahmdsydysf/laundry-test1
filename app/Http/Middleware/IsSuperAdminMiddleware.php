<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 401);

        return $next($request);
    }
}
