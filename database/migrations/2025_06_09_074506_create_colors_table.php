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
    Schema::create('colors', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // tên màu, ví dụ: Đỏ, Xanh, Đen...
        $table->string('code')->nullable(); // mã màu HEX, ví dụ: #FF0000 (nếu cần)
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
