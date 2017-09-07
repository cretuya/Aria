@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<br><br><br><br>
<input type="text" value="{{$band->band_name}}" id="bandName" hidden>
@if($albums == null)
@else
	@foreach($albums as $album)
	<div class='albums'>
	<button type="button" class="showSongs" data-id='{{$album->album_id}}'>{{$album->album_name}}</button>
	</div>
	@endforeach
@endif
<div class="songs">
<h4>Title of Album</h4>
<br>
	<div class="list">
		
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