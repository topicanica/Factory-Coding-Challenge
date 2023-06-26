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

        Meal::factory(10)->create()->each(function ($meal) use ($categories) {
            $tags = Tag::factory(2)->create();
            $ingredients = Ingredient::factory(2)->create();
            $meal->tags()->attach($tags);
            $meal->ingredients()->attach($ingredients);
            $category = $categories->random();
            $meal->category()->associate($category)->save();

            $title = faker_translation('title', 'foodName');
            $description = faker_translation('description', 'foodName');

            foreach ($title as $locale => $translation) {
                $meal->translateOrNew($locale)->title = $translation['title'];
            }
            foreach ($description as $locale => $translation) {
                $meal->translateOrNew($locale)->description = $translation['description'];
            }

            $meal->save();
        });
    }
}