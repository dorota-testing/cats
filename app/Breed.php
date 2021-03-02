<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
	protected $fillable = array('breed','country','colour','hair', 'image', 'desc', 'updated_at', 'created_at', );
    public function cats()
	{
		return $this->hasMany('App\Cat','id_breed', 'id'); //first parameter is of belonging table (cats), second of table that owns (breeds)
//		return $this->hasMany('App\Cat');// if cat table has 'breed_id' (NOT id_breed!!! or anything else) and I want it joined to this table 'id', then relation is automatic, no parameters needed
//		return $this->hasMany('Cat::class'); //alternative version
	}
}
