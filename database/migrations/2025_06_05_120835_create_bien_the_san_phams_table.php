<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienTheSanPhamsTable extends Migration
{
    public function up()
    {
        Schema::create('bien_the_san_pham', function (Blueprint $table) {
            $table->id('variant_id');
            $table->unsignedBigInteger('product_id');
            $table->string('ma_sku', 50)->unique();
            $table->decimal('gia_ban', 15, 2);
            $table->integer('so_luong_ton')->default(0);
            $table->string('hinh_anh', 255)->nullable();
            $table->enum('trang_thai', ['active', 'inactive', 'draft'])->default('active');
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('san_pham')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bien_the_san_pham');
    }
}
