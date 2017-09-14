@extends('layouts.master')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">

@include('layouts.navbar')
@section('content')
<br><br><br><br><br>
<div class="container">


	@foreach($allGenres as $genre)
	<div class="col-sm-2">
		<a href="{{url('/discover/'.$genre->genre_name)}}">
		<div style="background: #222">
			<img src="https://images.pexels.com/photos/374703/pexels-photo-374703.jpeg" class="img-responsive genre-thumbnail ">
			<div class="carousel-caption">
				<h4>{{$genre->genre_name}}</h4>
			</div>
			<div>
				<h1> </h1>
			</div>
		</div>
		</a>
	</div>
	@endforeach
	

</div>


@endsection