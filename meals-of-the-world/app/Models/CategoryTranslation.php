<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;
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
    
}
