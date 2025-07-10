<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThuongHieusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('thuong_hieu', function (Blueprint $table) {
            $table->id('brand_id'); // Khóa chính, tự tăng
            $table->string('ten_thuong_hieu', 100)->unique(); // Tên thương hiệu, duy nhất
            $table->string('xuat_xu', 100)->nullable(); // Xuất xứ, có thể để null
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('thuong_hieu');
    }
}

