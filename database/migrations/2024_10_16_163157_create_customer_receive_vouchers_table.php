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
        Schema::create('customer_receive_vouchers', function (Blueprint $table) {
            $table->unsignedBigInteger('id_voucher');
            $table->unsignedBigInteger('id_customer');
            $table->timestamps();

            $table->foreign('id_voucher')->references('id')->on('vouchers');
            $table->foreign('id_customer')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_receive_vouchers');
    }
};