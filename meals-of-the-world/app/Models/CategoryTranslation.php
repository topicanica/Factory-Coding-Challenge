<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use Sluggable;

    protected $fillable = ['title','slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    } 

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }
    
}
