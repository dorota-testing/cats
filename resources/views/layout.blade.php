<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags always come first -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		@yield('header')
		<meta name="author" content="dorota">
		<meta name="robots" content="noindex, nofollow">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" href="">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/main.css') }}" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="{{ asset('/js/slick-1.6.0/slick/slick.css') }}"/>		
		<link rel="stylesheet" type="text/css" href="{{ asset('/js/slick-1.6.0/slick/slick-theme.css') }}"/>
		
    </head>
    <body>
		<div class="top">
			<div class="container top">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-8">
						<h1><img src="<?= asset('images/logo.png');?>" width="40"/>CatBreedersClub</h1>
					</div>
					<div class="hidden-xs col-sm-4 col-md-4 text-right">
						<p>Today is: <b><?=date('d M Y');?></b></p>
					</div>				
				</div>
			</div>
		</div>			
		<nav>
		<?php $active=''; ?>
		@yield('nav') 
			<div class="container menu">
				<div class="row no-gutters text-center">
					<div class="col-xs-3 col-sm-3 col-md-3 <?=($active=='home'?'active':'')?>">
						<a href="{{ route('/') }}">HOME</a>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3 <?=($active=='breeds'?'active':'')?>">
						<a href="{{ route('breeds') }}">BREEDS</a>
					</div>					
					<div class="col-xs-3 col-sm-3 col-md-3 <?=($active=='cats'?'active':'')?>">
						<a href="{{ route('cats') }}">CATS</a>
					</div>
					<div class="col-xs-3 col-sm-3 col-md-3 <?=($active=='news'?'active':'')?>">
						<a href="{{ route('news') }}">NEWS</a>
					</div>
				</div>
			</div>
		</nav>	
		@if (isset($page) && $page != '')
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="hidden-xs col-sm-4 col-md-4">
						<div class="img">
							<img src="<?= asset('images/page/'.$page->image);?>" />
						</div>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8">
						<h1><?= $page->headline;?></h1>
						<h3><?= $page->intro;?></h3>
					</div>
				</div>
			</div>
		</div>
		@endif
		<div class="center">
			@yield('content')
		</div>
		<div class="footer">
			<div class="container">
				<div class="row">
				<br>
				<br>
					<div class="col-xs-4 col-sm-2 col-md-2">						
						<p><a href="{{ route('/') }}">HOME</a></p>
						<p><a href="{{ route('breeds') }}">BREEDS</a></p>
						<p><a href="{{ route('cats') }}">CATS</a></p>
						<p><a href="{{ route('news') }}">NEWS</a></p>
					</div>
					<div class="col-xs-8 col-sm-3 col-md-3  col-sm-offset-2 col-md-offset-2">
						<p>This website is just a learning aid. CatBreedersClub does not exist in reality.</p>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-sm-offset-2 col-md-offset-2">
						<p>The source of all breed descriptions is Wikipedia.</p>
					</div>
				</div>
			</div>
		</div>		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>		
	<script src="{{ asset('/js/main.js') }}"></script>
	<script src="{{ asset('/js/slick-1.6.0/slick/slick.min.js') }}"></script>		
    </body>
</html>