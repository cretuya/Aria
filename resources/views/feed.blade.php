@extends('layouts.master')

@section('content')

@include('layouts.navbar')

<br><br><br><br>
  <div class="container">
    

    <div class="col-md-8" id="feed-section">
            
      <div class="panel panel-default">
        <div class="panel-heading pnlhead-feed">
          <a href="#"><img class="feed-band-pic img-circle" src="img/oln.jpg"></a>
          <a href="#"><span class="feed-band-name">Our Last Night</span></a>
          <span class="feed-timestamp-time pull-right">16:32</span>
          <span class="feed-timestamp-date pull-right">Oct 30</span>
        </div>
        <div class="panel-body feed-content">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading pnlhead-feed">
          <a href="#"><img class="feed-band-pic img-circle" src="img/oln.jpg"></a>
          <a href="#"><span class="feed-band-name">Our Last Night</span></a>
          <span class="feed-timestamp-time pull-right">16:32</span>
          <span class="feed-timestamp-date pull-right">Oct 30</span>
        </div>
        <div class="panel-body feed-content">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading pnlhead-feed">
          <a href="#"><img class="feed-band-pic img-circle" src="img/oln.jpg"></a>
          <a href="#"><span class="feed-band-name">Our Last Night</span></a>
          <span class="feed-timestamp-time pull-right">16:32</span>
          <span class="feed-timestamp-date pull-right">Oct 30</span>
        </div>
        <div class="panel-body feed-content">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading pnlhead-feed">
          <a href="#"><img class="feed-band-pic img-circle" src="img/oln.jpg"></a>
          <a href="#"><span class="feed-band-name">Our Last Night</span></a>
          <span class="feed-timestamp-time pull-right">16:32</span>
          <span class="feed-timestamp-date pull-right">Oct 30</span>
        </div>
        <div class="panel-body feed-content">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading pnlhead-feed">
          <a href="#"><img class="feed-band-pic img-circle" src="img/oln.jpg"></a>
          <a href="#"><span class="feed-band-name">Our Last Night</span></a>
          <span class="feed-timestamp-time pull-right">16:32</span>
          <span class="feed-timestamp-date pull-right">Oct 30</span>
        </div>
        <div class="panel-body feed-content">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading pnlhead-feed">
          <a href="#"><img class="feed-band-pic img-circle" src="img/oln.jpg"></a>
          <a href="#"><span class="feed-band-name">Our Last Night</span></a>
          <span class="feed-timestamp-time pull-right">16:32</span>
          <span class="feed-timestamp-date pull-right">Oct 30</span>
        </div>
        <div class="panel-body feed-content">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>

    </div>

    <div class="col-md-4">
        
    <center><h4>Friends who joined Aria</h4></center>
    <br>

    <div class="panel panel-default">
      <div class="panel-body" style="padding-left: 35px; padding-right: 35px;">

      <div class="row">
      <ul class="list-group" style="margin-bottom: 0px;">
        @if($friends == null)
        @else
          @foreach($friends as $friend)
            <li class="list-group-item" style="border: 0">
              <a href="#"><img class="friends-in-aria-pic img-circle" src="{{$friend->profile_pic}}"></a>
              <a href="{{url('feed/'.$friend->user_id)}}"><span class="feed-band-name">{{$friend->fullname}}</span></a>
            </li>
          @endforeach
        @endif
      </ul>
      </div>

      </div>
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

@stop