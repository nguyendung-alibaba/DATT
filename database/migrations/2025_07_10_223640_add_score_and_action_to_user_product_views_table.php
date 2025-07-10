<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreAndActionToUserProductViewsTable extends Migration
{
    public function up()
    {
        Schema::table('user_product_views', function (Blueprint $table) {
            $table->integer('score')->default(0)->after('view_count');
            $table->string('action')->nullable()->after('score');
        });
    }

    public function down()
    {
        Schema::table('user_product_views', function (Blueprint $table) {
            $table->dropColumn(['score', 'action']);
        });
    }
}
