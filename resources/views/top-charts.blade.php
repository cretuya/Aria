@extends('layouts.master')

@section('content')

<style type="text/css">

@media (min-width: 1920px) {
  .portraits{
    width: 16.66666667%;
  }
}
  .hovereffect {
    width: 100%;
    height: 100%;
    float: left;
    overflow: hidden;
    position: relative;
    text-align: center;
    cursor: default;
    background: #000;
  }

  .hovereffect .overlay {
    width: 100%;
    height: 100%;
    position: absolute;
    overflow: hidden;
    top: 0;
    left: 0;
    padding: 50px 20px;
  }

  .hovereffect img {
    display: block;
    position: relative;
    max-width: none;
    width: calc(100% + 20px);
    height: 100%;
    -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
    transition: opacity 0.35s, transform 0.35s;
    -webkit-transform: translate3d(-10px,0,0);
    transform: translate3d(-10px,0,0);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    opacity: 0.8;
  }

  .hovereffect:hover img {
    opacity: 0.4;
    filter: alpha(opacity=40);
    -webkit-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
  }

  .hovereffect h6 {
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
    padding-bottom: 10px;
    background-color: transparent;
  }

  .hovereffect h6:after {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: #fff;
    content: '';
    -webkit-transition: -webkit-transform 0.35s;
    transition: transform 0.35s;
    -webkit-transform: translate3d(-100%,0,0);
    transform: translate3d(-100%,0,0);
  }

  .hovereffect:hover h6:after {
    -webkit-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
  }

  .hovereffect a, .hovereffect p {
    color: #fafafa;
    opacity: 0;
    filter: alpha(opacity=0);
    -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
    transition: opacity 0.35s, transform 0.35s;
    -webkit-transform: translate3d(100%,0,0);
    transform: translate3d(100%,0,0);
  }

  .hovereffect a:hover, .hovereffect p:hover {
    color: #E57C1F;
  }

  .hovereffect:hover a, .hovereffect:hover p {
    opacity: 1;
    filter: alpha(opacity=100);
    -webkit-transform: translate3d(0,0,0);
    transform: translate3d(0,0,0);
  }
</style>

@include('layouts.sidebar')

<br><br>

<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">
  <div class="row">
    <div class="col-md-12">
    
    <h3 style="text-align: center; text-transform: uppercase; letter-spacing: 3px;">Top 50 Bands</h3>
    <hr style="width: 10%">

    <?php 
      $counter = 1;
    ?>

    @foreach($bands as $band)
      <div class="col-md-2" style="height: 210px; margin-top: 20px;">
          <div class="panel-thumbnail hovereffect">
              <img class="img-responsive" src="{{$band->band_pic}}" alt="">
                  <div class="overlay">
                    <h2 style="font-size: 17px; text-transform: uppercase; margin-top: 10px;">{{$band->band_name}}</h2>
                    <h6>{{$band->num_followers}} Followers</h6>
                    <p>
                      <a href="{{url('/'.$band->band_name)}}">Visit Page</a>
                    </p>
                  </div>
              <div style="position: absolute; bottom: 0px; right: 0px; background: #E57C1F; padding: 8px; opacity: 0.9;">#{{$counter}}</div>
          </div>
      </div>
    <?php $counter++; ?>
    @endforeach

    </div>
  </div>
</div>
@stop


