@extends('layouts.master')
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/playlistPlayer.css').'?'.rand()}}">


@section('title')
@endsection

@include('layouts.navbar')

@section('content')
<br><br>
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<div class="container" id="main" style="background: #161616;">
<input type="text" value="{{$albums->album_id}}" id="albumId" hidden>
  <div class="row">
      <div id="albumBanner" class="panel-thumbnail" style="background: url({{$albums->album_pic}}) no-repeat center center;">
        &nbsp;
      </div>
      <div id="albumBannerFilter" class="panel-thumbnail">
        &nbsp;
      </div>
      <div id="albumPicTop" class="panel-thumbnail" style="background: transparent;">
          <div class="media" style="border: none; padding-left: 80px;">
            <div class="media-left">
              <div class="panel-thumbnail">
                <img src="{{$albums->album_pic}}" class="media-object" style="width: 255px;">
              </div>
            </div>
            <div class="media-body showLikeButton" style="background: transparent; padding-left: 30px; padding-top: 15px;">
              <p style="color: #E57C1F; font-size: 12px;">ALBUM</p>
              <h2 style="letter-spacing: 1px; margin: 0px;">{{$albums->album_name}}</h2>
              <h4 style="font-size: 18px;">{{$band->band_name}}</h4>
              @if($liked == null)
              <button class="fa fa-thumbs-up likealbumbtn" title="Like Album"></button><span class="likeText"> Like</span>
              @else
              <button class="fa fa-thumbs-up unlikealbumbtn" title="Like Album"></button><span class="likeText"> Unlike</span>
              @endif
              <h6 style="margin-top: 10px;">Released on 10 Mar 2018</h6>
              <p style="margin-top: 20px; font-size: 12px; text-align: justify; word-wrap: break-word; width: 75%">{{$albums->album_desc}}</p>
            </div>
          </div>
      </div>

  </div>
  <br>
  <div class="row">
    <div class="col-md-1">&nbsp;</div>
    <div class="col-md-7">
      <div class="panel" style="border-radius: 0px; background: transparent;">
        <div class="panel-body" style="padding: 0;">
          <div class="media" style="border: 0; border-radius: 0px;">
            <div class="media-left">
              <div class="panel-thumbnail">
                <img src="{{$albums->album_pic}}" class="media-object" style="width: 110px; height: 110px;">
              </div>
              
              <a href="#" onclick="playOrPause();">
                <img src="{{asset('assets/img/playfiller.png')}}" class="media-object" style="width: 50px; position: absolute; top: 32px; left: 47px; opacity: 0.75;" draggable="false">
                <img id="playBtn" src="{{asset('assets/img/play.png')}}" class="media-object" draggable="false">
              </a>

            </div>
            <div class="media-body" style="padding-left: 10px; padding-top: 10px; padding-right: 10px;">
              <h4 class="media-heading" id="song-name" style="color: #212121; padding-top: 5px;">Currently Playing:</h4>
              <p style="color: #212121; font-size: 12px">{{$band->band_name}}</p>
              <audio hidden id="albumSong" src="" type="audio/mpeg" controls></audio>
              <span id="currentTime" style="color: #212121; vertical-align: text-top;">0:00</span><span style="color: #212121; vertical-align: text-top;">  / </span><span id="fullDuration" style="color: #212121; vertical-align: text-top;">0:00</span>
              <input id="musicslider" type="range" style="margin-top: 5px;" min="0" max="100" value="0" step="1">
            </div>
            <div class="panel" style="border-radius: 0px; background: #232323;">
              <div class="panel-body">
                
                <ul id="albumlist" class="songsInAblum">
                @foreach($albums->songs as $songs)
                      @if(count($songs)==0)
                      <li class="current-song"><a href="{{asset('assets/music/'.$songs->song_audio)}}" value="{{$songs->song_id}}" class="songLiA">{{$songs->song_title}}</a></li>
                      @else
                        <li><a href="{{asset('assets/music/'.$songs->song_audio)}}" data-id="{{$songs->song_id}}" class="songLiA">{{$songs->song_title}}></a></li>                      
                      @endif            
                @endforeach
                </ul>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="panel" style="border-radius: 0px;">
        <div class="panel-heading"><h5 style="color: #212121; text-align: center;">SOME PICKS FOR YOU</h5></div>
        <div class="panel-body">
          
        </div>
      </div>
    </div>
    <div class="col-md-1">&nbsp;</div>
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