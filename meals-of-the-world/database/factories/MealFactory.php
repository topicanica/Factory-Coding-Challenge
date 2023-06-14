<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Meal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = faker_translation('title', 'foodName');
        $description = faker_translation('description', 'foodName');

        $meal = Meal::create();

        foreach ($title as $locale => $translation) {
            $meal->translateOrNew($locale)->title = $translation['title'];
            $meal->translateOrNew($locale)->description = $description[$locale]['description'];
            $meal->category()->associate(Category::factory()->create())->save();
        }

        return [];
    }
}
