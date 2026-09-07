<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoLoginDemoUser
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('login') || $request->is('register') || $request->is('forgot-password') || $request->is('reset-password/*') || $request->is('confirm-password') || $request->is('verify-email') || $request->is('verify-email/*') || $request->is('email/verification-notification') || $request->is('logout')) {
            return $next($request);
        }

        if ($request->route() && $request->route()->named([
            'login',
            'register',
            'password.request',
            'password.email',
            'password.reset',
            'password.store',
            'password.confirm',
            'verification.notice',
            'verification.verify',
            'verification.send',
            'logout',
        ])) {
            return $next($request);
        }

        if (!Auth::check()) {
            Auth::loginUsingId(1); // the demo user created in Step 1
        }

        return $next($request);
    }
}