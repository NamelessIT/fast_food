<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{

    public function run(): void
    {
        DB::table("payments")->insert([
            [
                "payment_name" => "thanh toán trực tiếp",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "payment_name" => "thanh toán chuyển khoản",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ]);
    }
}
