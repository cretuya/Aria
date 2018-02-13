@extends('layouts.master')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">

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

@section('content')

    @include('layouts.sidebar')

    <div class="container" id="main" style="background: #161616">
        <div class="row">
            <div class="col-md-12">
            <br><br>
                <span style="font-size: 18px; letter-spacing: .25px; font-family: Roboto; margin-left: 15px;">Here are some playlists by Aria</span>
                <br><br>

                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <div class="item active">
                 
                        @if(count($recplaylists) == null)
                        <h5 style="padding-left: 15px;">No playlists available yet</h5>
                        <br>
                        @else
                            <?php 
                            $count=0;
                            for($i=0; $i < count($recplaylists) ; $i++) {  

                            if($count == 4){
                                echo "</div>";
                                echo "<div class='item'>";
                                $count=0;
                            } 

                            ?>
                             <div class="col-xs-3">
                                <a href="{{url('discover/playlist/'.$recplaylists[$i]->genre_id)}}">
                                <div style="background: #222">
                                    <img src="{{url('assets/img/genre/'.$recplaylists[$i]->genre_name.'.jpeg')}}" class="img-responsive genre-thumbnail">
                                    <div class="carousel-caption" style="top: -5px; left: 30px;">
                                        <img src="{{ url('assets/img/arialogo.png')}}" class="img-responsive" style="width: 35px; padding: 7px 3px;border: 0.1em solid #F6843B; border-radius: 50%;"/>
                                    </div>
                                    <center>
                                    <div style="background: #e57c1f; padding-top: 5px;">
                                        <span style="font-size: 13px; font-family: Verdana; letter-spacing: 1.5px; color: #fafafa">{{$recplaylists[$i]->genre_name}} Playlist</span>
                                        <p style="font-size: 12px; font-family: Verdana; letter-spacing: 0.5px; color: #fafafa; margin-top: -2px; padding-bottom: 5px;">by: Aria</p>
                                    </div>
                                    </center>
                                </div>
                                
                                </a>
                            </div>
                            <?php $count++;} ?>
                        @endif

                    </div>
                  
                    
                  </div>

                  <div style="margin-left: 15px;">
                  <!-- Left and right controls -->
                      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <button class="fa fa-chevron-left"></button>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <button class="fa fa-chevron-right"></button>
                        <span class="sr-only">Next</span>
                      </a>
                  </div>

                </div>

                <br>
                <span style="font-size: 18px; letter-spacing: .25px; font-family: Roboto; margin-left: 15px;">Top Bands of the Week</span>
                <br><br>

                <div id="myCarousel1" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel1" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel1" data-slide-to="1"></li>
                    <li data-target="#myCarousel1" data-slide-to="2"></li>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <div class="item active">
                 
                        @if(count($topbandweek) == null)
                        <h5 style="padding-left: 15px;">No playlists available yet</h5>
                        <br>
                        @else
                            <?php 
                            $count=0;
                            $counter=1;
                            for($i=0; $i < count($topbandweek) ; $i++) {  

                            if($count == 6){
                                echo "</div>";
                                echo "<div class='item'>";
                                $count=0;
                            } 

                            ?>
                            
                            <div class="col-md-2" style="height: 210px; margin-top: 20px;">
                                <div class="panel-thumbnail hovereffect">
                                    <img class="img-responsive" src="{{$topbandweek[$i]->band_pic}}" alt="">
                                        <div class="overlay">
                                          <h2 style="font-size: 17px; text-transform: uppercase; margin-top: 10px;">{{$topbandweek[$i]->band_name}}</h2>
                                          <h6>{{$topbandweek[$i]->num_followers}} Followers</h6>
                                          <p>
                                            <a href="{{url('/'.$topbandweek[$i]->band_name)}}">Visit Page</a>
                                          </p>
                                        </div>
                                    <div style="position: absolute; bottom: 0px; right: 0px; background: #E57C1F; padding: 8px; opacity: 0.9;">#{{$counter}}</div>
                                </div>
                            </div>

                            <?php $count++; $counter++;} ?>
                        @endif

                    </div>
                  
                    
                  </div>

                  <div style="margin-left: 15px;">
                  <!-- Left and right controls -->
                      <a class="left carousel-control" href="#myCarousel1" data-slide="prev">
                        <button class="fa fa-chevron-left"></button>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel1" data-slide="next">
                        <button class="fa fa-chevron-right"></button>
                        <span class="sr-only">Next</span>
                      </a>
                  </div>

                </div>

                <br><br>

                <span style="font-size: 18px; letter-spacing: .25px; font-family: Roboto; margin-left: 15px;">Find out what suits you</span>
                <br><br>

                    @foreach($allGenres as $genre)
                    <div class="col-sm-3">
                        <a href="{{url('/discover/'.$genre->genre_name)}}">
                        <div style="background: #222;">
                            <img src="{{ url('assets/img/genre/'.$genre->genre_name.'.jpeg') }}" class="img-responsive genre-thumbnail ">
                            <div class="carousel-caption text-center">
                                <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 2.5px; font-family: Montserrat">{{$genre->genre_name}}</p>
                            </div>
                            <div>
                                <h1> </h1>
                            </div>
                        </div>
                        </a>
                    </div>
                    @endforeach
                    
            </div>
        </div>
    </div>

    <script>
        $('.carousel').carousel({
            interval: false
        }); 
    </script>
@endsection