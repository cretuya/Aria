@extends('layouts.master')

@section('content')

<meta name ="csrf-token" content = "{{csrf_token() }}"/>

<style type="text/css">
	input[type='range']{
	  -webkit-appearance: none !important;
	  background: #E57C1F;
	  cursor: pointer;
	  height: 5px;
	  outline: none !important;
	}

	input[type='range']::-webkit-slider-thumb{
	  -webkit-appearance: none !important;
	  background: #e4e4e4;
	  height: 12px;
	  width: 12px;
	  border-radius: 100%;
	  cursor: pointer;
	}
	.bandmemberslist{
		columns: 2;
		-webkit-columns: 2;
		-moz-columns: 2;
	}
</style>

@include('layouts.sidebar')

<div class="container" id="main" style="background: #161616;">
	<div class="row">
	    @if($band->band_coverpic == null)
	    <div id="bandBanner" class="panel-thumbnail" style="background: url({{asset('assets/img/banner.jpeg')}}) no-repeat center center;">
	      &nbsp;
	    </div>
	    <div id="bandBannerGradient" class="panel-thumbnail">
	      &nbsp;
	    </div>
	    @else
	    <div id="bandBanner" class="panel-thumbnail" style="background: url({{$band->band_coverpic}}) no-repeat center center;">
	      &nbsp;
	    </div>
	    <div id="bandBannerGradient" class="panel-thumbnail">
	      &nbsp;
	    </div>
	    @endif
	</div>

	<br><br><br><br><br><br><br><br>

	<div class="row bandpicfollower-section">
		@if($band->band_pic == null)
		<div class="panel-thumbnail" style="background: transparent;">
		  <img src="{{asset('assets/img/dummy-pic.jpg')}}" class="img-responsive bandpicstyle">
		</div>
		@else
		<div class="panel-thumbnail" style="background: transparent;">
		  <img src="{{$band->band_pic}}" class="img-responsive bandpicstyle">
		</div>
		@endif

		<center>
			<h4 style="text-transform: uppercase; letter-spacing: 2px;">{{$band->band_name}}</h4>
			@if ($band->num_followers == null)
			<p class="followers" style="margin-top: -5px; font-size: 12px; color: #9e9e9e">0 Followers</p>
			@else
			<p class="followers" style="margin-top: -5px; font-size: 12px; color: #9e9e9e">{{$followers}} Followers</p>
			@endif

			<input type="text" value="{{$band->band_id}}" id="bid" hidden>
			@if ($follower == null)
			<button class="btn-follow followButton" rel="6">Follow</button>
			@else
			<button class="btn-follow followButton following" rel="6">UnFollow</button>
			<input type="text" value="{{$follower->user_id}}" id="uid" hidden>
			@endif

			<br>
			<div style="width: 53%; margin-top: 35px;">
				<span style="font-size: 13px; letter-spacing: 0.5px;">{{$band->band_desc}}</span>
			</div>

		</center>
	</div>
	<br><br><br>
	<div class="row">
		<div class="col-md-8" style="padding-left: 30px;">
			<div class="panel" style="border-radius: 0px; background: #EEEEEE">
			  <div class="panel-heading" style="padding-bottom: 0px; padding-top: 15px;">
			  	<center><h6 style="color: #212121; text-transform: uppercase; letter-spacing: 1px;">Upcoming Events</h6></center>
			  </div>
				<div class="panel-body" style=" background: transparent;">
					<table class="table">					  
					  @if( count($events) == 0)
					  <tr>
					  	<td colspan="4" style="padding-top: 20px; padding-bottom: 20px; color: #7c7c7c; font-size: 13px; text-align: center;">No events yet</td>
					  </tr>
					  @else
					  @foreach($events as $event)

					  <?php
						  $date = DateTime::createFromFormat("Y-m-d", $event->event_date);
						  $event->event_date = $date->format("M d");
						  $time = $event->event_time; 
						  $event->event_time = date('h:i A', strtotime($time));
					  ?>
					  <tr>
					    <td style="padding-top: 20px; padding-bottom: 20px; color: #212121;">{{$event->event_date}}</td>
					    <td style="padding-top: 20px; padding-bottom: 20px; color: #212121;">{{$event->event_name}}</td>
					    <td style="padding-top: 20px; padding-bottom: 20px; color: #212121;">{{$event->event_venue}}</td>
					    <td style="padding-top: 20px; padding-bottom: 20px; color: #212121;">{{$event->event_time}}</td>
					    <td style="padding-top: 20px; padding-bottom: 20px; color: #212121;">{{$event->event_location}}</td>
					  </tr>
					  @endforeach
					  @endif
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4" style="padding-right: 30px;">
			<div class="panel" style="border-radius: 0px; background: #F5F5F5">
			  <div class="panel-heading" style="background: #232323">
			  	<center><h6 style="color: #fafafa; text-transform: uppercase; letter-spacing: 1px;">We Are</h6></center>
			  </div>
				<div class="panel-body">
				<ul class="bandmemberslist" style="padding-left: 35px; list-style-type: none">
				@if(count($band)==0)
					<li style="color: #212121; letter-spacing: 0.5px; line-height: 16px; font-size: 13px;">No members yet</li>
				@else
				@foreach($band->members as $member)
					<li style="color: #212121; letter-spacing: 0.5px; line-height: 16px; font-size: 13px; padding-top: 15px; padding-bottom: 15px;">{{$member->user->fullname}}</li>					
				@endforeach
				@foreach($band->members as $memberrole)
						<li style="color: #212121; letter-spacing: 0.5px; line-height: 16px; font-size: 13px; padding-top: 15px; padding-bottom: 15px;">{{$memberrole->bandrole}}</li>
					@endforeach
				@endif
				</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<br>
			<center><h6 style="color: #fafafa; text-transform: uppercase; letter-spacing: 1px;">Uploads from {{$band->band_name}}</h6></center>
			<hr style="width: 5%;">
			<br>
			@foreach($videos as $video)
				<div class="col-md-3">
					<div id="video-content{{$video->video->video_id}}" onclick="videoOpen({{$video->video->video_id}});">
						<video style="background: #000; width: 100%; height: inherit; cursor:pointer;" class="embed-responsive-item vidContent{{$video->video->video_id}}" data-content="{{asset('assets/video/'.$video->video->video_content)}}">
						    <source src="{{asset('assets/video/'.$video->video->video_content)}}">
						</video>
					</div>
					<div>
					  <a href="#" style="font-size: 12px;" onclick="videoOpen({{$video->video->video_id}});">{{$video->video->video_title}}</a>
					  <br>
					  <span style="font-size: 12px">{{$band->band_name}}</span>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<br><br>
			<center><h6 style="color: #fafafa; text-transform: uppercase; letter-spacing: 1px;">Released Albums</h6></center>
			<hr style="width: 5%;">
			<br><br>
			<div class="container-fluid">
				<div class="row">
				@forelse($albums as $album)
					<div class="col-md-2">
						<a href="{{url($band->band_name.'/albums/'.$album->album_id)}}">
						  <div class="panel-thumbnail">
							<img src="{{$album->album_pic}}" class="img-responsive" style="height: 150px;">
						  </div>
						</a>
						<a href="{{url($band->band_name.'/albums/'.$album->album_id)}}"><p style="text-align: center; margin-top: 10px;">{{$album->album_name}}</p>
						</a>
						<center><p style="margin-top: -10px; font-size: 11px;">23 Mar 2018</p></center>
						@if($album->num_likes == 0)
						<center><p class="followers" style="margin-top: -10px; font-size: 11px; color: #9e9e9e">0 likes</p></center>
						@else
						<center><p class="followers" style="margin-top: -10px; font-size: 11px; color: #9e9e9e">{{$album->num_likes}} likes</p></center>
						@endif
					</div>
				@empty
					<br>
					<center><p>No albums yet</p></center>
				@endforelse
				</div>
			</div>
		</div>
	</div>

	<br><br><br><br><br><br><br><br><br>

