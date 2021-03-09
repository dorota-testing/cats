@extends('layout')

@section('header')
<title>Cat Club | Cat News</title>
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
		<?php if (!empty($article)) {
			$date = date_create($article->date);
		?>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<br>
					<br>
					<div class="col-xs-12 col-sm-12 col-md-12 box no-gutters">
						<img src="<?= asset('images/news/' . $article['image']); ?>" />
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12">
					<h1><?= $article['title']; ?></h1>
					<p> Posted on: <?= $date->format('d M Y'); ?>
						<?php if ($article->categories->count()) {
							$category = $article->categories->implode('category', ', ');
							//dump ($category);
						?>
							<br>Category: {{ $category }}
						<?php } ?>
						<br><a href="{{ route('news') }}<?= $strParams != '?' ? $strParams : '' ?>">Back to list >></a>
					</p>
					<?= $article['text']; ?>
				</div>

			</div>
			<br>
		<?php } else { ?>
			<h1>Our News</h1>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 ">
					<form method="get" action="{{ route('news') }}">
						<div class="form-group row">
							<label class="col-xs-4 col-sm-2 col-md-2 control-label" for="category">Category</label>
							<div class="col-xs-8 col-sm-3 col-md-3">
								<select class="form-control" id="category" name="category_id">
									<option value="">All</option>
									<?php foreach ($categories as $ctg) { ?>
										<option value="<?= $ctg['id'] ?>" <?= ($ctg['id'] == $strCategory ? 'selected="selected"' : '') ?>><?= $ctg['category'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="visible-xs col-xs-12">&nbsp;</div>
							<label class="col-xs-4 col-sm-2 col-md-2 control-label" for="sort-by-date">Sort by date</label>
							<div class="col-xs-8 col-sm-3 col-md-3">
								<select class="form-control" id="sort-by-date" name="sort">
									<option value="desc" <?= ('desc' == $strSort ? 'selected="selected"' : '') ?>>From Latest </option>
									<option value="asc" <?= ('asc' == $strSort ? 'selected="selected"' : '') ?>>From Oldest</option>
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
			<?php foreach ($news as $item) { ?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 box no-gutters">
						<div class="col-xs-12 col-sm-6 col-md-6 no-gutters">
							<img src="<?= asset('images/news/' . $item->image); ?>" />
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<h2><?= $item['title']; ?></h2>
							<p> Posted on: <?= date_create($item->date)->format('d M Y'); ?>
								<?php if ($item->categories->count()) {
									$category = $item->categories->implode('category', ', ');
									//dump ($category);
								?>
									<br>Category: {{ $category }}
								<?php } ?>
								<br><a href="{{ route('news') }}/{{$item['url']}}">Read More >></a>
							</p>
						</div>
					</div>
				</div>
				<br>
			<?php }
			if ($strSort == "" && $strCategory == "") { ?>
				{{ $news->links() }}
			<?php } else { ?>
				{{ $news->appends(['sort' => $strSort])->appends(['category_id' => $strCategory])->links() }}
		<?php }
		} ?>
	</div>
</div>
@stop