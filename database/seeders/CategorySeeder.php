<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed 10 categories
        for ($i = 1; $i <= 10; $i++) {
            $name = $faker->lexify(str_repeat('?', rand(1, 10)));
            
            Category::create([
                'name' => $name
            ]);
        }
        
    }
}
