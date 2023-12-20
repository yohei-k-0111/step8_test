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
        Schema::create('sales', function (Blueprint $table) {
            $table->id(); // bigint(20) のID
            $table->unsignedBigInteger('product_id');
            $table->timestamps(); // created_at と updated_at の timestamp

            // 外部キー制約を追加
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->cascadeOnDelete()  // ON DELETE で CASCADE
                  ->cascadeOnUpdate(); // ON UPDATE で CASCADE
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sales');
    }
};
