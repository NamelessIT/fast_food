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
        Schema::create('extra_food', function (Blueprint $table) {
            $table->id();
            $table->string('food_name')->unique();
            $table->decimal('cod_price',10, 8);
            $table->decimal('price',10, 8);
            $table->integer('quantity');
            $table->mediumText('image_show')->charset('binary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_food');
    }
};