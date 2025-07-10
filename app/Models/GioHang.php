<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GioHang extends Model
{
    use HasFactory;

    protected $table = 'gio_hang';
    protected $primaryKey = 'cart_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    /**
     * Định nghĩa mối quan hệ HasMany với ChiTietGioHang.
     * Một giỏ hàng có nhiều chi tiết giỏ hàng.
     */
    public function chiTietGioHang() // Đổi tên từ 'items()' thành 'chiTietGioHang()' để khớp với controller
    {
        return $this->hasMany(ChiTietGioHang::class, 'cart_id', 'cart_id');
    }

    /**
     * Phiên giỏ hàng liên quan (nếu có).
     */
    public function phien()
    {
        return $this->hasOne(PhienGioHang::class, 'cart_id', 'cart_id');
    }
    public function chiTiet()
{
    return $this->hasMany(\App\Models\ChiTietGioHang::class, 'cart_id', 'cart_id');
}

}