<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
public function run()
{
    DB::table('sizes')->insert([
        // Dung lượng bộ nhớ
        ['name' => '32GB',  'type' => 'memory'],
        ['name' => '64GB',  'type' => 'memory'],
        ['name' => '128GB', 'type' => 'memory'],
        ['name' => '256GB', 'type' => 'memory'],
        ['name' => '512GB', 'type' => 'memory'],
        ['name' => '1TB',   'type' => 'memory'],
        // Kích thước màn hình
        ['name' => '5.0 inch', 'type' => 'screen'],
        ['name' => '5.5 inch', 'type' => 'screen'],
        ['name' => '6.0 inch', 'type' => 'screen'],
        ['name' => '6.1 inch', 'type' => 'screen'],
        ['name' => '6.4 inch', 'type' => 'screen'],
        ['name' => '6.7 inch', 'type' => 'screen'],
    ]);
}

}
