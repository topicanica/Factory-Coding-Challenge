<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable, HasFactory;

    public $translatedAttributes = ['title'];
    
    protected $fillable = ['title','slug'];

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
