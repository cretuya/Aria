
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">Aria Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="#">Discover</a></li>
        <li><a href="#">Top Charts</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ session('userSocial')['first_name'] }}
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#" data-toggle="modal" data-target="#create-band-modal">+ Form a band</a></li>
          <li><a href="#"><img src="img/band-pic.jpg" style="width: 25px;">Linkin Park</a></li>
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