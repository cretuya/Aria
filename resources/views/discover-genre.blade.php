@extends('layouts.master')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">

@include('layouts.navbar')
@section('content')
<br><br><br><br><br>
<div class="container">

	<center><h2>{{$genreChoice->genre_name}}</h2></center>
	<section id="photos">
		
	</section>

	<div id="bandModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body">
	       <img src="https://www.theshowlastnight.com/wp-content/uploads/2014/08/IMG_0244.jpg" class="img-responsive">
	       <h3>Our Last Night</h3>
	       <p>Genre: Post-hardcore, Alternative metal, Metalcore</p>
	       <p>Followers: 12,312,656</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default">Visit Our Last Night's Page</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

</div>

<script>

	function getRandomSize(min, max) {
	  return Math.round(Math.random() * (max - min) + min);
	}

	var allImages = "";

	for (var i = 0; i < 25; i++) {
	  var width = getRandomSize(200, 400);
	  var height =  getRandomSize(200, 300);
	  allImages += '<a href="#" data-toggle="modal" data-target="#bandModal"><img src="https://placekitten.com/'+width+'/'+height+'"></a><h4> </h4>';
	}

	$('#photos').append(allImages);

</script>

@endsection