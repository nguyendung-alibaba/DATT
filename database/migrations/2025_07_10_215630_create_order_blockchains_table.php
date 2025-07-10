<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_blockchains', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('don_hang_id');
            $table->longText('data'); // JSON toàn bộ thông tin đơn hàng
            $table->string('current_hash', 255); // hash hiện tại
            $table->string('previous_hash', 255); // hash block trước

            $table->timestamps();

            $table->foreign('don_hang_id')->references('id')->on('don_hang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_blockchains');
    }
};
