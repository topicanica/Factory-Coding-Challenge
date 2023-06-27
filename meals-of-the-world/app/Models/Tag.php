<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model implements TranslatableContract
{
    use Translatable, HasFactory, Sluggable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['title', 'slug'];

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'tag_slug'
            ]
        ];
    }

    public function getTagSlugAttribute(): string
    {
        return 'tag' . '-' ;
    }

    public function meals() : BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_tag', 'tag_id', 'meal_id');
    }
}
