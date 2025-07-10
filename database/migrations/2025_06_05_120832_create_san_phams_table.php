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
        Schema::create('san_pham', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('ten_san_pham', 255);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('mo_ta_ngan', 500)->nullable();
            $table->text('mo_ta_chi_tiet')->nullable();
            $table->decimal('gia_goc', 15, 2);
            $table->boolean('has_variants')->default(false);
            $table->decimal('gia_ban', 15, 2);
            $table->integer('so_luong_ton')->default(0);
            $table->string('slug', 255)->unique();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_bestseller')->default(false);
            $table->enum('trang_thai', ['active', 'inactive', 'draft'])->default('active');
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('danh_muc_san_pham');
            $table->foreign('brand_id')->references('brand_id')->on('thuong_hieu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
