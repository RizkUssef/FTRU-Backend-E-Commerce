<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_color_sizes', function (Blueprint $table) {
            $table->id();
            $table->enum("stock",["in_stock","out_of_stock"])->default("out_of_stock");
            $table->integer('quantity');
            $table->string("image");
            $table->unsignedBigInteger('product_colors_id');
            $table->foreign('product_colors_id')->references('id')->on('product_colors');
            $table->unsignedBigInteger('product_sizes_id');
            $table->foreign('product_sizes_id')->references('id')->on('product_sizes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_color_sizes');
    }
};
