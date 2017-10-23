@extends('layouts.master')

<style>
.charts-nav{
  width: 85px;
}

.charts-nav li a{
  border-radius: 0px !important;
  padding-top: 18px !important;
}

.charts-nav li a:hover{
  color: #212121 !important;
}

.charts-nav li.active>a:hover>h5{
  color: #fafafa !important;
}

.charts-nav span{
  font-size: 28px;
  padding-left: 10px;
  padding-right: 10px;
}

.charts-nav>li.active>a{
  background: #424242 !important;
}

.charts-nav>li.active>a span{
  background: none !important;
  color: #F9A825 !important;
}

.breadcrumb{
  background: none !important;
}

.breadcrumb li{
  color: #212121;
}

.breadcrumb li>a:hover{
  color: #F9A825;

  -webkit-transition-property:color, text;
  -webkit-transition-duration: 0.15s, 0.15s;
  -webkit-transition-timing-function: linear, ease-in;

  -moz-transition-property:color, text;
  -moz-transition-duration:0.15s;
  -moz-transition-timing-function: linear, ease-in;

  -o-transition-property:color, text;
  -o-transition-duration:0.15s;
  -o-transition-timing-function: linear, ease-in;
}

.charts-media-left-rank{
  padding-top: 28px;
  padding-bottom: 0px;
  padding-left: 32px !important;
  padding-right: 32px !important;
  background: #F9A825;
  color: #fafafa;
}

.charts-media-left-rank-2{
  padding-top: 23px;
  padding-bottom: 0px;
  padding-left: 32px !important;
  padding-right: 32px !important;
  background: #F9A825;
  color: #fafafa;
}

.charts-media-left-rank-3{
  padding-top: 50px;
  padding-bottom: 0px;
  padding-left: 32px !important;
  padding-right: 32px !important;
  background: #F9A825;
  color: #fafafa;
}

</style>

@section('content')

@include('layouts.navbar')

<br><br><br><br>

  <div class="container">

    <h1>Top Charts</h1>

    <br><br>
    
    <div class="col-md-2">

      <ul class="nav nav-pills nav-stacked charts-nav" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
        <li class="active"><a data-toggle="tab" href="#bands-tab" class="text-center" title="Top Ranking Bands"><span  class="fa fa-star"></span><h5>Bands</h5></a></li>
        <li><a data-toggle="tab" href="#tracks-tab" class="text-center" title="Most Played Songs"><span class="fa fa-headphones"></span><h5>Tracks</h5></a></li>
        <li><a data-toggle="tab" href="#videos-tab" class="text-center" title="Most Viewed Videos"><span class="fa fa-play-circle-o"></span><h5>Videos</h5></a></li>
      </ul>

    </div>

    <div class="col-md-10">

      <div class="tab-content">

        <div id="bands-tab" class="tab-pane fade in active">
          <ol class="breadcrumb">
            <li class="active">All Time</li>
            <li><a href="#">By Week</a></li>
            <li><a href="#">By Month</a></li>
          </ol>
            <div class="media" style="border-bottom: 1px solid #e4e4e4; box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
              <div class="media-left charts-media-left-rank">
                <h4>1</h4>
              </div>
              <div class="media-left">
                <a href="#"><img src="" class="media-object" style="width:92px"></a>
              </div>
              <div class="media-body" style="padding-top: 8px; padding-left: 5px;">
                <a href="#"><h4 class="media-heading">Paramore</h4></a>
                <p>Pop | Punk</p>
                <p>5 Followers</p>
                
              </div>
            </div>

    
        </div>

        <div id="tracks-tab" class="tab-pane fade">
          <ol class="breadcrumb">
            <li class="active">All Time</li>
            <li><a href="#">By Week</a></li>
            <li><a href="#">By Month</a></li>
          </ol>

          <div class="media" style="border-bottom: 1px solid #e4e4e4; box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
            <div class="media-left charts-media-left-rank-2">
              <h4>1</h4>
            </div>
            <div class="media-body" style="padding-top: 12px; padding-bottom: 10px; padding-left: 5px;">
              <p>Adele - Make You Feel My Love (Karaoke Version)</p>
              <audio controls>
                <source src="{{url('assets/music/Adele - Make You Feel My Love (Karaoke Version).mp3')}}" type="audio/mpeg">
              </audio>
            </div>
          </div>

          <div class="media" style="border-bottom: 1px solid #e4e4e4; box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
            <div class="media-left charts-media-left-rank-2">
              <h4>2</h4>
            </div>
            <div class="media-body" style="padding-top: 12px; padding-bottom: 10px; padding-left: 5px;">
              <p>Adele - Make You Feel My Love (Clean Version)</p>
              <audio controls>
                <source src="{{url('assets/music/Adele - Make You Feel My Love (Karaoke Version).mp3')}}" type="audio/mpeg">
              </audio>
            </div>
          </div>

          

        </div>

        <div id="videos-tab" class="tab-pane fade">

          <ol class="breadcrumb">
            <li class="active">All Time</li>
            <li><a href="#">By Week</a></li>
            <li><a href="#">By Month</a></li>
          </ol>

            <div class="media" style="border-bottom: 1px solid #e4e4e4; box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
              <div class="media-left charts-media-left-rank-3">
                <h4>1</h4>
              </div>
              <div class="media-left">
                <video style="width: 250px" class="embed-responsive-item" controls>
                  <source src="{{url('assets/video/12023583_1219430358083506_65886198_n.mp4')}}">
                </video>
              </div>
              <div class="media-body" style="padding-top: 12px; padding-left: 5px;">
                <h4 class="media-heading">Especially For You</h4>
                <a href="#"><p>Our Last Night</p></a>
                <p>3,638 Views</p>
              </div>
            </div>

            <div class="media" style="border-bottom: 1px solid #e4e4e4; box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
              <div class="media-left charts-media-left-rank-3">
                <h4>2</h4>
              </div>
              <div class="media-left">
                <video style="width: 250px" class="embed-responsive-item" controls>
                  <source src="{{url('assets/video/12023583_1219430358083506_65886198_n.mp4')}}">
                </video>
              </div>
              <div class="media-body" style="padding-top: 12px; padding-left: 5px;">
                <h4 class="media-heading">Especially For You Version 2</h4>
                <a href="#"><p>Our Last Night</p></a>
                <p>2,426 Views</p>
              </div>
            </div>

        </div>

      </div>

    </div>
    

  </div>

@stop


