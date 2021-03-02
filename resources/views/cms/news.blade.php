<?php 
$aOld = array();
$aOld = old();
$aErrors = array();
if(count($errors)) {
	$aErrors = $errors->toArray();
}

$strUrl = isset($aOld['url'])? $aOld['url'] : $news->url;
$strTitle = isset($aOld['title'])? $aOld['title'] : $news->title;
$strImage = isset($aOld['image'])? $aOld['image'] : $news->image;
$strText= isset($aOld['text'])? $aOld['text'] : $news->text;
$strDate = isset($aOld['date'])? $aOld['date'] : $news->date;
$aCatNews =  $news->categories()->get()->toArray();
$aCatNews =  array_pluck($aCatNews, 'pivot.category_id');
$aCategory_news = isset($aOld['category_id'])? $aOld['category_id'] : $aCatNews;
//echo '<pre>'; print_r($aOld);  echo '</pre>';
//echo '<pre>'; print_r($aErrors);  echo '</pre>';
//dump($errors->all());
//echo '<pre>'; print_r($categories);  echo '</pre>';
//if ($saved) echo 'saved';
//	dump ($news->categories()->get()->toArray());
//	dump ($aCategory_news); 
//	die;
?>
@extends('layouts.app')

@section('content')
		<div class="col-md-10">	
			<h1><?=($news->id != '' ? 'Edit':'Add')?> {{$url}} <a href="/select/{{$url}}" class="pull-right btn btn-primary">Exit</a></h1>
			@if($saved)
			<p class="alert alert-success" role="alert">Saved successfully.</p>
			@endif
			@if(!empty($aErrors))
			<p class="alert alert-warning" role="alert">
			Submission errors. Please fill in correctly required fields.
				@if(!empty($aErrors['imageFile']))
					@foreach($aErrors['imageFile'] as $fileError)
					<br>{{$fileError}}
					@endforeach	
				@endif	
				@if(!empty($aErrors['category_id']))
					<br>At least one category is required.
				@endif				
			</p>

			@endif
			<form class="form-horizontal" method="post" action="/{{$url}}/<?=($news->id != '' ? $news->id : 0)?>" enctype="multipart/form-data" files="true">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label" for="url">Friendly Url</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['url'])?'error':'')?>" name="url" value="<?=$strUrl?>"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label" for="title">Title</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['title'])?'error':'')?>" name="title" value="{{$strTitle}}"></div>
				</div>
				<div class="form-group">				
					<label class="col-xs-12 col-sm-3 col-md-3 control-label" >Categories</label>	
				</div>
<?php foreach($aCategory_news as $key=>$category_id){
 ?>		
				<div class="form-group">						
					<div class="col-xs-10 col-sm-offset-3 col-md-offset-3 col-sm-8 col-md-8">
						<select class="form-control <?=(!empty($aErrors['category_id.'.$key])?'error':'')?>" name="category_id[]">
							<option value="">Select...</option>
						<?php foreach($categories as $category){?>
							<option value="<?=$category['id']?>" <?=($category['id']==$category_id?'selected="selected"':'')?>><?=$category['category']?></option>
						<?php } ?>
						</select>
					</div>
					<div class="col-xs-2 col-sm-1 col-md-1 no-gutters">
						<span class="glyphicon glyphicon-minus-sign delete" aria-hidden="true"></span>
					</div>
				</div>	
<?php } ?>
				<div class="form-group">
					<div class="col-xs-6 col-sm-offset-3 col-md-offset-3 col-sm-3 col-md-3">
					<span class="btn btn-primary addSegment" data-segment="category">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp; Add a Category
					</span>
					</div>
				</div>				
				<div class="form-group">				
					<label class="col-xs-12 col-sm-3 col-md-3 control-label" for="image">Image</label>
					
					<div class="col-xs-12 col-sm-9 col-md-9">
						<div class="col-xs-8 col-sm-8 col-md-8 no-gutters">
							Image must be 720px wide and 400px high, otherwise it will be cropped to this size.
							<br>
							<br>
							<input type="file" class="<?=(!empty($aErrors['imageFile'])?'error':'')?>" name="imageFile"/> 
							<br> or select:
							<br>
							<select class="form-control <?=(!empty($aErrors['image'])?'error':'')?>" name="image">
								<option value="">Select...</option>
								<?php
								$files = File::files($path);
								foreach ($files as $file)
								{ ?>
									<option value="{{ basename($file) }}" <?=(basename($file)==$strImage?'selected="selected"':'')?> >{{ basename($file) }}</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4">
						
						@if(is_file($path.'/'.$strImage))
						
							<img src="{{url($path.'/'.$strImage)}}" class="cmsImage"/>
						@else
							<img src="{{url('/images/whiteSquare.jpg')}}" class="cmsImage"/>
						@endif
<?php // dd(is_file($path.'/'.$strImage)) ?>
						</div>
					</div>					
				</div>
				<div class="form-group">				
					<label class="col-sm-3 col-md-3 control-label" for="text">Article Date</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control datepicker <?=(!empty($aErrors['date'])?'error':'')?>" name="date" value="{{$strDate}}"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label" for="text">Article Text</label>				
					<div class="col-sm-9 col-md-9"><textarea class="form-control ckeditor <?=(!empty($aErrors['text'])?'error':'')?>" name="text">{{$strText}}</textarea></div>
				</div>
				<div class="text-right">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">	
					@if(Auth::user()->user_role=='admin')
					<input type="submit" name="save" value="Save" class="btn btn-primary ">
					<input type="submit" name="saveExit" value="Save & Exit" class="btn btn-primary">
					@else
					<span class="btn btn-default hoverTip">Save</span>
					<span class="btn btn-default hoverTip">Save & Exit</span>
					@endif
				</div>
				<br>			
			</form>
        </div>
        <div class="hidden">
			<div class="category">
				<div class="form-group">			
					<div class="col-xs-10 col-sm-offset-3 col-md-offset-3 col-sm-8 col-md-8">
						<select class="form-control" name="category_id[]">
							<option value="">Select...</option>
						<?php foreach($categories as $category){?>
							<option value="<?=$category['id']?>"><?=$category['category']?></option>
						<?php } ?>
						</select>
					</div>
					<div class="col-xs-2 col-sm-1 col-md-1 no-gutters">
						<span class="glyphicon glyphicon-minus-sign delete" aria-hidden="true"></span>
					</div>
				</div>
			</div>
        </div>
		
@endsection