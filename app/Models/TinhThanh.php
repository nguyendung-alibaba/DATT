<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TinhThanh extends Model
{
    use HasFactory;

    protected $table = 'tinh_thanh'; // Tên bảng
    protected $fillable = ['ten_tinh']; // Các cột có thể gán

    // 1 tỉnh có nhiều phường/xã
    public function phuongXas()
    {
        return $this->hasMany(PhuongXa::class, 'ma_tinh');
    }
}
