@extends('layouts.master')
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<style>
	.panel{
		margin-bottom: 0px !important;
	}
	.panel-body{
		padding-bottom: 0px !important;
	}

	.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover, .nav>li>a:focus, .nav>li>a:hover{
		background: none !important;
		border-top: none !important;
		border-left: none !important;
		border-right: none !important;
		border-bottom: 2px solid #E57C1F;
		border-radius: 0px;
		color: #fafafa;
	}
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

	.songforcertainplaylist h5:hover{
		background: #101010;
		color: #fafafa;
	}
</style>

@include('layouts.sidebar')
@section('content')
<br><br>
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">
    <div class="row">
        <div class="col-md-12">

			<ul class="nav nav-pills">
			  <li class="active"><a data-toggle="tab" href="#people">People</a></li>
			  <li><a data-toggle="tab" href="#band">Band</a></li>
			  <li><a data-toggle="tab" href="#playlist">Playlist</a></li>
			  <li><a data-toggle="tab" href="#song">Song</a></li>
			  <li><a data-toggle="tab" href="#album">Album</a></li>
			  <li><a data-toggle="tab" href="#video">Video</a></li>
			</ul>

			<div class="tab-content">

			  <div id="people" class="tab-pane fade in active">
				  @if(count($searchResultUser) > 0)
			        <br>
			        <?php for ($x=0; $x < count($searchResultUser) ; $x++) { ?>
			        <div class="panel" style="background: transparent;">
			        	<div class="panel-body">
				          <div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
				            <div class="media-left">
				              <a href="{{url('/profile/'.$searchResultUser[$x]->user_id)}}">
				              <div class="panel-thumbnail">
				              	<img src="{{$searchResultUser[$x]->profile_pic}}" class="media-object" style="width: 100%; min-width: 100px; height:100px;">
				              </div>
				              </a>
				            </div>
				            <div class="media-body" style="padding-top: 16px; background: #232323; padding-left: 12px;">
				              <a href="{{url('/profile/'.$searchResultUser[$x]->user_id)}}"><h5 class="media-heading">{{ $searchResultUser[$x]->fname }} {{ $searchResultUser[$x]->lname}}</h5></a>
				              <p style="font-size: 12px; margin-top: 10px;">{{$searchResultUser[$x]->address}}</p>
				              <p style="font-size: 12px; margin-top: -10px;">{{$searchResultUser[$x]->email}}</p>
				            </div>
				          </div>
			          	</div>
			          </div>
			         <?php } ?>
			      @else
			      	<br>
			      	<p>No person named '{{$termSearched}}' found.</p>
			      @endif

			      <br><br>
			  </div>

			  <div id="band" class="tab-pane fade">
				  @if(count($searchResultBand) > 0)
			        <br>
			        <?php 
			        $i = 0;
			        $j = $i;
			        for ($i=0; $i < count($searchResultBand); $i++) {
			        ?>
			          <div class="panel" style="background: transparent;">
			          	<div class="panel-body">
				          <div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
				            <div class="media-left">
				              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}">
				              <div class="panel-thumbnail">
				              <img src="{{$searchResultBand[$i]->band_pic}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px">
				              </div>
				              </a>
				            </div>
				            <div class="media-body" style="padding-top: 15px; background: #232323; padding-left: 10px;">
				              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}"><h5 class="media-heading">{{$searchResultBand[$i]->band_name}}</h5></a>
				              @if(count($bandGenre) == 0)
					              @if($searchResultBand[$i]->num_followers == null)
						          <p style="font-size: 12px;">0 Followers</p>
						          @else
						          <p style="font-size: 12px;">{{$searchResultBand[$i]->num_followers}} Followers</p>
						          @endif
					          @else			          
						          <p style="font-size: 12px;">{{ $bandGenre[$j]->genre_name }} | {{ $bandGenre[$j+1]->genre_name }}</p>
						          @if($searchResultBand[$i]->num_followers == null)
						          <p style="font-size: 12px;">0 Followers</p>
						          @else
						          <p style="font-size: 12px;">{{$searchResultBand[$i]->num_followers}} Followers</p>
						          @endif
				              @endif
				            </div>
				          </div>
				        </div>
				       </div>
				    <?php $j+=2;} ?>
			      @else
			      	<br>
			      	<p>No bands named '{{$termSearched}}' found.</p>
			      @endif
			      <br><br>
			  </div>


			  <div id="playlist" class="tab-pane fade">
		    	  @if(count($searchResultPlaylist) > 0)
		            <br>
		            @foreach($searchResultPlaylist as $srPlay)
		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              		<div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
		              		  <div class="media-left">
		              		    <a href="{{ url('/playlist/'.$srPlay->pl_id) }}">
		              		    <div class="panel-thumbnail">
		              		    <img src="{{$srPlay->image}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px">
		              		    </div>
		              		    </a>
		              		  </div>
		              		  <div class="media-body" style="padding-top: 15px; background: #232323; padding-left: 10px;">
		              		    <a href="{{ url('/playlist/'.$srPlay->pl_id) }}"><h5 class="media-heading">{{$srPlay->pl_title}}</h5></a>
		              		    @if($srPlay->followers == 0 || $srPlay->followers == null)
		              		    <p style="font-size: 12px;">0 people are following this playlist</p>
		              		    @else
		              		    <p style="font-size: 12px;">{{$srPlay->followers}} people are following this playlist</p>
		              		    @endif
		              		    <p style="font-size: 12px;">by: <a href="{{ url('/profile/'.$srPlay->user_id) }}">{{$srPlay->fullname}}</a></p>
		              		  </div>
		              		</div>
		              		
		              	</div>
		              </div>
		            @endforeach
		          @else
		          	<br>
		          	<p>No songs titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			  

			  <div id="song" class="tab-pane fade">
		    	  @if(count($searchResultSong) > 0)
		            <br>
		            @foreach($searchResultSong as $srSong)
		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              		<div class="media" style="width: 70%;">
		              			<div class="media-left">
		              				<div class="panel-thumbnail">
		              				  <img src="{{$srSong->album->album_pic}}" class="media-object" style="width: 80px; height: 80px;">
		              				</div>
		              				<a href="#" onclick="playOrPause($(this),{{$srSong->song_id}});" style="position: relative;">
		              				  <img src="{{asset('assets/img/playfiller.png')}}" class="media-object" style="width: 45px; position: absolute; top: -62px; left: 18px; opacity: 0.75;" draggable="false">
		              				  <img id="playBtn" src="{{asset('assets/img/play.png')}}" class="media-object" draggable="false" style="width: 45px; position: absolute; top: -62px; left: 18px;">
		              				</a>
		              				<audio src="{{url('/assets/music/'.$srSong->song_audio)}}" data-id="{{$srSong->song_id}}" type="audio/mpeg" controls hidden></audio>
		              			</div>
		              			<div class="media-body" style="background: #fafafa; padding: 15px;">
		              				<h5 style="margin-top: 5px; color: #212121;">
		              					{{$srSong->album->band->band_name}} - {{$srSong->song_title}}
		              					<button class="btn pull-right" onclick="openSelectPlaylistModal({{$srSong->song_id}},{{$srSong->genre->genre_id}});" style="padding: 3px 7px; margin-top: -5px; background: #232323; color: #fafafa;">
		              						<span style="font-size: 12px;">Add to playlist</span>
		              					</button>
		              					<!-- <div class="pull-right" style="margin-right: 20px;"><span id="fullDuration" style="color: #212121; vertical-align: text-top;">0:00</span>
		              					</div> -->
		              				</h5>
		              				<input id="musicslider{{$srSong->song_id}}" type="range" style="margin-top: 20px;" min="0" max="100" value="0" step="1">		              				
		              			</div>
		              		</div>		              		
		              	</div>
		              </div>
		            @endforeach
		          @else
		          	<br>
		          	<p>No songs titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			  <div id="album" class="tab-pane fade">
			    @if(count($searchResultAlbum) > 0)
		            <br>
		            @foreach($searchResultAlbum as $srAlbum)

		            <?php
		            	$date = DateTime::createFromFormat("Y-m-d", $srAlbum->released_date);
		            	$srAlbum->released_date = $date->format("M d Y");
		            ?>

		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              	<div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
		              		<div class="media-left">
		              		<a href="{{url('/'.$srAlbum->band->band_name.'/albums/'.$srAlbum->album_id)}}">
		              			<div class="panel-thumbnail">
		              				<img src="{{$srAlbum->album_pic}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px">
		              			</div>
		              		</a>
		              		</div>
		              		<div class="media-body" style="padding-top: 5px; background: #232323; padding-left: 10px;">
		              		<a href="{{url('/'.$srAlbum->band->band_name.'/albums/'.$srAlbum->album_id)}}"><h5>{{$srAlbum->album_name}}</h5></a>
		              		@if($srAlbum->num_likes == 0 || $srAlbum->num_likes == null)
		              		<p style="font-size: 12px; margin-top: -5px; margin-bottom: 20px;">0 people liked this album</p>
		              		@else
		              		<p style="font-size: 12px; margin-top: -5px; margin-bottom: 20px;">{{$srAlbum->num_likes}} people liked this album</p>
		              		@endif
		              		<span style="font-size: 12px;">Date Released: {{$srAlbum->released_date}}</span>
		              		</div>
		              	</div>
		              	</div>
		              </div>
		            @endforeach
		          @else
		          	<br>
		          	<p>No albums titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			  <div id="video" class="tab-pane fade">
			    @if(count($searchResultVideo) > 0)
		            <br>
		            @foreach($searchResultVideo as $srVideo)
			           <div class="panel" style="background: transparent;">
			           	<div class="panel-body">
			 	          <div class="media" style="border: none; border-radius: 0px;">
			 	            <div class="media-left">
			 	              <div id="video-content{{$srVideo->video_id}}" onclick="videoOpen({{$srVideo->video_id}});">
			 	              <video style="background: #000; width: 150px; height: inherit; cursor:pointer;" class="media-object embed-responsive-item vidContent{{$srVideo->video_id}}" data-name="{{$srVideo->video_title}}" data-content="{{asset('assets/video/'.$srVideo->video_content)}}">
			 	              	<source src="{{asset('assets/video/'.$srVideo->video_content)}}" type="video/mp4">
			 	              </video>
			 	          	  </div>
			 	            </div>
			 	            <div class="media-body" style="background: transparent; padding-left: 15px; padding-top: 5px;">
			 	              <h5 class="media-heading">{{$srVideo->video_title}}</h5>
			 	              @foreach($srVideo->bandvideos as $vids)
			 	              	<a href="{{url('/'.$vids->bands->band_name)}}" style="font-size: 12px;">{{$vids->bands->band_name}} </a><span style="font-size: 12px;">• {{$vids->bands->num_followers}} Followers</span>
			 	              @endforeach
			 	              
			 	              <p style="font-size: 11px; margin-top: 5px;">{{$srVideo->video_desc}}</p>
			 	            </div>
			 	          </div>
			 	        </div>
			 	       </div>
		              		
		            @endforeach
		          @else
		          	<br>
		          	<p>No videos titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			</div>
		</div>
	</div>
