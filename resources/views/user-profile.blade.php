@extends('layouts.master')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/user-profile.css').'?'.rand()}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dropdown-animation.css').'?'.rand()}}">
@section('content')

@include('layouts.sidebar')

<style>

.ellipsisProfile:hover{
  color: #E57C1F !important;
}

.ellipsisPlaylist:hover{
  color: #E57C1F !important;
}

</style>

<meta name ="csrf-token" content = "{{csrf_token() }}"/>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">
    <div class="row">
        <div class="col-md-12">

          <br><br>
          <div class="row">
            <div class="col-md-3">
              <div class="panel panel-default">
                  <div class="panel-thumbnail">
                      <img src="{{$user->profile_pic}}" class="img-responsive" style="height: 250px; width: 100%;">                
                  </div>
              </div>
            </div>

            <div class="col-md-9" style="padding-left: 40px;">
              
              <div class="dropdown pull-right">
                <button class="dropdown-toggle" type="button" data-toggle="dropdown" style="margin-top: 25px; background: transparent; border: none;"><span class="fa fa-ellipsis-h ellipsisProfile pull-right" style="font-size: 20px;"></span></button>
                <ul class="dropdown-menu">
                  <a href="#" data-toggle="modal" data-target="#edit-profile-modal" class="editprofActions"><li>Edit Profile</li></a>
                  <a href="#" data-toggle="modal" data-target="#create_playlist_modal" class="editprofActions"><li>Create a playlist</li></a>
                </ul>
              </div>

              <div class="row prfcntnt">
                <h2 style="margin-left: -2px;" class="profile-name">{{$user->fullname}}</h2>
                @if(count($userHasBand) > 0)
                <h5>{{$userBandRole[0]->bandrole}} at {{$userBandRole[0]->band_name}}</h5>
                @else
                <h5>{{$user->fname}} has no band role yet</h5>
                @endif
                <br>
                <ul class="list-group">
                @if($user->address == '')
                  <li class="user-info" style="display: inline"><span class="fa fa-map-marker"> </span> <span style="font-size: 12px;">N/A</span></li>
                @else
                  <li class="user-info" style="display: inline"><span class="fa fa-map-marker"> </span> <span style="font-size: 12px;">{{$user->address}}</span></li>
                @endif
                  <li class="user-info" style="display: inline; padding-left: 10px;"><span class="fa fa-envelope"> </span> <span style="font-size: 12px;">{{$user->email}}</span></li>
                  @if($user->contact == '')
                  <li class="user-info" style="display: inline; padding-left: 10px;"><span class="fa fa-phone"> </span> <span style="font-size: 12px;">N/A</span></li>
                  @else
                  <li class="user-info" style="display: inline; padding-left: 10px;"><span class="fa fa-phone"> </span> <span style="font-size: 12px;">{{$user->contact}}</span></li>
                  @endif
                </ul>

                <hr style="margin-top: 35px; margin-right: 15px; border-color: #d9d9d9">

                <label>Bio</label>
                @if($user->bio == '')
                <p style="text-align: justify; font-size: 12px;">N/A</p>
                @else
                <p style="text-align: justify; font-size: 12px;">{{$user->bio}}</p>

                @endif
              </div>               
            </div>
          </div>

        <br>
        <h3 style="font-size: 18px;">Playlists</h3>

        <div class="row">
          @if(count($playlists) == null)
          <div class="col-xs-3">
            <center>
            <a href="#" data-toggle="modal" data-target="#create_playlist_modal">
            <div class="panel" id="addplistpanel" style="background: none; border: 2.5px solid #d9d9d9; width: 180px; height: 180px; margin-top: 15px;">
              <div class="panel-body" style="padding-top: 25px;">                
                <br>
                  <span style="padding: 12px 14px 10px 14px; border: 2.5px solid #d9d9d9; border-radius: 50%; font-size: 24px; color: #fafafa;" class="fa fa-plus addPlistbtn"></span>
                  <br><br>
                  <p style="color: #fafafa;">Create a Playlist</p>
                <br>
              </div>
            </div>
            </a>
            </center>
          </div>
          @else
            @foreach ($playlists as $playlist)
              <center>
              <div class="col-xs-3 xs3block">
                <div class="panel" style="background: none; border: none;">
                  <div class="panel-body">
                    <a href="{{url('playlist/'.$playlist->pl_id)}}">
                    <div class="panel-thumbnail" style="background: transparent;">
                      <img src="{{$playlist->image}}" class="img-responsive" style="height: 100%; max-height: 180px; border: 2px solid #dddddd; margin-bottom: 10px;">
                    </div>
                    <span style="font-size: 14px;">{{$playlist->pl_title}}</span></a>
                    <br>
                    <p style="font-size: 12px; color: #999; font-family: Arial; font-weight: 600;">{{$playlist->fullname}}</p>

                    <div class="dropup">
                      <button class="dropdown-toggle" type="button" data-toggle="dropdown" style="background: transparent; border: none;"><span class="fa fa-ellipsis-h ellipsisPlaylist pull-right" style="font-size: 16px;"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li class="editprofActions2"><span class="btn edit" data-id="{{$playlist->pl_id}}">Edit</span></li>
                        <li class="editprofActions2"><span class="btn delete" data-id="{{$playlist->pl_id}}">Delete</span></li>
                      </ul>
                    </div>

                  </div>
                </div>
              </div>
              </center>
              @endforeach

              <div class="col-xs-3 xs3block">
                <center>
                <a href="#" data-toggle="modal" data-target="#create_playlist_modal">
                <div class="panel" id="addplistpanel" style="background: none; border: 2.5px solid #d9d9d9; width: 180px; height: 180px; margin-top: 15px;">
                  <div class="panel-body" style="padding-top: 25px;">                
                    <br>
                      <span style="padding: 12px 14px 10px 14px; border: 2.5px solid #d9d9d9; border-radius: 50%; font-size: 24px; color: #fafafa;" class="fa fa-plus addPlistbtn"></span>
                      <br><br>
                      <p style="color: #fafafa;">Create a Playlist</p>
                    <br>
                  </div>
                </div>
                </a>
                </center>
              </div>
            @endif
        </div>

        <br>
        <h3 style="font-size: 18px;">Bands Followed</h3>
        
            <div class="row">
            @if(count($bandsfollowedNoGenre) == 0)
            <p style="text-align:center; color: #a4a4a4; font-size: 14px; margin-left: -12px;">{{$user->fname}} has not followed any bands yet</p>
            @else
              @if(count($bandsfollowed) == 0)
                <?php
                $i = 0;          
                $j = $i;
                for ($i=0; $i < count($bandsfollowedNoGenre)/2; $i++) {
                  // if ($i % 4 == 0) {
                  //   echo "</div><br>";
                  //   echo "<div class='row'>";
                  // }
                ?>
                <div class="col-xs-3 xs3block">
                  <center>
                  <div class="panel" style="background: none; margin-bottom: 0px;">
                    <div class="panel-body" style="padding-bottom: 0px;">                    
                      <a href="{{url('/'.$bandsfollowedNoGenre[$j]->band_name)}}">
                      <div class="panel-thumbnail" style="background: transparent;">
                        <img src="{{$bandsfollowedNoGenre[$j]->band_pic}}" class="img-responsive img-circle" style="height: 210px; width: 210px;">
                      </div>
                      </a>
                      <a href="{{url('/'.$bandsfollowedNoGenre[$j]->band_name)}}"><h5 style="font-size: 14px;">{{$bandsfollowedNoGenre[$j]->band_name}}</h5></a>
                      <p style="font-size: 12px;">{{$bandsfollowedNoGenre[$i]->num_followers}} Followers</p>
                    </div>
                  </div>
                  </center>
                </div>
                <?php $j+=2;}?>
              @else
                <?php
                $i = 0;
                $j = $i;
                for ($i=0; $i < count($bandsfollowed)/2; $i++) {
                  // if ($i % 4 == 0) {
                  //   echo "</div><br>";
                  //   echo "<div class='row'>";
                  // }
                ?>
                <div class="col-xs-3 xs3block">
                  <center>
                  <div class="panel" style="background: none; margin-bottom: 0px;">
                    <div class="panel-body" style="padding-bottom: 0px;">
                      <a href="{{url('/'.$bandsfollowed[$j]->band_name)}}">
                      <div class="panel-thumbnail" style="background: transparent;">
                        <img src="{{$bandsfollowed[$j]->band_pic}}" class="img-responsive img-circle" style="height: 210px; width: 210px;">
                      </div>
                      </a>
                      <a href="{{url('/'.$bandsfollowed[$j]->band_name)}}"><h5 style="font-size: 14px;">{{$bandsfollowed[$j]->band_name}}</h5></a>
                      <p style="font-size: 12px;">{{$bandsfollowed[$j]->genre_name}} | {{$bandsfollowed[$j+1]->genre_name}}</p>
                      <p style="font-size: 12px;">{{$bandsfollowed[$i]->num_followers}} Followers</p>
                    </div>
                  </div>
                  </center>
                </div>
                <?php $j+=2;}?>
              @endif        
            @endif

            </div>
    </div>
  </div>
</div>

  <div id="edit-profile-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

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
          <label>City/Town</label>
          <input type="text" name="userscity" class="form-control" value="{{ $user->address }}" required>
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
  <div class="modal-dialog modal-sm">

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
          <!-- <label>Description</label><br>
          <input type="text" name="pl_desc" class="form-control" required> -->
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
  <div class="modal-dialog modal-sm">

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