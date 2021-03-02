<?php

namespace App\Http\Controllers;
use DB;
use Session;
use \App\Cat; //this is path to Cat model
use \App\Page; //this is path to Page model
use \App\Breed;
use Illuminate\Http\Request;

use App\Http\Requests;

class CatsController extends Controller
{
       public function index(Request $request)
	{
//		dd($request);

$strBreed = $request->get("id_breed");
	Session::set('id_breed', $strBreed);
$strGender = $request->get("gender");
	Session::set('gender', $strGender);
	Session::set('pageCats', $request->get("page"));	
//		dd($page1);
//		$cats = DB::table('cats')->get(); // this is query builder method (without Eloquent)

//		$cats = Cat::paginate(4); // query using Eloquent (requires creating a model for the table first)
		$query = DB::table('cats')
		->join('breeds', 'cats.id_breed', '=', 'breeds.id')
		->join('owners', 'cats.owner_id', '=', 'owners.id')
		->select('cats.*', 'breeds.breed', 'owners.forename', 'owners.surname');
		
if($strBreed !='') {
    $query = $query->when($strBreed, function($q) use ($strBreed) {
        return $q->where('id_breed', '=', $strBreed);
    });
}

if($strGender !='') {
    $query = $query->when($strGender, function($q) use ($strGender) {
        return $q->where('gender', '=', $strGender);
    });
}

		$cats = $query->paginate(4);
//		dd($cats);		
//		$page = DB::table('pages')->where('id',3)->first();
		$page = Page::find(3); // eloquent
		$breeds = Breed::all(); // eloquent
		
		return view('cats.index', compact('cats','page','breeds','strBreed','strGender')); // this means we have cats directory and index in it, and array $cats is passed as parameter
	}
	
       public function show($id)
	{
//		return $id; //this will echo to the screen velue of id in the table
//		return $cat = \App\Cat::find($id); // this will output to the screen content of the row in JASON array format
		$page = Page::find(3); //eloquent
		$cat = Cat::find($id);
		$owner_id = $cat->owner['id'];
		$ownersCats = Cat::where([['owner_id', '=', $owner_id], ['id', '<>', $cat['id']]])->get()->toArray();
//		dump ($ownersCats);
		$strParams = '?';
		if(Session::get('pageCats')){
			$strParams .= 'page='.Session::get('pageCats').'&';
		}
			$strParams .= 'id_breed='.Session::get('id_breed').'&gender='.Session::get('gender');
	
//		dump ( Session::get('pageCats'));
		//$ownersCats = array();
		
		return view('cats.index', compact('cat','page', 'ownersCats','strParams'));
	}
/*/ FILTERS EXAMPLE

$query = DB::table('something');

if($year) {
    $query = $query->when($year, function($q) use ($year) {
        return $q->where('year', '>', $year);
    });
}

if($age) {
    $query = $query->when($age, function($q) use ($age) {
        return $q->where('age', '>', $age);
    });
}

$query = $query->get();

/*/


/*/
	
       public function edit(Cat $lorem) //the variable name must be the same as wildcard in the route
	{
		
		$page = Page::find(3);
//		$cat = Cat::find($id);
		$cat = $lorem;
		return view('cats.show', compact('cat','page'));
	}
       public function update(Request $request, Cat $cat) //the variable name must be the same as wildcard in the route
	{
		$cat->update($request->all());
		
		return back();
	}
/*/	
}