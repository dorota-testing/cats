<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
	protected $fillable = array('name','owner_id','dob','id_breed','gender', 'image', 'desc');
    public function breed()
	{
		return $this->belongsTo('App\Breed','id_breed', 'id');// first parameter is of belonging table, second of table that owns
	}
    public function owner()
	{
		return $this->belongsTo('App\Owner');
	}	
}
