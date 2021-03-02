<?php
namespace App\Http\Controllers;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use \App\Breed;
use \App\Cat; //this is path to Cat model
use \App\Page; //this is path to Page model
use \App\Owner; 
use \App\News; 
use \App\User; 
use \App\Category; 
use Image;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{	
	private $arrTable = array (
			'Breed' => array(
			'fields'=>array('breed','country'), 
			'titles'=>array('Breed','Country'), 
			'add'=>true, 
			'edit'=>true, 
			'delete'=>false,
			'buttons'=>array(),
			'show_only_to'=>array(),
			'parent'=>array(),
			'children'=>array(),
		),
			'Cat' => array(
			'fields'=>array('name', 'gender', 'breed'), 
			'titles'=>array('Name', 'Gender', 'Breed'), 
			'add'=>true, 
			'edit'=>true, 
			'delete'=>true,
			'buttons'=>array(),
			'show_only_to'=>array(),
			'parent'=>array('Owner','owner_id','forename','surname'), //first value used in URL, second for is query name
			'children'=>array(),			
		),
		'Owner' => array(
			'fields'=>array('forename', 'surname'), 
			'titles'=>array('Forename', 'Surname'), 
			'add'=>true, 
			'edit'=>true, 
			'delete'=>true,
			'buttons'=>array('Cat'=>'cats'),
			'show_only_to'=>array(),
			'parent'=>array(),
			'children'=>array('Cat'),
		),
		'News' => array(
			'fields'=>array('title'),
			'titles'=>array('Title'),
			'add'=>true,
			'edit'=>true,
			'delete'=>true,
			'buttons'=>array(),
			'show_only_to'=>array(),
			'parent'=>array(),
			'children'=>array(),			
		),
		'Page' => array(
			'fields'=>array('url'),
			'titles'=>array('Page'),
			'add'=>true,
			'edit'=>true,
			'delete'=>false,
			'buttons'=>array(),
			'show_only_to'=>array(),
			'parent'=>array(),
			'children'=>array(),			
		),
		'User' => array(
			'fields'=>array('name', 'surname', 'user_role'), 
			'titles'=>array('Name', 'Surname', 'Role'), 
			'add'=>true,  
			'edit'=>true, 
			'delete'=>false,
			'buttons'=>array(),
			'show_only_to'=>array('admin'),
			'parent'=>array(),
			'children'=>array(),			
		),
	);

	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$url = '';
		$tables = $this->arrTable; //for menu
        return view('cms.index', compact('tables', 'url'));
    }
    public function select($url, $id='')
    {
		$tables = $this->arrTable; //for menu
		$table = $this->arrTable[$url]; //for list
		$strParent = '';
		
		$appPrefix = "App\\";
		$className = $appPrefix.$url;
		if(!empty($table['parent']) && $id!='' && ctype_digit($id)==true){
			//return 'lorem';
			$content = $className::where( $table['parent'][1], $id)->get();
			$classParent = $appPrefix.str_singular(($table['parent'][0]));
			$parent = $classParent::where('id', $id)->first();
//			dump ($table['parent'][2]);
//			dump ($parent->forename);
//			dump ($parent->$table['parent'][2]); 
			if($table['parent'] !=""){
			$dolor = ($table['parent'][2]);
			$strParent .= $parent->$dolor;
			}
			if($table['parent'][3] !=""){
			$dolor = ($table['parent'][3]);
			$strParent .= ' '.$parent->$dolor;
			}			
//			dump ($strParent);
			//$content = $className::all();
		} else {

			$content = $className::all();
			
		}

        return view('cms.select', compact('table', 'tables', 'url', 'content', 'id', 'strParent'));
    }
    public function delete($url, $id='')
    {
	
		$appPrefix = "App\\";
		$className = $appPrefix.$url;
		if($id!='' && ctype_digit($id)==true){
			$className::destroy($id);
		}

		return back();
    }	

    public function editBreed(Request $request, $id = 0)
    {
		$url = 'Breed';
		$tables = $this->arrTable; //for menu
		$saved = false;
		$path = 'images/breed';
		$image = 'imageFile';
		$breed = Breed::findOrNew($id);
		if ($request->isMethod('post')) {
			//dd($request);
		
// **** VALIDATION *****  we are passing an array of rules corresponding to the items in the request
			$this->validate($request, [
				'breed'=>'required',
				'country'=>'required',
				'hair'=>'required',
				'colour'=>'required',
				'image'=>'required_without_all:imageFile',
				'imageFile'=>'file|mimes:jpeg,bmp,png|required_without_all:image|max:2000',
				'desc'=>'required'
			]);			
			
			//dd($request->files);

			if ($request->hasFile($image)) {
				
				$file = $request->files->get($image)->getClientOriginalName(); //symfony property
				//dd ($file);
				
				//save uploaded file
				//save with resize (using intervention)
				if(Image::make(Input::file($image))->fit(400, 400)->save($path.'/'.$file)){
					//make so that the file name is in the request and will be validated and saved
					$request->request->set('image', $file);
				} else	{
					return 'File upload error';
				}
			}
			//return 'lorem';
					
			$breed->fill($request->all());
			$breed->save();			
			$saved = true;

		}
	
		if($request->saveExit){
			return redirect()->action(
				'HomeController@select', ['url' => $url, 'id'=>'']
			);
		}
		return view('cms.breed', compact('tables', 'url', 'id', 'breed', 'saved', 'path'));			
    }

    public function editOwner(Request $request, $id = 0)
    {
		$url = 'Owner';
		$tables = $this->arrTable; //for menu
		$saved = false;
		$owner = Owner::findOrNew($id);
		if ($request->isMethod('post')) {
		
// **** VALIDATION *****  we are passing an array of rules corresponding to the items in the request
			$this->validate($request, [
				'forename'=>'required',
				'surname'=>'required'
			]);	
					
			$owner->fill($request->all());
			$owner->save();			
			$saved = true;

		}
	
		if($request->saveExit){
			return redirect()->action(
				'HomeController@select', ['url' => $url, 'id'=>'']
			);
		}
		return view('cms.owner', compact('tables', 'url', 'id', 'owner', 'saved'));			
    }

    public function editPage(Request $request, $id = 0)
    {
		$url = 'Page';
		$tables = $this->arrTable; //for menu
		$saved = false;
		$path = 'images/page';
		$image = 'imageFile';
		$page = Page::findOrNew($id);
		if ($request->isMethod('post')) {
			//dd($request);
		
// **** VALIDATION *****  we are passing an array of rules corresponding to the items in the request
			$this->validate($request, [
				'url'=>'required',
				'headline'=>'required',
				'intro'=>'required',
				'page_title'=>'required',
				'image'=>'required_without_all:imageFile',
				'imageFile'=>'file|mimes:jpeg,bmp,png|required_without_all:image|max:2000',
				'page_desc'=>'required'
			]);			
			
			//dd($request->files);

			if ($request->hasFile($image)) {
				
				$file = $request->files->get($image)->getClientOriginalName(); //symfony property
				//dd ($file);
				
				//save uploaded file
				//if($request->$image->move($path, $file)){
				//save with resize (using intervention)
				if(Image::make(Input::file($image))->fit(400, 400)->save($path.'/'.$file)){
					//make so that the file name is in the request and will be validated and saved
					$request->request->set('image', $file);
				} else	{
					return 'File upload error';
				}
			}
			//return 'lorem';
					
			$page->fill($request->all());
			$page->save();			
			$saved = true;

		}
	
		if($request->saveExit){
			return redirect()->action(
				'HomeController@select', ['url' => $url, 'id'=>'']
			);
		}
		return view('cms.page', compact('tables', 'url', 'id', 'page', 'saved', 'path'));			
    }
    public function editUser(Request $request, $id = 0)
    {
		$url = 'User';
		$tables = $this->arrTable; //for menu
		$saved = false;
		$user = User::findOrNew($id);
		if ($request->isMethod('post')) {
		
// **** VALIDATION *****  we are passing an array of rules corresponding to the items in the request
			$this->validate($request, [
				'name'=>'required',
				'surname'=>'required',
				'user_role'=>'required'
			]);	
					
			$user->fill($request->all());
			$user->save();			
			$saved = true;

		}
	
		if($request->saveExit){
			return redirect()->action(
				'HomeController@select', ['url' => $url, 'id'=>'']
			);
		}
		return view('cms.user', compact('tables', 'url', 'id', 'user', 'saved'));			
    }	
    public function editCat(Request $request, $owner_id, $id = 0)
    {
		$url = 'Cat';
		$tables = $this->arrTable; //for menu
		$saved = false;
		$path = 'images/cat';
		$image = 'imageFile';
		$cat = Cat::findOrNew($id);
		$breeds = Breed::all()->toArray();

		if ($request->isMethod('post')) {
//			dd($request);
		
// **** VALIDATION *****  we are passing an array of rules corresponding to the items in the request
			$this->validate($request, [
				'name'=>'required',
				'dob'=>'required',
				'gender'=>'required',
				'id_breed'=>'required',
				'image'=>'required_without_all:imageFile',
				'imageFile'=>'file|mimes:jpeg,bmp,png|required_without_all:image|max:2000',
				'desc'=>'required',
				'owner_id'=>'required',
			]);			
			
			//dd($request->files);

			if ($request->hasFile($image)) {
				
				$file = $request->files->get($image)->getClientOriginalName(); //symfony property

				//save with resize (using intervention)
				if(Image::make(Input::file($image))->fit(400, 400)->save($path.'/'.$file)){
					//make so that the file name is in the request and will be validated and saved
					$request->request->set('image', $file);
				} else	{
					return 'File upload error';
				}
			}
//			dd($request);				
			$cat->fill($request->all());
			$cat->save();			
			$saved = true;

		}
	
		if($request->saveExit){
			$parent = $cat->owner_id;
			return redirect()->action(
				'HomeController@select', ['url' => $url, 'id'=>$parent]
			);
		}
		return view('cms.cat', compact('tables', 'url', 'id', 'cat', 'saved', 'path', 'owner_id', 'breeds'));			
    }
	
    public function editNews(Request $request, $id = 0)
    {
		$url = 'News';
		$tables = $this->arrTable; //for menu
		$saved = false;
		$path = 'images/news';
		$image = 'imageFile';
		$news = News::findOrNew($id);
		$categories = Category::all()->toArray();		
		if ($request->isMethod('post')) {
			//dd($request);
		
// **** VALIDATION *****  we are passing an array of rules corresponding to the items in the request
			$this->validate($request, [
				'url'=>'required',
				'title'=>'required',
				'image'=>'required_without_all:imageFile',
				'imageFile'=>'file|mimes:jpeg,bmp,png|required_without_all:image|max:2000',
				'text'=>'required',				
				'date'=>'required',
				'category_id.*' => 'required|integer',
				'category_id' => 'required',
			]);			
			
			$category_id = $request->category_id;
//			dd($category_id); 

			if ($request->hasFile($image)) {
				
				$file = $request->files->get($image)->getClientOriginalName(); //symfony property
				//dd ($file);
				
				//save uploaded file
				//if($request->$image->move($path, $file)){
				//save with resize (using intervention)
				if(Image::make(Input::file($image))->fit(720, 400)->save($path.'/'.$file)){
					//make so that the file name is in the request and will be validated and saved
					$request->request->set('image', $file);
				} else	{
					return 'File upload error';
				}
			}
			//return 'lorem';
					
			$news->fill($request->all());
			$news->save();
			$news->categories()->sync($category_id);
			
			$saved = true;

		}
	
		if($request->saveExit){
			return redirect()->action(
				'HomeController@select', ['url' => $url, 'id'=>'']
			);
		}
		return view('cms.news', compact('tables', 'url', 'id', 'news', 'saved', 'path', 'categories'));			
    }	
}