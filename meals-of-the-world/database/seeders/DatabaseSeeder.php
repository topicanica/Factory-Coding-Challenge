<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory(10)->create();
        $tags = Tag::factory(10)->create();
        $ingredients = Ingredient::factory(10)->create();

        Meal::factory(10)->create()->each(function ($meal) use ($categories, $tags, $ingredients) {
            $meal->tags()->attach($tags->random(2), ['created_at' => now(), 'updated_at' => now()]);
            $meal->ingredients()->attach($ingredients->random(2), ['created_at' => now(), 'updated_at' => now()]);

            if (rand(0, 1)) {
                $category = $categories->random();
                $meal->category()->associate($category);
            } else {
                $meal->category_id = null;
            }

            $meal->save();
        });
    
        $mealToDelete = Meal::inRandomOrder()->limit(3);
        $mealToDelete->delete();
    }
}