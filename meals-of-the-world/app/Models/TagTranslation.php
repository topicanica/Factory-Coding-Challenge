<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class TagTranslation extends Model
{
    use Sluggable;

    public $timestamps = false;
    protected $fillable = ['title', 'slug'];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

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
}
