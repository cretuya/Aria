@extends('layouts.master')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">

<style type="text/css">

.carousel-control.right, .carousel-control.left{
	background: none !important;
	opacity: 1 !important;
}

.carousel-control{
	width: 0 !important;
	display: none;
}

.carousel-control .fa-chevron-circle-left, .carousel-control .fa-chevron-circle-right{
	position: absolute;
    top: 34%;
    z-index: 5;
    display: inline-block;
}

.fa-chevron-circle-left{
	margin-left: -40px;
	font-size: 30px !important;
}

.fa-chevron-circle-right{
	right: -40px;
	font-size: 30px !important;
}

</style>

@include('layouts.navbar')
@section('content')
<br><br><br><br>
<div class="container">
<center><h2 style="font-family: Montserrat">PLAYLISTS</h2></center>
<br><br>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
 
@if(count($recplaylists) == null)
<h5>No playlists available yet</h5>
@else
	@foreach($recplaylists as $recplaylist)
     <div class="col-xs-3">
		<a href="{{url('discover/playlist/'.$recplaylist->genre_id)}}">
		<div style="background: #222">
			<img src="{{url('assets/img/genre/'.$recplaylist->genre_name.'.jpeg')}}" class="img-responsive genre-thumbnail">
			<div class="carousel-caption" style="top: -5px; left: 30px;"><img src="{{ url('assets/img/arialogo.png')}}" class="img-responsive" style="width: 35px; padding: 7px 3px;border: 0.1em solid #F6843B; border-radius: 50%;"></div>
		</div>
		<center>
		<h4>{{$recplaylist->genre_name}} Playlist</h4>
		<p>by: Aria</p>
		</center>
		</a>
	</div>
	@endforeach
@endif
    </div>
  
    
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="fa fa-chevron-circle-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="fa fa-chevron-circle-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>



<center><h2 style="font-family: Montserrat">GENRES</h2></center>
<br><br>

	@foreach($allGenres as $genre)
	<div class="col-sm-4">
		<a href="{{url('/discover/'.$genre->genre_name)}}">
		<div style="background: #222;">
			<img src="{{ url('assets/img/genre/'.$genre->genre_name.'.jpeg') }}" class="img-responsive genre-thumbnail ">
			<div class="carousel-caption text-center">
				<p style="font-size: 15px; text-transform: uppercase; letter-spacing: 2.5px; font-family: Montserrat">{{$genre->genre_name}}</p>
			</div>
			<div>
				<h1> </h1>
			</div>
		</div>
		</a>
	</div>
	@endforeach
	

</div>

<script>
	$('.carousel').carousel({
	    interval: false
	}); 
</script>

@endsection