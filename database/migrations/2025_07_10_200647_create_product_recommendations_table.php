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
        Schema::create('product_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ✅ Khai báo cột product_id
            $table->unsignedBigInteger('product_id');

            // ✅ Thiết lập khóa ngoại cho product_id
            $table->foreign('product_id')->references('product_id')->on('san_pham')->onDelete('cascade');

            $table->float('score')->default(0); // Mức độ gợi ý
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_recommendations');
    }
};
