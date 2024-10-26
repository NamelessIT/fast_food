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
        Schema::table('categories', function($table) {
            $table->string ('valueEn');
            $table->renameColumn('category_name', 'valueVi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function($table) {
            $table->dropColumn('valueEn');
            $table->renameColumn('valueVi', 'category_name');
        });
    }
};