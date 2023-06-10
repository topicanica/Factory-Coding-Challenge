<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class TagTranslation extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'slug'];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
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
