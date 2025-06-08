<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //	id	title	content	category_id	user_id	featured_image
    protected $fillable = [
        'id',
        'title',
        'content',
        'category_id',
        'user_id',
        'featured_image',
        'created_at',
        'updated_at'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
