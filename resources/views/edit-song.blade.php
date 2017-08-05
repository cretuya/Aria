@extends('layouts.master')

@section('title'){{$band->band_name}}@endsection

@section('content')
        Modal ni sha dapat:<br>
        Edit Song<br><br>
        <form method="post" action="{{url ('updateSong/'.$song->song_id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
        Edit Song Desc:<br>
        <input type="text" name="song_desc" value='{{$song->song_desc}}'><br><br>
        <select name="genre_id">
            <option value='1'>Reggae</option>
        </select>
        <br>
        <input type="submit">
        </form>
@endsection