<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Factory as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Seed 10 categories
        for ($i = 1; $i <= 100; $i++) {

            $name = $faker->unique()->word;
            Tag::create([
                'name' => $name
            ]);
        }
    }
}
