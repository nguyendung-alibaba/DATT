<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhuongXa extends Model
{
    use HasFactory;

    protected $table = 'phuong_xa'; // Tên bảng
    protected $fillable = ['ma_tinh', 'ten_phuong_xa']; // Các cột có thể gán

    // Mỗi phường/xã thuộc 1 tỉnh
    public function tinhThanh()
    {
        return $this->belongsTo(TinhThanh::class, 'ma_tinh');
    }
}
