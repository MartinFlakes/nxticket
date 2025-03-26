<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory()->count(10)->create();
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            VenueSeeder::class,
            EventSeeder::class,
            HostSeeder::class,
            EventHostSeeder::class
        ]);
    }
}