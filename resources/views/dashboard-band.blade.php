@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dashboard-manage-band.css').'?'.rand()}}">

@include('layouts.navbar')
<body>
<br><br><br>

<div class="container-fluid" style="padding-left: 30px; padding-right: 30px">
  
<br>
<div class="container">

  <div class="row" style="margin-left: 0px;">
    <span class="manage-band-heading">Manage Band</span>
    <span class="btn btn-default pull-right">Save changes</span>
    <span class="btn btn-default pull-right" style="margin-right: 10px;">View Band Profile</span>
    <span class="btn btn-default pull-right" style="margin-right: 10px;" data-toggle="modal" data-target="#invite-modal">Invite</span>
  </div>
  <br>

  <div class="row">
    <div class="col-md-3">
      <div class="container-profile-photo">
      <center><img src="{{asset('assets/img/dummy-pic.jpg')}}" class="img-responsive"></center>
        <div class="overlay"></div>
        <div class="button">
          <a href="#" onclick="openfile()"> Change Display Picture </a><input id="anchor-file" type="file" style="display: none;">
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <input id="bandName" class="band-name-title-manage edit-field" name="bandName" value="{{$band->band_name}}">
      <textarea class="band-description-txtarea" name="bandDesc" style="width: 100%; min-height: 221px; resize: none; margin-top: 5px;" placeholder="About the band"></textarea>
    </div>
    <div class="col-md-6" style="max-height: 263px; overflow-y: scroll;">
      <h4>Band Members</h4>

      <div class="row">
        <div class="col-sm-5">
          <label for="add-band-member">Add Member</label>
          <input type="text" name="" class="form-control" id="add-band-member">
        </div>

        <div class="col-sm-4">      
          <label for="add-band-member">Role</label>
          <input type="text" name="" class="form-control" id="add-band-member-role">
        </div>

        <div class="col-sm-3">
          <label for="add-band-member">&nbsp;</label>
          <button class="btn btn-default add-member-btn">Add Member</button>
        </div>
      </div>

      <table class="table table-hover" style="margin-top: 5px;">


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
        </tr>
        <tr>
          <td><span class="member-name">Chester Bennington</span></td>
          <td><span class="member-role">Vocalist</span></td>
          <td><a href="#"><span class="fa fa-pencil"></span></a></td>
          <td><a href="#"><span class="fa fa-close"></span></a></td>
        </tr>

        
      </table>

    </div>    
  </div>
  <br>
  <div class="row">
    <div class="col-md-12" style="max-height: 270px; overflow-y: scroll;">
          <h4>Choose 2 main genres</h4>
            <div class="row">
               <div class="col-md-4">
                @foreach($genres as $genre)
                 <div class="checkbox">
                   <label class="checkbox-form-control"><input type="checkbox" value="{{$genre->genre_id}}">{{$genre->genre_name}}</label>
                 </div>
                 @endforeach
            </div>
          </div>
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
              <a href="#" data-toggle="tab" data-id="{{$album->album_id}}" onclick="viewSongs(this);">  {{$album->album_name}}

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


<!--                 <li class="active"><a href="#tab1" data-toggle="tab">Lorem ipsum <button class="btn pull-right" style="margin-top: -7px;"><span class="fa fa-close"></span></button><button class="btn pull-right" style="margin-top: -7px;"><span class="fa fa-pencil"></span></button></a></li>
                <li class=""><a href="#tab2" data-toggle="tab">Dolor asit amet <button class="btn pull-right" style="margin-top: -7px;"><span class="fa fa-close"></span></button><button class="btn pull-right" style="margin-top: -7px;"><span class="fa fa-pencil"></span></button></a></li>
                <li class=""><a href="#tab3" data-toggle="tab">Stet clita <button class="btn pull-right" style="margin-top: -7px;"><span class="fa fa-close"></span></button><button class="btn pull-right" style="margin-top: -7px;"><span class="fa fa-pencil"></span></button></a></li>         -->                       


        <div class="tab-content">

          <div class="tab-pane active song-pane" id="tab1">
          <h4>TAB1</h4>
             <ul class="list-group">
               <li class="list-group-item"><label>Linkin Park - Faint</label><audio controls><source src="song.mp3"></audio></li>
               <li class="list-group-item"><label>Linkin Park - In The End</label><audio controls><source src="song.mp3"></audio></li>
               <li class="list-group-item"><label>Linkin Park - New Divide</label><audio controls><source src="song.mp3"></audio></li>
               <li class="list-group-item"><label>Linkin Park - Numb</label><audio controls><source src="song.mp3"></audio></li>
               <li class="list-group-item"><label>Linkin Park - Breaking The Habit</label><audio controls><source src="song.mp3"></audio></li>
               <li class="list-group-item"><label>Linkin Park - Points of Authority</label><audio controls><source src="song.mp3"></audio></li>
             </ul>
          </div>
          <div class="tab-pane song-pane" id="tab2">
          <h4>TAB2</h4>
            <ul class="list-group">
              <li class="list-group-item"><label>Linkin Park - Faint</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - In The End</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - New Divide</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - Numb</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - Breaking The Habit</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - Points of Authority</label><audio controls><source src="song.mp3"></audio></li>
            </ul>

          </div>
          <div class="tab-pane song-pane" id="tab3">
          <h4>TAB3</h4>
            <ul class="list-group">
              <li class="list-group-item"><label>Linkin Park - Faint</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - In The End</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - New Divide</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - Numb</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - Breaking The Habit</label><audio controls><source src="song.mp3"></audio></li>
              <li class="list-group-item"><label>Linkin Park - Points of Authority</label><audio controls><source src="song.mp3"></audio></li>
            </ul>
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

       <a href="{{'./'.$band->band_name.'/viewArticle/'.$article->art_id}}">{{$article->article->art_title}}</a> <button class="btn pull-right delete" value="{{$article->art_id}}"><span class="fa fa-close"></span></button><button class="btn pull-right edit" data-toggle="modal" data-content="{{$article->article->content}}" data-title="{{$article->article->art_title}}" data-id="{{$article->art_id}}"><span class="fa fa-pencil"></span></button>
       <br><br>

       @endforeach
      @endif
      </div>

