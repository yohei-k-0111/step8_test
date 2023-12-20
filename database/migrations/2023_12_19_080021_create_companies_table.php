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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // bigint(20) の ID
            $table->string('company_name', 255);
            $table->string('street_address', 255);
            $table->string('representative_name', 255);
            $table->timestamps(); // created_at と updated_at の timestamp
            $table->collation = 'utf8mb4_bin'; //大文字小文字・半角全角区別する
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('companies');
    }
};
