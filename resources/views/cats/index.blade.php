@extends('layout')

@section('header')
	<title>Cat Club | Cats Listing</title>
	<meta name="description" content="">
	<meta name="author" content="">
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
			<?php if(isset($cat)){?>
				<h1><?=$cat['name'];?> Details</h1>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 box no-gutters">
							<div class="col-xs-12 col-sm-8 col-md-8 no-gutters">
								<img src="<?= asset('images/cat/'.$cat['image']);?>" />
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<p>
									<b>Breed: <?=$cat->breed['breed'];?></b>
									<br>Born: <?=date_create($cat['dob'])->format('d M Y');?>
									<br>Gender: <?=$cat['gender'];?>
									<br>Owner: <?=$cat->owner['forename'].' '.$cat->owner['surname'];?>
									<br><a href="{{ route('cats') }}<?=$strParams != '?' ? $strParams : ''?>">Back to list >></a>
								</p>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h3>Description</h3> 
							<?=$cat['desc'];?>						

						<?php if(!empty($ownersCats)){ ?>
							<h3>Other cats of the same Owner</h3> 
							<?php foreach($ownersCats as $oCat){?>
							<div class="col-xs-6 col-sm-4 col-md-4 box no-gutters">
								<a href="/cats/<?=$oCat['id']?>">
								<img src="<?= asset('images/cat/'.$oCat['image']);?>"/>
								<div class="box-text">
								<p>
									Name: <b>{{ $oCat['name'] }}</b>
								</p>
								</div>	
								</a>						
							</div>
							<?php } ?>
						<?php } ?>
						</div>
					</div>
					<br>
				<?php } else { 
				?>
				<h1>Cats listing</h1>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 ">
							<form method="get" action="{{ route('cats') }}">								
								<div class="form-group row">
									<label class="col-xs-4 col-sm-1 col-md-1 control-label" for="breed">Breed</label>
									<div class="col-xs-8 col-sm-4 col-md-4">
										<select class="form-control" id="breed" name="id_breed">
											<option value="">All</option>
											<?php foreach($breeds as $breed){?>
												<option value="<?=$breed['id']?>" <?=($breed['id']==$strBreed?'selected="selected"':'')?>><?=$breed['breed']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="visible-xs col-xs-12">&nbsp;</div>
									<label class="col-xs-4 col-sm-1 col-md-1 control-label" for="gender">Gender</label>
									<div class="col-xs-8 col-sm-4 col-md-4">
										<select class="form-control" id="gender" name="gender">
											<option value="">All</option>
											<option value="female" <?=('female'==$strGender?'selected="selected"':'')?>>Female</option>
											<option value="male" <?=('male'==$strGender?'selected="selected"':'')?>>Male</option>
										</select>
									</div>
									<div class="visible-xs col-xs-12">&nbsp;</div>									
									<div class="col-xs-12 col-sm-2 col-md-2">
										<input type="submit" class="pull-right btn btn-primary" value="Search">
									</div>
								</div>
							</form>
						</div>
					</div>						
					<?php foreach($cats as $cat){?>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 box no-gutters">
							<p class="left">
								<img src="<?= asset('images/cat/'.$cat->image);?>" />
							</p>
							<p class="right">
								<b>Name: <?=$cat->name;?></b>
								<br>Breed: <?=$cat->breed;?>
								<br>Born: <?=date_create($cat->dob)->format('d M Y');?>
								<br>Gender: <?=$cat->gender;?>
								<br>Owner: <?=$cat->forename.' '.$cat->surname;?>
								<br><a href="cats/{{$cat->id}}">Details >></a>
							</p>
						</div>
					</div>
					<br>
					<?php } 
					if($strBreed=="" && $strGender=="") {?>
					{{ $cats->links() }}
					<?php } else {?>
					{{ $cats->appends(['id_breed' => $strBreed])->appends(['gender' => $strGender])->links() }}
					<?php } } ?>
	</div>				
</div>				
@stop
