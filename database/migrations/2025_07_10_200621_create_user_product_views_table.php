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
        Schema::create('user_product_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // ✅ Thêm cột product_id
            $table->unsignedBigInteger('product_id');

            // ✅ Thêm ràng buộc FK cho product_id
            $table->foreign('product_id')->references('product_id')->on('san_pham')->onDelete('cascade');

            $table->integer('view_count')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_product_views');
    }
};
