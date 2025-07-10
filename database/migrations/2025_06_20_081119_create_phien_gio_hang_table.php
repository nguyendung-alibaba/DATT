<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_phien_gio_hang_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhienGioHangTable extends Migration
{
    public function up()
    {
        Schema::create('phien_gio_hang', function (Blueprint $table) {
            $table->string('session_id')->primary();
            $table->unsignedBigInteger('cart_id')->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('expires_at');
            
            $table->foreign('cart_id')->references('cart_id')->on('gio_hang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('phien_gio_hang');
    }
}

