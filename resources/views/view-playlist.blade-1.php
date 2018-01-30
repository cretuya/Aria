@extends('layouts.master')
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/playlistPlayer.css').'?'.rand()}}">

@section('content')
@include('layouts.sidebar')

<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<input type="text" value="{{$pl->pl_id}}" id="pid" hidden>

<br><br>
<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
              <img src="{{$pl->image}}" class="img-responsive">
              <h3 class="text-center">{{$pl->pl_title}}</h3>
              <p class="text-center">by: {{$pl->fullname}}</p>
              {{--<img src="{{url('/assets/img/play.png')}}">--}}
            </div>
            <div class="col-md-9">
              @if(count($lists) == null)
              <div class="nlist">
                <audio src="{{url('/assets/music/')}}" controls id="audioPlayer" type="audio/mpeg" hidden></audio>
                <div class="list">

                <div class="buttons">
                  <span id="playButton" class="btn" onclick="playOrPause();" style="margin-left: 5px;"><img id="playPauseImg" src="{{url('/assets/img/play.png')}}" class="img-responsive" draggable="false" /></span>
                  <span id="muteButton" class="btn" onclick="muteOrUnmute();" style="margin-left: -8px;"><img id="muteUnmuteImg" src="{{url('/assets/img/unmute.png')}}" class="img-responsive" draggable="false" /></span>
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
              <hr>
              <div class="rsongs">
                <h4>Recommended Songs</h4>        
                  @foreach($rsongs as $rsong)
                    <div class="well" style="padding: 5px; background: #fafafa">
                    <div class="row">
                      <div class="col-md-12">
                        <label>{{$rsong->song_title}}</label><br>
                        <audio controls><source src="{{url('/assets/music/'.$rsong->song_audio)}}" type="audio/mpeg"></audio>
                        <span data-id="{{$rsong->song_id}}" class="addnlist btn fa fa-plus-square pull-right" style="margin-top: -10px;font-size: 18px" title="Add to playlist"></span>
                        <span class="pull-right" style="font-size: 12px; margin-right: -40px; margin-top: -23px;">Genre:{{$rsong->genre->genre_name}}</span>
                      </div>
                    </div>
                    </div>
                  @endforeach
                </div>
                <div class="nrecommend" hidden>
                <h4>Recommended Songs</h4>    
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

                for($i=0; $i < count($lists); $i++){

                    $removedmp3[$i] = str_replace('.mp3', '', $lists[$i]->songs->song_audio);

                      if($i == 0){
                        echo '<li class="current-song"><a href="http://localhost/Aria/public/assets/music/'.$lists[$i]->songs->song_audio.'" onclick="playOrPauseFromSongClick();">'.$removedmp3[$i].'</a><span data-id="'.$lists[$i]->songs->song_id.'" class="remlist btn fa fa-remove pull-right" style="margin-top: -7px;font-size: 18px; color: #555555" title="Remove from playlist"></span></li>';
                      }
                      else{
                        echo '<li><a href="http://localhost/Aria/public/assets/music/'.$lists[$i]->songs->song_audio.'" onclick="playOrPauseFromSongClick();">'.$removedmp3[$i].'</a><span data-id="'.$lists[$i]->songs->song_id.'" class="remlist btn fa fa-remove pull-right" style="margin-top: -7px;font-size: 18px; color: #555555" title="Remove from playlist"></span></li>';
                      }
                }

                ?>

                </ul>

                  

              </div>
              <hr>
              <div class="recsongs">
                <h4>Recommended Songs</h4>
                @if(count($recsongs) == null)
                <h6>No available songs at the moment.</h6>
                @else        
                  @foreach($recsongs as $recsong)
                    <div class="well" style="padding: 5px; background: #fafafa">
                    <div class="row">
                      <div class="col-md-12">
                        <label>{{$recsong->song_title}}</label><br>
                        <audio controls><source src="{{url('/assets/music/'.$recsong->song_audio)}}" type="audio/mpeg"></audio>
                        <span data-id="{{$recsong->song_id}}" class="addlist btn fa fa-plus-square pull-right" style="margin-top: -10px;font-size: 18px" title="Add to playlist"></span>
                        <span class="pull-right" style="font-size: 12px; margin-right: -40px; margin-top: -23px;">Genre:{{$recsong->genre->genre_name}}</span>
                      </div>
                    </div>
                    </div>
                  @endforeach
                @endif
              </div>

                <div class="recommend" hidden>
                <h4>Recommended Songs</h4>        
                </div>
              @endif
              </div>
            </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$('.addnlist').click(function(){
    
    var sid = $(this).data('id');
    // alert(sid);

    addtonlist(sid);
});
$('.nrecommend').on('click', '.addnlist', function()
{
    var sid = $(this).data('id');
    addtonlist(sid);
});
// no songs in playlist yet
function addtonlist(id)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var pid = $('#pid').val();
    // var nrec = null;
    // alert(pid);
    
        $.ajax({
          method : "post",
          url : "../addtonlist",
          data : { '_token' : CSRF_TOKEN,
            'id' : id,
            'pid' : pid,
          },
          success: function(data){
            console.log(data);
              var song = data.song.song_audio;
              var source = "{{url('/assets/music/')}}";
              var audio = source +'/'+ song;
              var songname = song.replace('.mp3','');

             if($("#audioPlayer li")[0] === undefined){

// // console.log(audio);
                var url = "{{url('assets/music/')}}"+'/'+songname;
                $('.nlist h3').remove();
                $('.songsInPlaylist').append('<li class="current-song"><a id="onlyoneSong" href="'+url+'">'+songname+'</a><span data-id="'+data.song.song_id+'" class="remlist btn fa fa-remove pull-right" style="margin-top: -7px;font-size: 18px; color: #555555" title="Remove from playlist"></span></li>');
                $('.rsongs').remove();
                $('#noSongsMessage').addClass('hidden');
                var url = $('#onlyoneSong').attr('href');
                $("#audioPlayer").attr('src',url);
                // nrecommend(data.song.song_id);
                nrecommend(data.song.song_id);
                window.location.reload();
              }

          },
          error: function(a,b,c)
          {
            console.log('Error');

          }
        });
}
// no songs in playlists
function nrecommend(id)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var pid = $('#pid').val();
    // var nrec = null;
    // alert(pid);
    
        $.ajax({
          method : "post",
          url : "../nrecommend",
          data : { '_token' : CSRF_TOKEN,
            'id' : id,
            'pid' : pid,
          },
          success: function(data){
            console.log(data);
            $('.nrecommend').empty();
            $('.nrecommend').append('<h4>Recommended Songs</h4>');
              $.each(data.recs, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

                $('.nrecommend').append('<div class="well" style="padding: 5px; background: #fafafa"><div class="row"><div class="col-md-12"><label>'+value.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio><span data-id="'+value.song_id+'" class="addlist btn fa fa-plus-square pull-right" style="margin-top: -10px;font-size: 18px" title="Add to playlist"></span></div></div></div>');

              });

              $('.nrecommend').show();
          },
          error: function(a,b,c)
          {
            console.log('Error');

          }
        });  
}
$('.nlist').on('click', '.remnlist' , function()
{
    var sid = $(this).data('id');
    var pid = $('#pid').val();
    window.location = '../delplsong/'+sid+'/'+pid;
    // alert(sid);
});

