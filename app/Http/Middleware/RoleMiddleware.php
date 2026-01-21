<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = null;
        $userRole = null;

        if (Auth::guard('superadmin')->check()) {
            $user = Auth::guard('superadmin')->user();
            $userRole = 'superadmin';
        } elseif (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $userRole = 'admin';
        } elseif (Auth::guard('kordinator')->check()) {
            $user = Auth::guard('kordinator')->user();
            $userRole = 'kordinator_sekolah';
        }

        if (!$user) {
            return redirect('/masuk')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}