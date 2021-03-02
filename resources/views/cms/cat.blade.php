<?php 
$aOld = array();
$aOld = old();
$aErrors = array();
if(count($errors)) {
	$aErrors = $errors->toArray();
}

$strName = isset($aOld['name'])? $aOld['name'] : $cat->name;
$strDOB = isset($aOld['dob'])? $aOld['dob'] : $cat->dob;
$strGender = isset($aOld['gender'])? $aOld['gender'] : $cat->gender;
$strBreed = isset($aOld['id_breed'])? $aOld['id_breed'] : $cat->id_breed;
$strImage = isset($aOld['image'])? $aOld['image'] : $cat->image;
$strDesc = isset($aOld['desc'])? $aOld['desc'] : $cat->desc;

//echo '<pre>'; print_r($aOld);  echo '</pre>';
//echo '<pre>'; print_r($aErrors);  echo '</pre>';
//echo '<pre>'; print_r($breeds);  echo '</pre>';
//if ($saved) echo 'saved';
$aGender = array('female','male');
?>
@extends('layouts.app')

@section('content')
		<div class="col-md-10">	
			<h1><?=($cat->id != '' ? 'Edit':'Add')?> {{$url}} <a href="/select/{{$url}}/{{ $owner_id }}" class="pull-right btn btn-primary">Exit</a></h1>
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
			<form class="form-horizontal" method="post" action="/{{$url}}/{{ $owner_id }}/<?=($cat->id != '' ? $cat->id : 0)?>" enctype="multipart/form-data" files="true">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label" for="name">Name</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['name'])?'error':'')?>" name="name" value="<?=$strName?>"></div>
				</div>
				<div class="form-group">				
					<label class="col-sm-3 col-md-3 control-label" for="dob">Date of birth</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control datepicker <?=(!empty($aErrors['dob'])?'error':'')?>" name="dob" value="{{$strDOB}}"></div>
				</div>
				<div class="form-group">				
					<label class="col-sm-3 col-md-3 control-label" for="gender">Gender</label>				
					<div class="col-sm-9 col-md-9">
						<select class="form-control <?=(!empty($aErrors['gender'])?'error':'')?>" name="gender">
							<option value="">Select...</option>
						<?php foreach($aGender as $gender){?>
							<option value="<?=$gender?>" <?=($gender==$strGender?'selected="selected"':'')?>><?=$gender?></option>
						<?php } ?>
						</select>					
					</div>
				</div>
				<div class="form-group">				
					<label class="col-sm-3 col-md-3 control-label" for="id_breed">Breed</label>				
					<div class="col-sm-9 col-md-9">
						<select class="form-control <?=(!empty($aErrors['id_breed'])?'error':'')?>" name="id_breed">
							<option value="">Select...</option>
						<?php foreach($breeds as $breed){?>
							<option value="<?=$breed['id']?>" <?=($breed['id']==$strBreed?'selected="selected"':'')?>><?=$breed['breed']?></option>
						<?php } ?>
						</select>
					</div>
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
					<label class="col-sm-3 col-md-3 control-label" for="desc">Description</label>				
					<div class="col-sm-9 col-md-9"><textarea class="form-control ckeditor <?=(!empty($aErrors['desc'])?'error':'')?>" name="desc">{{$strDesc}}</textarea></div>
				</div>
				<div class="text-right">
					<input type="hidden" name="owner_id" value="{{ $owner_id }}">	
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