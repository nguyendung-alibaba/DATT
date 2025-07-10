<?php

// app/Models/ChiTietGioHang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
    protected $table = 'chi_tiet_gio_hang';
    protected $primaryKey = 'cart_item_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'so_luong',
        'status',
        'don_gia',
        'selected',
    ];

    public function gioHang()
    {
        return $this->belongsTo(GioHang::class, 'cart_id', 'cart_id');
    }

    public function product()
    {
        // Giả sử 'product_id' là khóa chính của bảng 'san_pham'
        // Nếu khóa chính là 'id', bạn có thể bỏ tham số thứ 3
        return $this->belongsTo(SanPham::class, 'product_id', 'product_id');
    }

    public function variant()
    {
        // Giả sử 'id' là khóa chính của bảng 'variants'
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
    public function sanPham()
    {
        return $this->belongsTo(\App\Models\SanPham::class, 'product_id');
    }
}
