<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider; // DÒNG THÊM MỚI QUAN TRỌNG
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  ...$guards
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Sửa: Thay vì RouteServiceProvider::HOME (dòng 24 trong ảnh lỗi), 
                // ta cần đảm bảo class được import.
                return redirect(RouteServiceProvider::HOME); 
            }
        }

        return $next($request);
    }
}
// ```
// eof

// #### ⚠️ Lưu ý bổ sung:

// Sau khi sửa file này, nếu bạn vẫn gặp lỗi:

// 1.  **Kiểm tra file `RouteServiceProvider.php`:** Đảm bảo file này tồn tại trong thư mục **`app/Providers/`** và có định nghĩa hằng số `HOME`. Nếu nó bị thiếu, bạn cần tạo lại nó.
// 2.  **Chạy lại lệnh Cache:** Luôn luôn chạy lệnh này sau khi thêm hoặc sửa các Providers/Middleware:
//     ```bash
//     php artisan config:clear
//     composer dump-autoload
    
