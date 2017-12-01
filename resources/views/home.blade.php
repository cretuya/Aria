@extends('layouts.master')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/discover.css').'?'.rand()}}">

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
                        <h5>No playlists available yet</h5>
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