@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')

@section('content')
<br><br><br><br>
<div>
	Title of Article : {{$article->art_title}}<br>
	Content : {{$article->content}}<br>
</div>
@endsection