<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBehaviorLog extends Model
{
    use HasFactory;

    protected $table = 'user_behavior_logs';

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'action',
    ];

    // Quan hệ (tuỳ chọn)
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
