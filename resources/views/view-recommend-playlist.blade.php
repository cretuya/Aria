@extends('layouts.master')
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/playlistPlayer.css').'?'.rand()}}">

@section('content')

<style type="text/css">
  #albumPicTop{
    position: absolute;
    top: 25px;
    width: calc(100% - 240px);
  }
  #albumPicTop img{
    border: 2px solid #fafafa;
  }

  #albumBanner, #albumBannerFilter{
    height: 300px;
  }

  #albumPicTop img{
    height: 255px;
  }

  #albumlist{
    list-style-type: none;
    padding-left: 0px;
    margin-bottom: 0px;
  }

  #albumlist li{    
    padding-left: 10px;
    padding-right: 5px;
    border-radius: 4px;
    display: flex;
  }
  
  #albumlist li a{
    padding-top: 15px;
    padding-bottom: 15px;
    width: 100%;
    height: 100%:;
  }

  #albumlist li span{
    margin-top: 12px;
    font-size: 15px;
    color: #555555;
    padding: 3px;
  }

  #albumlist li span:hover{
    color: #E57C1F !important;
  }

  #albumlist li:hover a,#albumlist li:hover a:hover{
    color: #E57C1F;   
  }

  #albumlist li:hover{
     background: #181818;
  }

  input[type='range']{
    -webkit-appearance: none !important;
    background: #212121;
    cursor: pointer;
    height: 5px;
    outline: none !important;
  }

  input[type='range']::-webkit-slider-thumb{
    -webkit-appearance: none !important;
    background: #E57C1F;
    height: 12px;
    width: 12px;
    border-radius: 2px;
    cursor: pointer;
  }

  #playBtn{
    width: 50px; position: absolute; top: 32px; left: 47px;
  }
</style>

@include('layouts.sidebar')

<br><br>
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<div class="container" id="main" style="background: #161616;">
  <div class="row">
      <div id="albumBanner" class="panel-thumbnail" style="background: url({{url('assets/img/genre/'.$genre->genre_name.'.jpeg')}}) no-repeat center center;">
        &nbsp;
      </div>
      <div id="albumBannerFilter" class="panel-thumbnail">
        &nbsp;
      </div>
      <div id="albumPicTop" class="panel-thumbnail" style="background: transparent;">
          <div class="media" style="border: none; padding-left: 80px;">
            <div class="media-left">
              <div class="panel-thumbnail">
                <img src="{{url('assets/img/genre/'.$genre->genre_name.'.jpeg')}}" class="media-object" style="width: 255px;">
              </div>
            </div>
            <div class="media-body showLikeButton" style="background: transparent; padding-left: 30px; padding-top: 15px;">
              <p style="color: #E57C1F; font-size: 12px;">PLAYLIST</p>
              <h2 style="letter-spacing: 1px; margin: 0px;">{{$genre->genre_name}}</h2>
              <h4 style="font-size: 18px;">by Aria</h4>
            </div>
          </div>
      </div>

  </div>
  <br>
  <div class="row">
    <div class="col-md-1">&nbsp;</div>
    <div class="col-md-10">
      <div class="panel" style="border-radius: 0px; background: transparent;">
        <div class="panel-body" style="padding: 0;">
          <div class="media" style="border: 0; border-radius: 0px;">
            <div class="media-left">
              <div class="panel-thumbnail">
                <img src="{{url('assets/img/genre/'.$genre->genre_name.'.jpeg')}}" class="media-object" style="width: 110px; height: 110px;">
              </div>
              
              <a href="#" onclick="playOrPause();">
                <img src="{{asset('assets/img/playfiller.png')}}" class="media-object" style="width: 50px; position: absolute; top: 32px; left: 47px; opacity: 0.75;" draggable="false">
                <img id="playBtn" src="{{asset('assets/img/play.png')}}" class="media-object" draggable="false">
              </a>

            </div>
            <div class="media-body" style="padding-left: 10px; padding-top: 10px; padding-right: 10px;">
              <h4 class="media-heading" id="song-name" style="color: #212121; padding-top: 5px;">Currently Playing:</h4>
              <audio hidden id="albumSong" src="" type="audio/mpeg" controls></audio>
              <span id="currentTime" style="color: #212121; vertical-align: text-top;">0:00</span><span style="color: #212121; vertical-align: text-top;">  / </span><span id="fullDuration" style="color: #212121; vertical-align: text-top;">0:00</span>
              <input id="musicslider" type="range" style="margin-top: 5px;" min="0" max="100" value="0" step="1">
            </div>
            <div class="panel" style="border-radius: 0px; background: #232323;">
              <div class="panel-body">
                
                <ul id="albumlist" class="songsInAblum">
                @foreach($songs as $song)
                      @if(count($song)==0)
                      <li class="current-song"><a href="{{asset('assets/music/'.$song->song_audio)}}" value="{{$song->song_id}}" class="songLiA">{{$song->song_title}}</a></li>
                      @else
                        <li><a href="{{asset('assets/music/'.$song->song_audio)}}" data-band="{{$song->album->band->band_name}}" data-id="{{$song->song_id}}" data-title="{{$song->song_title}}" class="songLiA">{{$song->album->band->band_name}} - {{$song->song_title}}</a></li>                      
                      @endif            
                @endforeach
                </ul>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-md-3">
      <div class="panel" style="border-radius: 0px;">
        <div class="panel-heading"><h5 style="color: #212121; text-align: center;">SOME PICKS FOR YOU</h5></div>
        <div class="panel-body">
          
        </div>
      </div>
    </div> -->
    <div class="col-md-1">&nbsp;</div>
  </div>

