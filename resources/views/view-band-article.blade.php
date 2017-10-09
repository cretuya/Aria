@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')
@include('layouts.band-materials-navigation')

@section('content')
<div class="container">
<br><br>
<center><h3>Articles</h3></center>

<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<br><br><br><br>

<input type="text" value="{{$band->band_name}}" id="bandName" hidden>

@if($article == null)
@else
	<div class='articles'>
		<div class="panel panel-default" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);">
			<div class="panel-body">
				<h4>{{$article->art_title}}</h4>
				<p>{{$article->content}}</p>
			</div>
		</div>
	</div>
@endif



<!-- {{--@if($articles == null)
@else
	@foreach($articles as $article)
	<div class='articles'>
	<button type="button" class="showContent" data-id='{{$article->article->art_id}}'>{{$article->article->art_title}}</button>
	</div>
	@endforeach
@endif--}} -->
<br>
<div class="displayArticle">
		<div class="display">
		</div>
</div>

</div>



<script type="text/javascript">
$(document).ready(function(){
	$('.articles').on('click', '.showContent', function()
	{
		var id = $(this).data('id');
		$('.display').empty();
		getContent(id);
	});
	function getContent(id)
	{
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var bname = $('#bandName').val();
        $.ajax({
          method : "post",
          url : './getArticle',
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(content){
            $('.displayArticle').append('Title of Article: '+content.art_title+'<br><br>Content: '+content.content+'<br>');
          },
          error: function(a,b,c)
          {
            console.log(b);

          }
        });			
	}
});
</script>
@endsection