@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')

@section('content')
<br><br><br>

@if($videos == null)
@else
@foreach($videos as $video)
              <div class="col-md-4">
              {{$video->video->video_desc}}
                <video style="background: #000; width: 100%;" class="embed-responsive-item" controls>
                    <source src="{{asset('assets/video/'.$video->video->video_content)}}">
                </video>                    
              </div>
@endforeach
@endif
@endsection