@extends('layouts.master')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dashboard-manage-band.css').'?'.rand()}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/awesome-bootstrap-checkbox.css').'?'.rand()}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dropdown-animation.css').'?'.rand()}}">

<style>
  .carousel-control.left button, .carousel-control.right button{
  color: #212121;
  background: #fafafa;
  border: 1px solid #bdbdbd;
  padding: 5px 15px;
  font-size: 14px;
}

.carousel-control.left, .carousel-control.right{
  background: none !important;
  opacity: 1 !important;
}

.carousel-control{
  position: static !important;
  text-shadow: none !important;
}

.ellipsisAlbum:hover{
  color: #E57C1F !important;
}

input[type='range']{
  -webkit-appearance: none !important;
  background: #E57C1F;
  cursor: pointer;
  height: 5px;
  outline: none !important;
}

input[type='range']::-webkit-slider-thumb{
  -webkit-appearance: none !important;
  background: #e4e4e4;
  height: 12px;
  width: 12px;
  border-radius: 100%;
  cursor: pointer;
}

.band-description-txtarea::-webkit-scrollbar
{
  width: 0px;
}

.dashboard-tablesection::-webkit-scrollbar{
  width: 2px;
}

</style>

@include('layouts.sidebar')
<body>
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<br><br><br><br><br><br>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($band->band_coverpic == null)
<div id="bandBanner" class="panel-thumbnail" style="background: url({{asset('assets/img/banner.jpeg')}}) no-repeat center;">
  &nbsp;
</div>
<div id="bandBannerGradient" class="panel-thumbnail">
  &nbsp;
</div>
@else
<div id="bandBanner" class="panel-thumbnail" style="background: url({{$band->band_coverpic}}) no-repeat center;">
  &nbsp;
</div>
<div id="bandBannerGradient" class="panel-thumbnail">
  &nbsp;
</div>
@endif

<br><br><br><br><br><br><br>

<button class="btn btn-default" style="background: transparent; color: #fafafa; position: absolute; right: 25px;" onclick="openfile2();">Change cover photo</button>
<form id = "band-coverpic-form" method="post" action="{{url('/editbandCoverPic')}}" enctype="multipart/form-data">
{{csrf_field()}}
  <input type="text" value="{{$band->band_id}}" name="bandId"  hidden>
  <input type="text" value="{{$band->band_name}}" name="bandName" hidden>
  <input id="anchor-file-2" type="file" name="bandCoverPic" style="display: none;">
  <input type="Submit" id ="submitForm2" hidden />
