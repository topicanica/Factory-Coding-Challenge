<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;


class Meal extends Model implements TranslatableContract
{
    use SoftDeletes,Translatable,HasFactory;

    public $timestamps = true;
    //protected $dates = ['deleted_at'];
     
    public $translatedAttributes = ['title','description'];
    protected $fillable = ['title','description',"category_id"];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags() 
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ingredients() 
    {
        return $this->belongsToMany(Ingredient::class);
    }
   
}
