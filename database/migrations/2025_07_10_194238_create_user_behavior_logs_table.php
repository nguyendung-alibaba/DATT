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
        Schema::create('user_behavior_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Nếu khách vãng lai, có thể null
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('action'); // view, click, add_to_cart, purchase
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
           $table->foreign('product_id')->references('product_id')->on('san_pham')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_behavior_logs');
    }
};
