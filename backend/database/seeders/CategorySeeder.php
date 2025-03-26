<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Música'
        ]);
        Category::create([
            'name' => 'Conferencia'
        ]);
        Category::create([
            'name' => 'Deporte'
        ]);
        Category::create([
            'name' => 'Cine'
        ]);
        Category::create([
            'name' => 'Teatro'
        ]);
        Category::create([
            'name' => 'Fiesta'
        ]);
        Category::create([
            'name' => 'Cultura'
        ]);
        Category::create([
            'name' => 'Arte'
        ]);
        Category::create([
            'name' => 'Gastronomía'
        ]);
        Category::create([
            'name' => 'Viajes'
        ]);
        Category::create([
            'name' => 'Otros'
        ]);
    }
}
