
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="{{ url('user/profile')}}">Aria Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="{{ url('discover')}}">Discover</a></li>
        <li><a href="#">Top Charts</a></li>
      </ul>
      <div class="col-sm-3 col-md-3">
          <form class="navbar-form" action="{{ url('search') }}" method="get" role="search">
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" name="search_result">
              <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
          </div>
          </form>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ session('userSocial')['first_name'] }}
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#" data-toggle="modal" data-target="#create-band-modal">+ Form a band</a></li>
          @if(Auth::user()->bandmember)
            @foreach(Auth::user()->bandmember as $band)
          <li><a href="{{ url($band->band->band_name.'/manage')}}"><img src="{{ url('assets/'.$band->band->band_id.' - '.$band->band->band_name.'/'.$band->band->band_pic)}}" style="width: 25px;">&nbsp;{{ $band->band->band_name }}</a></li>
            @endforeach
          @endif
          <li><a href="#">My Account</a></li>
          <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
      </li>
      </ul>
    </div>
  </div>
</nav>