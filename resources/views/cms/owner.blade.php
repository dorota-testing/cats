<?php 
$aOld = array();
$aOld = old();
$aErrors = array();
if(count($errors)) {
	$aErrors = $errors->toArray();
}

$strForename = isset($aOld['forename'])? $aOld['forename'] : $owner->forename;
$strSurname = isset($aOld['surname'])? $aOld['surname'] : $owner->surname;

//echo '<pre>'; print_r($aOld);  echo '</pre>';
//echo '<pre>'; print_r($aErrors);  echo '</pre>';
//echo '<pre>'; print_r($owner);  echo '</pre>';
//if ($saved) echo 'saved';
?>
@extends('layouts.app')

@section('content')
		<div class="col-md-10">	
			<h1><?=($owner->id != '' ? 'Edit':'Add')?> {{$url}} <a href="{{ route('/') }}/select/{{$url}}" class="pull-right btn btn-primary">Exit</a></h1>
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
			<form class="form-horizontal" method="post" action="{{ route('/') }}/{{$url}}/<?=($owner->id != '' ? $owner->id : 0)?>" enctype="multipart/form-data" files="true">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="col-sm-3 col-md-3 control-label" for="forename">Forename</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['forename'])?'error':'')?>" name="forename" value="<?=$strForename?>"></div>
				</div>
				<div class="form-group">				
					<label class="col-sm-3 col-md-3 control-label" for="surname">Surname</label>
					<div class="col-sm-9 col-md-9"><input type="text" class="form-control <?=(!empty($aErrors['surname'])?'error':'')?>" name="surname" value="<?=$strSurname?>"></div>
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