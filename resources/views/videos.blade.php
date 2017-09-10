@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')

@include('layouts.band-materials-navigation')

@section('content')
<br><br>
<center><h3>Videos</h3></center>
<br><br><br>
<div class="container" style="padding: 0;">


	<div class="row">

@if($videos == null)
@else
@foreach($videos as $video)
            <div class="col-md-3 col-sm-4 col-xs-6">

            <div class="panel panel-default" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
            	<div class="panel-body">
	                <video style="background: #000; width: 100%; margin-top: 15px;" class="embed-responsive-item" controls>
	                    <source src="{{asset('assets/video/'.$video->video->video_content)}}">
	                </video>

	            	<h5 style="margin-top: 12px;">Video Title Here</h5>

	            	<div class="row">
		            	<div class="col-sm-6">
		            		<p class="pull-left">24k Views</p>
		            	</div>
		            	<div class="col-sm-6">
		            		<p class="pull-right">Sept 9, 2017</p>
		            	</div>
	            	</div>
            	</div>
            </div>
	                

            </div>
@endforeach
@endif
	</div>
</div>


@endsection