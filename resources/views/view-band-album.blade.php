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
      <div class='albums'>

      <a href="#" class="showSongs" data-id='{{$album->album_id}}' style="text-decoration: none;">
        <div class="panel panel-default" style="margin-top: -20px;">
          <div class="panel-body">
            {{$album->album_name}}
          </div>
        </div>
      </a>

      
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
	<div class="list">
		
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

               $('.list').append('<label>'+value.song_audio+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio>'); 

              });
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });			
	}
});
</script>
@endsection