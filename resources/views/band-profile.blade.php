@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('layouts.navbar')

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<br><br><br>

<div class="container" style="padding-left: 0px; padding-right: 0px;">

	<br>
    <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
        <!-- content -->                      
      	<div class="row">
          
         <!-- main col left --> 
         <div class="col-md-5">
           
              <div class="panel panel-default">

                <div class="panel-thumbnail"><img src="{{$band->band_pic}}" class="img-responsive" style="max-height: 406px; width: 100%;"></div>
	                <div class="panel-body">
		                <div class="row">
			                <div class="col-md-8">
			                  <p class="band-name-title">{{$band->band_name}}</p>
			                  <h4>
			                  @if($genres == null)
			                  @else
			                  @foreach ($genres as $genre)
			                  {{$genre->genre->genre_name}} |
			                  @endforeach
			                  @endif
			                  </h4>
								<!-- <ul class="social-icons-ul" style="padding-left: 0">
									<li><span class="fa fa-facebook-square social-icons" style="color: #3C5B9A"></span></li>
									<li><span class="fa fa-twitter-square social-icons" style="color: #0FB5EE"></span></li>
									<li><span class="fa fa-youtube-square social-icons" style="color: #CD201F"></span></li>
								</ul> -->
			                  <!-- <p>Established on 1996</p> -->
			                  @if ($band->num_followers == null)
			                  <p class="followers">0 Followers</p>
			                  @else
			                  <p class="followers">{{$followers}} Followers</p>
			                  @endif
			                </div>
			                <div class="col-md-4">
			                	<div class="row" style="padding-right: 15px">
			                		<input type="text" value="{{$band->band_id}}" id="bid" hidden>
			                		@if ($follower == null)
			                		<button class="btn-follow followButton pull-right" rel="6">Follow</button>
			                		@else
			                		<button class="btn-follow followButton pull-right following" rel="6">UnFollow</button>
			                		<input type="text" value="{{$follower->user_id}}" id="uid" hidden>
			                		@endif
		                		</div>
			                </div>
		                </div>
                	</div>
              	</div>


              <div class="panel panel-default">
                <div class="panel-heading"><h4>About the Band</h4></div>
                  <div class="panel-body" style="padding: 30px">
                    <p style="text-indent: 20px; text-align: justify;">{{$band->band_desc}}
                  </div>
              </div>
           
<!--               <div class="panel panel-default">
                 <div class="panel-heading"><h4>Heading Text Here</h4></div>
                  <div class="panel-body">
                    
                  </div>
              </div> -->
            <div class="panel panel-default">
		        <div class="panel-heading"><h4>Articles</h4></div>
	               	<div class="panel-body">
            @if ($articles == null)
           	@else
           			@foreach ($articles as $article)
			            <a href="{{url('/'.$band->band_name.'/viewArticle/'.$article->article->art_id)}}"><div class="well">{{$article->article->art_title}}</div></a>           
			                         			
           			@endforeach
           	@endif
           			</div>
           	</div>

              <div id="addArticle">
              <button type="button" class='add' value="{{$band->band_name.'/articles'}}">View More Articles</button>
              </div>
           		
           
          </div>
          
          <!-- main col right -->
          <div class="col-md-7">
                     
          		<div class="panel panel-default">
                <div class="panel-heading"><a href="{{$band->band_name.'/videos'}}" class="pull-right">See all Videos</a><h4>Featured Video</h4></div>
                  <div class="panel-body" style="padding: 0px;">
                    <div align="center" class="embed-responsive embed-responsive-16by9">
					    <video style="background: #000" class="embed-responsive-item" controls autoplay>
					        <source src="videos/Linkin Park-Talking To Myself.mp4" type="video/mp4">
					    </video>
					</div>
                  </div>
               </div>

               <div class="panel panel-default">
                 <div class="panel-heading"><a href="{{$band->band_name.'/albums'}}" class="pull-right">See all Albums</a><h4>Latest Released Albums</h4></div>
                  <div class="panel-body" style="padding: 0;">
                    <div class="container-fluid" style="padding: 0;">
					    <!-- <div class="column center">
					    </div>
					    <div class="column add-bottom">
					        <div id="mainwrap">
					            <div id="nowPlay">
					                <span class="left" id="npAction">Paused...</span>
					                <span class="right" id="npTitle"></span>
					            </div>
					            <div id="audiowrap">
					                <div id="audio0">
					                    <audio class="audio-player" preload id="audio1" controls="controls">Your browser does not support HTML5 Audio!</audio>
					                </div>
					                <div id="tracks">
					                    <a id="btnPrev">&laquo; Previous</a>
					                    <a id="btnNext">&raquo; Next</a>
					                </div>
					            </div>
					            <div id="plwrap">
					                <ul style="padding-left: 0px;" id="plList"></ul>
					            </div>
					        </div>
					    </div> -->

					</div>
                  </div>
               </div>

<!--                <div class="panel panel-default">
                 <div class="panel-heading"><h4>Heading Text Here</h4></div>
                  <div class="panel-body">
                    
                  </div>
               </div>
            
               <div class="panel panel-default">
                 <div class="panel-heading"><h4>Heading Text Here</h4></div>
                  <div class="panel-body">
                    
                  </div>
               </div> -->
            
          </div>
       </div><!--/row-->

</div>


</div>

<script type="text/javascript">

	// The rel attribute is the userID you would want to follow

	$('button.followButton').on('click', function(e){
	    e.preventDefault();
	    $button = $(this);
	    if($button.hasClass('following')){
	        
	        // $.ajax(); Do UnFollow
	        var bid = $('#bid').val();
	        unfollowBand(bid);
	        
	    } else {
	        
	        // $.ajax(); Do Follow
	        var id = $('#bid').val();
	        followBand(id);
	        
	    }
	});

	function followBand(id)
	{
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

 		$.ajax({
          method : "post",
          url : "./followBand",
          data : { '_token' : CSRF_TOKEN,
            'id' : id
          },
          success: function(json){
        	console.log(json);
			$button.addClass('following');
	        $button.text('Following');
	        $('.following').append('<input type="text" value="'+json.preference.user_id+'" id="uid" hidden>');
	        $('.followers').text(json.followers+' Followers');
          },
          error: function(a,b,c)
          {
            alert('Error');

          }
        });		
	}

	function unfollowBand(bid)
	{
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    var uid = $('#uid').val();


 		$.ajax({
          method : "post",
          url : "./unfollowBand",
          data : { '_token' : CSRF_TOKEN,
            'bid' : bid,
            'uid' : uid
          },
          success: function(json){
        	console.log(json);
	        $button.removeClass('following');
	        // $button.removeClass('unfollow');
	        $button.text('Follow');
	        $('.followers').text(json.followers+' Followers');
          },
          error: function(a,b,c)
          {
            console.log('Error');

          }
        });			
	}

	// $('button.followButton').hover(function(){
	//      $button = $(this);
	//     if($button.hasClass('following')){
	//         $button.addClass('unfollow');
	//         $button.text('Unfollow');
	//     }
	// }, function(){
	//     if($button.hasClass('following')){
	//         $button.removeClass('unfollow');
	//         $button.text('Following');
	//     }
	// });
$(document).ready(function()
{
	$('#addArticle').on('click', '.add', function()
	{
		var val = $(this).val();
		window.location =  val;
	});
});

</script>

</body>
</html>
@endsection