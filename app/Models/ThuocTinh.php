<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThuocTinh extends Model
{
    protected $table = 'thuoc_tinh';
    protected $primaryKey = 'attribute_id';
    public $incrementing = true;
    public $timestamps = true;

    // Nếu bạn dùng fillable
    protected $fillable = [
        'ten_thuoc_tinh',
        'mo_ta',
        'is_variant_attribute',
    ];
    public function values()
    {
        return $this->hasMany(GiaTriThuocTinh::class);
    }

    // Trong app/Models/GiaTriThuocTinh.php
    public function attribute()
    {
        return $this->belongsTo(ThuocTinh::class);
    }
}
