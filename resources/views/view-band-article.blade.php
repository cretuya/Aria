@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<br><br><br><br>
<input type="text" value="{{$band->band_name}}" id="bandName" hidden>
@if($articles == null)
@else
	@foreach($articles as $article)
	<div class='articles'>
	<button type="button" class="showContent" data-id='{{$article->article->art_id}}'>{{$article->article->art_title}}</button>
	</div>
	@endforeach
@endif
<br>
<div class="displayArticle">
		<div class="display">
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
          url : "../getArticle",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(content){
            $('.display').append('Title of Article: '+content.art_title+'<br><br>Content: '+content.content+'<br>');
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