</form>
<br>
<div class="container" id="main" style="background: #161616; padding-left: 30px; padding-right: 30px;">

    <div class="row">
        <div class="col-md-12">
            <div class="row" style="margin-left: 0px;">
            <br><br>
              <span class="manage-band-heading">Manage Band</span>
              <span class="btn btn-default pull-right" onclick="saveBand();" style="background: #E57C1F; color: #fafafa; border-color: #E57C1F; margin-right: 12px;">Save changes</span>
              <a href="{{url('/'.$band->band_name)}}"><span class="btn btn-default pull-right" style="margin-right: 10px; background: transparent; color: #fafafa">View Band Profile</span></a>
              <span class="btn btn-default pull-right hidden" style="margin-right: 10px;" data-toggle="modal" data-target="#invite-modal">Invite</span>
            </div>

            
            <input type="text" value="{{$band->band_id}}" name="bandId" hidden>
            <div class="row">
              <div class="col-md-3">
              <br>
                <div class="container-profile-photo">
                @if($band->band_pic == null)
                <center>
                <div class="panel-thumbnail">
                  <img src="{{asset('assets/img/dummy-pic.jpg')}}" class="img-responsive" style="height: 245px; width: 100%; border: 2px solid #fafafa;">
                </div>
                </center>
                @else
                <center>
                <div class="panel-thumbnail">
                  <img src="{{$band->band_pic}}" class="img-responsive" style="height: 245px; width: 100%; border: 2px solid #fafafa;">
                </div>
                </center>
                @endif
                  <div class="overlay"></div>
                  <div class="button" style="padding-top: 3px; padding-bottom: 3px; background: #E57C1F;">
                    <a href="#" onclick="openfile()" style="font-size: 12px; letter-spacing: 1px;"> Change Display Picture </a>
                    <form id = "band-pic-form" method="post" action="{{url('/editbandPic')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                      <input type="text" value="{{$band->band_id}}" name="bandId"  hidden>
                      <input type="text" value="{{$band->band_name}}" name="bandName" hidden>
                      <input id="anchor-file" type="file" name="bandPic" style="display: none;">
                      <input type="Submit" id = "submitForm" hidden />
                    </form>
                  </div>
                </div>
              </div>
              <br>
              <form method="post" id="save-band-form" action="{{url('/editband')}}">
            {{csrf_field()}}
              <div class="col-md-3">
                <input type="text" value="{{$band->band_id}}" name="bandId"  hidden>
                <input id="bandName" class="band-name-title-manage edit-field" name="bandName" value="{{$band->band_name}}">
                <textarea class="band-description-txtarea" name="bandDesc" placeholder="About the band">{{$BandDetails->band_desc}}</textarea>
              </div>

              <?php
              $checker = 0;
              $counter = 0;
              ?>

              <div class="col-md-6" style="max-height: 270px;">
                    <h4>Choose 2 main genres</h4>
                      <div class="row">
                         <div class="col-xs-4">
                          @foreach($genres as $genre)
                          <?php 
                          if($counter == 6){
                            echo "</div>";
                            echo "<div class='col-xs-4'>";
                            $counter = 0;
                          }
                          ?>
                            @foreach($bandGenreSelected as $genreSelected)
                              @if($genre->genre_id == $genreSelected->genre_id)
                                <div class="checkbox">
                                  <label class="checkbox-form-control">                           
                                  <input type="checkbox" name="genres[]" class="checkboxGenre" value="{{$genre->genre_id}}" checked>
                                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>{{$genre->genre_name}}</label>
                                </div>
                                <?php $checker = 1; ?>
                              @endif

                            @endforeach

                               @if($checker == 0 )
                               <div class="checkbox">
                                 <label class="checkbox-form-control">
                                 <input type="checkbox" name="genres[]" class="checkboxGenre" value="{{$genre->genre_id}}">
                                 <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                 {{$genre->genre_name}}</label>
                               </div>

                               @endif
                                <?php $checker = 0; ?>
                                <?php $counter++; ?>
                           @endforeach
                      </div>
                    </div>
              </div>                  
            </form>

            </div>
            <br>
              
          <div class="row">
           <div class="col-md-7 dashboard-tablesection" style="max-height: 450px; overflow-y: scroll;">
               <table class="table">
                <thead><h4>Events</h4></thead>
                 <tr>
                   <td>Mar 08</td>
                   <td>Slim's</td>
                   <td>4:00 PM</td>
                   <td>San Francisco, CA</td>
                 </tr>
                 <tr>
                   <td>Mar 10</td>
                   <td>Hawthrone Theatre</td>
                   <td>5:00 PM</td>
                   <td>Portland, OR</td>
                 </tr>
                 <tr>
                   <td>Mar 08</td>
                   <td>Slim's</td>
                   <td>4:00 PM</td>
                   <td>San Francisco, CA</td>
                 </tr>
                 <tr>
                   <td>Mar 10</td>
                   <td>Hawthrone Theatre</td>
                   <td>5:00 PM</td>
                   <td>Portland, OR</td>
                 </tr>
                 <tr>
                   <td>Mar 08</td>
                   <td>Slim's</td>
                   <td>4:00 PM</td>
                   <td>San Francisco, CA</td>
                 </tr>
                 <tr>
                   <td>Mar 10</td>
                   <td>Hawthrone Theatre</td>
                   <td>5:00 PM</td>
                   <td>Portland, OR</td>
                 </tr>
               </table>
           </div>
           <div class="col-md-5 dashboard-tablesection" style="max-height: 450px; overflow-y: scroll;">
           <!-- <div class="col-md-12" style="height: 263px;max-height: 263px;"> -->
             <h4>Band Members</h4>
             <br>

             <form method="post" action="{{url('/addmember')}}">
                 {{csrf_field()}}
             <div class="row" id="band-member-section">
               <div class="col-xs-4">
                 <label for="add-band-member-name">Add Member</label>
                 <input type="text" class="form-control" id="add-band-member-name" name="add-band-member-name" placeholder="Enter a name">
                 <input type="text" id="add-band-member-id" name="add-band-member-id" hidden>
                 <input type="text" id="add-band-member-band-id" name="add-band-member-band-id" value="{{$band->band_id}}" hidden>
                 <input type="text" id="add-band-member-band-name" name="add-band-member-band-name" value="{{$band->band_name}}" hidden>
                 <div id="dummyContainer"></div>
               </div>
               <input type="text" name="member-user-id" hidden>
               <div class="col-xs-4">      
                 <label for="add-band-member">Role</label>
                 <select id="add-band-member-role" class="form-control" name="add-band-member-role">
                   <option hidden>Select Role</option>
                   <option value="Vocalist">Vocalist</option>
                   <option value="Lead Guitar">Lead Guitar</option>
                   <option value="Rythm Guitar">Rythm Guitar</option>
                   <option value="Keyboardist">Keyboardist</option>
                   <option value="Drummer">Drummer</option>
                   <option value="Bassist">Bassist</option>
                 </select>
               </div>

               <div class="col-xs-4">
                 <label>&nbsp;</label>                 
                 <button class="btn btn-default add-member-btn">Add Member</button>
               </div>
             </div>
             </form>

             <table class="table table-hover" style="margin-top: 5px;">
             
             @foreach($bandmembers as $members)
             
             <form id="bandmemberform" method="post" action="{{url('/deletemember')}}">
             <span style="margin-top: 20px;">&nbsp;</span>
             {{csrf_field()}}
               <tr>
                 <td class="hidden"><input type="text" name="band-member-id" class="member-id" value="{{$members->user->user_id}}"></td>
                 <td class="hidden"><input type="text" name="band-id" value="{{$band->band_id}}"></td>
                 <td><input type="text" name="band-member-name" class="member-name" style="border: none; background: transparent;" value="{{$members->user->fullname}}" readonly></td>
                 <td><input type="text" name="band-member-role" class="member-role" style="border: none; background: transparent;" value="{{$members->bandrole}}" readonly></td>
                 <input type="text" value="{{$band->band_name}}" name="bandName" hidden>
                 <!-- <td><a href="#"><span class="fa fa-pencil"></span></a></td> -->
                 <td><button type="submit" style="background: transparent; border: none;" class="fa fa-close"></button></td>
               </tr>
             </form>
             @endforeach

               <!-- 
               <tr>
                 <td><span class="member-name">Chester Bennington</span></td>
                 <td><span class="member-role">Vocalist</span></td>
                 <td><a href="#"><span class="fa fa-pencil"></span></a></td>
                 <td><a href="#"><span class="fa fa-close"></span></a></td>
               </tr>
               <tr>
                 <td><span class="member-name">Chester Bennington</span></td>
                 <td><span class="member-role">Vocalist</span></td>
                 <td><a href="#"><span class="fa fa-pencil"></span></a></td>
                 <td><a href="#"><span class="fa fa-close"></span></a></td>
               </tr>
               <tr>
                 <td><span class="member-name">Chester Bennington</span></td>
                 <td><span class="member-role">Vocalist</span></td>
                 <td><a href="#"><span class="fa fa-pencil"></span></a></td>
                 <td><a href="#"><span class="fa fa-close"></span></a></td>
               </tr> -->

               
             </table>

            </div>
           </div>

            <br>

            
            <div class="row">
              <div class="col-md-12">
                <div class="panel" style="background: transparent;">
                  <div class="panel-heading"><h4>Videos<button class="btn pull-right" style="margin-top: -5px; background: #E57C1F;" data-toggle="modal" data-target="#video-upload-modal">Upload a video</button></h4></div>
                  <div class="panel-body" style="margin-left: -15px">

                  <!-- ari ang foreach-->
                  <div id="showVideos">
                  @if(count($videos) == 0)
                  <center><p>No videos were found</p></center>
                  @else
                    @foreach($videos as $video)
                      
                  <div class="col-md-3">

                    <div id="video-content{{$video->video->video_id}}" onclick="videoOpen({{$video->video->video_id}});">
                    <video style="background: #000; width: 100%; height: inherit; cursor:pointer;" class="embed-responsive-item vidContent{{$video->video->video_id}}" data-content="{{asset('assets/video/'.$video->video->video_content)}}">
                        <source src="{{asset('assets/video/'.$video->video->video_content)}}">
                    </video>
                    </div>

                    <div class="dropdown pull-right" style="position: absolute; top: 5px; right: 20px">
                      <button class="dropdown-toggle" type="button" data-toggle="dropdown" style="background: #444; border: none;"><span class="fa fa-ellipsis-h ellipsisProfile pull-right" style="font-size: 14px; margin-left: 0px;"></span></button>
                      <ul class="dropdown-menu">
                        <a href="#" class="edit actions" data-toggle="modal" data-title="{{$video->video->video_title}}" data-desc="{{$video->video->video_desc}}" data-id="{{$video->video->video_id}}"><li>Edit Video Details</li></a>
                        <a href="{{'../'.$band->band_name.'/deleteVideo/'.$video->video->video_id}}" class="delete actions"><li>Delete Video</li></a>
                      </ul>
                    </div>
                    <div>
                      <a href="#" style="font-size: 12px;" onclick="videoOpen({{$video->video->video_id}});">{{$video->video->video_title}}</a>
                      <br>
                      <span style="font-size: 12px">{{$band->band_name}}</span>
                    </div>
                    
                    <!-- <p style="font-size: 11px">32 Views</p> -->
                    
                  </div>
                    @endforeach
                  @endif
                   </div>

                  </div>
                </div>
              </div>

            </div>

            <br>

            <div class="row">
              <div class="col-md-12">
                <div class="panel" style="background: transparent;">
                  <div class="panel-heading"><h4>Albums<button class="btn pull-right" style="margin-top: -10px; background: #E57C1F" data-toggle="modal" data-target="#add-album-modal">Add an album</button></h4></div>
                  <div class="panel-body" style="margin-left: -30px; margin-right: -15px;">
                    <div class="col-xs-12">

                      <div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-right: -15px">
                        <!-- Indicators -->
                        <ol class="carousel-indicators hidden">
                          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                          <li data-target="#myCarousel" data-slide-to="1"></li>
                          <li data-target="#myCarousel" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                          <div class="item active">


                          @if(count($albums) == 0)
                          <center><p>No albums were found</p></center>
                          @else
                                <?php 
                                $count=0;
                                for($i=0; $i < count($albums) ; $i++) {  

                                if($count == 6){
                                    echo "</div>";
                                    echo "<div class='item'>";
                                    $count=0;
                                } 

                                ?>
                                    
                                <div class="col-xs-2">
                                  @if($albums[$i]->album_pic == null)
                                  <a href="{{url($band->band_name.'/albums/'.$albums[$i]->album_id)}}"><img src="{{asset('assets/img/dummy-pic.jpg')}}" class="img-responsive">
                                  </a>
                                  @else
                                  <a href="{{url($band->band_name.'/editAlbum/'.$albums[$i]->album_id)}}"><img src="{{$albums[$i]->album_pic}}" class="img-responsive">
                                  </a>
                                  @endif
                                  <a href="{{url($band->band_name.'/editAlbum/'.$albums[$i]->album_id)}}"><p style="text-align: center; margin-top: 5px;">{{$albums[$i]->album_name}}</p>
                                  </a>
                                  <p style="font-size: 11px; text-align: center; margin-top: -10px;">Released: 23 Aug 2008</p>

                                  
                                  <center>
                                  <div class="dropup">
                                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" style="background: transparent; border: none;"><span class="fa fa-ellipsis-h ellipsisAlbum pull-right" style="font-size: 16px;"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                      <li class="editprofActions2"><span class="btn addSong" data-toggle="modal" data-target="">Add song to album</span></li>
                                      <li class="editprofActions2"><span class="btn editAlbum" data-name="{{$albums[$i]->album_name}}" data-id="{{$albums[$i]->album_id}}" data-desc="{{$albums[$i]->album_desc}}" data-toggle="modal" data-target="#edit-album-modal">Edit album</span></li>
                                      <li class="editprofActions2"><span class="btn deleteAlbum" data-toggle="modal" data-target="">Delete album</span></li>
                                    </ul>
                                  </div>
                                  </center>                               

                                </div>


                                <?php $count++;} ?>
                          @endif

                          </div>
                        </div>

                        <div style="margin-left: 15px">
                        <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                              <button class="fa fa-chevron-left"></button>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                              <button class="fa fa-chevron-right"></button>
                              <span class="sr-only">Next</span>
                            </a>
                        </div>
                        
                      </div>

                      
                    </div>
                </div>
                </div>
              </div>
            </div>

      {{--
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default" style="background: transparent; border: none;">
          <div class="panel-heading" style="background: transparent; border: none;"><h4 style="color: #fafafa">Articles<button class="btn btn-default pull-right" data-toggle="modal" data-target="#add-article-modal" style="background: #E57C1F; color: #fafafa; border: 1px solid #E57C1F">Add new article</button></h4></div>
          <div class="panel-body">

          <div id="showArticles">
          @if ($articles == null)
          @else
           @foreach ($articles as $article)

           <a href="{{'../'.$band->band_name.'/viewArticle/'.$article->art_id}}">{{$article->article->art_title}}</a> <button class="btn pull-right delete" style="background: none;" value="{{$article->art_id}}"><span class="fa fa-close"></span></button><button class="btn pull-right edit" style="background: none;" data-toggle="modal" data-content="{{$article->article->content}}" data-title="{{$article->article->art_title}}" data-id="{{$article->art_id}}"><span class="fa fa-pencil"></span></button>
           <br><br>

           @endforeach
          @endif
          </div>


          </div>
        </div>
      </div>

      <br><br>

      </div>
      --}}

    </div>
  </div>
