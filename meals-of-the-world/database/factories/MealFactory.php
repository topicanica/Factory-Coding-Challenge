<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use \App\Models\Meal;
use \App\Models\Tag;
use \App\Models\Ingredient;
use \App\Models\Category;
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
        return [];
    }

     /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (TranslatableContract $model) {

            $title = faker_translation('title', 'foodName');
            $description = faker_translation('description', 'foodName');

            foreach ($title as $locale => $translation) {
                $model->translateOrNew($locale)->fill([
                    'title' => $translation['title'],
                ]);
            }
            foreach ($description as $locale => $translation) {
                $model->translateOrNew($locale)->fill([
                    'description' => $translation['description'],
                ]);
            }
        });
    }
}
