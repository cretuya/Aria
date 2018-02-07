@extends('layouts.master')

@section('content')

@include('layouts.sidebar')

<br><br>
<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">
  <div class="row">
    <div class="col-md-12">
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="col-md-9" id="feed-section">
                
          @if(count($events)==0)
          <br><br><br>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Not seeing updates from bands? </p>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Head over to Home and check them out!</p>
          @else
          <br><br><br>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Upcoming GIGS of you favorite Bands! </p>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Head over to Home and check them out!</p>
            @foreach($events as $event)
              <div class="panel" style="background: #232323;">
                <div class="panel-heading" style="border-bottom: 2px solid #E57C1F">
                  <a href="{{url('/'.$event->band->band_name)}}"><img class="feed-band-pic img-circle" src="{{$event->band->band_pic}}"></a>
                  <a href="{{url('/'.$event->band->band_name)}}"><span class="feed-band-name">{{$event->band->band_name}} //tarongon ni ang nawng ani</span></a>
                </div>
              </div>
            @endforeach
          @endif      

        </div>

        <div class="col-md-3" style="padding-left: 0; padding-right: 0;">
        
        <center><h4>Bands you may want to follow</h4></center>
        <br>

        <div class="panel" style="background: transparent;">
          <div class="panel-body" style="padding-left: 15px; padding-right: 15px;">

          <div class="row">
          <ul class="list-group" style="margin-bottom: 0px;">
            @if($recommendBands == null)
            <br>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">No bands to show</p>
            <br>
            @else($recommendBands != null)
              @foreach($recommendBands as $rec)
                <li class="list-group-item" style="border: 0;background: transparent;">
                  <a href="#"><img class="friends-in-aria-pic img-circle" src="{{$rec['band']->band_pic}}"></a>
                  <a href="{{url($rec['band']->band_name)}}"><span class="feed-band-name">{{$rec['band']->band_name}}</span></a>
                </li>
              @endforeach
            @endif
          </ul>
          </div>

          </div>
        </div>
        </div>


        <div class="col-md-9" id="feed-section">
                
          @if(count($recommendGigs)==0)
          <br><br><br>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Not seeing updates from bands? </p>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Here are some recommendation you want to see!</p>
          @else
          <br><br><br>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Some Upcoming GIGS of your favorite Friends' Bands! </p>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Head over to Home and check them out!</p>
            @foreach($recommendGigs as $recommendGig)
              <div class="panel" style="background: #232323;">
                <div class="panel-heading" style="border-bottom: 2px solid #E57C1F">
                  <a href="{{url('/'.$recommendGig->band->band_name)}}"><img class="feed-band-pic img-circle" src="{{$recommendGig->band->band_pic}}"></a>
                  <a href="{{url('/'.$recommendGig->band->band_name)}}"><span class="feed-band-name">{{$recommendGig->band->band_name}} //tarongon ni ang nawng ani</span></a>
                </div>
              </div>
            @endforeach
          @endif      

        </div>


    </div>
  </div>
</div>

@stop