$('.addlist').click(function()
{
    var sid = $(this).data('id');
    addtolist(sid);
});
// songs in playlist yet
function addtolist(id)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var pid = $('#pid').val();
    // var nrec = null;
    // alert(pid);
    
        $.ajax({
          method : "post",
          url : "../addtolist",
          data : { '_token' : CSRF_TOKEN,
            'id' : id,
            'pid' : pid,
          },
          success: function(data){
            console.log(data);
              var song = data.song.song_audio;
              var source = "{{url('/assets/music/')}}";
              var audio = source +'/'+ song;
// // console.log(audio);
            var url = "{{url('assets/music/')}}"+'/'+songname;
            var songname = song.replace('.mp3','');
            // console.log(url);
            $('.songsInPlaylist').append('<li><a href="'+url+'">'+songname+'</a><span data-id="'+data.song.song_id+'" class="remlist btn fa fa-remove pull-right" style="margin-top: -7px;font-size: 18px; color: #555555" title="Remove from playlist"></span></li>');
            $('.recsongs').remove();
            recommend(data.song.song_id);
            window.location.reload();
            // recommend(data.song.song_id);

          },
          error: function(a,b,c)
          {
            console.log('Error');

          }
        });
}

// songs in playlists
function recommend(id)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var pid = $('#pid').val();
    // var nrec = null;
    // alert(pid);
    
        $.ajax({
          method : "post",
          url : "../listrecommend",
          data : { '_token' : CSRF_TOKEN,
            'id' : id,
            'pid' : pid,
          },
          success: function(data){
            console.log(data);
            $('.recommend').empty();
            $('.recommend').append('<h4>Recommended Songs</h4>');
              $.each(data, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

                $('.recommend').append('<div class="well" style="padding: 5px; background: #fafafa"><div class="row"><div class="col-md-12"><label>'+value.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio><span data-id="'+value.song_id+'" class="addlist btn fa fa-plus-square pull-right" style="margin-top: -10px;font-size: 18px" title="Add to playlist"></span></div></div></div>');

              });

              $('.recommend').show();
          },
          error: function(a,b,c)
          {
            console.log('Error');

          }
        });  
}
$('.list').on('click', '.remlist' , function()
{
    var sid = $(this).data('id');
    var pid = $('#pid').val();
    // alert(pid);
    window.location = '../delplsong/'+sid+'/'+pid;
});


});

</script>



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