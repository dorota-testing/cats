<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('about', function () {
	$arrLorem = ['lorem', 'ipsum', 'dolor'];
	$varDolor = 'dolor';
    return view('lorem', ['arrLorem'=> $arrLorem, 'varDolor'=>$varDolor]);//parameters passed to the view as an array 
});

Route::get('firstpage', function () {
    return view('pages.page1');
});
/*/

	Route::get('/', 'PagesController@welcome');
	Route::get('breeds', 'PagesController@breeds');
	Route::get('breeds/{breed}', 'PagesController@breed');
//	Route::get('breeds/{breed}/cat', 'PagesController@cat');
//	Route::post('breeds/{breed}/cat', 'PagesController@storeCat'); //this is where we post from a form
	
	Route::get('news', 'PagesController@news');
	Route::get('news/{url}', 'PagesController@article');
	
	Route::get('cats', 'CatsController@index');
	Route::get('cats/{cat}', 'CatsController@show');
//	Route::get('cats/{lorem}/edit', 'CatsController@edit');
//	Route::patch('cats/{cat}', 'CatsController@update'); //patch = update


Route::auth(); 

Route::get('/cms', 'HomeController@index');
Route::get('/select/{url}', 'HomeController@select');
Route::get('/delete/{url}/{id}', 'HomeController@delete');//delete
Route::get('/select/{url}/{id}', 'HomeController@select');//select childern of id1


Route::post('/Breed', 'HomeController@editBreed');
Route::get('/Breed/{id}', 'HomeController@editBreed');
Route::post('/Breed/{id}', 'HomeController@editBreed');

Route::post('/Owner', 'HomeController@editOwner');
Route::get('/Owner/{id}', 'HomeController@editOwner');
Route::post('/Owner/{id}', 'HomeController@editOwner');

Route::post('/Page', 'HomeController@editPage');
Route::get('/Page/{id}', 'HomeController@editPage');
Route::post('/Page/{id}', 'HomeController@editPage');

Route::post('/User', 'HomeController@editUser');
Route::get('/User/{id}', 'HomeController@editUser');
Route::post('/User/{id}', 'HomeController@editUser');

Route::post('/Cat/{owner_id}', 'HomeController@editCat');
Route::get('/Cat/{owner_id}/{id}', 'HomeController@editCat');
Route::post('/Cat/{owner_id}/{id}', 'HomeController@editCat');

Route::post('/News', 'HomeController@editNews');
Route::get('/News/{id}', 'HomeController@editNews');
Route::post('/News/{id}', 'HomeController@editNews');