<!--         <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="{{asset('assets/img/oln.jpg')}}">
            <p class="card-block">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam velit quisquam veniam excepturi temporibus inventore corporis dicta sit culpa veritatis placeat earum, dolorum asperiores, delectus dolore voluptatibus, at magnam nobis!
            </p>
            <button class="btn pull-right"><span class="fa fa-close"></span></button><button class="btn pull-right"><span class="fa fa-pencil"></span></button>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="{{asset('assets/img/oln.jpg')}}">
            <p class="card-block">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam velit quisquam veniam excepturi temporibus inventore corporis dicta sit culpa veritatis placeat earum, dolorum asperiores, delectus dolore voluptatibus, at magnam nobis!
            </p>
            <button class="btn pull-right"><span class="fa fa-close"></span></button><button class="btn pull-right"><span class="fa fa-pencil"></span></button>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="{{asset('assets/img/oln.jpg')}}">
            <p class="card-block">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam velit quisquam veniam excepturi temporibus inventore corporis dicta sit culpa veritatis placeat earum, dolorum asperiores, delectus dolore voluptatibus, at magnam nobis!
            </p>
            <button class="btn pull-right"><span class="fa fa-close"></span></button><button class="btn pull-right"><span class="fa fa-pencil"></span></button>
          </div>
        </div>

        <div class="col-sm-3">
          <div class="card">
            <img class="card-img-top" src="{{asset('assets/img/oln.jpg')}}">
            <p class="card-block">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam velit quisquam veniam excepturi temporibus inventore corporis dicta sit culpa veritatis placeat earum, dolorum asperiores, delectus dolore voluptatibus, at magnam nobis!
            </p>
            <button class="btn pull-right"><span class="fa fa-close"></span></button><button class="btn pull-right"><span class="fa fa-pencil"></span></button>
          </div>
        </div> -->

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
    <form method="post" action="{{'./'.$band->band_name.'/addVideo'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Video</h4>
      </div>
      <div class="modal-body">
        
            Video Description:<br>
            <textarea name='video_desc'></textarea> <br><br>            
            Add Video:<br>
            <input type='file' name='video_content[]' accept="video/*" multiple><br><br>
      
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
    <form method="post" action="{{$band->band_name.'/updateVideo'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Video</h4>
      </div>
      <div class="modal-body">
        
            Video Description:<br>
            <textarea name='video_desc' id='video_desc'></textarea> <br><br> 
            <input type="text" id="video_id" name="video_id">
      
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
    <form method="post" action="{{'./'.$band->band_name.'/addAlbum'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Album</h4>
      </div>
      <div class="modal-body">
        
            Album Title:<br>
            <input type='text' name='album_name'><br>
            Description:<br>
            <input type='text' name='album_desc'><br>
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
    <form method="post" action="{{$band->band_name.'/updateAlbum'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Video</h4>
      </div>
      <div class="modal-body">
        
            Album Title:<br>
            <input type='text' name='album_name' id="album_name"><br>
            Description:<br>
            <input type='text' name='album_desc' id="album_desc"><br>
            <br>
            <input type="text" id="album_id" name="album_id"><br>
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
    <form method="post" action="{{'./'.$band->band_name.'/addArticle'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Article</h4>
      </div>
      <div class="modal-body">
        
            Title of Article:<br>
            <input type='text' name='art_title'><br><br>
            Content:<br>
            <textarea name='content'></textarea><br><br>
      
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
    <form method="post" action="{{'./'.$band->band_name.'/updateArticle'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Article</h4>
      </div>
      <div class="modal-body">
        
            Title of Article:<br>
            <input type='text' name='art_title' id="art_title"><br><br>
            Content:<br>
            <textarea name='content' id="content"></textarea><br><br>
            <input type="text" name="art_id" id="art_id">
      
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
    <form method="post" action="{{'./'.$band->band_name.'/addSongs'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Songs</h4>
      </div>
      <div class="modal-body">
        
        Song Title:<br>
        <input type="text" name="song_desc"><br>
        <input type="file" name="song_audio[]" accept="audio/*" multiple><br>
        <input type="text" name="album_id" id="album_id"><br>
        <select name="genre_id">
            @foreach($genres as $genre)
            <option value='{{$genre->genre_id}}'>{{$genre->genre_name}}</option>
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

<div id="invite-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Invites</h4>
      </div>
      <div class="modal-body">
      <label>To be ivited as member:</label>
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
function viewSongs($id)
{
  var id = $(this).data('id');

  alert(id);
}

$(document).ready(function()
{
     $("#showVideos").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this video?'))
        {
            window.location.href = './deleteVideo/'+val;
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
            window.location.href = './deleteArticle/'+val;
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
            window.location.href = './deleteAlbum/'+val;
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

 });
</script>
@endsection
