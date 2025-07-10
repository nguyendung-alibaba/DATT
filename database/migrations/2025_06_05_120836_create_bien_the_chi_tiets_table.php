<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienTheChiTietsTable extends Migration
{
    public function up()
    {
        Schema::create('bien_the_chi_tiet', function (Blueprint $table) {
            $table->id('variant_detail_id');
            $table->unsignedBigInteger('variant_id');
            $table->unsignedBigInteger('attribute_value_id');
            $table->timestamps();

            $table->foreign('variant_id')->references('variant_id')->on('bien_the_san_pham')->onDelete('cascade');
            $table->foreign('attribute_value_id')->references('attribute_value_id')->on('gia_tri_thuoc_tinh')->onDelete('cascade');
            $table->unique(['variant_id', 'attribute_value_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bien_the_chi_tiet');
    }
}
