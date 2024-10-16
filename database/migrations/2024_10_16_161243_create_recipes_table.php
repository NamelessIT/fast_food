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
        Schema::create('recipes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_ingredient');
            $table->decimal('quantity', 10, 2);
            $table->timestamps();

            $table->foreign('id_product')->references('id')->on('products');
            $table->foreign('id_ingredient')->references('id')->on('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};