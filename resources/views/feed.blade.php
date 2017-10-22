@extends('layouts.master')

@section('content')

@include('layouts.navbar')

<br><br><br><br>
  <div class="container">
    

    <div class="col-md-8" id="feed-section">
            
      @if(count($articlesfeed)==0)
      <br><br><br>
        <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Where did the articles go? </p>
        <p style="text-align:center; color: #a4a4a4; font-size: 16px;">You might want to follow some bands. Head over to Explore!</p>
      @else
        @foreach($articlesfeed as $articles)
          <div class="panel panel-default">
            <div class="panel-heading pnlhead-feed">
              <a href="{{url('/'.$articles->band_name)}}"><img class="feed-band-pic img-circle" src="{{$articles->band_pic}}"></a>
              <a href="{{url('/'.$articles->band_name)}}"><span class="feed-band-name">{{$articles->band_name}}</span></a>
              <?php $datetime = strtotime($articles->created_at);
                $dateformat = date("M d Y g:i a",$datetime);
              ?>
              <span class="feed-timestamp-time pull-right"><?php echo "$dateformat";?></span>
              <!-- <span class="feed-timestamp-date pull-right">Oct 30</span> -->
            </div>
            <div class="panel-body feed-content">
            <h3>{{$articles->art_title}}</h3>
            <p style="padding-top: 5px;">{{$articles->content}}</p>
            </div>
          </div>
        @endforeach
      @endif      

    </div>

    <div class="col-md-4">
        
    <center><h4>Friends who joined Aria</h4></center>
    <br>

    <div class="panel panel-default">
      <div class="panel-body" style="padding-left: 35px; padding-right: 35px;">

      <div class="row">
      <ul class="list-group" style="margin-bottom: 0px;">
        @if($friends == null)
        <br>
        <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Invite your facebook friends</p>
        <p style="text-align:center; color: #a4a4a4; font-size: 16px;">to join Aria!</p>
        <br>
        @else
          @foreach($friends as $friend)
            <li class="list-group-item" style="border: 0">
              <a href="#"><img class="friends-in-aria-pic img-circle" src="{{$friend->profile_pic}}"></a>
              <a href="{{url('feed/'.$friend->user_id)}}"><span class="feed-band-name">{{$friend->fullname}}</span></a>
            </li>
          @endforeach
        @endif
      </ul>
      </div>

      </div>
    </div>

    <center><h4>Bands you may want to follow</h4></center>
    <br>

    <div class="panel panel-default">
      <div class="panel-body" style="padding-left: 35px; padding-right: 35px;">

      <div class="row">
      <ul class="list-group" style="margin-bottom: 0px;">
        @if($recommend == null)
        <br>
        <p style="text-align:center; color: #a4a4a4; font-size: 16px;">No bands to show</p>
        <br>
        @else
          @foreach($recommend as $rec)
            <li class="list-group-item" style="border: 0">
              <a href="#"><img class="friends-in-aria-pic img-circle" src="{{$rec->band_pic}}"></a>
              <a href="{{url($rec->band_name)}}"><span class="feed-band-name">{{$rec->band_name}}</span></a>
            </li>
          @endforeach
        @endif
      </ul>
      </div>

      </div>
    </div>
    </div>



  </div>

@stop