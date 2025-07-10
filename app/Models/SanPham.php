<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    //
    protected $table = 'san_pham'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'product_id';

    use HasFactory;


    protected $fillable = [
    'ten_san_pham', 'category_id', 'brand_id', 'image',
    'mo_ta_ngan', 'mo_ta_chi_tiet',
    'gia_goc', 'gia_ban', 'so_luong_ton',
    'slug', 'has_variants',
    'is_featured', 'is_bestseller', 'trang_thai',
];



    public function thuongHieu() {
    return $this->belongsTo(ThuongHieu::class, 'brand_id');
}
public function bienThe() {
    return $this->hasMany(BienTheSanPham::class, 'product_id');
}

public function danhMuc()
{
    return $this->belongsTo(DanhMucSanPham::class, 'category_id', 'category_id');
}

public function variants()
{
    return $this->hasMany(Variant::class, 'product_id');
}
public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}
public function behaviorLogs()
{
    return $this->hasMany(UserBehaviorLog::class, 'product_id');
}



}
