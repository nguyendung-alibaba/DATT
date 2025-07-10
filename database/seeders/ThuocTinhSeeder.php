<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\ThuocTinh;
use App\Models\GiaTriThuocTinh;

class ThuocTinhSeeder extends Seeder
{
    public function run()
    {
        // 1. Tạo thuộc tính màu sắc
        $color = ThuocTinh::create([
            'ten_thuoc_tinh' => 'Màu sắc',
            'mo_ta' => 'Phân biệt màu sản phẩm',
            'is_variant_attribute' => true,
        ]);
        // 2. Tạo giá trị cho thuộc tính màu sắc
        foreach (['Đỏ', 'Xanh', 'Đen'] as $mau) {
            GiaTriThuocTinh::create([
                'attribute_id' => $color->attribute_id, // PHẢI ĐẢM BẢO $color->attribute_id CÓ GIÁ TRỊ
                'gia_tri' => $mau,
            ]);
        }
    }
}
