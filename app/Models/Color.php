<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';
    protected $fillable = ['name', 'code']; // 'code' là mã màu HEX hoặc bất kỳ mã gì bạn cần
    public $timestamps = false; // Không tự động tạo/cập nhật created_at, updated_at

    public function variants()
    {
        return $this->hasMany(Variant::class, 'color_id');
    }
}