</div>

<!-- Video Modals -->

<!-- Add Video Modal -->
<div id="video-upload-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addVideo'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Video</h4>
      </div>
      <div class="modal-body">
            Video Title
            <input type="text" name="video_title" class="form-control">
            Video Description:<br>
            <textarea name='video_desc' class='form-control' rows="6" required></textarea> <br>            
            Add Video:<br>
            <input type='file' name='video_content[]' class="btn btn-default" accept="video/*" multiple required><br><br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Video Modal -->
<div id="video-edit-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateVideo'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Video</h4>
      </div>
      <div class="modal-body">
            
            Video Title
            <input type="text" id="video_title" name="video_title" class="form-control">
            Video Description:<br>
            <textarea name='video_desc' id='video_desc' class='form-control' rows="6"></textarea> <br><br> 
            <input type="text" id="video_id" name="video_id" hidden>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- Add Album Modal -->
<div id="add-album-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addAlbum'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Album</h4>
      </div>
      <div class="modal-body">
        
            Album Title:<br>
            <input type='text' name='album_name' class='form-control' required><br>
            Description:<br>
            <input type='text' name='album_desc' class='form-control' required><br>
            Add Album Picture:<br>
            <input type='file' name='album_pic'  class='form-control' accept="image/*" required><br><br>            
            <br>


      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Album Modal -->
