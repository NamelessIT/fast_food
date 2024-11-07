<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("orders")->insert([
            [
                "id_customer" => 1,
                "total" => 200000,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [

                "id_customer" => 2,
                "total" => 400000,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]
        ]);
    }
}