</div>

<div id="selectPlaylistModal" class="modal" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Select Playlist</h4>
        </div>
        <div class="modal-body" style="padding-left: 25px;padding-right: 25px;">
        <?php
        	for ($i=0; $i < count($allUserPlaylist); $i++) {
        ?>

    		<a href="#" class="songforcertainplaylist" onclick="submitPlaylist({{$allUserPlaylist[$i]->pl_id}},this);">
    			<h5 style="margin-top: 4px; margin-bottom: 4px; padding: 10px; border-radius: 4px;">{{$allUserPlaylist[$i]->pl_title}}</h5>
    		</a>
        <?php } ?>
        </div>
        </form>
    </div>

  </div>
</div>


<!-- Video modal -->

<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"><span id="vidName" style="margin: 0;"></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetVid();">
          <span aria-hidden="true" onclick="resetVid();">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 0px;">
        <div class="modal-video">
          <div class="embed-responsive embed-responsive-16by9" id="vidcontainer">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

	var usersDurationPlayed = 0;
	var globalInt;
	var othersongId;
	var currentlyPlayingId;
	var prevPlayingId;
	var counter=0;
	var prevSong;

	function playOrPause(element, id){

		// console.log(element.next().data('id'));
		// console.log(currentlyPlayingId);
		var audioElement = element.next();

		var seekslider = document.getElementById('musicslider'+id);
		// var audio = audioElement;

		prevSong = parseInt($(audioElement).get(0).duration);

		$(audioElement).get(0).addEventListener("ended", function(){
		  setTimeout(function(){

		    element.find(':nth-child(2)').attr("src","{{url('/assets/img/play.png')}}");
		    element.find(':nth-child(2)').css('width','45px');
		    element.find(':nth-child(2)').css('left','18px');
		    element.find(':nth-child(2)').css('top','-62px');

		    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		    console.log(CSRF_TOKEN, usersDurationPlayed, id, prevSong);
		    $.ajax({
		      method : "post",
		      url : 'addSongPlayedForScore',
		      data : { '_token' : CSRF_TOKEN, 'durationPlayed' : usersDurationPlayed, 'songID' : id, 'prevSong' : prevSong
		      },
		      success: function(json){
		        console.log(json);
		      },
		      error: function(a,b,c)
		      {
		        console.log(b);
		      }
		    });

		    clearInterval(globalInt);
		    usersDurationPlayed = 0;
		    timerDurationPlayed();

			});
		  var prevElement = $('audio[data-id="'+prevPlayingId+'"]');
		  prevElement.get(0).currentTime=0;
		});

		// console.log($(audioElement).get(0));

		if (!$(audioElement).get(0).paused && !$(audioElement).get(0).ended) {
			element.find(':nth-child(2)').attr("src","{{url('/assets/img/play.png')}}");
			element.find(':nth-child(2)').css('width','45px');
			element.find(':nth-child(2)').css('left','18px');
			element.find(':nth-child(2)').css('top','-62px');
			$(audioElement).get(0).pause();			
			// window.clearInterval(updateTime);
		}
		else{			
			element.find(':nth-child(2)').attr("src","{{url('/assets/img/equa2.gif')}}");
			element.find(':nth-child(2)').css('width','20px');
			element.find(':nth-child(2)').css('left','30px');
			element.find(':nth-child(2)').css('top','-55px');
			$(audioElement).get(0).play();

			counter++;

			if (counter == 1) {
				prevPlayingId = id;
			}else{				
				if (id != prevPlayingId) {
					var prevElement = $('audio[data-id="'+prevPlayingId+'"]');
					// console.log(prevElement);
					prevElement.prev().find(':nth-child(2)').attr("src","{{url('/assets/img/play.png')}}");
					prevElement.prev().find(':nth-child(2)').css('width','45px');
					prevElement.prev().find(':nth-child(2)').css('left','18px');
					prevElement.prev().find(':nth-child(2)').css('top','-62px');
					prevElement.get(0).pause();
					prevElement.get(0).currentTime=0;

					if(usersDurationPlayed == 0){
					  timerDurationPlayed();
					}else{
					  //push then usersDurationPlayed = 0;
					  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
					    console.log(CSRF_TOKEN, usersDurationPlayed, prevPlayingId, prevSong);
					  $.ajax({
					    method : "post",
					    url : 'addSongPlayedForScore',
					    data : { '_token' : CSRF_TOKEN, 'durationPlayed' : usersDurationPlayed, 'songID' : prevPlayingId, 'prevSong' : prevSong
					    },
					    success: function(json){
					      console.log(json);
					    },
					    error: function(a,b,c)
					    {
					      console.log(b);
					    }
					  });
					  usersDurationPlayed = 0;
					  timerDurationPlayed();
					}

					prevPlayingId = id;
				}
			}

			// othersongId = audioElement.data('id');
			// console.log(othersongId, "other song id");
			// updateTime = setInterval(update(element), 0);
		}
		
		// console.log(element.next());
		// console.log(audioElement.get(0).duration);

		seekslider.addEventListener("change", function(){
		    var seekTo = audioElement.get(0).duration * (seekslider.value/100);
		    audioElement.get(0).currentTime = seekTo;
		});

		audioElement.get(0).addEventListener("timeupdate", function(){
		    var newtime = audioElement.get(0).currentTime/audioElement.get(0).duration*100;
		    seekslider.value = newtime;
		});
	}

	function timerDurationPlayed(flag = true){

	  globalInt = setInterval(function(){
	    usersDurationPlayed++;
	    // console.log(usersDurationPlayed);
	  }, 1000);
	}

	function openSelectPlaylistModal(songID,genreID){

		$('.songforcertainplaylist').attr('data-sngid', songID);
		$('.songforcertainplaylist').attr('data-gnrid', genreID);
		
		$('#selectPlaylistModal').fadeTo(300, 1).modal('show');
		// console.log('modal opened');
	}

	function submitPlaylist(id,element){
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		var plID = id;
		var songID = $(element).data('sngid');
		var genreID = $(element).data('gnrid');

		// console.log(plID,songID,genreID);

		$.ajax({
		  method : "post",
		  url : 'addSongResultToPlaylist',
		  data : { '_token' : CSRF_TOKEN, 'plID' : plID , 'songID' : songID , 'genreID' : genreID
		  },
		  success: function(json){
		    console.log(json);
		  },
		  error: function(a,b,c)
		  {
		    console.log(b);
		  }
		});

		$('#selectPlaylistModal').fadeTo(300, 1).modal('hide');
	}

	function resetVid(){
	  // $('#actualVideo').children().filter("video").each(function(){
	  //     this.pause(); // can't hurt
	  //     delete this; // @sparkey reports that this did the trick (even though it makes no sense!)
	  //     $(this).remove(); // this is probably what actually does the trick
	  // });
	  // $('#actualVideo').empty();
	  var vid1 = document.getElementById('actualVideo');
	  var vid2 = $('#actualVideo').html();
	  vid1.pause();
	  // vid2.remove();
	}
	function videoOpen(id){

	    var vid = document.getElementById('vidcontainer');
	    var content = $('.vidContent'+id).data('content');
	    var playIcon = "{{asset('assets/img/play.png')}}";
	    var vidname = $('.vidContent'+id).data('name');
	    $('#vidName').html(vidname);

	    // console.log(vidname,content);
	    vid.innerHTML ='<video id="actualVideo" class="embed-responsive-item" autoplay><source id="vidsrc" src="'+content+'" type="video/mp4"></source></video><div id="controllerBox" class="video-controls-box" style="position: absolute;bottom: 0px;width: 100%;"><input id="seeksliderVid" type="range" min="0" max="100" value="0" step="1"><div style="padding-top: 5px; padding-bottom: 4px;"><span><img id="playPauseBottomOfVid" src="'+playIcon+'" onclick="playPauseVid()" style="cursor:pointer; width: 25px; padding-left: 5px; margin-top: -2px;"></span><span id="curtimeText" style="color:#fafafa; margin-left: 5px;">0:00</span> / <span id="durtimeText" style="color:#fafafa;">0:00</span></div></div>';

	    $('#modal-video').modal('show');
	    playPauseVid();
	}
	function playPauseVid(){
	    // console.log(vid.id);
	    var vid = document.getElementById('actualVideo');
	    // var controller_vId = "controllOfVid"+vid.id;
	    var vidForSlider = "seeksliderVid";
	    var seekslider = document.getElementById(vidForSlider);
	    var playPauseBottom = "playPauseBottomOfVid";
	    var controlBox = "controllerBox";

	    // console.log(controller_vId);
	    var playBtn = "{{asset('assets/img/play.png')}}";
	    var pauseBtn = "{{asset('assets/img/pause.png')}}";

	    // var controllerVid = document.getElementById(controller_vId);
	    var controllerVidBottom = document.getElementById(playPauseBottom);
	    var controllerBox = document.getElementById(controlBox);
	    
	    if (vid.paused) {
	      vid.play();
	      // controllerVid.src = pauseBtn;
	      controllerVidBottom.src = pauseBtn;
	      // $(controllerVid).fadeOut();

	      setTimeout(function(){
	        $(controllerBox).fadeIn();
	      }, 100);
	      
	      // setTimeout(function(){
	      //   $(controllerBox).fadeOut();
	      // }, 2000);

	      // $(vId).mouseover(function(event) {
	      //   $(controllerBox).fadeIn();
	      //   setTimeout(function(){
	      //     $(controllerBox).fadeOut();
	      //   }, 2000);
	      // });
	      

	    }else{
	      vid.pause();
	      // controllerVid.src = playBtn;
	      controllerVidBottom.src = playBtn;
	      // $(controllerVid).fadeIn();
	      // $(controllerBox).fadeOut();
	    }
	    
	    // console.log(vidForSlider);
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

</script>

@endsection