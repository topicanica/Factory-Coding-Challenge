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
        $meals= Meal::factory(10)->create()->each(function ($meal) use ($categories) {
            $tags = Tag::factory(2)->create();
            $ingredients = Ingredient::factory(2)->create();
            $meal->tags()->attach($tags);
            $meal->ingredients()->attach($ingredients);
            $category = $categories->random();
            $meal->category()->associate($category)->save();
        });

        // // Associate random categories to meals
        // $meals->each(function ($meal) use ($categories) {
        //     $category = $categories->random();
        //     $meal->category()->associate($category)->save();
        // });
    }
}