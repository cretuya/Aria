@extends('layouts.master')


@section('content')
    <div>
        <form method='post' action="{{'../updateAlbum/'.$album->album_id}}">
            {{csrf_field()}}
            Edit Album Title:<br>
            <input type='text' name='album_name' value='{{$album->album_name}}'><br>
            Edit Description:<br>
            <input type='text' name='album_desc' value='{{$album->album_desc}}'><br>
            <input type="text" value='{{$album->band_id}}' name="band_id" hidden>
            <br>
            <input type="submit">
        </form>
    </div>
@endsection