</div>

<script type="text/javascript">

var usersDurationPlayed = 0;
var globalInt;
var currSong;
var songId;
var prevSong;

// $( document ).ready(function(){
//   setTimeout(function(){

//     var currentTrack = $('#audioPlayer')[0];
//     var fullDuration = $('#fullDuration');

//     // console.log(currentTrack.duration);
//     var minutes = Math.trunc(parseInt(currentTrack.duration)/60);
//     var seconds = parseInt(currentTrack.duration)%60;
    
//     if(isNaN(minutes) && isNaN(seconds)){
//       fullDuration.html("0:00");
//     }else{
//       fullDuration.html(minutes+':'+seconds);
//     }

//   },100);
    
// });

  function audioPlayer(){
    var currentSong = 0;
    $("#albumSong")[0].src = $("#albumlist li a")[0];
    // console.log($("#albumlist li a")[0]);
    // $("#albumSong")[0].play();
    $("#albumlist li a").click(function(e){
       e.preventDefault(); 
       $("#albumSong")[0].src = this;
       $("#albumSong")[0].play();
       $("#albumlist li").removeClass("current-song");
        currentSong = $(this).parent().index();
        $(this).parent().addClass("current-song");
    });
    
    $("#albumSong")[0].addEventListener("ended", function(){
      setTimeout(function(){
       currentSong++;
        if(currentSong == $("#albumlist li a").length)
            currentSong = 0;
        prevSong = parseInt($("#albumSong")[0].duration);
        $("#albumlist li").removeClass("current-song");
        $("#albumlist li:eq("+currentSong+")").addClass("current-song");
        $("#albumSong")[0].src = $("#albumlist li a")[currentSong].href;
        $('#playBtn').attr("src","{{url('/assets/img/play.png')}}");
        $('#playBtn').css('width','50px');
        $('#playBtn').css('left','47px');
        $('#playBtn').css('top','32px');
        $("#albumSong")[0].play();
        $('#playBtn').attr("src","{{url('/assets/img/equa2.gif')}}");
        $('#playBtn').css('width','23px');
        $('#playBtn').css('left','60px');
        $('#playBtn').css('top','38px');

        
        // console.log(songId);

        // console.log('before ni push database song_id kay ',songId, currSong.next('li').find('a').data('id'));

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // console.log(CSRF_TOKEN, usersDurationPlayed, songId, prevSong);
        $.ajax({
          method : "post",
          url : '../../addSongPlayedForScore',
          data : { '_token' : CSRF_TOKEN, 'durationPlayed' : usersDurationPlayed, 'songID' : songId, 'prevSong' : prevSong
          },
          success: function(json){
            console.log(json);
          },
          error: function(a,b,c)
          {
            console.log(b);
          }
        });
        
        // if (jQuery.type(currSong.next('li')) === 'undefined')
        if (currSong.next('li').find('a').data('id') == songId){
          songId = $('#albumlist').first().find('a').data('id');
          // console.log('nisud diri', songId);
        }else if (currSong.next('li').find('a').data('id') == null){
          songId = $('#albumlist').first().find('a').data('id');
          // console.log('nisud diri undefined ang next song id', songId);
        }else{
          songId = currSong.next('li').find('a').data('id');
          // console.log('after pag push na change ang song_id into ', songId);
        }

        clearInterval(globalInt);
        usersDurationPlayed = 0;
        timerDurationPlayed();

          // var url = $('#albumSong')[0].src;
          // var url2 = "{{url('/assets/music/')}}";        
          // var songnamedilipa = url.replace(url2+'/',"");
          // // var songnamme = songnamedilipa.replace("%20/g"," ");
          // var songnamedilipajud = songnamedilipa.replace('.mp3','');
          // var songname = decodeURI(songnamedilipajud);


          $('#albumSong').attr('data-band',$("#albumlist li a")[currentSong].getAttribute('data-band'));
          $('#albumSong').attr('data-title',$("#albumlist li a")[currentSong].getAttribute('data-title'));

          $('#song-name').html("Currently Playing: "+$('#albumSong').attr('data-band')+" - "+$('#albumSong').attr('data-title'));

          // nextdataBand = currSong.next().find('a').data('band');
          // nextdataTitle = currSong.next().find('a').data('title');

          // console.log($("#albumlist li a")[currentSong].getAttribute('data-title'));

          // console.log(nextdataTitle);


          $('#albumSong')[0].addEventListener('loadedmetadata', function() {
              var minutes = Math.trunc(parseInt($('#albumSong')[0].duration)/60);
              var seconds = parseInt($('#albumSong')[0].duration)%60;

              $('#fullDuration').html(minutes+':'+seconds);
          });

        },500);

        updateTime = setInterval(update, 0);

        

    });
}

  function playOrPause() {

    if (!$("#albumSong")[0].paused && !$("#albumSong")[0].ended) {
      $('#playBtn').attr("src","{{url('/assets/img/play.png')}}");
      $('#playBtn').css('width','50px');
      $('#playBtn').css('left','47px');
      $('#playBtn').css('top','32px');
      $("#albumSong")[0].pause();
      window.clearInterval(updateTime);
      clearInterval(globalInt);
      console.log(usersDurationPlayed);
    }
    else{
      $('#playBtn').attr("src","{{url('/assets/img/equa2.gif')}}");
      $('#playBtn').css('width','23px');
      $('#playBtn').css('left','60px');
      $('#playBtn').css('top','38px');
      $("#albumSong")[0].play();
      // var url = $('#albumSong')[0].src;
      // var url2 = "{{url('/assets/music/')}}";        
      // var songnamedilipa = url.replace(url2+'/',"");
      // // var songnamme = songnamedilipa.replace("%20/g"," ");
      // var songnamedilipajud = songnamedilipa.replace('.mp3','');
      // var songname = decodeURI(songnamedilipajud);

      // $('#song-name').html("Currently Playing: "+$('#albumSong').data('band')+" - "+$('#albumSong').data('title'));
      updateTime = setInterval(update, 0);
      timerDurationPlayed();
    }

  }

  function timerDurationPlayed(flag = true){

    globalInt = setInterval(function(){
      usersDurationPlayed++;
      // console.log(usersDurationPlayed);
    }, 1000);
  }

  $('.songLiA').click(function (e) {

    // console.log(id, 'mao ni ang song id');
    // $('#albumSong')[0].attr('data-id', id);
    e.preventDefault();

    currSong = $(this).closest('li');
    // console.log(currSong.find('a').data('id'));
    // console.log(currSong.find('a').data('band'));
    // console.log(currSong.find('a').data('title'));
    songId = currSong.find('a').data('id');

    prevSong = parseInt($('#albumSong')[0].duration);

    if(usersDurationPlayed == 0){
      timerDurationPlayed();
    }else{
      //push then usersDurationPlayed = 0;
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      console.log(CSRF_TOKEN, usersDurationPlayed, songId, prevSong);
      $.ajax({
        method : "post",
        url : '../../addSongPlayedForScore',
        data : { '_token' : CSRF_TOKEN, 'durationPlayed' : usersDurationPlayed, 'songID' : songId, 'prevSong' : prevSong
        },
        success: function(json){
          console.log(json);
        },
        error: function(a,b,c)
        {
          console.log(b);
        }
      });
      usersDurationPlayed = 0;
      timerDurationPlayed();
    }

    var seekslider = document.getElementById('musicslider');
    var audio = document.getElementById('albumSong');

    seekslider.addEventListener("change", function(){
        var seekTo = audio.duration * (seekslider.value/100);
        audio.currentTime = seekTo;
    });

    audio.addEventListener("timeupdate", function(){
        var newtime = audio.currentTime/audio.duration*100;
        seekslider.value = newtime;
    });
    
    if($("#albumSong")[0].paused || !$("#albumSong")[0].paused){
      setTimeout(function(){

          var currentTrack = $('#albumSong')[0];
          var fullDuration = $('#fullDuration');
          var minutes = Math.trunc(parseInt(currentTrack.duration)/60);
          var seconds = parseInt(currentTrack.duration)%60;
          
          // console.log(minutes,seconds);

          fullDuration.html(minutes+':'+seconds);          

          $('#playBtn').attr("src","{{url('/assets/img/equa2.gif')}}");
          $('#playBtn').css('width','23px');
          $('#playBtn').css('left','60px');
          $('#playBtn').css('top','38px');
        },100);
    }

    setTimeout(function(){
      if(!$("#albumSong")[0].paused && !$("#albumSong")[0].ended && 0 < $('#albumSong')[0].currentTime){
        setTimeout(function(){
          $('#playBtn').attr("src","{{url('/assets/img/equa2.gif')}}");
          $('#playBtn').css('width','23px');
          $('#playBtn').css('left','60px');
          $('#playBtn').css('top','38px');
        },100);
        $('#playBtn').attr("src","{{url('/assets/img/play.png')}}");
        $('#playBtn').css('width','50px');
        $('#playBtn').css('left','47px');
        $('#playBtn').css('top','32px');
        updateTime = setInterval(update, 200);

        // var url = $('#albumSong')[0].src;
        // var url2 = "{{url('/assets/music/')}}";        
        // var songnamedilipa = url.replace(url2+'/',"");
        // var songnamme = songnamedilipa.replace("%20/g"," ");
        // var songnamedilipajud = songnamedilipa.replace('.mp3','');
        // var songname = decodeURI(songnamedilipajud);
        $('#song-name').html("Currently Playing: "+currSong.find('a').data('band')+" - "+currSong.find('a').data('title'));
        $('#albumSong').attr('data-band',currSong.find('a').data('band'));
        $('#albumSong').attr('data-title',currSong.find('a').data('title'));
        // console.log(url);
        // console.log(url2);
        // console.log(songnamedilipajud);
        // console.log(songname);

        // $('#song-name').html(songnamme);
      }
    },200);

  });

  function muteOrUnmute() {

    if ($("#albumSong")[0].muted == true) {
      $('#muteUnmuteImg').attr("src","{{url('/assets/img/unmute.png')}}");;
      $("#albumSong")[0].muted = false;
    }
    else{
      $('#muteUnmuteImg').attr("src","{{url('/assets/img/mute.png')}}");;
      $("#albumSong")[0].muted = true;
    }

  }

  function update() {
    var currentTrack = $('#albumSong')[0];
    var currentTime = $('#currentTime');
    if (!$("#albumSong")[0].ended) {
      var playedMinutes = Math.trunc(parseInt(currentTrack.currentTime)/60);
      var playedSeconds = parseInt(currentTrack.currentTime)%60;

      if(playedSeconds < 10){        
        currentTime.html(playedMinutes+':0'+playedSeconds)
      }else{        
        currentTime.html(playedMinutes+':'+playedSeconds)
      }

      var fullDuration = Math.trunc(parseInt(currentTrack.duration));
      var movingtime = $('#albumSong')[0].currentTime;

      var progressSize = movingtime/fullDuration*100;
      // console.log(progressSize);
      $('#moving_progressbar').width(progressSize+"%");

    }
    else{
      currentTime.html('0:00');
      $('#playBtn').attr("src","{{url('/assets/img/play.png')}}");
      $('#playBtn').css('width','50px');
      $('#playBtn').css('left','47px');
      $('#playBtn').css('top','32px');
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