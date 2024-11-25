<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("accounts")->insert([
            [
                "user_id" => 1,
                "email" => "nhatnam201104@gmail.com",
                "username" => "conditrannam",
                "password" => Hash::make("12345678"),
                "status" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "user_type" => "App\Models\Customer",
            ],
            [
                "user_id" => 2,
                "email" => "trannam@gmail.com",
                "username" => "trannam",
                "password" => Hash::make("12345678"),
                "status" => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "user_type" => "App\Models\Customer",

            ],
            [
                "user_id" => 1,
                "email" => "admin@admin.com",
                "username" => "admin",
                "password" => Hash::make("admin"),
                "status" => 1,
                "user_type" => "App\Models\Employee",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ]);
    }
}
