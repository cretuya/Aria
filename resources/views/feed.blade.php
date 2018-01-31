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
                
          @if(count($articlesfeed)==0)
          <br><br><br>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Where did the articles go? </p>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">You might want to follow some bands. Head over to Explore!</p>
          @else
            @foreach($articlesfeed as $articles)
              <div class="panel" style="background: #232323;">
                <div class="panel-heading" style="border-bottom: 2px solid #E57C1F">
                  <a href="{{url('/'.$articles->band_name)}}"><img class="feed-band-pic img-circle" src="{{$articles->band_pic}}"></a>
                  <a href="{{url('/'.$articles->band_name)}}"><span class="feed-band-name">{{$articles->band_name}}</span></a>
                  <?php $datetime = strtotime($articles->created_at);
                    $dateformat = date("M d Y g:i a",$datetime);
                  ?>
                  <span class="feed-timestamp-time pull-right"><?php echo "$dateformat";?></span>
                  <!-- <span class="feed-timestamp-date pull-right">Oct 30</span> -->
                </div>
                <div class="panel-body feed-content">
                <p style="margin-top: 0px; font-size: 16px;">{{$articles->art_title}}</p>
                <p style="padding-top: 5px; font-size: 12px">{{$articles->content}}</p>
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
            @if($recommend == null)
            <br>
            <p style="text-align:center; color: #a4a4a4; font-size: 16px;">No bands to show</p>
            <br>
            @else($recommend != null)
              @foreach($recommend as $rec)
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


    </div>
  </div>
</div>

@stop