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
        Schema::create('permission_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id_permission');
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_task');
            $table->timestamps();
            
            $table->foreign('id_permission')->references('id')->on('permissions');
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_task')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_details');
    }
};