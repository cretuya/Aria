@extends('layouts.master')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/user-profile.css').'?'.rand()}}">

@include('layouts.navbar')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<br><br><br><br>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">

  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-default">
          <div class="panel-thumbnail">
              <img src="{{$user->profile_pic}}" class="img-responsive" style="height: 350px; width: 100%;">                
          </div>
      </div>
    </div>

    <div class="col-md-1">
    </div>

    <div class="col-md-8">
      <a href="#" data-toggle="modal" data-target="#edit-profile-modal" class="editprof-btn pull-right"><span class="fa fa-pencil"></span></a>
      <a href="#" data-toggle="modal" data-target="#create_playlist_modal" class="editprof-btn pull-right"><span class="fa fa-folder"></span></a>
      <div class="row prfcntnt">
        <h1 class="profile-name">{{$user->fullname}}</h1>
        @if(count($userHasBand) > 0)
        <h3>{{$userBandRole[0]->bandrole}} at {{$userBandRole[0]->band_name}}</h3>
        @else
        <h4>{{$user->fname}} has no band role yet</h4>
        @endif
        <br>
        <ul class="list-group">
        @if($user->address == '')
          <li class="user-info" style="display: inline"><span class="fa fa-map-marker"> </span> <span>N/A</span></li>
        @else
          <li class="user-info" style="display: inline"><span class="fa fa-map-marker"> </span> <span>{{$user->address}}</span></li>
        @endif
          <li class="user-info" style="display: inline; padding-left: 10px;"><span class="fa fa-envelope"> </span> <span>{{$user->email}}</span></li>
          @if($user->contact == '')
          <li class="user-info" style="display: inline; padding-left: 10px;"><span class="fa fa-phone"> </span> <span>N/A</span></li>
          @else
          <li class="user-info" style="display: inline; padding-left: 10px;"><span class="fa fa-phone"> </span> <span>{{$user->contact}}</span></li>
          @endif
        </ul>

        <hr style="margin-top: 35px; border-color: #d9d9d9">

        <label>Bio</label>
        @if($user->bio == '')
          <p style="text-align: justify;">N/A</p>
        @else
        <p style="text-align: justify;">{{$user->bio}}</p>

        @endif
        

      </div>
       
    </div>

  </div>

  <br><br>
  <h3>Playlists</h3>

      
  <div class="container playlists" style="padding: 0;">
  <!-- nag usab ko diri -->
      <div class="row">
      @if(count($playlists) == null)
      <p style="text-align:center; color: #a4a4a4; font-size: 16px;">{{$user->fname}} has not created any playlists yet.</p>
      @else
        @foreach ($playlists as $playlist)
          <center>
          <div class="col-xs-3">
            <div class="panel panel-default">
              <div class="panel-body">
                <a href="{{url('playlist/'.$playlist->pl_id)}}"><img src="{{$playlist->image}}" class="img-responsive" style="height: 100%; max-height: 180px;"><span style="font-size: 18px;">{{$playlist->pl_title}}</span></a>
                <br>
                <p>by: {{$playlist->fullname}}</p>
                <button class="btn btn-default edit" data-id="{{$playlist->pl_id}}">Edit</button>
                <button class="btn btn-default delete" data-id="{{$playlist->pl_id}}">Delete</button>
                <!-- </div> -->
              </div>
            </div>
          </div>
          </center>
          @endforeach
        @endif
      </div>
      <br>
  </div>

  <br><br>

  <h3>Bands Followed</h3>

      
  <div class="container" style="padding: 0;">
  <!-- nag usab ko diri -->
      <div class="row">
      @if(count($bandsfollowedNoGenre) == 0)
      <p style="text-align:center; color: #a4a4a4; font-size: 16px;">{{$user->fname}} has not followed any bands yet</p>
      @else
        @if(count($bandsfollowed) == 0)
          <?php
          $i = 0;          
          $j = $i;
          for ($i=0; $i < count($bandsfollowedNoGenre)/2; $i++) {
            if ($i % 3 == 0) {
              echo "</div><br>";
              echo "<div class='row'>";
            }
          ?>
          <div class="col-xs-4">
            <div class="media">
              <div class="media-left">
                <a href="{{url('/'.$bandsfollowedNoGenre[$j]->band_name)}}"><img src="{{$bandsfollowedNoGenre[$j]->band_pic}}" class="media-object" style="max-width:200px; height: 100%; max-height: 180px;"></a>
              </div>
              <div class="media-body" style="padding-top: 25px;">
                <a href="{{url('/'.$bandsfollowedNoGenre[$j]->band_name)}}"><h4 class="media-heading">{{$bandsfollowedNoGenre[$j]->band_name}}</h4></a>
                <p>{{$bandsfollowedNoGenre[$i]->num_followers}} Followers</p>
              </div>
            </div>
          </div>
          <?php $j+=2;}?>
        @else
          <?php
          $i = 0;
          $j = $i;
          for ($i=0; $i < count($bandsfollowed)/2; $i++) {
            if ($i % 3 == 0) {
              echo "</div><br>";
              echo "<div class='row'>";
            }
          ?>
          <div class="col-xs-4">
            <div class="media">
              <div class="media-left">
                <a href="{{url('/'.$bandsfollowed[$j]->band_name)}}"><img src="{{$bandsfollowed[$j]->band_pic}}" class="media-object" style="max-width:200px; height: 100%; max-height: 180px;"></a>
              </div>
              <div class="media-body" style="padding-top: 25px;">
                <a href="{{url('/'.$bandsfollowed[$j]->band_name)}}"><h4 class="media-heading">{{$bandsfollowed[$j]->band_name}}</h4></a>
                <p>{{$bandsfollowed[$j]->genre_name}} | {{$bandsfollowed[$j+1]->genre_name}}</p>
                <p>{{$bandsfollowed[$i]->num_followers}} Followers</p>
              </div>
            </div>
          </div>
          <?php $j+=2;}?>
        @endif        
      @endif

      </div>

      <br>
  </div>

