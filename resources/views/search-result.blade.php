@extends('layouts.master')


@include('layouts.navbar')
@section('content')
<br><br><br><br><br>
<div class="container">

	<ul class="nav nav-pills">
	  <li class="active"><a data-toggle="tab" href="#people">People</a></li>
	  <li><a data-toggle="tab" href="#band">Band</a></li>
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
	        <div class="panel panel-default">
	        	<div class="panel-body">
		          <div class="media" style="border-top: 0px; border-right: 0px;">
		            <div class="media-left">
		              <a href="{{url('/feed/'.$searchResultUser[$x]->user_id)}}"><img src="{{$searchResultUser[$x]->profile_pic}}" class="media-object" style="width: 100%; min-width: 100px; height:100px;"></a>
		            </div>
		            <div class="media-body" style="padding-top: 10px">
		              <a href="{{url('/feed/'.$searchResultUser[$x]->user_id)}}"><h4 class="media-heading">{{ $searchResultUser[$x]->fname }} {{ $searchResultUser[$x]->lname}}</h4></a>
		              <!-- sasdasd -->
		            </div>
		          </div>
	          	</div>
	          </div>
	         <?php } ?>
	      @else
	      	<br>
	      	<p>No person named '{{$termSearched}}' found.</p>
	      @endif
	  </div>

	  <div id="band" class="tab-pane fade">
		  @if(count($searchResultBand) > 0)
	        <br>
	        <?php 
	        $i = 0;
	        $j = $i;
	        for ($i=0; $i < count($searchResultBand); $i++) {
	        ?>
	          <div class="panel panel-default">
	          	<div class="panel-body">
		          <div class="media" style="border-top: 0px; border-right: 0px;">
		            <div class="media-left">
		              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}"><img src="{{$searchResultBand[$i]->band_pic}}" class="media-object" style="width: 100%; min-width: 100px; height: 100px"></a>
		            </div>
		            <div class="media-body" style="padding-top: 10px">
		              <a href="{{ url('/'.$searchResultBand[$i]->band_name) }}"><h4 class="media-heading">{{$searchResultBand[$i]->band_name}}</h4></a>
		              @if(count($bandGenre) == 0)
			              @if($searchResultBand[$i]->num_followers == null)
				          0 Followers</p>
				          @else
				          <p>{{$searchResultBand[$i]->num_followers}} Followers</p>
				          @endif
			          @else			          
				          <p>{{ $bandGenre[$j]->genre_name }} | {{ $bandGenre[$j+1]->genre_name }} • 
				          @if($searchResultBand[$i]->num_followers == null)
				          0 Followers</p>
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
	  </div>

	  <div id="song" class="tab-pane fade">
    	  @if(count($searchResultSong) > 0)
            <br>
            @foreach($searchResultSong as $srSong)
              <div class="panel panel-default">
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
	  </div>

	  <div id="album" class="tab-pane fade">
	    @if(count($searchResultAlbum) > 0)
            <br>
            @foreach($searchResultAlbum as $srAlbum)
              <div class="panel panel-default">
              	<div class="panel-body">
              		<a href="#"><h5>{{$srAlbum->album_name}}</h5></a>
              	</div>
              </div>
            @endforeach
          @else
          	<br>
          	<p>No albums titled '{{$termSearched}}' found.</p>
          @endif
	  </div>

	  <div id="video" class="tab-pane fade">
	    @if(count($searchResultVideo) > 0)
            <br>
            @foreach($searchResultVideo as $srVideo)
	           <div class="panel panel-default">
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
	  </div>

	  <div id="article" class="tab-pane fade">
	    @if(count($searchResultArticle) > 0)
            <br>
            @foreach($searchResultArticle as $srArticle)
              <div class="panel panel-default">
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
	  </div>

	</div>

</div>


@endsection