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
        //
        Schema::table('don_hang', function (Blueprint $table) {
            $table->string('trang_thai', 30)->change(); // hoặc lớn hơn nếu cần
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('don_hang', function (Blueprint $table) {
            $table->string('trang_thai', 20)->change(); // hoặc nhỏ hơn nếu cần
        });
    }
};
