@extends('layouts.master')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/user-profile.css').'?'.rand()}}">

@include('layouts.navbar')

<br><br><br><br>
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
      <!-- <a href="#" data-toggle="modal" data-target="#edit-profile-modal" class="editprof-btn pull-right"><span class="fa fa-pencil"></span></a> -->
      <div class="row prfcntnt">
        <h1 class="profile-name">{{$user->fullname}}</h1>
        @if(count($userHasBand) > 0)
        <h3>{{$userBandRole[0]->bandrole}} at {{$usersBand->band_name}}</h3>
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


  <h3>Bands Followed</h3>

      
  <div class="container" style="padding: 0;">

    <div class="container" style="padding: 0;">

        <div class="row">
        @if(count($bandsfollowed) == 0)
        <p style="text-align:center; color: #a4a4a4; font-size: 16px;">{{$user->fname}} has not followed any bands yet </p>
        @else
          <?php
          $i = 0;
          $j = $i;
          for ($i=0; $i < count($bandsfollowed); $i++) { 
            if ($i % 3 == 0) {
              echo "</div><br>";
              echo "<div class='row'>";
            }
          ?>
          <div class="col-xs-4">
            <div class="media">
              <div class="media-left">
                <img src="{{$bandsfollowed[$i]->band_pic}}" class="media-object" style="min-width:130px; height: 100%; max-height: 200px;">
              </div>
              <div class="media-body" style="padding-top: 25px;">
                <h4 class="media-heading">{{$bandsfollowed[$i]->band_name}}</h4>
                <p>{{$bandGenre[$j]->genre_name}} | {{$bandGenre[$j+1]->genre_name}}</p>
                <p>{{$bandsfollowed[$i]->num_followers}} Followers</p>
              </div>
            </div>
          </div>
          <?php $j+=2;}?>
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