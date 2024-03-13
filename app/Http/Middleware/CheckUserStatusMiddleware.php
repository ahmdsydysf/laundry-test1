<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;

class CheckUserStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->isSuspended()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return to_route('login')->withErrors(['phone' => 'تم إيقاف هذا الحساب. تواصل مع أحد المسؤولين.']);
        }
        return $next($request);
    }
}
