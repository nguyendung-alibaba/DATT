<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    public function run()
    {
        DB::table('colors')->insert([
            ['name' => 'Đỏ', 'code' => '#FF0000'],
            ['name' => 'Xanh lá', 'code' => '#00FF00'],
            ['name' => 'Xanh dương', 'code' => '#0000FF'],
            ['name' => 'Vàng', 'code' => '#FFFF00'],
            ['name' => 'Đen', 'code' => '#000000'],
            ['name' => 'Trắng', 'code' => '#FFFFFF'],
            ['name' => 'Xám', 'code' => '#808080'],
            // Thêm các màu khác tùy ý
        ]);
    }
}
