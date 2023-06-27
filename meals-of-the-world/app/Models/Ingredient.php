<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;

class Ingredient extends Model implements TranslatableContract
{
    use Translatable, HasFactory, Sluggable;

    public $translatedAttributes = ['title'];

    protected $fillable = ['title', 'slug'];

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'ingredient_slug'
            ]
        ];
    }

    public function getIngredientSlugAttribute(): string
    {
        return 'ingredient' . '-' ;
    }
    
    public function meals()
    {
        return $this->belongsToMany(Tag::class, 'ingredient_meal','meal_id','tag_id');
    }
}
