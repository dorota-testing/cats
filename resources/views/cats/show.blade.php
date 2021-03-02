@extends('layout')

@section('header')
	<title>Cat Club | Cats Listing</title>
	<meta name="description" content="">
	<meta name="author" content="">
@stop

@section('nav')
<?php $active='cats';?>
@stop

@section('content')
        <div class="container">
            <div class="content">
	<h1>Single Cat goes here</h1>

	<p>Cat's Name is {{$cat->name}}</p>
	<p>Owner is {{$cat->user['forename'].' '.$cat->user['surname']}}</p>
	<p>Date of Birth is {{$cat->dob}}</p>
	<p><img src="<?= asset('images/cat/'.$cat->image);?>"> {{$cat->image}}</p>
	
				<h1>Edit cat</h1>
				<form method="post" action="/cats/{{$cat->id}}">
					{{ method_field('PATCH') }} <?php //this can also be method DELETE?>
					<input type="text" class="form-control" name="name" value="{{$cat->name}}">
					<input type="text" class="form-control" name="user_id" value="{{$cat->user_id}}">
					<input type="text" class="form-control" name="dob" value="{{$cat->dob}}">
					<input type="text" class="form-control" name="gender" value="{{$cat->gender}}">
					<input type="text" class="form-control" name="image" value="{{$cat->image}}">
					<input type="text" class="form-control" name="desc" value="{{$cat->desc}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="submit" value="Submit">
				</form>
            </div>
        </div>
@stop
