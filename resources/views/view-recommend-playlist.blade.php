@extends('layouts.master')


@section('title')
@endsection


@include('layouts.navbar')

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>

<br><br><br><br><br>

<div class="container">
  <div class="col-md-3">
    <img src="#" class="img-responsive">
    <h3 class="text-center">{{$genre->genre_name}}</h3>
    <p class="text-center">by: Aria</p>
    <img src="{{url('/assets/img/play.png')}})">
  </div>
  <div class="col-md-9">
    @if(count($songs) == null)
    <div>
      <h3>There are no songs in your playlist yet.</h3>
    </div>
    <hr>
    @else
    <h4>Songs Available</h4>
    @foreach($songs as $song)
      <div>
            <div class="well" style="padding: 5px; background: #fafafa">
            <div class="row">
              <div class="col-md-12">
                <label>{{$song->song_title}}</label><br>
                <audio controls><source src="{{url('/assets/music/'.$song->song_audio)}}" type="audio/mpeg"></audio>
      
              </div>
            </div>
            </div>
      </div>
    @endforeach
    @endif
  </div>
</div>
@endsection