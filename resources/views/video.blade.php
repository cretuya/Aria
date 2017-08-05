@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection


@section('content')
<div id="viewVideos">
        Modal ni sha dapat:<br>
        Add Video<br><br>
        <form method="post" action="{{'./addVideo'}}" enctype="multipart/form-data">
        {{csrf_field()}}
            Video Description:<br>
            <input type='text' name='video_desc'><br><br>            
            Add Video:<br>
            <input type='file' name='video_content[]' accept="video/*" multiple><br><br>
            <input type='submit'>
        </form>
</div>
<div id="showVideos">
	@if($videos == null)
	@else
		@foreach($videos as $video)
		    {{$video->video->video_id}}  {{$video->video->video_desc}}<br><br>
            <video width="300" height="300" controls>
                <source src="{{asset('assets/video/'.$video->video->video_content)}}">
            </video>
            <br>

            <button type="button" class="delete" value="{{$video->video->video_id}}">Delete</button>
            <button type="button" class="edit" value="{{'../'.$band->band_name.'/editVideo/'.$video->video->video_id}}">Edit</button>
            <br><br>
		@endforeach
	@endif
</div>
<script type="text/javascript">
$(document).ready(function()
{
     $("#showVideos").on('click', '.edit' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to edit this video?'))
        {
            window.location = val;
        }
     });
     $("#showVideos").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this video?'))
        {
            window.location = './deleteVideo/'+val;
        }
     });
 });
</script>
@endsection