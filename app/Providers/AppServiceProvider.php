<?php

namespace App\Providers;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Models\DonHang;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        View::composer('*', function ($view) {
        $soDonHangChoXacNhan = DonHang::where('trang_thai', 'pending')->count();
        $view->with('soDonHangChoXacNhan', $soDonHangChoXacNhan);
    });
        Carbon::setLocale('vi');
        Route::middleware('role', RoleMiddleware::class);
        view()->composer('client.layouts.app', function ($view) {
        $cartCount = 0;
        if (auth()->check()) {
            $cart = \App\Models\GioHang::where('user_id', auth()->id())->first();
            if ($cart) {
                $cartCount = $cart->chiTietGioHang()->sum('so_luong');
            }
        } else {
            // Nếu dùng session cho khách
            $cartId = session('cart_id');
            if ($cartId) {
                $cart = \App\Models\GioHang::find($cartId);
                if ($cart) {
                    $cartCount = $cart->chiTietGioHang()->sum('so_luong');
                }
            }
        }
        $view->with('cartCount', $cartCount);
    });
    }
}
