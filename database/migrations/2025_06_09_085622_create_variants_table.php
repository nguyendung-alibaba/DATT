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
    Schema::create('variants', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('color_id')->nullable();
        $table->unsignedBigInteger('size_id')->nullable();
        $table->integer('price')->nullable();
        $table->integer('quantity')->nullable();
        $table->timestamps();

        $table->foreign('product_id')->references('product_id')->on('san_pham')->onDelete('cascade');
        $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
        $table->foreign('size_id')->references('id')->on('sizes')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
