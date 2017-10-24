@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dashboard-manage-band.css').'?'.rand()}}">

@include('layouts.navbar')
<body>
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<br><br><br>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container-fluid" style="padding-left: 30px; padding-right: 30px">
  
<br>
<div class="container">

  <div class="row" style="margin-left: 0px;">
    <span class="manage-band-heading">Manage Band</span>
    <span class="btn btn-default pull-right" onclick="saveBand();">Save changes</span>
    <a href="{{url('/'.$band->band_name)}}"><span class="btn btn-default pull-right" style="margin-right: 10px;">View Band Profile</span></a>
    <span class="btn btn-default pull-right" style="margin-right: 10px;" data-toggle="modal" data-target="#invite-modal">Invite</span>
  </div>
  <br>

  
  <input type="text" value="{{$band->band_id}}" name="bandId" hidden>
  <div class="row">
    <div class="col-md-3">
      <div class="container-profile-photo">
      @if($band->band_pic == null)
      <center><img src="../assets/img//dummy-pic.jpg" class="img-responsive"></center>
      @endif
      <center><img src="{{$band->band_pic}}" class="img-responsive"></center>
        <div class="overlay"></div>
        <div class="button">
          <a href="#" onclick="openfile()"> Change Display Picture </a>
          <form id = "band-pic-form" method="post" action="{{url('/editbandPic')}}" enctype="multipart/form-data">
          {{csrf_field()}}
            <input type="text" value="{{$band->band_id}}" name="bandId"  hidden>
            <input type="text" value="{{$band->band_name}}" name="bandName" hidden>
            <input id="anchor-file" type="file" name="bandPic" style="display: none;">
            <input type="Submit" id = "submitForm" hidden />
          </form>
        </div>
      </div>
    </div>
    <form method="post" id="save-band-form" action="{{url('/editband')}}">
  {{csrf_field()}}
    <div class="col-md-3">
      <input type="text" value="{{$band->band_id}}" name="bandId"  hidden>
      <input id="bandName" class="band-name-title-manage edit-field" name="bandName" value="{{$band->band_name}}">
      <textarea class="band-description-txtarea" name="bandDesc" style="width: 100%; min-height: 221px; resize: none; margin-top: 5px;" placeholder="About the band">{{$BandDetails->band_desc}}</textarea>
    </div>

    <?php
    $checker = 0;
    ?>

    <div class="col-md-6" style="max-height: 270px; overflow-y: scroll;">
          <h4>Choose 2 main genres</h4>
            <div class="row">
               <div class="col-md-4">
                @foreach($genres as $genre)
                  @foreach($bandGenreSelected as $genreSelected)
                    @if($genre->genre_id == $genreSelected->genre_id)
                      <div class="checkbox">
                        <label class="checkbox-form-control">
                        <input type="checkbox" name="genres[]" class="checkboxGenre" value="{{$genre->genre_id}}" checked>{{$genre->genre_name}}</label>
                      </div>
                      <?php $checker = 1; ?>
                    @endif

                  @endforeach

                     @if($checker == 0 )
                     <div class="checkbox">
                       <label class="checkbox-form-control">
                       <input type="checkbox" name="genres[]" class="checkboxGenre" value="{{$genre->genre_id}}">{{$genre->genre_name}}</label>
                     </div>
                     @endif
                      <?php $checker = 0; ?>
                 @endforeach
            </div>
          </div>
    </div>
        
  </form>
  </div>
  <br>
    
