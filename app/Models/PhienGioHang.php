<?php

// app/Models/PhienGioHang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhienGioHang extends Model
{
    protected $table = 'phien_gio_hang';
    protected $primaryKey = 'session_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'cart_id',
        'expires_at',
    ];

    public function gioHang()
    {
        return $this->belongsTo(GioHang::class, 'cart_id', 'cart_id');
    }
}
