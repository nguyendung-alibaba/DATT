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
        Schema::table('magiamgia', function (Blueprint $table) {
            $table->dropColumn('gia_tri_don_hang_toi_da'); // nếu không cần dùng nữa
            $table->decimal('gia_tri_giam_toi_da', 10, 2)->nullable()->after('gia_tri_giam_gia');
        });
    }

    public function down()
    {
        Schema::table('magiamgia', function (Blueprint $table) {
            $table->decimal('gia_tri_don_hang_toi_da', 10, 2)->nullable(); // phục hồi nếu rollback
            $table->dropColumn('gia_tri_giam_toi_da');
        });
    }
};
