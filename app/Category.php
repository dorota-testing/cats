<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = array('url','category');
    public function news()
    {
        return $this->belongsToMany('App\News');
    }
}
