<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category'; // Ajoutez cette ligne

    public function getRouteKeyName(){
        return 'slug';
    }
    
    public function articles(){
        return $this->hasMany(Article::class);
    }
}