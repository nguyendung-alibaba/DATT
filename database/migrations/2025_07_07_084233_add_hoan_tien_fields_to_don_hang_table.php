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
        Schema::table('don_hang', function (Blueprint $table) {
    $table->string('trang_thai')->default('pending')->change();
    $table->string('ly_do_khieu_nai')->nullable();
    $table->timestamp('ngay_khieu_nai')->nullable();
    $table->timestamp('ngay_hoan_tien')->nullable();
    $table->string('phuong_thuc_hoan')->nullable(); // ví, ngân hàng
    $table->string('stk_nguoi_nhan')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('don_hang', function (Blueprint $table) {
            //
        });
    }
};
