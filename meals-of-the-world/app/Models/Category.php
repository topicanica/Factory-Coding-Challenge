<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model implements TranslatableContract
{
    use Translatable, HasFactory, Sluggable;

    public $translatedAttributes = ['title'];
    
    protected $fillable = ['title','slug'];

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'category_slug'
            ]
        ];
    }
    public function getCategorySlugAttribute(): string
    {
        return 'category' . '-' ;
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
