<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\MaGiamGiaController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// ==================== TRANG CHỦ ====================
Route::get('/',  function () {
    return view('welcome')->with('title', 'Trang chủ');
})->name('home');

// ==================== AUTH ====================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== ADMIN (auth + role:admin) ====================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard')->with('title', 'Dashboard');
    })->name('admin.dashboard');

    Route::resource('sanpham', SanPhamController::class);
    Route::resource('don-hang', DonHangController::class);
    Route::post('/don-hang/{id}/xac-nhan', [DonHangController::class, 'xacNhan'])->name('donhang.confirm');
    
    Route::resource('ma-giam-gia', MaGiamGiaController::class);
    Route::resource('variant', VariantController::class);

    Route::get('sanpham/variant-template', [SanPhamController::class, 'variantTemplate'])
        ->name('sanpham.variantTemplate');
});
// Các route mở rộng cho xử lý trạng thái đơn hàng
Route::prefix('admin/don-hang')->name('admin.donhang.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('{id}/xac-nhan', [DonHangController::class, 'xacNhan'])->name('confirm');
    Route::get('{id}/huy', [DonHangController::class, 'huyDon'])->name('cancel');
    Route::get('{id}/giao-hang', [DonHangController::class, 'giaoHang'])->name('shipping');
    Route::get('{id}/hoan-thanh', [DonHangController::class, 'hoanThanh'])->name('complete');
    Route::get('{id}/tra-hang', [DonHangController::class, 'traHang'])->name('return');
});
// Hiển thị danh sách đơn hàng của người dùng
Route::get('/don-hang', [DonHangController::class, 'clientIndex'])->name('client.donhang.index');

// Xác nhận đã nhận hàng
Route::post('/don-hang/{id}/hoan-thanh', [DonHangController::class, 'hoanThanhClient'])->name('client.donhang.hoanThanh');

// Trang chi tiết đơn hàng (tuỳ chọn)
Route::get('/don-hang/{id}', [DonHangController::class, 'clientShow'])->name('client.donhang.show');


Route::post('/admin/upload-temp-image', function (Request $request) {
    // THÊM ĐOẠN XÁC THỰC NÀY
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Yêu cầu là ảnh, định dạng phổ biến, tối đa 2MB
    ]);
    // KẾT THÚC ĐOẠN XÁC THỰC

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $originalExtension = $file->getClientOriginalExtension();
        $fileName = 'temp_' . Str::random(20) . '.' . $originalExtension;

        $path = $file->storeAs('public/temp_uploads', $fileName);

        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
            'temp_path' => $path
        ]);
    }


    return response()->json(['success' => false, 'message' => 'No file uploaded.'], 400);
})->name('upload.temp.image');

// ==================== CLIENT (auth + role:client) ====================


Route::prefix('client')->middleware(['auth', 'role:client,admin'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('client.dashboard');
    Route::resource('products', ProductController::class);
    // Route mở rộng cho trạng thái đơn hàng
Route::post('don-hang/{id}/xac-nhan', [DonHangController::class, 'xacNhan'])->name('donhang.confirm');
Route::post('don-hang/{id}/huy', [DonHangController::class, 'huyDon'])->name('donhang.huy');
Route::post('don-hang/{id}/giao-hang', [DonHangController::class, 'giaoHang'])->name('donhang.giaohang');
 Route::post('don-hang/{id}/nhan-hang', [DonHangController::class, 'hoanThanhClient'])->name('client.donhang.nhanhang');
Route::post('don-hang/{id}/hoan-thanh', [DonHangController::class, 'hoanThanh'])->name('donhang.hoanthanh');
Route::post('don-hang/{id}/giao-that-bai', [DonHangController::class, 'giaoThatBai'])->name('donhang.thatbai');
Route::post('don-hang/{id}/nhanve', [DonHangController::class, 'nhanVeKho'])->name('donhang.nhanve');

Route::post('don-hang/{id}/tra-hang', [DonHangController::class, 'traHang'])->name('donhang.trahang');
// web.php
Route::post('don-hang/{id}/confirm-complete', [DonHangController::class, 'xacNhanHoanThanh'])->name('donhang.confirm-complete');
Route::get('don-hang/{id}/khieu-nai', [DonHangController::class, 'formKhieuNai'])->name('donhang.khieunai');
Route::post('don-hang/{id}/khieu-nai', [DonHangController::class, 'submitKhieuNai'])->name('donhang.khieunai.submit');


    // Route::resource('checkout', CheckoutController::class)->only(['show']);
});

// ==================== CART & CHECKOUT ====================
Route::resource('cart', CartController::class)->except(['update']);
Route::put('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.update_all');
Route::delete('/cart-clear', [CartController::class, 'clear'])->name('cart.clear');
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// ==================== SEARCH ====================
Route::get('/search', [SearchController::class, 'index'])->name('search');
// Route::post('/checkout/apply-discount', [CheckoutController::class, 'applyDiscount'])->name('checkout.applyDiscount');
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/apply-discount', [CheckoutController::class, 'applyDiscount'])->name('checkout.applyDiscount');
Route::post('/checkout/remove-discount', [CheckoutController::class, 'removeDiscount'])->name('checkout.removeDiscount');

Route::middleware(['auth', 'role:client,admin'])->prefix('client')->group(function () {
    // Trang hiển thị form thanh toán
    Route::get('/thanh-toan', [CheckoutController::class, 'paymentForm'])->name('checkout.payment');
    // Xử lý đơn hàng sau khi xác nhận
    Route::post('/thanh-toan', [CheckoutController::class, 'processPayment'])->name('checkout.process');
});

// Trang thanh toán thành công
Route::get('/checkout/success/{order?}', [CheckoutController::class, 'paymentSuccess'])->name('checkout.success');

// VNPay routes (không cần middleware vì VNPay sẽ redirect về)
Route::get('/vnpay/return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
Route::get('/blockchain/check', [DonHangController::class, 'kiemTraBlockchain'])->name('blockchain.check');
