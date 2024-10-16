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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement();
            $table->unsignedBigInteger('id_category');
            $table->string('product_name', 255);
            $table->decimal('cod_price', 10, 2);
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('id_promotion')->default(0);
            $table->text('description')->nullable();
            $table->binary('image_show')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreign('id_promotion')->references('id')->on('promotions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};