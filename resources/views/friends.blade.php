@extends('layouts.master')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/user-profile.css').'?'.rand()}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/dropdown-animation.css').'?'.rand()}}">
@section('content')

@include('layouts.sidebar')

<style>

.modal-content {
    -webkit-border-radius: 4px !important;
    -moz-border-radius: 4px !important;
    border-radius: 4px !important; 
}

.modal-title{
  margin-left: 10px;
}

.modal-header button.close, .modal-footer button.btn[type="submit"]{
  margin-right: 10px;
}

.modal-header button.close{
  margin-top: 0px;
  color: #fafafa;
  opacity: 1;
  font-weight: 100;
}

.modal-header{
  background: #E57C1F;
  border-top-right-radius: 4px !important; 
  border-top-left-radius: 4px !important;
  border-bottom: none;
}

.modal label{
  font-family: Arial;
  font-size: 12px;
  letter-spacing: 0.5px;
  margin-top: 7px;
}

.modal-footer{
  border-top: none;
}

.modal-footer button{
  border: none;
}

.modal-footer button.btn[type="submit"]{
  background: #E57C1F;
  color: #fafafa;
}

.modal-content{
  background: #232323;
}

body.modal-open #main{
  -webkit-filter: blur(4px);
  -moz-filter: blur(4px);
  -o-filter: blur(4px);
  -ms-filter: blur(4px);
  filter: blur(4px);
}

.ellipsisProfile:hover{
  color: #E57C1F !important;
}

.ellipsisPlaylist:hover{
  color: #E57C1F !important;
}

#addplistpanel:hover{
  zoom: 105%;
  margin-top: 12px !important;
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
    <h4 style="font-size: 18px;">Friends who joined Aria</h4>
    <br>
    <div class="row">
      @if($friends == null)
      <br>
      <p style="text-align:center; color: #a4a4a4; font-size: 16px;">Invite your facebook friends to join Aria!</p>
      <br>
      @else
        <?php
          for ($i=0; $i < count($friends); $i++) { 
            if($i == 3){
              echo "</div><br>";
              echo "<div class='row'>";
            }
        ?>          
          <div class="col-xs-4">
            <div class="media">
              <div class="media-left">
                <div class="panel-thumbnail" style="padding: 0">
                  <a href="{{url('profile/'.$friends[$i]->user_id)}}"><img class="media-object" src="{{$friends[$i]->profile_pic}}" style="height: 120px; width: 120px;"></a>
                </div>
              </div>
              <div class="media-body" style="background: #232323; padding: 20px">
                <a href="{{url('profile/'.$friends[$i]->user_id)}}"><span style="color: #fafafa; font-size: 15.5px">{{$friends[$i]->fullname}} </span></a>
                <br>
                <a href="{{url('profile/'.$friends[$i]->user_id)}}"><button class="btn" style="color: #fafafa; font-size: 11px; padding: 4px 6px; background: #E57C1F; position: absolute; bottom: 24px;">Visit Profile</button></a>
              </div>
            </div>
          </div>

        <?php }?>
      @endif
    
      

    </div>
         
    </div>
  </div>
</div>

@stop