<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThuocTinhsTable extends Migration
{
    public function up()
    {
        Schema::create('thuoc_tinh', function (Blueprint $table) {
            $table->id('attribute_id');
            $table->string('ten_thuoc_tinh', 100);
            $table->text('mo_ta')->nullable();
            $table->boolean('is_variant_attribute')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('thuoc_tinh');
    }
}
