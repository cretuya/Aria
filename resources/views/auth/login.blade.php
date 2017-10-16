@extends('layouts.master')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/index.css').'?'.rand()}}">

<video poster="{{asset('assets/img/video-thumbnail.png')}}" id="bgvid" playsinline autoplay muted loop>
  <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
  <source src="{{asset('assets/videos/Linkin Park-Talking To Myself.mp4')}}" type="video/mp4">
</video>
<center>
<div class="header">
    <div class="wrap">
      <div class="row header-text-container">
         <!-- <h1 class="welcome">Introducing</h1> -->
         <img src="{{asset('assets/img/arialogo.png')}}" class="img-responsive arialogo">
         <h1 class="aria">Aria</h1>
         <h1 class="welcome">A multi-platform application for audio and video band promotion</h1>
         <br><br>
         <center><a href="{{url('login/facebook')}}"><button class="btn fb-btn"><span class="fa fa-facebook-square"> </span> Login with Facebook</button></a></center>
      </div>
    </div>
</div>
</center>

@stop