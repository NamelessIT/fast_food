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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('user_type', 255);
            $table->string('email', 255)->unique();
            $table->string('username', 255)->unique();
            $table->string('password', 255);
            $table->binary('avatar')->nullable();
            // $table->mediumText('avatar')->charset('binary');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            // $table->foreign('id_user')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('id_user')->references('id')->on('employees')->onDelete('cascade');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email', 255);
            $table->string('token', 255);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->unsignedBigInteger('id_account')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};