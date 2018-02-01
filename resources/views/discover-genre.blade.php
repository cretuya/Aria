@extends('layouts.master')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">
@section('content')

<style type="text/css">
	.hovereffect {
	  width: 100%;
	  height: 100%;
	  float: left;
	  overflow: hidden;
	  position: relative;
	  text-align: center;
	  cursor: default;
	  background: #000;
	}

	.hovereffect .overlay {
	  width: 100%;
	  height: 100%;
	  position: absolute;
	  overflow: hidden;
	  top: 0;
	  left: 0;
	  padding: 50px 20px;
	}

	.hovereffect img {
	  display: block;
	  position: relative;
	  max-width: none;
	  width: calc(100% + 20px);
	  height: 100%;
	  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
	  transition: opacity 0.35s, transform 0.35s;
	  -webkit-transform: translate3d(-10px,0,0);
	  transform: translate3d(-10px,0,0);
	  -webkit-backface-visibility: hidden;
	  backface-visibility: hidden;
	}

	.hovereffect:hover img {
	  opacity: 0.4;
	  filter: alpha(opacity=40);
	  -webkit-transform: translate3d(0,0,0);
	  transform: translate3d(0,0,0);
	}

	.hovereffect h2 {
	  text-transform: uppercase;
	  color: #fff;
	  text-align: center;
	  position: relative;
	  font-size: 17px;
	  overflow: hidden;
	  padding: 0.5em 0;
	  background-color: transparent;
	}

	.hovereffect h2:after {
	  position: absolute;
	  bottom: 0;
	  left: 0;
	  width: 100%;
	  height: 2px;
	  background: #fff;
	  content: '';
	  -webkit-transition: -webkit-transform 0.35s;
	  transition: transform 0.35s;
	  -webkit-transform: translate3d(-100%,0,0);
	  transform: translate3d(-100%,0,0);
	}

	.hovereffect:hover h2:after {
	  -webkit-transform: translate3d(0,0,0);
	  transform: translate3d(0,0,0);
	}

	.hovereffect a, .hovereffect p {
	  color: #fafafa;
	  opacity: 0;
	  filter: alpha(opacity=0);
	  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
	  transition: opacity 0.35s, transform 0.35s;
	  -webkit-transform: translate3d(100%,0,0);
	  transform: translate3d(100%,0,0);
	}

	.hovereffect a:hover, .hovereffect p:hover {
		color: #E57C1F;
	}

	.hovereffect:hover a, .hovereffect:hover p {
	  opacity: 1;
	  filter: alpha(opacity=100);
	  -webkit-transform: translate3d(0,0,0);
	  transform: translate3d(0,0,0);
	}
</style>

@include('layouts.sidebar')

<br><br>
<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">
  <div class="row">
    <div class="col-md-12">
    <h3 style="text-align: center; text-transform: uppercase; letter-spacing: 3px;">{{ $genreChoice->genre_name }} Bands</h3>
    <hr style="width: 10%">
    </div>
  </div>
  @foreach($bands as $band)
  	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="height: 280px; margin-top: 20px;">
  	    <div class="panel-thumbnail hovereffect">
  	        <img class="img-responsive" src="{{$band->band->band_pic}}" alt="">
  	            <div class="overlay">
  	                <h2>{{$band->band->band_name}}</h2>
  					<p>
  						<a href="{{url('/'.$band->band->band_name)}}">Visit Page</a>
  					</p>
  	            </div>
  	    </div>
  	</div>
  @endforeach

</div>


<!-- <div id="bandModal" class="modal fade" role="dialog">
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
</div> -->

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