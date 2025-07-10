<?php

namespace App\Models;

use App\Models\SanPham; // Đảm bảo đã import model SanPham
use App\Models\Color; // Đảm bảo đã import model Color
use App\Models\Size; // Đảm bảo đã import model Size
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    // Nếu bảng tên là 'variants' đúng chuẩn thì không cần khai báo $table

    // Nếu không sử dụng timestamps (created_at, updated_at) thì để false
    // public $timestamps = false;

    protected $fillable = [
        'product_id',   // Khóa ngoại liên kết tới bảng san_pham
        'thumbnail', // Ảnh đại diện biến thể (nếu có)
        'color_id',        // Màu sắc biến thể
        'size_id',         // Kích cỡ biến thể
        'price',        // Giá biến thể
        'quantity',     // Số lượng tồn kho
        // Thêm các trường khác nếu có, ví dụ: 'image'
    ];

    /**
     * Quan hệ: Mỗi biến thể thuộc về 1 sản phẩm
     */
    public function sanPham() {
    return $this->belongsTo(SanPham::class, 'product_id');
}
public function color() {
    return $this->belongsTo(Color::class, 'color_id');
}
public function size() {
    return $this->belongsTo(Size::class, 'size_id');
}

}
