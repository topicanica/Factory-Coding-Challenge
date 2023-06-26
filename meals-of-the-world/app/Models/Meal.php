<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends Model implements TranslatableContract
{
    use SoftDeletes,Translatable,HasFactory;

    public $translatedAttributes = ['title','description'];
    protected $fillable = ['title','description','status'=>'created'];
    //protected $dates = ['deleted_at'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'meal_tag', 'meal_id', 'tag_id');
    }

    public function ingredients() 
    {
        return $this->belongsToMany(Ingredient::class);
    }
}
