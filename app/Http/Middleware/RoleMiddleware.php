<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Nếu role_id khớp => cho qua
        if (in_array($user->role_id, $roles)) {
            return $next($request);
        }

        // Nếu không khớp => về đúng trang dashboard của role hiện tại
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role_id == 2) {
            return redirect()->route('staff.dashboard');
        } elseif ($user->role_id == 3) {
            return redirect()->route('customer.dashboard');
        }

        return redirect()->route('home');
    }
}
