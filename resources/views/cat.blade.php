@extends('layout')

@section('header')
	<title><?=$page->page_title;?></title>
	<meta name="description" content="<?=$page->page_desc;?>">
@stop

@section('nav')
<?php 
$active = $page->url;
$image = $page->image;
$headline = $page->headline;
$intro = $page->intro;
?>
@stop

@section('content')
        <div class="container">
            <div class="content">
							<?php foreach($breed->cats as $cat){?>
							<h3><?=$cat['name'].' created:'.$cat['created_at']?></h3>
							<p>Owner is {{$cat->owner['forename'].' '.$cat->owner['surname']}}</p>
							<p>Date of Birth is {{$cat->dob}}</p>
							<p><img width="50" src="<?= asset('images/cat/'.$cat->image);?>"> {{$cat->image}}</p>
							<a href="{{ route('cats') }}/{{$cat->id}}/edit">Edit Cat >></a>
							<?php }?>
				<h1>Add a cat</h1>
				<form method="post" action="{{ route('/') }}/breeds/{{$breed->id}}/cat">
					<input type="text" class="form-control" name="name" placeholder="name" value="{{old('name')}}">
					<input type="text" class="form-control" name="owner_id" placeholder="owner id" value="{{old('owner_id')}}">
					<input type="text" class="form-control" name="dob" placeholder="dob" value="{{old('dob')}}">
					<input type="text" class="form-control" name="gender" placeholder="gender" value="{{old('gender')}}">
					<input type="text" class="form-control" name="image" placeholder="image" value="{{old('image')}}">
					<input type="text" class="form-control" name="desc" placeholder="desc" value="{{old('desc')}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="submit" value="Submit">
				</form>
				@if(count($errors))
					@foreach($errors->all() as $error)
					<p>{{$error}}</p>
					@endforeach
				@endif
            </div>
        </div>				
@stop
