<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags always come first -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		 <title>Cat Breeders Club</title>
		<meta name="author" content="dorota">	
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="icon" href="">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('/css/cms.css') }}" rel="stylesheet" type="text/css">		
        <link href="{{ asset('/js/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css') }}" rel="stylesheet" type="text/css">		
    </head>
<body id="app-layout">
@if(Auth::user())	
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse"  aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Cat Breeders Club
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">						
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                </ul>
            </div>
        </div>
    </nav>
@endif
<footer class="footer">
<div class="container">
    <div class="row">
@if(Auth::user())
        <div class="col-md-2 menu no-gutters ">
            <p>Menu</p>
			@if(!empty($tables) && isset($url))
			<ul>
				@foreach($tables as $key=>$value)
					@if(empty($value['parent']))
					<li <?=(($url==$key || in_array($url, $value['children'])===true) ?'class="active"':'')?>><a href="{{ url('/select/'.$key) }}">{{ str_plural($key) }}</a></li>
					@endif
				@endforeach
			</ul>
			@endif
        </div>

	<?php // echo '<pre>'; print_r($tables); echo '</pre>'; ?>
@endif
    @yield('content')
    </div>
</div>
</footer>
    <!-- JavaScripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>	
	<script src="{{ asset('/js/mainCMS.js') }}"></script>
	<script src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>	
</body>
</html>
