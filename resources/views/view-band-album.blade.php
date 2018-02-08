@extends('layouts.master')

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

/*  table.table>tbody>tr.active>td{
    background: transparent !important;
  }

  table.table>tbody>tr:hover{
    background: #191919;
    color: #E57C1F;
  }

  table.table>tbody>tr>td{
    border-top: none;
    padding-top: 20px;
    padding-bottom: 20px;
  }

  table.table>tbody>tr>td:first-child{  
    border-top-left-radius: 7px;
    border-bottom-left-radius: 7px;
    text-align: center;
  }

  table.table>tbody>tr>td:last-child{    
    border-top-right-radius: 7px;
    border-bottom-right-radius: 7px;
  }*/

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

  .likealbumbtn{
    background: transparent;
    border: 0;
    font-size: 16px;
  }
  .unlikealbumbtn{
    color: #E57C1F;
  }
  
</style>

@include('layouts.sidebar')

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
              <img src="{{$albums->album_pic}}" class="media-object">
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
              <img src="{{$albums->album_pic}}" class="media-object" style="width: 110px;">
              
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
                    <?php $removedmp3 = str_replace('.mp3', '', $songs->song_audio);?>
                      @if(count($songs)==0)
                      <li class="current-song"><a href="{{asset('assets/music/'.$songs->song_audio)}}" onclick="playOrPauseFromSongClick();"><?php echo $removedmp3; ?></a></li>
                      @else
                        <li><a href="{{asset('assets/music/'.$songs->song_audio)}}" onclick="playOrPauseFromSongClick();"><?php echo $removedmp3; ?></a></li>                      
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


$(document).ready(function(){
	$('.albums').on('click', '.showSongs', function()
	{
		var id = $(this).data('id');
		getSongs(id);
	});
	function getSongs(id)
	{
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : "../"+bname+"/viewSongs",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            $('.songs h4').text(json.album.album_name);
            $('.list').empty();
              $.each(json.songs, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

               $('.list').append('<label>'+value.song_title+'</label><br><audio onplay="playSong('+value.song_id+')" class="audio" controls><source src="'+audio+'" type="audio/mpeg"></audio><br><br>'); 

              });
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });			
	}

  $('.showLikeButton').on('click', '.likealbumbtn', function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var id = $('#albumId').val();
        // alert(id);
        $.ajax({
          method : "post",
          url : '../../likeAlbum',
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
            $('button').removeClass('likealbumbtn');
            $('button').addClass('unlikealbumbtn');
            $('.likeText').html('Unlike');
            // change ang name to unlike ug ang likebutton nga classname mahimo ug unlike

          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });  
  });
    $('.showLikeButton').on('click', '.unlikealbumbtn', function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var id = $('#albumId').val();
        // alert(id);
        $.ajax({
          method : "post",
          url : '../../unlikeAlbum',
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
            $('button').removeClass('unlikealbumbtn');
            $('button').addClass('likealbumbtn');
            $('.likeText').html('Like');
            // change ang name to like nya ang classname mahimo ug like
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });  
  });

  // $('button.likeButton').on('click', function(e)
  // {
  //     e.preventDefault();
  //     $button = $(this);
  //     if($button.hasClass('liked')){
          
  //         // $.ajax(); Do Unlike
  //         var id = $(this).data('id');
  //         alert('unlike');
  //         unlikeAlbum(id); 
          
  //     } else {
          
  //         // $.ajax(); Do Like
  //         var id = $(this).data('id');
  //         alert('like');
  //         likeAlbum(id);   
  //     }
  // });

  // function likeAlbum(id)
  // {
  //       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  //       // var bname = $('#bandName').val();
  //       $.ajax({
  //         method : "post",
  //         url : "../likeAlbum",
  //         data : { '_token' : CSRF_TOKEN,
  //           'id' : id
  //         },
  //         success: function(json){
  //           console.log(json);
  //           $button.addClass('liked');
  //           $button.text('Unlike');
  //         },
  //         error: function(a,b,c)
  //         {
  //           console.log(b);

  //         }
  //       });         
  // }
  // function unlikeAlbum(id)
  // {
  //       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  //       // var bname = $('#bandName').val();
  //       $.ajax({
  //         method : "post",
  //         url : "../unlikeAlbum",
  //         data : { '_token' : CSRF_TOKEN,
  //           'id' : id
  //         },
  //         success: function(json){
  //           console.log(json);
  //           $button.removeClass('liked');
  //           $button.text('Like');
  //         },
  //         error: function(a,b,c)
  //         {
  //           console.log(b);

  //         }
  //       });         
  // }
});

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

          var url = $('#albumSong')[0].src;
          var url2 = "{{url('/assets/music/')}}";        
          var songnamedilipa = url.replace(url2+'/',"");
          // var songnamme = songnamedilipa.replace("%20/g"," ");
          var songnamedilipajud = songnamedilipa.replace('.mp3','');
          var songname = decodeURI(songnamedilipajud);

          $('#song-name').html("Currently Playing: "+songname);

          $('#albumSong')[0].addEventListener('loadedmetadata', function() {
              var minutes = Math.trunc(parseInt($('#albumSong')[0].duration)/60);
              var seconds = parseInt($('#albumSong')[0].duration)%60;

              $('#fullDuration').html(minutes+':'+seconds);
          });

        },500);

        updateTime = setInterval(update, 200);

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
    }
    else{
      $('#playBtn').attr("src","{{url('/assets/img/equa2.gif')}}");
      $('#playBtn').css('width','23px');
      $('#playBtn').css('left','60px');
      $('#playBtn').css('top','38px');
      $("#albumSong")[0].play();
      var url = $('#albumSong')[0].src;
      var url2 = "{{url('/assets/music/')}}";        
      var songnamedilipa = url.replace(url2+'/',"");
      // var songnamme = songnamedilipa.replace("%20/g"," ");
      var songnamedilipajud = songnamedilipa.replace('.mp3','');
      var songname = decodeURI(songnamedilipajud);

      $('#song-name').html("Currently Playing: "+songname);
      updateTime = setInterval(update, 200);
    }

  }

  function playOrPauseFromSongClick() {

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

        var url = $('#albumSong')[0].src;
        var url2 = "{{url('/assets/music/')}}";        
        var songnamedilipa = url.replace(url2+'/',"");
        // var songnamme = songnamedilipa.replace("%20/g"," ");
        var songnamedilipajud = songnamedilipa.replace('.mp3','');
        var songname = decodeURI(songnamedilipajud);

        $('#song-name').html("Currently Playing: "+songname);
        // console.log(url);
        // console.log(url2);
        // console.log(songnamedilipajud);
        // console.log(songname);

        // $('#song-name').html(songnamme);
      }
    },200);

  }

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

function playSong(id)
{
  songid = id;
  var audio = document.getElementsByClassName('audio');
  setTimeout(function() { addSongPlayed(songid)}, 5000);
}
function addSongPlayed(id)
{
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          method : "post",
          url : "../addSongPlayed",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
            console.log(json);
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });   
}
</script>
<script>
    // loads the audio player
    audioPlayer();
</script>
@endsection