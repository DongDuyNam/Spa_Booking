<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home'; // Hoặc đường dẫn mặc định khác sau khi đăng nhập

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
// ```
// eof

// Sau khi bạn tạo file **`RouteServiceProvider.php`** và đặt nó vào thư mục **`app/Providers/`**:

// 1.  Lỗi `Class 'App\Providers\RouteServiceProvider' not found` sẽ biến mất.
// 2.  Hệ thống sẽ hoạt động trở lại và có thể tiến hành kiểm tra phân quyền (Role Middleware) mà chúng ta đã cấu hình trước đó.

// Cuối cùng, hãy chạy lại lệnh xóa cache để đảm bảo mọi thứ được cập nhật:
// ```bash
// php artisan config:clear
// composer dump-autoload
