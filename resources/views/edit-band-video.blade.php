@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection


@section('content')
<div id="editVideos">
        Modal ni sha dapat:<br>
        Edit Video:<br><br>
        <form method="post" action="{{'../updateVideo/'.$video->video_id}}" enctype="multipart/form-data">
        {{csrf_field()}}
            Edit Video Description:<br>
            <input type='text' name='video_desc' value="{{$video->video_desc}}"><br><br>            
            <input type='submit'>
        </form>
</div>
@endsection