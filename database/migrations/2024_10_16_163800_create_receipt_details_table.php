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
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_receipt');
            $table->unsignedBigInteger('id_ingredient');
            $table->integer('quantity');
            $table->integer('total_price');
            $table->timestamps();

            $table->foreign('id_receipt')->references('id')->on('receipts');
            $table->foreign('id_ingredient')->references('id')->on('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_details');
    }
};