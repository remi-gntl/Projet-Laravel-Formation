<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    // test de fillable:  
    //protected $fillable = ['title', 'user_id', 'slug', 'content', 'categorie_id'];
    
    //test de guarded: 
    protected $guarded = ['user_id', 'slug']; 

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    //guarded: (prends tout sauf ce qu'on met dedans)
    //fillable: (prends rien sauf ce qu'on met dedans)
    //faut utiliser soit l'un soit l'autre


    public function getRouteKeyName(){
        return 'slug';
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class)->withDefault([
            'name'=>'Categorie anonyme',
        ]);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
