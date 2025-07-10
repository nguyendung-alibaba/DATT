<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaChiController;

Route::get('/phuong-xa', [DiaChiController::class, 'getPhuongXa']); // dạng ?tinh_id=...
Route::get('/tinh-thanh', [DiaChiController::class, 'getTinhThanh']);
Route::get('/tinh-thanh/{id}/phuong-xa', [DiaChiController::class, 'getPhuongXaTheoTinh']);