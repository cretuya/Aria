@extends('layouts.master')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">

@include('layouts.navbar')
@section('content')
<br><br><br><br><br>
<div class="container">


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


@endsection