<div class="row">
 <div class="col-md-12" style="height: 263px;max-height: 263px; overflow-y: scroll;">
   <h4>Band Members</h4>

   <form method="post" action="{{url('/addmember')}}">
       {{csrf_field()}}
   <div class="row" id="band-member-section">
     <div class="col-sm-5">
       <label for="add-band-member-name">Add Member</label>
       <input type="text" class="form-control" id="add-band-member-name" name="add-band-member-name" placeholder="Enter a name">
       <input type="text" id="add-band-member-id" name="add-band-member-id" hidden>
       <input type="text" id="add-band-member-band-id" name="add-band-member-band-id" value="{{$band->band_id}}" hidden>
       <input type="text" id="add-band-member-band-name" name="add-band-member-band-name" value="{{$band->band_name}}" hidden>
       <div id="dummyContainer"></div>
     </div>
     <input type="text" name="member-user-id" hidden>
     <div class="col-sm-4">      
       <label for="add-band-member">Role</label>
       <select id="add-band-member-role" class="form-control" name="add-band-member-role">
         <option hidden>Select Role</option>
         <option value="Vocalist">Vocalist</option>
         <option value="Lead Guitar">Lead Guitar</option>
         <option value="Rythm Guitar">Rythm Guitar</option>
         <option value="Keyboardist">Keyboardist</option>
         <option value="Drummer">Drummer</option>
         <option value="Bassist">Bassist</option>
       </select>
     </div>

     <div class="col-sm-3">
       <label>&nbsp;</label>
       
       <button class="btn btn-default add-member-btn">Add Member</button>
     </div>
   </div>
   </form>

   <table class="table table-hover" style="margin-top: 5px;">
   
   @foreach($bandmembers as $members)
   
   <form id="bandmemberform" method="post" action="{{url('/deletemember')}}">
   {{csrf_field()}}
     <tr>
       <td class="hidden"><input type="text" name="band-member-id" class="member-id" value="{{$members->user->user_id}}"></td>
       <td class="hidden"><input type="text" name="band-id" value="{{$band->band_id}}"></td>
       <td><input type="text" name="band-member-name" class="member-name" style="border: none; background: transparent;" value="{{$members->user->fullname}}" readonly></td>
       <td><input type="text" name="band-member-role" class="member-role" style="border: none; background: transparent;" value="{{$members->bandrole}}" readonly></td>
       <input type="text" value="{{$band->band_name}}" name="bandName" hidden>
       <!-- <td><a href="#"><span class="fa fa-pencil"></span></a></td> -->
       <td><button type="submit" style="background: transparent; border: none;" class="fa fa-close"></button></td>
     </tr>
   </form>
   @endforeach

     <!-- 
     <tr>
       <td><span class="member-name">Chester Bennington</span></td>
       <td><span class="member-role">Vocalist</span></td>
       <td><a href="#"><span class="fa fa-pencil"></span></a></td>
       <td><a href="#"><span class="fa fa-close"></span></a></td>
     </tr>
     <tr>
       <td><span class="member-name">Chester Bennington</span></td>
       <td><span class="member-role">Vocalist</span></td>
       <td><a href="#"><span class="fa fa-pencil"></span></a></td>
       <td><a href="#"><span class="fa fa-close"></span></a></td>
     </tr>
     <tr>
       <td><span class="member-name">Chester Bennington</span></td>
       <td><span class="member-role">Vocalist</span></td>
       <td><a href="#"><span class="fa fa-pencil"></span></a></td>
       <td><a href="#"><span class="fa fa-close"></span></a></td>
     </tr> -->

     
   </table>

 </div>
 </div>

  <br>

  
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><h4>Videos<button class="btn pull-right" data-toggle="modal" data-target="#video-upload-modal">Upload a video</button></h4></div>
        <div class="panel-body">

        <!-- ari ang foreach-->
        <div id="showVideos">
        @if($videos == null)
        @else
          @foreach($videos as $video)
            
              <div class="col-md-4">
                <video style="background: #000; width: 100%;" class="embed-responsive-item" controls>
                    <source src="{{asset('assets/video/'.$video->video->video_content)}}">
                </video>
                <button type="button" class="edit" data-toggle="modal" data-desc="{{$video->video->video_desc}}" data-id="{{$video->video->video_id}}">Edit Description</button>
                <button type="button" class="delete" value="{{'../'.$band->band_name.'/deleteVideo/'.$video->video->video_id}}">Delete</button>                    
              </div>
          @endforeach
        @endif
         </div>

        </div>
      </div>
    </div>

  </div>

  <br>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading"><h4>Albums<button class="btn pull-right" data-toggle="modal" data-target="#add-album-modal">Add an album</button></h4></div>
        <div class="panel-body" style="padding: 0px;">

        <br>
        <div id="showAlbums">
          <nav class="nav-sidebar">
            <ul class="nav tabs">
             @if ($albums == null)
             @else

              @foreach ($albums as $album)



              <li class="active">
              <a href="#" data-toggle="tab" class="viewSongs" data-id= "{{$album->album_id}}">  {{$album->album_name}}
                <button class="btn pull-right addSong" style="margin-top: -7px;" data-id="{{$album->album_id}}"><span class="fa fa-plus"></span></button>
                <button class="btn pull-right delete" style="margin-top: -7px;" value="{{$album->album_id}}"><span class="fa fa-close"></span></button>
                <button class="btn pull-right edit" style="margin-top: -7px;" data-name="{{$album->album_name}}" data-id="{{$album->album_id}}" data-desc="{{$album->album_desc}}"><span class="fa fa-pencil"></span>
                </button>

              </a></li>



              @endforeach
           @endif
          </ul>
        </nav>
       </div>               


       <div id="showSongs">
        <div class="tab-content">
          <div class="tab-pane active song-pane">
          <h4 class="tabtitle"></h4>
             <ul class="list-group tablist">
             </ul>
          </div>
        </div>
        </div>

        </div>          
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
      <div class="panel-heading"><h4>Articles<button class="btn btn-default pull-right" data-toggle="modal" data-target="#add-article-modal">Add new article</button></h4></div>
      <div class="panel-body">

      <div id="showArticles">
      @if ($articles == null)
      @else
       @foreach ($articles as $article)

       <a href="{{'../'.$band->band_name.'/viewArticle/'.$article->art_id}}">{{$article->article->art_title}}</a> <button class="btn pull-right delete" value="{{$article->art_id}}"><span class="fa fa-close"></span></button><button class="btn pull-right edit" data-toggle="modal" data-content="{{$article->article->content}}" data-title="{{$article->article->art_title}}" data-id="{{$article->art_id}}"><span class="fa fa-pencil"></span></button>
       <br><br>

       @endforeach
      @endif
      </div>


      </div>
    </div>
  </div>

  <br><br>


