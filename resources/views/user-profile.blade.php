@extends('layouts.master')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/user-profile.css')}}">

@include('layouts.navbar')

<br><br><br>

<div class="container-fluid">
  
  <br>
    <div class="container">
      <div class="col-md-3">
      <div class="panel panel-default">
          <div class="panel-thumbnail">
              <div class="container-profile-photo">
              <img src="{{ session('userSocial_UserPic') }}" class="img-responsive">
                <div class="overlay"></div>
                <div class="button">
                  <a href="#" data-toggle="modal" data-target="#edit-profile-modal">Edit Profile</a>
                  <!-- <a href="#" onclick="openfile()"> Change Display Picture </a><input id="anchor-file" type="file" style="display: none;"> -->
                </div>
              </div>
          </div>
            <div class="panel-body" style="padding-bottom: 0px">
              <p class="band-name-title"><a href="#">{{ session('userSocial')['first_name'] }} {{ session('userSocial')['last_name'] }}</a></p>
              <p class="band-role-name">Lead Vocalist / Keyboardist</p>
              <ul class="list-group user-profile-ul" id="accordion">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                  <li class="list-group-item">
                  Bio
                  </li>
                </a>

                <div id="collapse1" class="panel-collapse collapse in">
                  <div class="panel-body accordion-body-content" style="text-align: justify;">
                    {{ session('userSocial_Bio') }}
                  </div>
                </div>

                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                  <li class="list-group-item">
                  Basic Information
                  </li>
                </a>

                <div id="collapse2" class="panel-collapse collapse in">
                  <div class="panel-body">
                    
                    <div class="container">
                      <p class="basic-info-p"><span class="fa fa-calendar fa-fw"></span> {{ session('userSocial')['birthday'] }}</p>                      
                      <p class="basic-info-p"><span class="fa fa-map-marker fa-fw"></span> {{ session('userSocial_City') }}</p>
                      <p class="basic-info-p"><span class="fa fa-venus-mars fa-fw"></span> {{session('userSocial')['gender'] }}</p>
                      <p class="basic-info-p"><span class="fa fa-envelope fa-fw"></span> {{ session('userSocial')['email'] }}</p>
                      <p class="basic-info-p"><span class="fa fa-phone fa-fw"></span> {{ session('userSocial_Contact') }}</p>
                    </div>

                  </div>
                </div>

                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                  <li class="list-group-item">
                    Recent Bands Viewed
                  </li>
                </a>

                <div id="collapse3" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <div class="row">

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                    </div>
                  </div>
                </div>

                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                  <li class="list-group-item">
                    Recent Albums Viewed
                  </li>
                </a>

                <div id="collapse4" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <div class="row">

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                        <div class="media" style="padding-left: 7px; padding-right: 7px;">
                          <span class="media-left">
                              <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
                          </span>
                          <div class="media-body">
                              <a href="#"><span class="media-heading recent-viewed-heading">Linkin Park</span></a><br>
                              <span class="recent-viewed-detail">Alternative Rock / Alternative Metal</span>
                          </div>
                        </div>

                    </div>
                  </div>
                </div>

              </ul>
            </div>
      </div>
      </div>

      <div class="col-md-7" id="feed-section" style="overflow-y: scroll;">
              
        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/25/2017 8:22 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            We will be having our next gig on July 29 at Tonyo's Bar & Restaurant! See you there! 
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/oln.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Our Last Night</a> posted an update</h4>
                  <span class="feed-time-stamp">07/20/2017 3:20 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Purchase our new album "Younger Dreams Here: https://itunes.apple.com/us/album/you<br><br>Also Check out<br>https://www.ourlastnight.com for Merchandise & everything OLN!
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/25/2017 8:22 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            We will be having our next gig on July 29 at Tonyo's Bar & Restaurant! See you there! 
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/25/2017 8:22 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            We will be having our next gig on July 29 at Tonyo's Bar & Restaurant! See you there! 
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/25/2017 8:22 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            We will be having our next gig on July 29 at Tonyo's Bar & Restaurant! See you there! 
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/25/2017 8:22 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            We will be having our next gig on July 29 at Tonyo's Bar & Restaurant! See you there! 
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/25/2017 8:22 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            We will be having our next gig on July 29 at Tonyo's Bar & Restaurant! See you there! 
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/25/2017 8:07 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            We will be posting a backing track by Brad Delson for those fans who would like to practice their solos soon! Keep updated folks! :)
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/oln.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Our Last Night</a> posted an update</h4>
                  <span class="feed-time-stamp">07/20/2017 3:20 PM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Purchase our new album "Younger Dreams Here: https://itunes.apple.com/us/album/you<br><br>Also Check out<br>https://www.ourlastnight.com for Merchandise & everything OLN!
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/7/2017 7:41 AM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Now that was a hell of a concert! Thank you Birmingham’s Barclaycard Arena!
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/7/2017 7:41 AM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Now that was a hell of a concert! Thank you Birmingham’s Barclaycard Arena!
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/7/2017 7:41 AM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Now that was a hell of a concert! Thank you Birmingham’s Barclaycard Arena!
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/7/2017 7:41 AM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Now that was a hell of a concert! Thank you Birmingham’s Barclaycard Arena!
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/7/2017 7:41 AM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Now that was a hell of a concert! Thank you Birmingham’s Barclaycard Arena!
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading" style="background: transparent; border: none">
            <div class="media">
              <span class="media-left">
                  <a href="#"><img class="band-pic-feed-header" src="{{asset('assets/img/band-pic.jpg')}}"></a>
              </span>
              <div class="media-body">
                  <h4 class="media-heading"><a href="#">Linkin Park</a> posted an update</h4>
                  <span class="feed-time-stamp">07/7/2017 7:41 AM</span>
              </div>
            </div>
          </div>
          <div class="panel-body" style="padding-top: 5px;">
            Now that was a hell of a concert! Thank you Birmingham’s Barclaycard Arena!
          </div>
        </div>

      </div>

      <div class="col-md-2">
          <h4>Suggested Bands</h4>
          <br>
          <div class="card card-inverse card-info">
              <div class="card-block">
                  <figure class="profile">
                      <img src="{{asset('assets/img/oln.jpg')}}" class="profile-avatar img-responsive" alt="">
                  </figure>
                  <a href=""><h4 class="card-title">Our Last Night</h4></a>
                  <div class="meta card-text">
                      <span>Post hardcore / Alternative Metal</span>
                  </div>
                  <!-- <div class="card-text">
                      Tawshif is a web designer living in Bangladesh.
                  </div> -->
              </div>
              <div class="card-footer">
                <div class="col-sm-8" style="padding: 0px 0px 10px 0px">
                  <small>Kirster Kyle Quinio and 123 others followed this band</small>
                </div> 
                <div class="col-sm-4" style="padding: 0px 0px 10px 0px">
                  <button class="btn btn-info pull-right btn-sm">Follow</button>
                </div>
              </div>
          </div>

          <br>

          <div class="card card-inverse card-info">
              <div class="card-block">
                  <figure class="profile">
                      <img src="{{asset('assets/img/oln.jpg')}}" class="profile-avatar img-responsive" alt="">
                  </figure>
                  <a href=""><h4 class="card-title">Our Last Night</h4></a>
                  <div class="meta card-text">
                      <span>Post hardcore / Alternative Metal</span>
                  </div>
                  <!-- <div class="card-text">
                      Tawshif is a web designer living in Bangladesh.
                  </div> -->
              </div>
              <div class="card-footer">
                <div class="col-sm-8" style="padding: 0px 0px 10px 0px">
                  <small>Kirster Kyle Quinio and 123 others followed this band</small>
                </div> 
                <div class="col-sm-4" style="padding: 0px 0px 10px 0px">
                  <button class="btn btn-info pull-right btn-sm">Follow</button>
                </div>
              </div>
          </div>

          <br>

          <h4>Suggested Albums</h4>
          <br>
          <div class="card card-inverse card-info">
              <div class="card-block">
                  <figure class="profile">
                      <img src="{{asset('assets/img/album-oln.jpg')}}" class="profile-avatar img-responsive" alt="">
                  </figure>
                  <a href="#"><h4 class="card-title">Selective Hearing</h4></a>
                  <div class="meta card-text">
                      <a href="#">Our Last Night</a>
                  </div>
                  <!-- <div class="card-text">
                      Tawshif is a web designer living in Bangladesh.
                  </div> -->
              </div>
          </div>

          <br>
          <div class="card card-inverse card-info">
              <div class="card-block">
                  <figure class="profile">
                      <img src="{{asset('assets/img/album-oln.jpg')}}" class="profile-avatar img-responsive" alt="">
                  </figure>
                  <a href="#"><h4 class="card-title">Selective Hearing</h4></a>
                  <div class="meta card-text">
                      <a href="#">Our Last Night</a>
                  </div>
                  <!-- <div class="card-text">
                      Tawshif is a web designer living in Bangladesh.
                  </div> -->
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
          <input type="text" class="form-control" name="band_role_create" style="text-transform: capitalize;""><br>
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
        <input type="text" name="usersname" class="form-control" value="{{session('userSocial')['first_name'] }} {{ session('userSocial')['last_name']}}" disabled>
        <label>Birthdate</label>
        <input type="text" name="usersbod" class="form-control" value="{{session('userSocial')['birthday'] }}" disabled>
        <label>City/Town</label>
        <input type="text" name="userscity" class="form-control" value="{{ session('userSocial_City') }}">
        <label>Gender</label>
        <input type="text" name="usersgender" class="form-control" value="{{ session('userSocial')['gender'] }}" disabled>
        <label>Email</label>
        <input type="text" name="usersemail" class="form-control" value=" {{ session('userSocial')['email'] }} ">
        <label>Contact No.</label>
        <input type="text" name="userscontact" class="form-control" value=" {{ session('userSocial_Contact') }} ">
        <label>Bio</label>
        <textarea name="usersbio" class="bio-textarea" rows="4">{{ session('userSocial_Bio') }}</textarea>
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