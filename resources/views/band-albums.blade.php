@extends('layouts.master')

@section('title'){{$band->band_name}}@endsection

@section('content')
<div>
	    <form method='post' action='{{url ('albums/addAlbum')}}'>
            {{csrf_field()}}
            Album Title:<br>
            <input type='text' name='album_name'><br>
            Description:<br>
            <input type='text' name='album_desc'><br>
            <br>
            <input type="text" value='{{$band->band_id}}' name="band_id" hidden>
            <input type="submit">
        </form>
        <hr>
        <div id="viewAlbums">
        Album Titles:<br>
        @if ($albums == null)
        @else
            @foreach ($albums as $album)
            {{$album->album_name}}
            <button type="button" class="add" value="{{$album->album_id}}">Add Song</button>
            <button type="button" class="delete" value="{{$album->album_id}}">Delete</button>
            <button type="button" class="edit" value="{{'editAlbum/'.$album->album_id}}">Edit</button>
            <br><br>
            @endforeach

        @endif
        </div>
        <hr>
        @if ($albums == null)
        @else
            @foreach($albums as $album)
        Modal ni sha dapat:<br>
        Add Song<br><br>
        <form method="post" action="{{'../'.$album->album_id.'/addSongs'}}" enctype="multipart/form-data">
        {{csrf_field()}}
        Song Title:<br>
        <input type="text" name="song_desc"><br>
        <input type="file" name="song_audio[]" accept="audio/*" multiple><br>
        <select name="genre_id">
            <option value='1'>Reggae</option>
        </select>
        <br>
        <input type="submit">
        </form>
        @endforeach
        @endif

</div>
<script type="text/javascript">
$(document).ready(function()
{
    $("#viewAlbums").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this album?'))
        {
            window.location.href = "./deleteAlbum/"+val;
        }
     });
    $("#viewAlbums").on('click', '.edit' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to edit this album?'))
        {
            window.location = val;
        }
     });
    $("#viewAlbums").on('click', '.add' ,function(){
        var val = $(this).val();
        if(confirm('Do you want to add song in this album?'))
        {
          window.location.href = "../"+val+"/addSongs";
        }
     });
});
</script>
@endsection