</div>

  <div id="edit-profile-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <form action="{{url('/edit/profile')}}" method="post">
        {{csrf_field()}}
        <div class="modal-body" style="padding-left: 25px;padding-right: 25px;">
          <label>Name</label>
          <input type="text" name="usersname" class="form-control" value="{{ $user->fullname }}" disabled>
          <!-- {{--<label>Birthdate</label>
                              <input type="text" name="usersbod" class="form-control" value="{{session('userSocial')['birthday'] }}" disabled>--}} -->
          <label>City/Town</label>
          <input type="text" name="userscity" class="form-control" value="{{ $user->address }}" required>
          <!-- {{--<label>Gender</label>
                              <input type="text" name="usersgender" class="form-control" value="{{ session('userSocial')['gender'] }}" disabled>--}} -->
          <label>Email</label>
          <input type="text" name="usersemail" class="form-control" value=" {{ $user->email }}" required>
          <label>Contact No.</label>
          <input type="text" name="userscontact" class="form-control" value="{{ $user->contact }}" required>
          <label>Bio</label>
          <textarea name="usersbio" class="form-control" rows="4">{{ $user->bio }}</textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Submit</button>
        </div>
        </form>
      </div>

    </div>
  </div>

<div id="create_playlist_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create Playlist</h4>
        </div>
        <form action="{{url('createplaylist')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-body" style="padding-left: 25px;padding-right: 25px;">
          <label>Title</label><br>
          <input type="text" name="pl_title" class="form-control" required>
          <label>Description</label><br>
          <input type="text" name="pl_desc" class="form-control" required>
          <label>Add Image</label><br>
          <input type="file" name="pl_image"  class="form-control" accept="image/*" required><br><br> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Submit</button>
        </div>
        </form>
    </div>

  </div>
</div>

<div id="edit_playlist_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Playlist</h4>
        </div>
        <form action="{{url('updateplaylist')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-body" style="padding-left: 25px;padding-right: 25px;">
          <label>Title</label><br>
          <input type="text" name="pl_title" class="form-control" id="pl_title" required>
          <label>Description</label><br>
          <input type="text" name="pl_desc" class="form-control" id="pl_desc" required>
          <label>Change Image</label><br>
          <input type="file" name="pl_image"  class="form-control" accept="image/*">
          <input type="text" name="pl_id" class="form-control hidden" id="pl_id" >

<!--           <label>Add Image</label><br>
          <input type='file' name='image'  class='form-control' id="image" accept="image/*"><br><br>  -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Submit</button>
        </div>
        </form>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$('.delete').click(function()
{
  var id = $(this).data('id');
  // alert(id);
  window.location = '../playlist/delete/'+id;
});
$('.edit').click(function()
{
  var id = $(this).data('id');
  // alert(id);
  editplaylist(id);
});

function editplaylist(id)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          method : "post",
          url : "../editplaylist",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(data){
            console.log(data);
          $('.modal-body #pl_id').attr('placeholder',data.pl_id);
          $('.modal-body #pl_title').attr('placeholder',data.pl_title);
          $('.modal-body #pl_desc').attr('placeholder',data.pl_desc);
          // $('.modal-body #image').val(data.image);

          $('#edit_playlist_modal').modal('show');            
          },
          error: function(a,b,c)
          {
            console.log('Error');

          }
        });  
}


});
</script>
@stop