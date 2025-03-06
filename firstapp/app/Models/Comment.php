<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id', 'article_id', 'content'];
    
    public function article(){
        return $this->belongsTo(Article::class);
    }
     
    public function user(){
        return $this->belongsTo(User::class);
    }
}
