<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = ['A', 'B', 'C', 'D'];
        $seatsPerRow = 10;
        
        foreach ($rows as $row) {
            for ($number = 1; $number <= $seatsPerRow; $number++) {
                Seat::create([
                    'row' => $row,
                    'number' => $number,
                    'zone' => 1
                ]);
            }
        }
    }
}
