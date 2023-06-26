<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model implements TranslatableContract
{
    use Translatable, HasFactory;

    public $translatedAttributes = ['title'];
    protected $fillable = ['title', 'slug'];

    public function meals() : BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_tag', 'tag_id', 'meal_id');
    }
}
