<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
	protected $fillable = array('forename','surname');
    public function cats()
	{
		return $this->hasMany('App\Cat');
	}	
}
