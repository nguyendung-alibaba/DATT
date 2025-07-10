<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiaTriThuocTinhsTable extends Migration
{
    public function up()
    {
        Schema::create('gia_tri_thuoc_tinh', function (Blueprint $table) {
            $table->id('attribute_value_id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('gia_tri', 100);
            $table->boolean('hien_thi_duyet')->default(true);
            $table->timestamps();

            $table->foreign('attribute_id')->references('attribute_id')->on('thuoc_tinh')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gia_tri_thuoc_tinh');
    }
}