<div id="edit-album-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateAlbum'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Album</h4>
      </div>
      <div class="modal-body">
        
            Album Title:<br>
            <input type='text' name='album_name' id="album_name" class='form-control'><br>
            Description:<br>
            <input type='text' name='album_desc' id="album_desc" class='form-control'><br>
            <br>
            <input type="text" id="album_id" name="album_id" hidden><br>
            <br>

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- Add Article Modal -->
<div id="add-article-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addArticle'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Article</h4>
      </div>
      <div class="modal-body">
        
            Title of Article:<br>
            <input type='text' name='art_title' class='form-control' required><br><br>
            Content:<br>
            <textarea name='content' id="content" class='form-control' required></textarea><br><br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Article Modal -->
<div id="edit-article-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateArticle'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Article</h4>
      </div>
      <div class="modal-body">
        
            Title of Article:<br>
            <input type='text' name='art_title' id="art_title" class='form-control'><br><br>
            Content:<br>
            <textarea name='content' id="content" class='form-control'></textarea><br><br>
            <input type="text" name="art_id" id="art_id" hidden>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- Add Song Modal -->
<div id="add-song-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/addSongs'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Song</h4>
      </div>
      <div class="modal-body">
        Song Title:<br>
        <input type="text" name="song_title"  class='form-control' required>
        Song Description:<br>
        <input type="text" name="song_desc"  class='form-control' required>
        Song File
        <input type="file" name="song_audio[]" class='form-control' accept="audio/*" multiple required>
        <input type="text" name="album_id" id="album_id" hidden>
        Song Genre
        <select name="genre_id" class='form-control'>
            @foreach($genres as $genre)
            <option value="{{$genre->genre_id}}">{{$genre->genre_name}}</option>
            @endforeach
        </select>
        <br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default" >Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Edit Song Modal -->
