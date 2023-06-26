<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class IngredientTranslation extends Model
{
    use Sluggable;
    
    public $timestamps = false;
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
}
