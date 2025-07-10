<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('magiamgia', function (Blueprint $table) {
            $table->unsignedBigInteger('gia_tri_giam_toi_da')->nullable()->change(); // CHO PHÉP NULL
        });
    }

    public function down()
    {
        Schema::table('magiamgia', function (Blueprint $table) {
            $table->integer('gia_tri_giam_toi_da')->change(); // hoặc đúng kiểu cũ nếu biết
        });
    }
};
