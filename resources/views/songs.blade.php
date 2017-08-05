@extends('layouts.master')

@section('title'){{$band->band_name}}@endsection

@section('content')
<div id="viewSongs">
	@if($songs == null)
	@else
		@foreach($songs as $song)
		{{$song->song->song_audio}}<br><br>
		<audio controls>
        <source  src="{{ asset('assets/music/'.$song->song->song_audio)}}" type="audio/mpeg">
        </audio><br>
        <button type="button" class="delete" value="{{$song->song->song_id}}">Delete</button>
        <button type="button" class="edit" value="{{url ('/editSong/'.$song->song->song_id)}}">Edit</button>
       	<br><br>
		@endforeach
	@endif
</div>
<script type="text/javascript">
$(document).ready(function()
{
    $("#viewSongs").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this song?'))
        {
            window.location.href = "./deleteSong/"+val;
        }
     });
    $("#viewSongs").on('click', '.edit' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to edit this song?'))
        {
            window.location = val;
        }
     });
});
</script>
@endsection