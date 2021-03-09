<?php 
$aOld = array();
$aOld = old();
$aErrors = array();
if(count($errors)) {
	$aErrors = $errors->toArray();
}

$strUrl = isset($aOld['url'])? $aOld['url'] : $page->url;
$strHeadline = isset($aOld['headline'])? $aOld['headline'] : $page->headline;
$strIntro = isset($aOld['intro'])? $aOld['intro'] : $page->intro;
$strImage = isset($aOld['image'])? $aOld['image'] : $page->image;
$strPageTitle= isset($aOld['page_title'])? $aOld['page_title'] : $page->page_title;
$strPageDesc = isset($aOld['page_desc'])? $aOld['page_desc'] : $page->page_desc;
//echo '<pre>'; print_r($aOld);  echo '</pre>';
//echo '<pre>'; print_r($aErrors);  echo '</pre>';
//if ($saved) echo 'saved';
?>
@extends('layouts.app')

@section('content')
		<div class="col-md-10">	
			<h1><?=($page->id != '' ? 'Edit':'Add')?> {{$url}} <a href="{{ route('/') }}/select/{{$url}}" class="pull-right btn btn-primary">Exit</a></h1>
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
			</p>

			@endif
			<form class="form-horizontal" method="post" action="{{ route('/') }}/{{$url}}/<?=($page->id != '' ? $page->id : 0)?>" enctype="multipart/form-data" files="true">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label" for="url">Page URL</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['url'])?'error':'')?>" name="url" value="<?=$strUrl?>"></div>
				</div>
				<div class="form-group">				
					<label class="col-sm-3 col-md-3 control-label" for="headline">Headline</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['headline'])?'error':'')?>" name="headline" value="{{$strHeadline}}"></div>
				</div>
				<div class="form-group">				
					<label class="col-sm-3 col-md-3 control-label" for="intro">Intro</label>				
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['intro'])?'error':'')?>" name="intro" value="{{$strIntro}}"></div>
				</div>

				<div class="form-group">				
					<label class="col-xs-12 col-sm-3 col-md-3 control-label" for="image">Image</label>
					
					<div class="col-xs-12 col-sm-9 col-md-9">
						<div class="col-xs-8 col-sm-8 col-md-8 no-gutters">
							Image must be 400px wide and 400px high, otherwise it will be cropped to this size.
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
					<label class="col-sm-3 col-md-3 control-label" for="page_title">Page Title</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['page_title'])?'error':'')?>" name="page_title" value="{{$strPageTitle}}"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label" for="page_desc">PageDescription</label>				
					<div class="col-sm-9 col-md-9"><textarea class="form-control <?=(!empty($aErrors['page_desc'])?'error':'')?>" name="page_desc">{{$strPageDesc}}</textarea></div>
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
@endsection