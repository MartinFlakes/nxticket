<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Host;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventHostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $events =   Event::all();
        $hosts =   Host::all();

        // asigna valores en la tabla pivote
        $events->each(function($events) use ($hosts){
            $events->hosts()->attach(
                $hosts->random(rand(1,3))->pluck('id')
            );
        });

    }
}
