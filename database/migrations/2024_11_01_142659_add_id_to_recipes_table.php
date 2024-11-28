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
        Schema::create('recipes_new', function (Blueprint $table) {
            $table->id(); // Adds an auto-incrementing primary key
            $table->string('name'); // Add your other columns here
            $table->timestamps(); // Add timestamps if needed
        });

        // Copy data from old table to new table
        DB::table('recipes_new')->insert(
            DB::table('recipes')->select('name', 'created_at', 'updated_at')->get()->toArray()
        );

        // Drop old table
        Schema::drop('recipes');

        // Rename new table to old table name
        Schema::rename('recipes_new', 'recipes');
    }

    public function down()
    {
        // Revert changes if needed
        Schema::dropIfExists('recipes');
    }

    
};
