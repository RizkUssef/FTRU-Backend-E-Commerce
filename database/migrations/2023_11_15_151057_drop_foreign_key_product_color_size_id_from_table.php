<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['product_color_size_id']);
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('product_color_size_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('product_color_size_id');
            $table->foreign('product_color_size_id')->references('id')->on('product_color_sizes');
        });
    }
};
