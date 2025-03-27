<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            ['name' => 'VIP', 'capacity' => 30, 'venue_id' => 1,'price' => 100],
            ['name' => 'Platinum', 'capacity' => 50, 'venue_id' => 1,'price' => 80],
            ['name' => 'Gold', 'capacity' => 100, 'venue_id' => 1,'price' => 60],
            ['name' => 'Silver', 'capacity' => 150, 'venue_id' => 1,'price' => 40],
            ['name' => 'Bronze', 'capacity' => 200, 'venue_id' => 1,'price' => 20]
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }
    }
}
