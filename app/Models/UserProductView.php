<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProductView extends Model
{
    protected $table = 'user_product_views';

    protected $fillable = ['user_id', 'product_id', 'view_count'];

    public function product()
    {
        return $this->belongsTo(SanPham::class, 'product_id', 'product_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
