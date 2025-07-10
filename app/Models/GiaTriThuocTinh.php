<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiaTriThuocTinh extends Model
{
    protected $table = 'gia_tri_thuoc_tinh';
    protected $primaryKey = 'attribute_value_id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'attribute_id',
        'gia_tri',
        'hien_thi_duyet',
    ];
}

