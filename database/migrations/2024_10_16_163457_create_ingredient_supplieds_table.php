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
        Schema::create('ingredient_supplieds', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ingredient');
            $table->unsignedBigInteger('id_supplier');
            $table->decimal('ingredient_price', 10, 2);
            $table->timestamps();

            $table->foreign('id_ingredient')->references('id')->on('ingredients');
            $table->foreign('id_supplier')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_supplieds');
    }
};