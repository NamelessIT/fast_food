<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SlideSeeder::class);
        $this->call(VoucherSeeder::class);
        $this->call(ExtraFoodSeeder::class);
        $this->call(ExtraFoodDetailSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(AccountSeeder::class);
        // $this->call(OrderSeeder::class);
        // $this->call(OrderDetailSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EmployeeSeeder::class);
    }
}
