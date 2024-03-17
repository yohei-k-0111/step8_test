<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // 購入数'quantity'カラムを定義
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->comment('購入数')->after('product_id');
            // nullを許容する product_idの後ろに追加する
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('quantity'); //upで追加したカラム
        });
    }
};
