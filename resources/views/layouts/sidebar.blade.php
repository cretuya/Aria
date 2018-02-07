<style>

  #bandlistdrpdwn:hover, #logoutbtn:hover{
    color: #9e9e9e;
  }

  .carousel-indicators li {
    visibility: hidden;
  }

  .navbar-form{
    box-shadow: none;
    width: 100%;
    padding-left: 20px;
    padding-right: 20px;
  }
  .nav-side-menu {
    font-family: Verdana;
    font-size: 12px;
    font-weight: 200;
    background-color: #232323;
    position: fixed;
    top: 0px;
    width: 240px;
    height: 100%;
    color: #fafafa;
  }
  
  .nav-side-menu .toggle-btn {
    display: none;
  }
  .nav-side-menu ul, .nav-side-menu li {
    list-style: none;
    padding: 0px;
    margin: 0px;
    line-height: 35px;
  }
  .nav-side-menu li {
    padding-left: 0px;
  }
  .nav-side-menu li a {
    text-decoration: none;
    color: #fafafa;
  }
  .nav-side-menu li a i {
    padding-left: 10px;
    width: 20px;
    padding-right: 20px;
  }
  
  @media (max-width: 767px) {
    .nav-side-menu {
      overflow: auto;
    }
    .navbar-form button{
      margin-top: -1px;
    }
    .nav-side-menu {
      position: relative;
      width: 100%;
      margin-bottom: 10px;
      padding-left: 20px;
      padding-right: 20px;
    }
    .nav-side-menu .toggle-btn {
      display: block;
      cursor: pointer;
      position: absolute;
      right: 10px;
      top: 10px;
      z-index: 10 !important;
      padding: 3px;
      background-color: #fafafa;
      color: #000;
      width: 40px;
      text-align: center;
    }
    .brand {
      text-align: left !important;
      font-size: 22px;
      padding-left: 20px;
      line-height: 50px !important;
    }
  }
  @media (min-width: 767px) {
    .nav-side-menu .menu-list .menu-content {
      display: block;
    }
    #main {
      width:calc(100% - 240px);
      float: right;
    }
  }

  select option:hover {
    background: #E57C1F !important;
    color: #fafafa !important;
  }

  select option{
    color: #212121;
  }

  .modal.left .modal-dialog{
      position: fixed;
      margin: auto;
      width: 360px;
      height: 100%;
      -webkit-transform: translate3d(0%, 0, 0);
          -ms-transform: translate3d(0%, 0, 0);
           -o-transform: translate3d(0%, 0, 0);
              transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content{
      height: 100%;
      overflow-y: auto;
    }
    
    .modal.left .modal-body{
      padding: 15px 15px 80px;
    }

  /*Left*/
    .modal.left.fade .modal-dialog{
      left: 240px;
      -webkit-transition: opacity 0.1s linear, left 0.1s ease-out;
         -moz-transition: opacity 0.1s linear, left 0.1s ease-out;
           -o-transition: opacity 0.1s linear, left 0.1s ease-out;
              transition: opacity 0.1s linear, left 0.1s ease-out;
    }
    
    .modal.left.fade.in .modal-dialog{
      left: 245px;
    }

</style>

<div class="nav-side-menu">
    <div class="brand"><a class="navbar-brand" href="{{ url('home')}}" style="padding: 25px;"><img src="{{ url('assets/img/ariabrand.png')}}" class="img-responsive" draggable="false"></a></div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <li>
              <form class="navbar-form" action="{{ url('search') }}" method="get" role="search">
              <div class="input-group" style="margin-top: 50px;">
                  <input type="text" class="form-control" placeholder="Search" name="search_result" style="background: transparent; color: #fafafa;">
                  <div class="input-group-btn">
                      <button class="btn btn-default" type="submit" style="background: transparent; border-color: #d9d9d9; height: 34px;"><i class="fa fa-search" style="color:#d9d9d9"></i></button>
                  </div>
              </div>
              </form>
            </li>
            <a href="{{url('home')}}">
              <li style="padding: 3px 20px">Home</li>
            </a>
            <a href="{{url('feed')}}">
              <li style="padding: 3px 20px">Feed</li>
            </a>
            <a href="{{url('charts')}}">
              <li style="padding: 3px 20px">Top Bands</li>
            </a>

            <hr style="width: 80%; margin-top: 12px;">

            <div class="row">
            <li id="sidebaruser" style="padding: 3px 20px">
              <div class="col-xs-10">
                <a href="{{url('user/profile')}}">
                  <div class="panel-thumbnail" style="background: transparent;">
                    <img src="{{session('userSocial_avatar')}}" class="img-circle" style="width: 33px; height: 33px; border: 2px solid #757575;margin: 0; display: inline;" draggable="false"> <span style="margin-left: 5px;">{{Auth::user()->fname}}</span>
                  </div>
                </a>
              </div>
              <div class="col-xs-2">
                <a href="#" data-toggle="modal" data-target="#notifModal"><span class="fa fa-bell pull-right" style="margin-top: 10px; margin-left: -15px;"></span></a>  
              </div>
            </li>
            </div>
            
            <a href="{{url('friends')}}">
              <li style="padding: 3px 20px; margin-top: 10px;">Find Friends</li>
            </a>

            <a href="#bandlistuser" id="bandlistdrpdwn" data-toggle="collapse">
              <li style="padding: 3px 20px"><span>My Bands</span><span class="caret pull-right" style="margin-top: 14px;"></span>
                <div id="bandlistuser" class="panel-collapse collapse">
                  <ul class="list-group" style="padding-left: 10px;">
                    <li><a href="#" data-toggle="modal" data-target="#create-band-modal">+ Form a band</a></li>
                    @if(Auth::user()->bandmember)
                      @foreach(Auth::user()->bandmember as $band)
                    <li>
                      <a href="{{ url($band->band->band_name.'/manage')}}">
                        @if($band->band->band_pic == null )
                        <img src="{{asset('assets/img/dummy-pic.jpg')}}" style="width: 25px; height: 25px;">&nbsp;{{ $band->band->band_name }}
                        @else
                        <img src="{{$band->band->band_pic}}" style="width: 25px; height: 25px;">&nbsp;{{ $band->band->band_name }}
                        @endif
                      </a>
                    </li>
                      @endforeach
                    @endif
                  </ul>
                </div>
              </li>
            </a>
            <li style="padding: 3px 20px"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" id="logoutbtn">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
              </li>
        </ul>
    </div>
</div>

<div id="create-band-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form method="post" action="{{url('/createband')}}">
          {{csrf_field()}}
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create a Band</h4>
      </div>
      <div class="modal-body" style="padding-left: 25px; padding-right: 25px;">
      
      <div class="row">
        <div class="col-md-6">
          Band Name: <br>
          <input type="text" class="form-control" name="band_name" required>
          <br>
          What's your role? <br>
          <select class="form-control" name="band_role_create" required>
            <option value="" selected hidden>Select Band Role</option>
            <option value="Vocalist">Vocalist</option>
            <option value="Lead Guitar">Lead Guitar</option>
            <option value="Rythm Guitar">Rythm Guitar</option>
            <option value="Keyboardist">Keyboardist</option>
            <option value="Drummer">Drummer</option>
            <option value="Bassist">Bassist</option>
          </select>
        </div>

      <?php 

      use App\Genre;

      $genres = Genre::all();

      ?>

      <div class="col-md-6">
        Primary genre <br>
        <select class="form-control" name="genre_select_1" required>
          <option value="" selected hidden>Select primary genre</option>
          @foreach($genres as $genre)
          <option value="{{$genre->genre_id}}">{{$genre->genre_name}}</option>
          @endforeach
        </select>
        <br>
        Secondary genre <br>
        <select class="form-control" name="genre_select_2" required>
          <option value="" selected hidden>Select secondary genre</option>
          @foreach($genres as $genre)
          <option value="{{$genre->genre_id}}">{{$genre->genre_name}}</option>
          @endforeach
        </select>
      </div>

      </div>
          <!-- <input type="text" class="form-control" name="band_role_create" style="text-transform: capitalize;""><br> -->
<!--           <input type="text" name="band_pic" hidden> -->
          <br>
      
      <div class="row">
        <div class="col-md-12">
        Band Description
        <textarea class="form-control" rows="6" name="bandDescr" style="resize:none;"></textarea>
        </div>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
      </div>
      </form>
    </div>
  </div>

  <!-- Slide Modal -->
    <div class="modal left fade" id="notifModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header" style="padding: 5px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Notifications</h4>
          </div>

          <div class="modal-body" style="padding: 0px; border: none; border-radius: 0px;">
            @foreach($usernotifinvite as $notificationinvite)
            <div class="media" style="padding: 5px 0px 5px 10px; border: none; margin-top: 0px;">
              <div class="media-left">
              @if($notificationinvite->band_pic == null)
              <img src="{{asset('assets/img/dummy-pic.jpg')}}" class="media-object" style="height:51px; border-radius: 4px">
              @else
              <img src="{{$notificationinvite->band_pic}}" class="media-object" style="height:51px;border-radius: 4px">
              @endif
              </div>
              <div class="media-body" style="background: transparent; padding-left: 10px; padding-top: 0px;">
                <span class="media-heading" style="font-size: 12px;">{{$notificationinvite->invitor}} of {{$notificationinvite->band_name}} has invited you to become their {{$notificationinvite->bandrole}}</span>
              </div>
              <div class="media-body" style="background: transparent; width: 3120px;">
              <form action="{{ url('ignoreRequest') }}" method="post">
                <input type="text" name="urlbeforeignore" value="{{$_SERVER['REQUEST_URI']}}" hidden>
                <input type="text" name="band_id_requested2" value="{{$notificationinvite->band_id}}" hidden>
                <input type="text" name="user_id_requested2" value="{{$notificationinvite->user_id}}" hidden>
                <input type="text" name="bandrole_requested2" value="{{$notificationinvite->bandrole}}" hidden>
                <input type="text" name="invitor_requested2" value="{{$notificationinvite->invitor}}" hidden>
                <button class="btn btn-danger pull-right" style="padding: 5px 7px; margin-right: 10px; margin-top: 9px;" title="Decline"><span class="fa fa-close"></span></button>
                {{ csrf_field() }}
              </form>
              <form action="{{ url('acceptRequest') }}" method="post">                
                <input type="text" name="band_name_requested1" value="{{$notificationinvite->band_name}}" hidden>
                <input type="text" name="band_id_requested1" value="{{$notificationinvite->band_id}}" hidden>
                <input type="text" name="user_id_requested1" value="{{$notificationinvite->user_id}}" hidden>
                <input type="text" name="bandrole_requested1" value="{{$notificationinvite->bandrole}}" hidden>
                <input type="text" name="invitor_requested1" value="{{$notificationinvite->invitor}}" hidden>
                <button class="btn btn-success pull-right" style="padding: 5px; margin-right: 5px; margin-top: -5px;" title="Accept"><span class="fa fa-check"></span></button>
                {{ csrf_field() }}
              </form>
              </div>
            </div>
            @endforeach
          </div>

        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->

<script>
  $(document).ready(function(){
    $('#drpdown').removeClass('hidden');
  });
</script>