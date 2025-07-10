<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHangChiTiet extends Model
{
    use HasFactory;

    protected $table = 'don_hang_chi_tiet';
    protected $primaryKey = 'id';

    protected $fillable = [
        'don_hang_id',
        'product_id',
        'variant_id',
        'ten_san_pham',
        'so_luong',
        'don_gia',
        'thanh_tien',
    ];

    protected $casts = [
        'don_gia' => 'decimal:2',
        'thanh_tien' => 'decimal:2',
    ];

    // Relationships
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'product_id', 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
