@extends('layouts.master')
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

@section('title')
@endsection

<style>
    .list{      
        background: #212121;
        border-radius: 5px;
    }
    .nlist{        
        border-radius: 5px;
    }
    #playlist{
        list-style: none;
        padding-left: 0;
    }
    #playlist li{
        background: #212121;
        padding: 10px;
        border-top: 1px solid #555555;
        margin-left: 10px;
        margin-right: 10px;
    }
    #playlist li a{
        color:#aaa;
        text-decoration: none;
    }
    #playlist .current-song a{
        color:#fafafa;
    }
    #playButton{
      border: none;
      background: transparent;
      height: 35px;
      width: 35px;
      padding: 4px;
    }
    #muteButton{
      border: none;
      background: transparent;
      height: 35px;
      width: 35px;
      padding: 4px;
    }
</style>

@include('layouts.navbar')

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<input type="text" value="{{$pl->pl_id}}" id="pid" hidden>

<br><br><br><br><br>
<div class="container">
  <div class="col-md-3">
    <img src="{{$pl->image}}" class="img-responsive">
    <h3 class="text-center">{{$pl->pl_title}}</h3>
    <p class="text-center">by: {{$pl->fullname}}</p>
    <img src="{{url('/assets/img/play.png')}})">
  </div>
  <div class="col-md-9">
    @if(count($lists) == null)
    <div class="nlist">
      <h3>You have no songs in your playlist yet.</h3>
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
    @foreach($lists as $list)
      <audio src="{{url('/assets/music/')}}" controls id="audioPlayer" type="audio/mpeg" hidden></audio>
      @break
    @endforeach

    <div class="buttons">
      <span id="playButton" class="btn" onclick="playOrPause();" style="margin-left: 5px;"><img id="playPauseImg" src="{{url('/assets/img/play.png')}}" class="img-responsive"></span>
      <span id="muteButton" class="btn" onclick="muteOrUnmute();" style="margin-left: -8px;"><img id="muteUnmuteImg" src="{{url('/assets/img/unmute.png')}}" class="img-responsive"></span>
      <span id="currentTime" style="color: #fafafa; vertical-align: text-top;">0:00</span><span style="color: #fafafa; vertical-align: text-top;">  / </span><span id="fullDuration" style="color: #fafafa; vertical-align: text-top;">0:00</span>
    </div>

    <div class="progress" id="progress_bar" style="margin-bottom: 0px; height: 4px;">
      <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
        <span class="sr-only">70% Complete</span>
      </div>
    </div>

      <ul id="playlist">
      <?php

      for($i=0; $i < count($lists); $i++){

          // $spaceReplaced[$i] = str_replace(' ', '%20', $lists[$i]->songs->song_audio);

            if($i == 0){
              echo '<li class="current-song"><a href="http://localhost/Aria/public/assets/music/'.$lists[$i]->songs->song_audio.'">'.$lists[$i]->songs->song_audio.'</a><span data-id="'.$lists[$i]->songs->song_id.'" class="remlist btn fa fa-remove pull-right" style="margin-top: -10px;font-size: 18px" title="Remove from playlist"></span></li>';
            }
            else{
              echo '<li><a href="http://localhost/Aria/public/assets/music/'.$lists[$i]->songs->song_audio.'">'.$lists[$i]->songs->song_audio.'</a><span data-id="'.$lists[$i]->songs->song_id.'" class="remlist btn fa fa-remove pull-right" style="margin-top: -10px;font-size: 18px" title="Remove from playlist"></span></li>';
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
// // console.log(audio);
            $('.nlist h3').remove();
            $('.nlist').append('<div class="row"><div class="col-md-7"><label>'+data.song.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio></div><div class="col-md-2"><span class="remlist btn fa fa-remove pull-right" style="margin-top: -10px;font-size: 18px" title="Remove from playlist" data-id="'+data.song.song_id+'"></span></div></div>');
            $('.rsongs').remove();
            // nrecommend(data.song.song_id);
            nrecommend(data.song.song_id);

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
              $.each(data, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

                $('.nrecommend').append('<div class="row"><div class="col-md-7"><label>'+value.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio></div><div class="col-md-2"><button type="button" class="addnlist" data-id="'+value.song_id+'">Add</button></div></div>');

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
            $('.list').append('<div class="row"><div class="col-md-7"><label>'+data.song.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio></div><div class="col-md-2"><span class="remlist btn fa fa-remove pull-right" style="margin-top: -10px;font-size: 18px" title="Remove from playlist" data-id="'+data.song.song_id+'"></span></div></div>');
            $('.recsongs').remove();
            recommend(data.song.song_id);
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

                $('.recommend').append('<div class="row"><div class="col-md-7"><label>'+value.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio></div><div class="col-md-2"><button type="button" class="removenlist" data-id="'+value.song_id+'">Add</button></div></div>');

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
      var barsize = $("#progress_bar").clientWidth;
      console.log(barsize);

      console.log(currentTrack.duration);
      var minutes = Math.trunc(parseInt(currentTrack.duration)/60);
      var seconds = parseInt(currentTrack.duration)%60;
      fullDuration.html(minutes+':'+seconds);


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

      },500); 
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
      updateTime = setInterval(update, 500);
    }

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
    }
    else{
      currentTime.html('0.00');
      $('#playPauseImg').attr("src","{{url('/assets/img/play.png')}}");
    }
  }

</script>

<script>
    // loads the audio player
    audioPlayer();
</script>

@endsection