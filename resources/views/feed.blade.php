
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
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Not seeing events from bands? </p>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Head over to home and start following some!</p>
          @else
            @foreach($events as $event)

            <?php

            $date1=$event->event_date;
            $date = DateTime::createFromFormat("Y-m-d", $event->event_date);
            $event->event_date = $date->format("M d, Y");

            $time = $event->event_time; 
            $event->event_time = date('h:i A', strtotime($time));

            ?>
              <div class="panel" style="background: #232323;">
                <div class="panel-heading" style="border-bottom: 2px solid #E57C1F">
                  <a href="{{url('/'.$event->band->band_name)}}"><img class="feed-band-pic img-circle" src="{{$event->band->band_pic}}" style="object-fit: cover;"></a>
                  <a href="{{url('/'.$event->band->band_name)}}"><span class="feed-band-name">{{$event->band->band_name}}</span></a>
                </div>
                <div class="panel-body">
                  <h5 style="margin-top: 0px;">{{$event->event_name}}</h5>
                  <span style="font-size: 12px;">{{$event->event_date}} {{$event->event_time}}</span> at
                  <span style="font-size: 12px;">{{$event->event_venue}}</span>, <span style="font-size: 12px;">{{$event->event_location}}</span>
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
                  <a href="{{url($rec['band']->band_name)}}"><img class="friends-in-aria-pic img-circle" src="{{$rec['band']->band_pic}}" style="object-fit: cover;"></a>
                  <a href="{{url($rec['band']->band_name)}}"><span class="feed-band-name">{{$rec['band']->band_name}}</span></a>
                </li>
              @endforeach
            @endif
          </ul>
          </div>

          <br>

          <center><h4>Album you may want to like</h4></center>
          <br>

          <div class="panel" style="background: transparent;">
            <div class="panel-body" style="padding-left: 15px; padding-right: 15px;">

            <div class="row">
            <ul class="list-group" style="margin-bottom: 0px;">
              @if($recommendAlbums == null)
              <br>
              <p style="text-align:center; color: #a4a4a4; font-size: 16px;">No albums to show</p>
              <br>
              @else($recommendAlbums != null)
                @foreach($recommendAlbums as $rec)
                  <li class="list-group-item" style="border: 0;background: transparent;">
                    <a href="#"><img class="friends-in-aria-pic img-circle" src="{{$rec->album_pic}}" style="object-fit: cover;"></a>
                    <a href="{{url($rec->band->band_name.'/albums/'.$rec->album_id)}}"><span class="feed-band-name">{{$rec->album_name}}</span></a>
                  </li>
                @endforeach
              @endif
            </ul>
            </div>

            </div>
          </div>

          </div>
        </div>
        </div>

    </div>
  </div>
</div>

@stop