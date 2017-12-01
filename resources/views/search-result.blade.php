@extends('layouts.master')

<style>
	.panel{
		margin-bottom: 0px !important;
	}
	.panel-body{
		padding-bottom: 0px !important;
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
			  <li><a data-toggle="tab" href="#article">Article</a></li>
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
				              <a href="{{url('/profile/'.$searchResultUser[$x]->user_id)}}"><h4 class="media-heading">{{ $searchResultUser[$x]->fname }} {{ $searchResultUser[$x]->lname}}</h4></a>
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
				              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}"><img src="{{$searchResultBand[$i]->band_pic}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px"></a>
				            </div>
				            <div class="media-body" style="padding-top: 10px; background: #232323; padding-left: 10px;">
				              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}"><h4 class="media-heading">{{$searchResultBand[$i]->band_name}}</h4></a>
				              @if(count($bandGenre) == 0)
					              @if($searchResultBand[$i]->num_followers == null)
						          <p>0 Followers</p>
						          @else
						          <p>{{$searchResultBand[$i]->num_followers}} Followers</p>
						          @endif
					          @else			          
						          <p>{{ $bandGenre[$j]->genre_name }} | {{ $bandGenre[$j+1]->genre_name }}</p>
						          @if($searchResultBand[$i]->num_followers == null)
						          <p>0 Followers</p>
						          @else
						          <p>{{$searchResultBand[$i]->num_followers}} Followers</p>
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
		              		    <a href="{{ url('/playlist/'.$srPlay->pl_id) }}"><img src="{{$srPlay->image}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px"></a>
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
		              		<label>{{$srSong->song_audio}}</label><br>
		              		<audio controls>
		              			<source src="{{url('/assets/music/'.$srSong->song_audio)}}" type="audio/mpeg">
		              		</audio>
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
		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              		<a href="#"><h5>{{$srAlbum->album_name}}</h5></a>
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

			  <div id="article" class="tab-pane fade">
			    @if(count($searchResultArticle) > 0)
		            <br>
		            @foreach($searchResultArticle as $srArticle)
		              <div class="panel" style="background: transparent;">
		              	<div class="panel-body">
		              		<a href="#"><h5>{{$srArticle->art_title}}</h5></a>
		              		<!--  url('../'.$band->band_name.'/viewArticle/'.$srArticle->art_id) -->
		              	</div>
		              </div>
		            @endforeach
		          @else
		          	<br>
		          	<p>No articles titled '{{$termSearched}}' found.</p>
		          @endif
		          <br><br>
			  </div>

			</div>
		</div>
	</div>
</div>


@endsection