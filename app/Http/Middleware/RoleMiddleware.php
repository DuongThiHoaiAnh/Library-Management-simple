<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            if ($request->is('admin/*')) {
                return redirect()->route('admin.login-admin');
            }

            return redirect()->route('user.login-user');
        }

        if (Auth::user()->vaiTro !== $role) {
            abort(403, '🚫 Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
