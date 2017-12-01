
@extends('layouts.master')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/user-profile.css').'?'.rand()}}">

@include('layouts.sidebar')

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
            <!-- <a href="#" data-toggle="modal" data-target="#edit-profile-modal" class="editprof-btn pull-right"><span class="fa fa-pencil"></span></a> -->
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
          <p style="text-align:center; color: #a4a4a4; font-size: 14px;">{{$user->fname}} has not created any playlists yet.</p>
          @else
            @foreach ($playlists as $playlist)
              <center>
              <div class="col-xs-3">
                <div class="panel" style="background: none; border: none;">
                  <div class="panel-body">
                    <a href="{{url('playlist/'.$playlist->pl_id)}}"><img src="{{$playlist->image}}" class="img-responsive" style="height: 100%; max-height: 180px; border: 2px solid #dddddd; margin-bottom: 10px;"><span style="font-size: 14px;">{{$playlist->pl_title}}</span></a>
                    <br>
                    <p style="font-size: 12px; color: #999; font-family: Arial; font-weight: 600;">{{$playlist->fullname}}</p>

                    <div class="dropup">
                      <button class="dropdown-toggle" type="button" data-toggle="dropdown" style="background: transparent; border: none;"><span class="fa fa-ellipsis-h ellipsisPlaylist pull-right" style="font-size: 16px;"></span></button>
                      <ul class="dropdown-menu dropdown-menu-right">
                      </ul>
                    </div>

                  </div>
                </div>
              </div>
              </center>
              @endforeach
            @endif
        </div>

        <br>
        <h3 style="font-size: 18px;">Bands Followed</h3>

            <div class="row">
            @if(count($bandsfollowedNoGenre) == 0)
            <p style="text-align:center; color: #a4a4a4; font-size: 14px;">{{$user->fname}} has not followed any bands yet</p>
            @else
              @if(count($bandsfollowed) == 0)
                <?php
                $i = 0;          
                $j = $i;
                for ($i=0; $i < count($bandsfollowedNoGenre)/2; $i++) {
                  if ($i % 4 == 0) {
                    echo "</div><br>";
                    echo "<div class='row'>";
                  }
                ?>
                <div class="col-xs-3">
                  <center>
                  <div class="panel" style="background: none; margin-bottom: 0px;">
                    <div class="panel-body" style="padding-bottom: 0px;">
                      <a href="{{url('/'.$bandsfollowedNoGenre[$j]->band_name)}}"><img src="{{$bandsfollowedNoGenre[$j]->band_pic}}" class="img-responsive img-circle" style="width: 84%; min-width:199px; max-width: 200px height: 100%; min-height: 179px; max-height: 180px;"></a>
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
                  if ($i % 4 == 0) {
                    echo "</div><br>";
                    echo "<div class='row'>";
                  }
                ?>
                <div class="col-xs-3">
                  <center>
                  <div class="panel" style="background: none; margin-bottom: 0px;">
                    <div class="panel-body" style="padding-bottom: 0px;">
                      <a href="{{url('/'.$bandsfollowed[$j]->band_name)}}"><img src="{{$bandsfollowed[$j]->band_pic}}" class="img-responsive img-circle" style="width: 84%; max-width:199px; max-width: 200px height: 100%; min-height: 179px; max-height: 180px;"></a>
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

            <br>
    </div>
  </div>
</div>

    <div id="create-band-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form method="post" action='{{url('/createband')}}'>
            {{csrf_field()}}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create a Band</h4>
        </div>
        <div class="modal-body">
          
            Band Name: <br>
            <input type="text" class="form-control" name="band_name" style="text-transform: capitalize;"><br>
            What's your role? <br>
            <select class="form-control" name="band_role_create">
              <option value="Vocalist">Vocalist</option>
              <option value="Lead Guitar">Lead Guitar</option>
              <option value="Rythm Guitar">Rythm Guitar</option>
              <option value="Keyboardist">Keyboardist</option>
              <option value="Drummer">Drummer</option>
              <option value="Bassist">Bassist</option>
            </select>
            <!-- <input type="text" class="form-control" name="band_role_create" style="text-transform: capitalize;""><br> -->
  <!--           <input type="text" name="band_pic" hidden> -->
            <br>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Submit</button>
        </div>
        </div>
        </form>
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
          <input type="text" name="userscity" class="form-control" value="{{ $user->address }}">
          <!-- {{--<label>Gender</label>
                              <input type="text" name="usersgender" class="form-control" value="{{ session('userSocial')['gender'] }}" disabled>--}} -->
          <label>Email</label>
          <input type="text" name="usersemail" class="form-control" value=" {{ $user->email }} ">
          <label>Contact No.</label>
          <input type="text" name="userscontact" class="form-control" value="{{ $user->contact }}">
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

@stop