<div id="edit-song-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="{{'../'.$band->band_name.'/updateSong'}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Song</h4>
      </div>
      <div class="modal-body edit-modal">
        Song Title:<br>
        <input type="text" name="song_title" id="song_title" class='form-control'><br><br>
        Song Description:<br>
        <input type="text" name="song_desc" id="song_desc" class='form-control'><br><br>

        <div class="showgenre">
        <select name="genre_id" id="genre_id" class='form-control'>
            @foreach($genres as $genre)
            <option value="{{$genre->genre_id}}">{{$genre->genre_name}}</option>
            @endforeach
        </select>
        </div>
        <br>
        <input type="text" name="song_id" id="song_id" hidden>
        <br>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div id="invite-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Invites</h4>
      </div>
      <div class="modal-body">
      <label>To be invited as member:</label>
        <input type="text" name="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Video modal -->

<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetVid();">
          <span aria-hidden="true" onclick="resetVid();">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-video">
          <div class="embed-responsive embed-responsive-16by9" id="vidcontainer">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>

<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script type="text/javascript">
// CKEDITOR.replace("#content");
    $('#content').ckeditor(); // if class is prefered.
</script>
<script type="text/javascript">
$( function() {
    
    $( "#add-band-member-name").autocomplete({
      source: 'http://localhost/Aria/public/{{$band->band_name}}/manage/search',
      appendTo: "#dummyContainer",
      autoFocus: true,
      select: function(e,ui){
        $('#add-band-member-name').val(ui.item.value);
        $('#add-band-member-id').val(ui.item.id);
      }
    });

});

function resetVid(){
  // $('#actualVideo').children().filter("video").each(function(){
  //     this.pause(); // can't hurt
  //     delete this; // @sparkey reports that this did the trick (even though it makes no sense!)
  //     $(this).remove(); // this is probably what actually does the trick
  // });
  // $('#actualVideo').empty();
  var vid1 = document.getElementById('actualVideo');
  var vid2 = $('#actualVideo').html();
  vid1.pause();
  // vid2.remove();
}
function videoOpen(id){

    var vid = document.getElementById('vidcontainer');
    var content = $('.vidContent'+id).data('content');
    var playIcon = "{{asset('assets/img/play.png')}}";

    // console.log(content);
    vid.innerHTML ='<video id="actualVideo" class="embed-responsive-item" autoplay><source id="vidsrc" src="'+content+'" type="video/mp4"></source></video><div id="controllerBox" class="video-controls-box" style="position: absolute;bottom: 0px;width: 100%;"><input id="seeksliderVid" type="range" min="0" max="100" value="0" step="1"><div style="padding-top: 5px; padding-bottom: 4px;"><span><img id="playPauseBottomOfVid" src="'+playIcon+'" onclick="playPauseVid()" style="cursor:pointer; width: 25px; padding-left: 5px; margin-top: -2px;"></span><span id="curtimeText" style="color:#fafafa; margin-left: 5px;">0:00</span> / <span id="durtimeText" style="color:#fafafa;">0:00</span></div></div>';

    $('#modal-video').modal('show');
    playPauseVid();
}

function openfile(){
  $('#anchor-file').click();
}
$("#anchor-file").on("change",function()
{
  console.log("niagi-here");
  $("#submitForm").click();
});

function openfile2(){
  $('#anchor-file-2').click();
}
$("#anchor-file-2").on("change",function()
{
  console.log("niagi-here");
  $("#submitForm2").click();
});

// function changeBandPic(){
//   $('#band-pic-form').submit();
// }

function saveBand(){
  document.getElementById('save-band-form').submit();
}

function playPauseVid(){
    // console.log(vid.id);
    var vid = document.getElementById('actualVideo');
    // var controller_vId = "controllOfVid"+vid.id;
    var vidForSlider = "seeksliderVid";
    var seekslider = document.getElementById(vidForSlider);
    var playPauseBottom = "playPauseBottomOfVid";
    var controlBox = "controllerBox";

    // console.log(controller_vId);
    var playBtn = "{{asset('assets/img/play.png')}}";
    var pauseBtn = "{{asset('assets/img/pause.png')}}";

    // var controllerVid = document.getElementById(controller_vId);
    var controllerVidBottom = document.getElementById(playPauseBottom);
    var controllerBox = document.getElementById(controlBox);
    
    if (vid.paused) {
      vid.play();
      // controllerVid.src = pauseBtn;
      controllerVidBottom.src = pauseBtn;
      // $(controllerVid).fadeOut();

      setTimeout(function(){
        $(controllerBox).fadeIn();
      }, 100);
      
      // setTimeout(function(){
      //   $(controllerBox).fadeOut();
      // }, 2000);

      // $(vId).mouseover(function(event) {
      //   $(controllerBox).fadeIn();
      //   setTimeout(function(){
      //     $(controllerBox).fadeOut();
      //   }, 2000);
      // });
      

    }else{
      vid.pause();
      // controllerVid.src = playBtn;
      controllerVidBottom.src = playBtn;
      // $(controllerVid).fadeIn();
      // $(controllerBox).fadeOut();
    }
    
    // console.log(vidForSlider);
    seekslider.addEventListener("change", function(){
        var seekTo = vid.duration * (seekslider.value/100);
        vid.currentTime = seekTo;
    });

    vid.addEventListener("timeupdate", function(){
        var newtime = vid.currentTime * (100/vid.duration);
        seekslider.value = newtime;

        var curtimeId = "curtimeText";
        var durtimeId = "durtimeText";
        var curtimeText = document.getElementById(curtimeId);
        var durtimeText = document.getElementById(durtimeId);

        var curmins = Math.floor(vid.currentTime/60);
        var cursecs = Math.floor(vid.currentTime-curmins*60);
        var durmins = Math.floor(vid.duration/60);
        var dursecs = Math.round(vid.duration-durmins*60);
        if (cursecs<10) {
          cursecs = "0"+cursecs;
        }
        if (dursecs<10) {          
          dursecs = "0"+dursecs;
        }
        curtimeText.innerHTML = curmins+":"+cursecs;
        durtimeText.innerHTML = durmins+":"+dursecs;

    });

    vid.addEventListener("ended", function(){
        var controllerVidBottom = document.getElementById(playPauseBottom);
        vid.currentTime = 0;
        controllerVidBottom.src = playBtn;
    });
}


$(document).ready(function()
{

     $("#showVideos").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this video?'))
        {
            window.location.href = '../deleteVideo/'+val;
        }
     });

     $('#showVideos').on('click', '.edit', function(){
          var title = $(this).data('title');
          var desc = $(this).data('desc');
          var id = $(this).data('id');

          console.log(title);

          $('.modal-body #video_title').val(title);
          $('.modal-body #video_desc').val(desc);
          $('.modal-body #video_id').val(id);
          $('#video-edit-modal').modal('show');
     });

     $("#showArticles").on('click', '.delete' ,function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this article?'))
        {
            window.location.href = '../deleteArticle/'+val;
        }
     });

     $('#showArticles').on('click', '.edit', function(){
          var title = $(this).data('title');
          var id = $(this).data('id');
          var content = $(this).data('content');

          $('.modal-body #art_title').val(title);
          $('.modal-body #art_id').val(id);
          $('.modal-body #content').val(content);

          $('#edit-article-modal').modal('show');
     });

     $(".deleteAlbum").on('click',function(){
        
        var val = $(this).val();
        if(confirm('Do you want to delete this album?'))
        {
            window.location.href = '../deleteAlbum/'+val;
        }
     });

     $('.editAlbum').on('click', function(){
          var desc = $(this).data('desc');
          var id = $(this).data('id');
          var name = $(this).data('name');

          $('.modal-body #album_desc').val(desc);
          $('.modal-body #album_id').val(id);
          $('.modal-body #album_name').val(name);
     });

     $('.addSong').on('click', function(){
          var id = $(this).data('id');

          $('.modal-body #album_id').val(id);
          $('#add-song-modal').modal('show');
     });

    $('#showAlbums').on('click', '.viewSongs', function(){
        var album_id = $(this).data('id');
        viewSongs(album_id);
    });

    function viewSongs($id)
    {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // alert($id);
        var bname = $('#bandName').val();
        // alert(bname);
        $.ajax({
          method : "post",
          url : "../"+bname+"/viewSongs",
          data : { '_token' : CSRF_TOKEN,
            'id' : $id
          },
          success: function(json){
            $('.tabtitle').text(json.album.album_name);
            $('.tablist li').remove();
              $.each(json.songs, function(key, value)
              {
                var song = value.song_audio;
                var source = "{{url('/assets/music/')}}";
                var audio = source +'/'+ song;

               $('.tablist').append('<li id="listItem'+value.song_id+'" class="list-group-item"><label>'+value.song_title+'</label><br><audio controls><source src="'+audio+'" type="audio/mpeg"></audio><button class="btn pull-right delete" value="'+value.song_id+'"><span class="fa fa-close"></span></button><button class="btn pull-right edit" data-toggle="modal" data-genre="'+value.genre_id+'" data-desc="'+value.song_desc+'" data-title="'+value.song_title+'" data-id="'+value.song_id+'"><span class="fa fa-pencil"></span></button></li>'); 

              });
          },
          error: function(a,b,c)
          {
            alert('Error');

          }
        });
    }

  $('#showSongs').on('click', '.delete', function()
  {
      var id = $(this).val();
      alert(id);
      if(confirm('Do you want to delete this song?'))
        {
            deleteSong(id);
        }
  });

  function deleteSong($id)
  {
    console.log($id);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          method : "post",
          url : "../deleteSong/"+$id,
          data : { '_token' : CSRF_TOKEN,
            'id' : $id
          },
          success: function(song){
            $('#listItem'+song.song_id).remove();
          }


        });

  }

  $('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > 2) {
        $(this).prop('checked', false);
    }
  });


  $('#showSongs').on('click', '.edit', function()
  {
      var id = $(this).data('id');
      var gid = $(this).data('genre');
      var desc = $(this).data('desc');
      var title = $(this).data('title');
      console.log(gid);

          $('.modal-body #song_title').val(title);
          $('.modal-body #song_desc').val(desc);
          $('.modal-body #song_id').val(id);
          $('.showgenre select').val(gid);

          $('#edit-song-modal').modal('show');
  });
  $('#updateSongbutton').click(function(){

      var desc = $('.edit-modal #song_desc').val();
      var id = $('.edit-modal #song_id').val();
      var genre = $('.edit-modal #genre_id').val();


      var data = new Array(id,desc,genre);
      updateSong(data);
      $('#edit-song-modal').modal('hide');
  });
  // function updateSong(data)
  // {
  //     var id = data[0];
  //     var desc = data[1];
  //     var genre = data[2];
  //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  //       $.ajax({
  //         method : "post",
  //         url : "../updateSong",
  //         data : { '_token' : CSRF_TOKEN,
  //           'song_id' : id,
  //           'song_desc' : desc,
  //           'genre_id': genre
  //         },
  //         success: function(content){
  //           alert('Success');
  //         }


  //       });  
  // }

 });
</script>
<script>
    $('.carousel').carousel({
        interval: false
    }); 
</script>
@endsection
