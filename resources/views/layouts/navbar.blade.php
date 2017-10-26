  <nav class="navbar navbar-default navbar-fixed-top" style="box-shadow: 0 1px 3px rgba(0,0,0,0.12)">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="{{ url('feed')}}"><img src="{{ url('assets/img/arialogo.png')}}" class="img-responsive" style="width: 45px;"></a>
        <a class="navbar-brand" href="{{ url('feed')}}"><span>ARIA</span></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">        
        <ul class="nav navbar-nav">
          <li><a href="{{ url('discover')}}">Explore</a></li>
          <li><a href="{{ url('charts') }}">Top Charts</a></li>
        </ul>
        <div class="col-sm-3 col-md-3">
            <form class="navbar-form" action="{{ url('search') }}" method="get" role="search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="search_result">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" style="background: #F9A825; border-color: #F9A825"><i class="fa fa-search" style="color:#ffffff"></i></button>
                </div>
            </div>
            </form>
        </div>
        <ul class="nav navbar-nav navbar-right">

          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="background: #F9A825"><span class="fa fa-envelope" style="color: #fff;"></span></a>
          <ul class="dropdown-menu" style="width: 400px;">
            <li class="dropdown-header">Band Invitations</li>
            <li class="divider"></li>
            
            <a href="#">
            <li style="padding: 5px;">

              @foreach($usernotifinvite as $notificationinvite)
              <div class="media" style="padding: 5px;">
                <div class="media-left">
                  <img src="{{$notificationinvite->band_pic}}" class="media-object img-circle" style="width:50px;">
                </div>
                <div class="media-body" style="padding-left: 10px;">
                  <span class="media-heading" style="font-size: 13px;">{{$notificationinvite->invitor}} of {{$notificationinvite->band_name}} has invited you to become their {{$notificationinvite->bandrole}}</span>
                </div>
                <div class="media-body" style="width: 4515px; padding-top: 10px;">
                <form action="{{ url('ignoreRequest') }}" method="post">
                  <input type="text" name="urlbeforeignore" value="{{$_SERVER['REQUEST_URI']}}" hidden>
                  <input type="text" name="band_id_requested2" value="{{$notificationinvite->band_id}}" hidden>
                  <input type="text" name="user_id_requested2" value="{{$notificationinvite->user_id}}" hidden>
                  <input type="text" name="bandrole_requested2" value="{{$notificationinvite->bandrole}}" hidden>
                  <input type="text" name="invitor_requested2" value="{{$notificationinvite->invitor}}" hidden>
                  <button class="btn btn-danger pull-right" style="padding: 5px; margin-right: 10px">Ignore</button>
                  {{ csrf_field() }}
                </form>
                <form action="{{ url('acceptRequest') }}" method="post">                
                  <input type="text" name="band_name_requested1" value="{{$notificationinvite->band_name}}" hidden>
                  <input type="text" name="band_id_requested1" value="{{$notificationinvite->band_id}}" hidden>
                  <input type="text" name="user_id_requested1" value="{{$notificationinvite->user_id}}" hidden>
                  <input type="text" name="bandrole_requested1" value="{{$notificationinvite->bandrole}}" hidden>
                  <input type="text" name="invitor_requested1" value="{{$notificationinvite->invitor}}" hidden>
                  <button class="btn btn-success pull-right" style="padding: 5px; margin-right: 5px">Accept</button>
                  {{ csrf_field() }}
                </form>
                </div>
              </div>
              @endforeach

            </li>
            </a>
          </ul>
          </li>

          <li>
            <a href="{{url('user/profile')}}">
            <ul class="nav navbar-nav">
              <li><img src="{{ session('userSocial_avatar') }}" class="img-responsive img-circle" style="width: 30px; height: 30px; margin-top: -6px; margin-right: 7px;"></li>
              <li>{{ session('userSocial')['first_name'] }}</li>
            </ul>
            </a>
          </li>          

          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="background: transparent;"><span class="caret" style="color: #F9A825"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" data-toggle="modal" data-target="#create-band-modal">+ Form a band</a></li>
            @if(Auth::user()->bandmember)
              @foreach(Auth::user()->bandmember as $band)
            <li><a href="{{ url($band->band->band_name.'/manage')}}"><img src="{{$band->band->band_pic}}" style="width: 25px; height: 25px;">&nbsp;{{ $band->band->band_name }}</a></li>
              @endforeach
            @endif
            <li><a href="#">My Account</a></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            </li>
          </ul>
          </li>

        </ul>

      </div>
    </div>
  </nav>


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