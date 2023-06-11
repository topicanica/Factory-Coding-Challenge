<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class IngredientTranslation extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'slug'];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
    
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
