<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('MaGiamGia', function (Blueprint $table) {
            $table->increments('voucher_id');
            $table->string('ma_code', 50)->unique();
            $table->string('ten_voucher');
            $table->text('mo_ta')->nullable();

            $table->enum('loai_giam_gia', ['percentage', 'fixed_amount']);
            $table->decimal('gia_tri_giam_gia', 10, 2);
            $table->decimal('gia_tri_don_hang_toi_thieu', 15, 2)->default(0.00);
            $table->decimal('gia_tri_don_hang_toi_da', 15, 2)->nullable()->after('gia_tri_don_hang_toi_thieu');

            $table->dateTime('ngay_bat_dau');
            $table->dateTime('ngay_ket_thuc');

            $table->integer('so_luong_gioi_han')->default(1);
            $table->integer('so_luong_da_dung')->default(0);

            $table->enum('trang_thai', ['active', 'inactive'])->default('active');

            $table->timestamps(); // created_at và updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MaGiamGia');
    }
};
