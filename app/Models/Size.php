<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';
    protected $fillable = ['name', 'type']; // Thêm 'type' nếu có phân loại size

    public $timestamps = false; // Nếu bảng không dùng created_at, updated_at

    public function variants()
    {
        return $this->hasMany(Variant::class, 'size_id');
    }
}
