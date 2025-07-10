<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_chi_tiet_gio_hang_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietGioHangTable extends Migration
{
    public function up()
    {
        Schema::create('chi_tiet_gio_hang', function (Blueprint $table) {
            $table->id('cart_item_id');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->integer('so_luong')->default(1);
            $table->enum('status', ['active', 'removed'])->default('active');
            $table->decimal('don_gia', 15, 2);
            $table->boolean('selected')->default(true);
            $table->timestamps();

            $table->foreign('cart_id')->references('cart_id')->on('gio_hang')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('san_pham')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chi_tiet_gio_hang');
    }
}
