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
	  background: #212121;
	  cursor: pointer;
	  height: 5px;
	  outline: none !important;
	}

	input[type='range']::-webkit-slider-thumb{
	  -webkit-appearance: none !important;
	  background: #E57C1F;
	  height: 12px;
	  width: 12px;
	  border-radius: 2px;
	  cursor: pointer;
	}
</style>

@include('layouts.sidebar')
@section('content')
<br><br>
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
		              		  <div class="media-body" style="padding-top: 20px; background: #232323; padding-left: 10px;">
		              		    <a href="{{ url('/playlist/'.$srPlay->pl_id) }}"><h4 class="media-heading">{{$srPlay->pl_title}}</h4></a>
		              		    <p>by: {{$srPlay->fullname}}</p>
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
		              				<a href="#" onclick="playOrPause($(this));" style="position: relative;">
		              				  <img src="{{asset('assets/img/playfiller.png')}}" class="media-object" style="width: 45px; position: absolute; top: -62px; left: 18px; opacity: 0.75;" draggable="false">
		              				  <img id="playBtn" src="{{asset('assets/img/play.png')}}" class="media-object" draggable="false" style="width: 45px; position: absolute; top: -62px; left: 18px;">
		              				</a>
		              				<audio src="{{url('/assets/music/'.$srSong->song_audio)}}" type="audio/mpeg" controls hidden></audio>
		              			</div>
		              			<div class="media-body" style="background: #fafafa; padding: 15px;">
		              				<h5 style="margin-top: 5px; color: #212121;">
		              					{{$srSong->album->band->band_name}} - {{$srSong->song_title}}
		              					<button class="btn pull-right" style="padding: 3px 7px; margin-top: -5px; background: #232323; color: #fafafa;">
		              						<span style="font-size: 12px;">Add to playlist</span>
		              					</button>
		              				</h5>
		              				<input id="musicslider" type="range" style="margin-top: 20px;" min="0" max="100" value="0" step="1">		              				
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
		            	$srAlbum->released_date = $date->format("M Y");
		            ?>

		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              	<div class="media" style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 2px solid #E57C1F">
		              		<div class="media-left">
		              		<a href="#">
		              			<div class="panel-thumbnail">
		              				<img src="{{$srAlbum->album_pic}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px">
		              			</div>
		              		</a>
		              		</div>
		              		<div class="media-body" style="padding-top: 5px; background: #232323; padding-left: 10px;">
		              		<a href="#"><h5>{{$srAlbum->album_name}}</h5></a>
		              		<p style="font-size: 12px; margin-top: -5px; margin-bottom: 20px;">{{$srAlbum->num_likes}} people liked this album</p>
		              		<span style="font-size: 12px;">Date Release: {{$srAlbum->released_date}}</span>
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
			 	          <div class="media">
			 	            <div class="media-left">
			 	              <video class="media-object" style="width:150px" controls>
			 	              	<source src="{{asset('assets/video/'.$srVideo->video_content)}}" type="video/mp4">
			 	              </video>
			 	            </div>
			 	            <div class="media-body">
			 	              <h4 class="media-heading">Video Title</h4>
			 	              <p>{{$srVideo->video_desc}}</p>
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


<script type="text/javascript">
	
	function playOrPause(element){

		var audioElement = element.next();

		var seekslider = document.getElementById('musicslider');
		var audio = audioElement;

		console.log($(audioElement).get(0));

		if (element.paused) {

			element.find(':nth-child(2)').attr("src","{{url('/assets/img/equa2.gif')}}");
			element.find(':nth-child(2)').css('width','20px');
			element.find(':nth-child(2)').css('left','30px');
			element.find(':nth-child(2)').css('top','-55px');
			$(audioElement).get(0).play();
			
			console.log("if paused");
		}
		else{
			element.find(':nth-child(2)').attr("src","{{url('/assets/img/play.png')}}");
			$(audioElement).get(0).pause();
			console.log('else');
		}
		
		// console.log(element.next());

		seekslider.addEventListener("change", function(){
		    var seekTo = audio.duration * (seekslider.value/100);
		    audio.currentTime = seekTo;
		});

		// audio.addEventListener("timeupdate", function(){
		//     var newtime = audio.currentTime/audio.duration*100;
		//     seekslider.value = newtime;
		// });
	}

</script>

@endsection