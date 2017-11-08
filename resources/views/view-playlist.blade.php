@extends('layouts.master')

@section('title')
@endsection

<!-- @include('layouts.navbar') -->

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<input type="text" value="{{$pl->pl_id}}" id="pid" hidden>

<br><br><br><br><br>
<div class="container">
  <div class="col-md-3">
    <img src="{{$pl->image}}" class="img-responsive">
    <h3 class="text-center">{{$pl->pl_title}}</h3>
    <p class="text-center">by: {{$pl->fullname}}</p>
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
          <div class="well" style="padding: 5px; background: #fafafa">
          <div class="row">
            <div class="col-md-12">
              <label>{{$list->songs->song_title}}</label><br>
              <audio controls><source src="{{url('/assets/music/'.$list->songs->song_audio)}}" type="audio/mpeg"></audio>
              <span data-id="{{$list->songs->song_id}}" class="remlist btn fa fa-trash pull-right" style="margin-top: -10px;font-size: 18px" title="Remove from playlist"></span>
            </div>
          </div>
          </div>
        @endforeach
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
            $('.nlist').append('<div class="row"><div class="col-md-7"><label>'+data.song.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio></div><div class="col-md-2"><button type="button" class="remnlist" data-id="'+data.song.song_id+'">Remove</button></div></div>');
            $('.rsongs').remove();
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
            $('.list').append('<div class="row"><div class="col-md-7"><label>'+data.song.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio></div><div class="col-md-2"><button type="button" class="remlist" data-id="'+data.song.song_id+'">Remove</button></div></div>');
            $('.recsongs').remove();
            recommend(data.song.song_id);

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
@endsection