@extends('layouts.master')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">

@include('layouts.navbar')
@section('content')
<br><br><br>
<div class="container">
<meta name ="csrf-token" content = "{{csrf_token() }}"/>

	<center><h3>{{$genreChoice->genre_name}}</h3><br></center>

	<ul class="nav nav-pills">
	  <li class="active"><a data-toggle="tab" href="#bandstab">Bands</a></li>
	  <li><a data-toggle="tab" href="#playliststab">Playlists</a></li>
	</ul>

	<div class="tab-content" style="padding-top: 25px;">
	  <div id="bandstab" class="tab-pane fade in active">
	    	<section id="bands">
	    	@if ($bands == null)
	    	@else
	    		@foreach ($bands as $band)
	    		<div class="bandphoto">
	    		@if ($band->band->band_pic == null)
	    		<div class="col-xs-2">
	    			<a href="#" data-id="{{$band->band->band_id}}" data-title="{{$band->band->band_name}}" data-desc="{{$band->band->band_desc}}" data-follower="{{$band->band->num_followers}}" data-pic="{{$band->band->band_pic}}" class="viewBand">
	    			<div style="background: #222">
	    				<img src="http://res.cloudinary.com/demo/image/upload/v1499589454/sample.jpg" class="img-responsive genre-thumbnail">
	    				<div class="carousel-caption">
	    					<h4>{{$band->band->band_name}}</h4>
	    				</div>
	    				<div>
	    					<h1> </h1>
	    				</div>
	    			</div>
	    			</a>
	    		</div>
	    		@else
	    		<div class="col-xs-2">
	    			<a href="#" data-id="{{$band->band->band_id}}" data-title="{{$band->band->band_name}}" data-desc="{{$band->band->band_desc}}" data-follower="{{$band->band->num_followers}}" data-pic="{{$band->band->band_pic}}" class="viewBand">
	    			<div style="background: #222">
	    				<img src="{{$band->band->band_pic}}" class="img-responsive genre-thumbnail">				
	    				<div>
	    					<h1> </h1>
	    				</div>
	    			</div>
	    			<center><h4>{{$band->band->band_name}}</h4></center>
	    			</a>
	    		</div>
	    		@endif
	    		</div>
	    		@endforeach
	    	@endif		
	    	</section>
	  </div>
	  <div id="playliststab" class="tab-pane fade">
	    <div class="col-xs-2">
	    	<a href="#">
	    	<div style="background: #222">
	    		<img src="https://images.pexels.com/photos/287240/pexels-photo-287240.jpeg?w=940&h=650" class="img-responsive genre-thumbnail">				
	    		<div>
	    			<h1> </h1>
	    		</div>
	    	</div>
	    	<center>
	    	<h4>Relax and Unwind</h4>
	    	<p>by: Aria</p>
	    	</center>
	    	</a>
	    </div>
	  </div>
	</div>

	<div id="bandModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body">
	       <img src="https://www.theshowlastnight.com/wp-content/uploads/2014/08/IMG_0244.jpg" class="img-responsive thispic">
	       <h3></h3>
	       <p class="desc"></p>
	       <p class="followers"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default visitpage">Visit Page</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

</div>

<script>
$(document).ready(function()
{
	$('.bandphoto').on('click', '.viewBand', function()
	{
		var id = $(this).data('id');
		var name = $(this).data('title');
		var desc = $(this).data('desc');
		var follower = $(this).data('follower');
        var source = "{{url('/assets/img/')}}";
        var getimage = $(this).data('pic');
        // var image = source +'/'+ getimage;
        var dummypic = source +'/dummy-pic.jpg';

      $('.modal-body h3').text(name);
      $('.modal-body .desc').text(desc);
      $('.modal-footer .visitpage').val(id);
      if (follower == "")
      {
      $('.modal-body .followers').text("No followers yet.");      	
      }
      else
      {
      $('.modal-body .followers').text(follower+" followers");       	
      }


      if(getimage == "")
      {
      	$('.thispic').attr('src', dummypic);
      }
      else
      {
      	$('.thispic').attr('src', getimage);
      }


      $('#bandModal').modal('show');
	});
	$('#bandModal').on('click', '.visitpage', function()
	{
		var id = $('.visitpage').val();
		var name = $('.modal-body h3').text();
		console.log(name);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          method : "post",
          url : "../visitCount",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
          	window.location.href = "../"+name;
          },
          error: function(a,b,c)
          {
            alert('Error');

          }
        });
	});
});
	// function getRandomSize(min, max) {
	//   return Math.round(Math.random() * (max - min) + min);
	// }

	// var allImages = "";

	// for (var i = 0; i < 25; i++) {
	//   var width = getRandomSize(200, 400);
	//   var height =  getRandomSize(200, 300);
	//   allImages += '<a href="#" data-toggle="modal" data-target="#bandModal"><img src="https://placekitten.com/'+width+'/'+height+'"></a><h4> </h4>';
	// }

	// $('#photos').append(allImages);

</script>

@endsection