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
        Schema::table('don_hang', function (Blueprint $table) {
            $table->unsignedTinyInteger('so_lan_giao_that_bai')->default(0)->after('trang_thai');
        });
    }

    public function down()
    {
        Schema::table('don_hang', function (Blueprint $table) {
            $table->dropColumn('so_lan_giao_that_bai');
        });
    }
};