</div>

<!-- Video Modals -->

<!-- Add Video Modal -->
<div id="video-upload-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addVideo'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Video</h4>
      </div>
      <div class="modal-body">
        
            Video Description:<br>
            <textarea name='video_desc' class='form-control' required></textarea> <br>            
            Add Video:<br>
            <input type='file' name='video_content[]' class="btn btn-default" accept="video/*" multiple required><br><br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Video Modal -->
<div id="video-edit-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateVideo'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Video</h4>
      </div>
      <div class="modal-body">
        
            Video Description:<br>
            <textarea name='video_desc' id='video_desc' class='form-control'></textarea> <br><br> 
            <input type="text" id="video_id" name="video_id" hidden>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- Add Album Modal -->
<div id="add-album-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addAlbum'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Album</h4>
      </div>
      <div class="modal-body">
        
            Album Title:<br>
            <input type='text' name='album_name' class='form-control' required><br>
            Description:<br>
            <input type='text' name='album_desc' class='form-control' required><br>
            Add Album Picture:<br>
            <input type='file' name='album_pic'  class='form-control' accept="image/*" required><br><br>            
            <br>


      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Album Modal -->
<div id="edit-album-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateAlbum'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Video</h4>
      </div>
      <div class="modal-body">
        
            Album Title:<br>
            <input type='text' name='album_name' id="album_name" class='form-control'><br>
            Description:<br>
            <input type='text' name='album_desc' id="album_desc" class='form-control'><br>
            <br>
            <input type="text" id="album_id" name="album_id" hidden><br>
            <br>

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- Add Article Modal -->
<div id="add-article-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addArticle'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Article</h4>
      </div>
      <div class="modal-body">
        
            Title of Article:<br>
            <input type='text' name='art_title' class='form-control' required><br><br>
            Content:<br>
            <textarea name='content' class='form-control' required></textarea><br><br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Article Modal -->
<div id="edit-article-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateArticle'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Article</h4>
      </div>
      <div class="modal-body">
        
            Title of Article:<br>
            <input type='text' name='art_title' id="art_title" class='form-control'><br><br>
            Content:<br>
            <textarea name='content' id="content" class='form-control'></textarea><br><br>
            <input type="text" name="art_id" id="art_id" hidden>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- Add Song Modal -->
<div id="add-song-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addSongs'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Song</h4>
      </div>
      <div class="modal-body">
        
        Song Description:<br>
        <input type="text" name="song_desc"  class='form-control' required><br><br>
        <input type="file" name="song_audio[]" class='form-control' accept="audio/*" multiple required><br>
        <input type="text" name="album_id" id="album_id" hidden><br>
        <select name="genre_id" class='form-control'>
            @foreach($genres as $genre)
            <option value="{{$genre->genre_id}}">{{$genre->genre_name}}</option>
            @endforeach
        </select>
        <br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Song Modal -->
<div id="edit-song-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateSong'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Song</h4>
      </div>
      <div class="modal-body edit-modal">
        
        Song Description:<br>
        <input type="text" name="song_desc" id="song_desc" class='form-control'><br><br>

        <div class="showgenre">
        <select name="genre_id" id="genre_id" class='form-control'>
            @foreach($genres as $genre)
            <option value="{{$genre->genre_id}}">{{$genre->genre_name}}</option>
            @endforeach
        </select>
        </div>
        <br>
        <input type="text" name="song_id" id="song_id" hidden>
        <br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div id="invite-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Invites</h4>
      </div>
      <div class="modal-body">
      <label>To be invited as member:</label>
        <input type="text" name="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</body>
<script type="text/javascript">

$( function() {
    
    $( "#add-band-member-name").autocomplete({
      source: 'http://localhost/Aria/public/{{$band->band_name}}/manage/search',
      appendTo: "#dummyContainer",
      autoFocus: true,
      select: function(e,ui){
        $('#add-band-member-name').val(ui.item.value);
        $('#add-band-member-id').val(ui.item.id);
      }
    });

});

