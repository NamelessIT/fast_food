<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->id()->first(); // Adds the auto-incrementing primary key at the first position
        });
       
       
    }

    public function down()
    {
        // Revert changes if needed
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('id'); // Remove the 'id' column if needed
        });
    }

    
};
