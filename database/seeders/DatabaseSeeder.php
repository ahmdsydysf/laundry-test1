<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ServiceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                SettingSeeder::class,
                UserSeeder::class,
                ServiceSeeder::class,
                ItemServiceSeeder::class,
                CustomerSeeder::class,
//                OrderSeeder::class
            ]
        );
    }
}
