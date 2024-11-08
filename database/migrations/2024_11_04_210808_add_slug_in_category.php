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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_valueen_unique'); 
            $table->dropColumn('valueEn');
            $table->string('slug');
            $table->renameColumn('valueVi', 'category_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('valueEn')->unique(); // Adding unique constraint back if needed
            $table->dropColumn('slug');
            $table->renameColumn('category_name', 'valueVi');
        });
    }
};