</div>

<!-- Video modal -->

<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetVid();">
          <span aria-hidden="true" onclick="resetVid();">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-video">
          <div class="embed-responsive embed-responsive-16by9" id="vidcontainer">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

	function resetVid(){
	  var vid1 = document.getElementById('actualVideo');
	  var vid2 = $('#actualVideo').html();
	  vid1.pause();
	}

	function videoOpen(id){

	    var vid = document.getElementById('vidcontainer');
	    var content = $('.vidContent'+id).data('content');
	    var playIcon = "{{asset('assets/img/play.png')}}";

	    // console.log(content);
	    vid.innerHTML ='<video id="actualVideo" class="embed-responsive-item" autoplay><source id="vidsrc" src="'+content+'" type="video/mp4"></source></video><div id="controllerBox" class="video-controls-box" style="position: absolute;bottom: 0px;width: 100%;"><input id="seeksliderVid" type="range" min="0" max="100" value="0" step="1"><div style="padding-top: 5px; padding-bottom: 4px;"><span><img id="playPauseBottomOfVid" src="'+playIcon+'" onclick="playPauseVid()" style="cursor:pointer; width: 25px; padding-left: 5px; margin-top: -2px;"></span><span id="curtimeText" style="color:#fafafa; margin-left: 5px;">0:00</span> / <span id="durtimeText" style="color:#fafafa;">0:00</span></div></div>';

	    $('#modal-video').modal('show');
	    playPauseVid();
	}

	function playPauseVid(){
	    var vid = document.getElementById('actualVideo');
	    var vidForSlider = "seeksliderVid";
	    var seekslider = document.getElementById(vidForSlider);
	    var playPauseBottom = "playPauseBottomOfVid";
	    var controlBox = "controllerBox";

	    var playBtn = "{{asset('assets/img/play.png')}}";
	    var pauseBtn = "{{asset('assets/img/pause.png')}}";

	    var controllerVidBottom = document.getElementById(playPauseBottom);
	    var controllerBox = document.getElementById(controlBox);
	    
	    if (vid.paused) {
	      vid.play();
	      controllerVidBottom.src = pauseBtn;

	      setTimeout(function(){
	        $(controllerBox).fadeIn();
	      }, 100);
	      

	    }else{
	      vid.pause();
	      controllerVidBottom.src = playBtn;
	    }
	    
	    seekslider.addEventListener("change", function(){
	        var seekTo = vid.duration * (seekslider.value/100);
	        vid.currentTime = seekTo;
	    });

	    vid.addEventListener("timeupdate", function(){
	        var newtime = vid.currentTime * (100/vid.duration);
	        seekslider.value = newtime;

	        var curtimeId = "curtimeText";
	        var durtimeId = "durtimeText";
	        var curtimeText = document.getElementById(curtimeId);
	        var durtimeText = document.getElementById(durtimeId);

	        var curmins = Math.floor(vid.currentTime/60);
	        var cursecs = Math.floor(vid.currentTime-curmins*60);
	        var durmins = Math.floor(vid.duration/60);
	        var dursecs = Math.round(vid.duration-durmins*60);
	        if (cursecs<10) {
	          cursecs = "0"+cursecs;
	        }
	        if (dursecs<10) {          
	          dursecs = "0"+dursecs;
	        }
	        curtimeText.innerHTML = curmins+":"+cursecs;
	        durtimeText.innerHTML = durmins+":"+dursecs;

	    });

	    vid.addEventListener("ended", function(){
        var controllerVidBottom = document.getElementById(playPauseBottom);
        vid.currentTime = 0;
        controllerVidBottom.src = playBtn;
    });
	}

	// The rel attribute is the userID you would want to follow

	$('button.followButton').on('click', function(e){
	    e.preventDefault();
	    $button = $(this);
	    if($button.hasClass('following')){
	        
	        // $.ajax(); Do UnFollow
	        var bid = $('#bid').val();
	        unfollowBand(bid);
	        
	    } else {
	        
	        // $.ajax(); Do Follow
	        var id = $('#bid').val();
	        followBand(id);
	        
	    }
	});

	function followBand(id)
	{
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

 		$.ajax({
          method : "post",
          url : "./followBand",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
        	console.log(json);
			$button.addClass('following');
	        $button.text('Following');
	        $('.following').append('<input type="text" value="'+json.preference.user_id+'" id="uid" hidden>');
	        $('.followers').text(json.followers+' Followers');
          },
          error: function(a,b,c)
          {
            alert('Error');

          }
        });		
	}

	function unfollowBand(bid)
	{
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    var uid = $('#uid').val();


 		$.ajax({
          method : "post",
          url : "./unfollowBand",
          data : { '_token' : CSRF_TOKEN,
            'bid' : bid,
            'uid' : uid
          },
          success: function(json){
        	console.log(json);
	        $button.removeClass('following');
	        // $button.removeClass('unfollow');
	        $button.text('Follow');
	        $('.followers').text(json.followers+' Followers');
          },
          error: function(a,b,c)
          {
            console.log('Error');

          }
        });			
	}

	// $('button.followButton').hover(function(){
	//      $button = $(this);
	//     if($button.hasClass('following')){
	//         $button.addClass('unfollow');
	//         $button.text('Unfollow');
	//     }
	// }, function(){
	//     if($button.hasClass('following')){
	//         $button.removeClass('unfollow');
	//         $button.text('Following');
	//     }
	// });
$(document).ready(function()
{
	$('#addArticle').on('click', '.add', function()
	{
		var val = $(this).val();
		window.location =  val;
	});
});

</script>

</body>
</html>
@endsection