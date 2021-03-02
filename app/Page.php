<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = array('url','image','headline','intro', 'page_title', 'page_desc');
}
