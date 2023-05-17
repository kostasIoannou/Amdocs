<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all category IDs
        $categoryIds = Category::pluck('id')->all();

        // Get all tag IDs
        $tagIds = Tag::pluck('id')->all();

        // Seed 10,000 products
        for ($i = 1; $i <= 10000; $i++) {
            $name = $faker->words(rand(1, 3), true);
            $code = Product::generateUniqueCode();
            $category = $faker->randomElement($categoryIds);
            $price = $faker->randomFloat(2, 1, 1000);
            $releaseDate = $faker->dateTimeBetween('-1 year', 'now');
            $tags = $faker->randomElements($tagIds, rand(1, 5));

            $product = Product::create([
                'name' => $name,
                'code' => $code,
                'category_id' => $category,
                'price' => $price,
                'release_date' => $releaseDate,
            ]);

            $product->tags()->attach($tags);
        }
    }
}
