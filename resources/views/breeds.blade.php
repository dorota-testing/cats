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
			<?php if(isset($breed)){?>
				<h1><?=$breed['breed'];?> Breed Details</h1>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 box no-gutters">
							<div class="col-xs-12 col-sm-8 col-md-8 no-gutters">
								<img src="<?= asset('images/breed/'.$breed['image']);?>" />
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">							
								<p>
									<b>Breed: <?=$breed['breed'];?></b>
									<br>Country: <?=$breed['country'];?>
									<br>Coat: <?=$breed['hair'];?>
									<br>Colour: <?=$breed['colour'];?>
									<br><a href="/breeds<?=Session::get('pageBreed')!=''?'?page='.Session::get('pageBreed'):''?>">Back to list >></a>
								</p>							
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h3>Description</h3> 
							<?=$breed['desc'];?>
							<!--<a href="/breeds/{{$breed->id}}/cat">Add a Cat</a>-->						
						</div>
						<?php if($breed->cats->count()){ 
						//dump ($breed->cats);
						?>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h3>Examples</h3> 
							<?php foreach($breed->cats as $n => $cat){
								if($n<3){?>
							<div class="col-xs-6 col-sm-4 col-md-4 box no-gutters">
								<a href="/cats/<?=$cat['id']?>">
								<img src="<?= asset('images/cat/'.$cat['image']);?>"/>
								<div class="box-text">
								<p>
									Name: <b>{{ $cat->name }}</b>
									<br>Breed: <b>{{ $cat->breed->breed }}</b>
								</p>
								</div>								
								</a>
							</div>
								<?php } } ?>
						</div>
						<?php } ?>
					</div>
					<br>
				<?php } else { ?>
				<h1>Breeds of cats</h1>
					<?php foreach($breeds as $breed){?>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 box no-gutters">
							<p class="left">
								<img src="<?= asset('images/breed/'.$breed['image']);?>" />
							</p>
							<p class="right">
								<b>Breed: <?=$breed['breed'];?></b>
								<br>Country: <?=$breed['country'];?>
								<br>Coat: <?=$breed['hair'];?>
								<br>Colour: <?=$breed['colour'];?>
								<br><a href="breeds/{{$breed['id']}}">Details >></a>
							</p>
						</div>
					</div>
					<br>
					<?php } ?>
					{{ $breeds->links() }}
				<?php } ?>
            </div>
        </div>				
@stop
