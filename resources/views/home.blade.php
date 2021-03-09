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
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h2>Welcome to CatBreedersClub</h2>
						<p>We are an online club for everyone who breeds pedigree cats and for everyone owning or wanting to own one. The owners can post their cats' profiles here and get in touch with potential buyers. We also ofer information on breeds and other things.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-sm-offset-0 col-md-offset-0 col-xs-10 col-sm-12 col-md-12">
						<h2>Our Showcased Cats</h2>
					</div>
					<div class="col-xs-offset-1 col-sm-offset-0 col-md-offset-0 col-xs-10 col-sm-12 col-md-12 cat-slider box no-gutters">
					<?php foreach($cats as $cat){?>
						<div class="box no-gutters">
						<a href="{{ route('/') }}/cats/{{ $cat->id }}">
							<img src="<?= asset('images/cat/'.$cat->image);?>" />
							<div class="box-text">
							<p>
								Name: <b>{{ $cat->name }}</b>
								<br>Breed: <b>{{ $cat->breed->breed }}</b>
							</p>
							</div>
						</a>
						</div>
					<?php } ?>
					</div>					
				</div>
				<div class="row">
					<div class="col-xs-offset-1 col-sm-offset-0 col-md-offset-0 col-xs-10 col-sm-12 col-md-12">
						<h2>Latest News</h2>
					</div>
					<div class="col-xs-offset-1 col-sm-offset-0 col-md-offset-0 col-xs-10 col-sm-12 col-md-12 no-gutters">
					<?php foreach($news as $article){
						$date = date_create($article->date);
						?>
						<div class="col-xs-12 col-sm-6 col-md-6 box no-gutters">
						<a href="{{ route('/') }}/news/{{ $article->url }}">
							<img src="<?= asset('images/news/'.$article->image);?>" />
							<div class="box-text">
							<p>							
								<b>{{ $article->title }}</b>
								<br>Posted: <b>{{ $date->format('d M Y')}}</b>
							</p>								
							</div>
						</a>
						</div>
					<?php } ?>
					</div>
				</div>					
            </div>
        </div>
@stop
