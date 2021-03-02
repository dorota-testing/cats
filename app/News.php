<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
	protected $fillable = array('url','image','title','text', 'date');
    public function categories()
    {
        return $this->belongsToMany('App\Category')->withPivot('category_id', 'news_id');
    }
}
