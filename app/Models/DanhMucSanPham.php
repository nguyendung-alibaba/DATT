<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucSanPham extends Model
{
    //
    protected $table = 'danh_muc_san_pham';
    protected $primaryKey = 'category_id';
    public $incrementing = true; // nếu khóa chính là auto increment
    protected $keyType = 'int'; // nếu id là số nguyên

    public $timestamps = false;


    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'category_id');
    }
}
