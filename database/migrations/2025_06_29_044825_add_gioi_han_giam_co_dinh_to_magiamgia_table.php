<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('magiamgia', function (Blueprint $table) {
            $table->unsignedBigInteger('gioi_han_giam_co_dinh')->nullable()->after('gia_tri_giam_gia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magiamgia', function (Blueprint $table) {
            //
        });
    }
};
