<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRecommendation extends Model
{
    protected $table = 'product_recommendations';

    protected $fillable = ['user_id', 'product_id', 'score'];

    public function product()
    {
        return $this->belongsTo(SanPham::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

