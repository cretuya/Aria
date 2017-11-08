@extends('layouts.master')
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/playlistPlayer.css').'?'.rand()}}">


@section('title')
@endsection

@include('layouts.navbar')

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>

<br><br><br><br><br>

<div class="container">
  <div class="col-md-3">
    <img src="{{url('assets/img/genre/'.$genre->genre_name.'.jpeg')}}" class="img-responsive">
    <div class="carousel-caption" style="top: -5px; left: 30px;"><img src="{{ url('assets/img/arialogo.png')}}" class="img-responsive" style="width: 35px; padding: 7px 3px;border: 0.1em solid #F6843B; border-radius: 50%;"></div>
    <h3 class="text-center">{{$genre->genre_name}}</h3>
    <p class="text-center">by: Aria</p>
    <img src="{{url('/assets/img/play.png')}})">
  </div>
  <div class="col-md-9">
    @if(count($songs) == null)
    
    <div class="nlist">
      <audio src="{{url('/assets/music/')}}" controls id="audioPlayer" type="audio/mpeg" hidden></audio>
      <div class="list">      

      <div class="buttons">
        <span id="playButton" class="btn" onclick="playOrPause();" style="margin-left: 5px;"><img id="playPauseImg" src="{{url('/assets/img/play.png')}}" class="img-responsive"></span>
        <span id="muteButton" class="btn" onclick="muteOrUnmute();" style="margin-left: -8px;"><img id="muteUnmuteImg" src="{{url('/assets/img/unmute.png')}}" class="img-responsive"></span>
        <span id="currentTime" style="color: #fafafa; vertical-align: text-top;">0:00</span><span style="color: #fafafa; vertical-align: text-top;">  / </span><span id="fullDuration" style="color: #fafafa; vertical-align: text-top;">0:00</span>
      </div>

      <div class="progress" id="progress_bar" style="margin-bottom: 0px; height: 4px;">
        <!-- <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%"> -->
        <div class="progress-bar" id="moving_progressbar" role="progressbar" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>

        <ul id="playlist" class="songsInPlaylist">
          <li id="noSongsMessage"><center><h5 style="color: #fafafa">There are no songs in this playlist yet.</h5></center></li>
        </ul>
    </div>
    
    @else
    <div class="list">
      <audio src="{{url('/assets/music/')}}" controls id="audioPlayer" type="audio/mpeg" hidden></audio>
    <div class="buttons">
      <span id="playButton" class="btn" onclick="playOrPause();" style="margin-left: 5px;"><img id="playPauseImg" src="{{url('/assets/img/play.png')}}" class="img-responsive"></span>
      <span id="muteButton" class="btn" onclick="muteOrUnmute();" style="margin-left: -8px;"><img id="muteUnmuteImg" src="{{url('/assets/img/unmute.png')}}" class="img-responsive"></span>
      <span id="currentTime" style="color: #fafafa; vertical-align: text-top;">0:00</span><span style="color: #fafafa; vertical-align: text-top;">  / </span><span id="fullDuration" style="color: #fafafa; vertical-align: text-top;">0:00</span>
      <span class="pull-right" style="color: #fafafa; margin-top: 8px; margin-right: 25px;"><span id="song-name"> </span></span>
    </div>

    <div class="progress" id="progress_bar" style="margin-bottom: 0px; height: 4px;">
      <!-- <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%"> -->
      <div class="progress-bar" id="moving_progressbar" role="progressbar" aria-valuemin="0" aria-valuemax="100">
      </div>
    </div>

      <ul id="playlist" class="songsInPlaylist">
      <?php

      for($i=0; $i < count($songs); $i++){

          $removedmp3[$i] = str_replace('.mp3', '', $songs[$i]->song_audio);

            if($i == 0){
              echo '<li class="current-song"><a href="http://localhost/Aria/public/assets/music/'.$songs[$i]->song_audio.'" onclick="playOrPauseFromSongClick();">'.$removedmp3[$i].'</a><span data-id="'.$songs[$i]->song_id.'" class="remlist btn fa fa-remove pull-right" style="margin-top: -7px;font-size: 18px; color: #555555" title="Remove from playlist"></span></li>';
            }
            else{
              echo '<li><a href="http://localhost/Aria/public/assets/music/'.$songs[$i]->song_audio.'" onclick="playOrPauseFromSongClick();">'.$removedmp3[$i].'</a><span data-id="'.$songs[$i]->song_id.'" class="remlist btn fa fa-remove pull-right" style="margin-top: -7px;font-size: 18px; color: #555555" title="Remove from playlist"></span></li>';
            }
      }

      ?>

      </ul>
    </div>

    @endif
  </div>
</div>

<script type="text/javascript">

