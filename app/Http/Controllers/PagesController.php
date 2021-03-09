<?php

namespace App\Http\Controllers;

use \App\Page; //this is path to eloquent Page model
use \App\Breed; //this is path to eloquent model
use \App\Cat; //this is path to eloquent model
use \App\News; //this is path to eloquent model
use \App\Category;
use DB;
use Session;
use Illuminate\Http\Request;
use Carbon\Carbon;

//use App\Http\Requests; // I won't use it

class PagesController extends Controller
{
	public function welcome()
	{
		//		$page = DB::table('pages')->where('id',1)->first();
		$page = Page::find(1); //eloquent
		$cats = Cat::orderBy('created_at', 'desc')->take(12)->get();
		$news = News::orderBy('date', 'desc')->take(4)->get();

		return view('home', compact('page', 'cats', 'news'));
	}

	public function breeds(Request $request)
	{
		//		$arrLorem = ['lorem', 'ipsum', 'dolor'];
		//		$varDolor = 'dolor';
		//		return view('breeds', ['arrLorem'=> $arrLorem, 'varDolor'=>$varDolor]);//parameters passed to the view as an array 
		//		$page = DB::table('pages')->where('id',2)->first();
		$page = Page::find(2); //eloquent
		$breeds = Breed::paginate(4);
		$pageBreed = $request->get("page");
		Session::set('pageBreed', $pageBreed);

		return view('breeds', compact('page', 'breeds'));
	}
	public function breed(Breed $breed)
	{
		$page = Page::find(2); //eloquent
		$breed->load('cats.owner'); // this is EAGER LOADING loads only once from database with all relationships (cats belonging to breed and users belonging to cats)
		//		return $breed;

		return view('breeds', compact('page', 'breed'));
	}
	/*/	
       public function cat($id)
	{
		$page = Page::find(2); 
		$breed = Breed::find($id);
		return view('cat', compact('page', 'breed'));
	}	
       public function storeCat(Request $request, Breed $breed)
	{
		$page = Page::find(2);
//		return $breed;
// **** VALIDATION *****  we are passing an array of rules corresponding to the items in the request
		$this->validate($request, [
			'name'=>'required',
			'dob'=>'required|date_format:"d-m-Y"',
			'gender'=>'required',
			'image'=>'required',
			'desc'=>'required',
			'owner_id'=>'required|numeric'
		]);
// crete new cat object and fill it 
		$cat = new Cat; // Cat here is an eloquent model, included above
		$cat->name = $request->name;
		$cat->dob = $request->dob;
		$cat->gender = $request->gender;
		$cat->image = $request->image;
		$cat->desc = $request->desc;
		$cat->owner_id = $request->owner_id;
//save object cat as descendant of breed specified in url		
		$breed->cats()->save($cat);
//redirect to previous page (it can also be a different page)		
		return back();
	}
/*/
	public function news(Request $request)
	{
		//		dd($request);

		$strCategory = $request->get("category_id");
		$strSort = $request->get("sort") != '' ? $request->get("sort") : 'desc';
		Session::set('pageNews', $request->get("page"));
		Session::set('sort', $strSort);
		Session::set('category_id', $strCategory);

		//dump($request);
		$page = Page::find(4); //eloquent
		$categories = Category::all();

		//dump($categories );
		if ($strCategory != '') {

			$data['news'] = News::join('category_news', 'news_id', '=', 'news.id')
			->select('news.*')
			->where('category_news.category_id', $strCategory)
			->orderBy('date', $strSort)
			->paginate(4);

			$news = $data['news'];

		} else {
			$news = News::with('categories')->orderBy('date', $strSort)->paginate(4);
		}

		//		dump($news);
		return view('news', compact('page', 'news', 'categories', 'strCategory', 'strSort'));
	}
	
	public function article($url)
	{
		$page = Page::find(4); //eloquent
		$article = News::where('url', $url)->with('categories')->first();

		if (!$article->count()) {
			return redirect()->action('PagesController@news');
		}
		$strParams = '?';
		if (Session::get('pageNews')) {
			$strParams .= 'page=' . Session::get('pageNews') . '&';
		}
		$strParams .= 'sort=' . Session::get('sort') . '&category_id=' . Session::get('category_id');
		//	dump($article);
		return view('news', compact('page', 'article', 'strParams'));
	}
}
