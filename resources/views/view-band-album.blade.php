@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')
@include('layouts.band-materials-navigation')
@section('content')
<div class="container">

<br><br>
<center><h3>Albums</h3></center>
<meta name ="csrf-token" content = "{{csrf_token() }}"/>

<br><br><br><br>


<input type="text" value="{{$band->band_name}}" id="bandName" hidden>


    @if($albums == null)
    @else
      @foreach($albums as $album)
      <div class="row">
        <div class="col-md-9">
          <div class='albums'>
          <a href="#" class="showSongs" data-id='{{$album->album_id}}' style="text-decoration: none;">
            <div class="panel panel-default" style="margin-top: -20px;">
              <div class="panel-body">
              <img class="friends-in-aria-pic img-circle" src="{{$album->album_pic}}">
              {{$album->album_name}}
              </div>
            </div>
          </a>
        </div>
        </div>
        <div class="col-md-2 likeAlbum">
        @if (in_array($album->album_id, $likers))
        <button type="button" class="likeButton liked" data-id='{{$album->album_id}}'>Unlike</button>
        @else
        <button type="button" class="likeButton" data-id='{{$album->album_id}}'>Like</button>
        @endif
        </div>
      </div>
      @endforeach
    @endif
  

<!--   {{-- @if($albums == null)
    @else
      @foreach($albums as $album)
      <div class='albums'>

      <a href="#" data-toggle="collapse" data-target="#{{$album->album_id}}" style="text-decoration: none;">
        <div class="panel panel-default" style="margin-top: -20px;">
          <div class="panel-body">
            {{$album->album_name}}
          </div>
        </div>
      </a>

      @foreach($songs as $song)
      <div id="{{$album->album_id}}" class="collapse">
        <label>{{$song->song_audio}}</label>
        <audio controls>
          <source src="{{url('/assets/music/')}} {{$song->song_audio}}" type="audio/mpeg">
        </audio>
      </div>
      @endforeach

      
      </div>
      @endforeach
    @endif --}} -->


<div class="songs">
<br>
	<div class="list" align="center">
		
	</div>
</div>

</div>


<script type="text/javascript">
$(document).ready(function(){
	$('.albums').on('click', '.showSongs', function()
	{
		var id = $(this).data('id');
		getSongs(id);
	});
	function getSongs(id)
	{
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : "../"+bname+"/viewSongs",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            $('.songs h4').text(json.album.album_name);
            $('.list').empty();
              $.each(json.songs, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

               $('.list').append('<label>'+value.song_title+'</label><br><audio onplay="playSong('+value.song_id+')" class="audio" controls><source src="'+audio+'" type="audio/mpeg"></audio><br><br>'); 

              });
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });			
	}

  $('button.likeButton').on('click', function(e)
  {
      e.preventDefault();
      $button = $(this);
      if($button.hasClass('liked')){
          
          // $.ajax(); Do Unlike
          var id = $(this).data('id');
          alert('unlike');
          unlikeAlbum(id); 
          
      } else {
          
          // $.ajax(); Do Like
          var id = $(this).data('id');
          alert('like');
          likeAlbum(id);   
      }
  });

  function likeAlbum(id)
  {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : "../likeAlbum",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
            $button.addClass('liked');
            $button.text('Unlike');
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });         
  }
  function unlikeAlbum(id)
  {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : "../unlikeAlbum",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
            $button.removeClass('liked');
            $button.text('Like');
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });         
  }
});

function playSong(id)
{
  songid = id;
  var audio = document.getElementsByClassName('audio');
  setTimeout(function() { addSongPlayed(songid)}, 5000);
}
function addSongPlayed(id)
{
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          method : "post",
          url : "../addSongPlayed",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });   
}
</script>
@endsection