$( document ).ready(function(){
  setTimeout(function(){

    var currentTrack = $('#audioPlayer')[0];
    var fullDuration = $('#fullDuration');

    // console.log(currentTrack.duration);
    var minutes = Math.trunc(parseInt(currentTrack.duration)/60);
    var seconds = parseInt(currentTrack.duration)%60;
    
    if(isNaN(minutes) && isNaN(seconds)){
      fullDuration.html("0:00");
    }else{
      fullDuration.html(minutes+':'+seconds);
    }

  },100);
    
});

  function audioPlayer(){
    var currentSong = 0;
    $("#audioPlayer")[0].src = $("#playlist li a")[0];
    // console.log($("#audioPlayer")[0]);
    // $("#audioPlayer")[0].play();
    $("#playlist li a").click(function(e){
       e.preventDefault(); 
       $("#audioPlayer")[0].src = this;
       $("#audioPlayer")[0].play();
       $("#playlist li").removeClass("current-song");
        currentSong = $(this).parent().index();
        $(this).parent().addClass("current-song");
    });
    
    $("#audioPlayer")[0].addEventListener("ended", function(){
      setTimeout(function(){
       currentSong++;
        if(currentSong == $("#playlist li a").length)
            currentSong = 0;
        $("#playlist li").removeClass("current-song");
        $("#playlist li:eq("+currentSong+")").addClass("current-song");
        $("#audioPlayer")[0].src = $("#playlist li a")[currentSong].href;
        $('#playPauseImg').attr("src","{{url('/assets/img/play.png')}}");
        $("#audioPlayer")[0].play();

        setTimeout(function(){

          var currentTrack = $('#audioPlayer')[0];
          var fullDuration = $('#fullDuration');
          var minutes = Math.trunc(parseInt(currentTrack.duration)/60);
          var seconds = parseInt(currentTrack.duration)%60;
          
          fullDuration.html(minutes+':'+seconds);          

          $('#playPauseImg').attr("src","{{url('/assets/img/pause.png')}}");
        },500);

          var url = $('#audioPlayer')[0].src;
          var url2 = "{{url('/assets/music/')}}";        
          var songnamedilipa = url.replace(url2+'/',"");
          // var songnamme = songnamedilipa.replace("%20/g"," ");
          var songnamedilipajud = songnamedilipa.replace('.mp3','');
          var songname = decodeURI(songnamedilipajud);

          $('#song-name').html("Now playing: "+songname); 

        },500);

        updateTime = setInterval(update, 200);

    });
}

  function playOrPause() {

    if (!$("#audioPlayer")[0].paused && !$("#audioPlayer")[0].ended) {
      $('#playPauseImg').attr("src","{{url('/assets/img/play.png')}}");
      $("#audioPlayer")[0].pause();
      window.clearInterval(updateTime);
    }
    else{
      $('#playPauseImg').attr("src","{{url('/assets/img/pause.png')}}");
      $("#audioPlayer")[0].play();
      var url = $('#audioPlayer')[0].src;
      var url2 = "{{url('/assets/music/')}}";        
      var songnamedilipa = url.replace(url2+'/',"");
      // var songnamme = songnamedilipa.replace("%20/g"," ");
      var songnamedilipajud = songnamedilipa.replace('.mp3','');
      var songname = decodeURI(songnamedilipajud);

      $('#song-name').html("Now playing: "+songname);
      updateTime = setInterval(update, 200);
    }

  }

  function playOrPauseFromSongClick() {
    
    setTimeout(function(){
      if(!$("#audioPlayer")[0].paused && !$("#audioPlayer")[0].ended && 0 < $('#audioPlayer')[0].currentTime){
        setTimeout(function(){
          $('#playPauseImg').attr("src","{{url('/assets/img/pause.png')}}");
        },100);
        $('#playPauseImg').attr("src","{{url('/assets/img/play.png')}}");
        updateTime = setInterval(update, 200);

        var url = $('#audioPlayer')[0].src;
        var url2 = "{{url('/assets/music/')}}";        
        var songnamedilipa = url.replace(url2+'/',"");
        // var songnamme = songnamedilipa.replace("%20/g"," ");
        var songnamedilipajud = songnamedilipa.replace('.mp3','');
        var songname = decodeURI(songnamedilipajud);

        $('#song-name').html("Now playing: "+songname);
        // console.log(url);
        // console.log(url2);
        // console.log(songnamedilipajud);
        // console.log(songname);

        // $('#song-name').html(songnamme);
      }
    },200);

  }

  function muteOrUnmute() {

    if ($("#audioPlayer")[0].muted == true) {
      $('#muteUnmuteImg').attr("src","{{url('/assets/img/unmute.png')}}");;
      $("#audioPlayer")[0].muted = false;
    }
    else{
      $('#muteUnmuteImg').attr("src","{{url('/assets/img/mute.png')}}");;
      $("#audioPlayer")[0].muted = true;
    }

  }

  function update() {
    var currentTrack = $('#audioPlayer')[0];
    var currentTime = $('#currentTime');
    if (!$("#audioPlayer")[0].ended) {
      var playedMinutes = Math.trunc(parseInt(currentTrack.currentTime)/60);
      var playedSeconds = parseInt(currentTrack.currentTime)%60;

      if(playedSeconds < 10){        
        currentTime.html(playedMinutes+':0'+playedSeconds)
      }else{        
        currentTime.html(playedMinutes+':'+playedSeconds)
      }

      var fullDuration = Math.trunc(parseInt(currentTrack.duration));
      var movingtime = $('#audioPlayer')[0].currentTime;

      var progressSize = movingtime/fullDuration*100;
      // console.log(progressSize);
      $('#moving_progressbar').width(progressSize+"%");

    }
    else{
      currentTime.html('0.00');
      $('#playPauseImg').attr("src","{{url('/assets/img/play.png')}}");
      $('#moving_progressbar').width("0%");
      window.clearInterval(updateTime);
    }
  }

</script>

<script>
    // loads the audio player
    audioPlayer();
</script>

@endsection