function openfile(){
  $('#anchor-file').click();
}
$("#anchor-file").on("change",function()
{
  console.log("niagi-here");
  $("#submitForm").click();
});

// function changeBandPic(){
//   $('#band-pic-form').submit();
// }

function saveBand(){
  document.getElementById('save-band-form').submit();
}

$(document).ready(function()
{
     $("#showVideos").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this video?'))
        {
            window.location.href = '../deleteVideo/'+val;
        }
     });

     $('#showVideos').on('click', '.edit', function(){
          var desc = $(this).data('desc');
          var id = $(this).data('id');

          $('.modal-body #video_desc').val(desc);
          $('.modal-body #video_id').val(id);
          $('#video-edit-modal').modal('show');
     });

     $("#showArticles").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this article?'))
        {
            window.location.href = '../deleteArticle/'+val;
        }
     });

     $('#showArticles').on('click', '.edit', function(){
          var title = $(this).data('title');
          var id = $(this).data('id');
          var content = $(this).data('content');

          $('.modal-body #art_title').val(title);
          $('.modal-body #art_id').val(id);
          $('.modal-body #content').val(content);

          $('#edit-article-modal').modal('show');
     });

     $("#showAlbums").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this album?'))
        {
            window.location.href = '../deleteAlbum/'+val;
        }
     });

     $('#showAlbums').on('click', '.edit', function(){
          var desc = $(this).data('desc');
          var id = $(this).data('id');
          var name = $(this).data('name');

          $('.modal-body #album_desc').val(desc);
          $('.modal-body #album_id').val(id);
          $('.modal-body #album_name').val(name);
          $('#edit-album-modal').modal('show');
     });

     $('#showAlbums').on('click', '.addSong', function(){
          var id = $(this).data('id');

          $('.modal-body #album_id').val(id);
          $('#add-song-modal').modal('show');
     });

    $('#showAlbums').on('click', '.viewSongs', function(){
        var album_id = $(this).data('id');
        viewSongs(album_id);
    });

    function viewSongs($id)
    {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // alert($id);
        var bname = $('#bandName').val();
        // alert(bname);
        $.ajax({
          method : "post",
          url : "../"+bname+"/viewSongs",
          data : { '_token' : CSRF_TOKEN,
            'id' : $id
          },
          success: function(json){
            $('.tabtitle').text(json.album.album_name);
            $('.tablist li').remove();
              $.each(json.songs, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

               $('.tablist').append('<li id="listItem'+value.song_id+'" class="list-group-item"><label>'+value.song_audio+'</label><audio controls><source src="'+audio+'" type="audio/mpeg"></audio><button class="btn pull-right delete" value="'+value.song_id+'"><span class="fa fa-close"></span></button><button class="btn pull-right edit" data-toggle="modal" data-genre="'+value.genre_id+'" data-desc="'+value.song_desc+'" data-id="'+value.song_id+'"><span class="fa fa-pencil"></span></button></li>'); 

              });
          },
          error: function(a,b,c)
          {
            alert('Error');

          }
        });
    }

  $('#showSongs').on('click', '.delete', function()
  {
      var id = $(this).val();
      alert(id);
      if(confirm('Do you want to delete this song?'))
        {
            deleteSong(id);
        }
  });

  function deleteSong($id)
  {
    console.log($id);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          method : "post",
          url : "../deleteSong/"+$id,
          data : { '_token' : CSRF_TOKEN,
            'id' : $id
          },
          success: function(song){
            $('#listItem'+song.song_id).remove();
          }


        });

  }

  $('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > 2) {
        $(this).prop('checked', false);
    }
  });


  $('#showSongs').on('click', '.edit', function()
  {
      var id = $(this).data('id');
      var gid = $(this).data('genre');
      var desc = $(this).data('desc');
      console.log(gid);

          $('.modal-body #song_desc').val(desc);
          $('.modal-body #song_id').val(id);
          $('.showgenre select').val(gid);

          $('#edit-song-modal').modal('show');
  });
  $('#updateSongbutton').click(function(){

      var desc = $('.edit-modal #song_desc').val();
      var id = $('.edit-modal #song_id').val();
      var genre = $('.edit-modal #genre_id').val();


      var data = new Array(id,desc,genre);
      updateSong(data);
      $('#edit-song-modal').modal('hide');
  });
  // function updateSong(data)
  // {
  //     var id = data[0];
  //     var desc = data[1];
  //     var genre = data[2];
  //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  //       $.ajax({
  //         method : "post",
  //         url : "../updateSong",
  //         data : { '_token' : CSRF_TOKEN,
  //           'song_id' : id,
  //           'song_desc' : desc,
  //           'genre_id': genre
  //         },
  //         success: function(content){
  //           alert('Success');
  //         }


  //       });  
  // }

 });
</script>
@endsection
