@extends('layouts.master')

@section('content')
<style type="text/css">
@media (min-width: 768px){
  #bandBanner{
    opacity: 0.8;
    height: 300px;
    width: calc(100% - 240px);
    position: absolute;
    top: 0px;
    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important;
  }

  #bandBannerGradient{
    opacity: 1;
    height: 300px;
    width: calc(100% - 240px);
    position: absolute;
    top: 0px;

    background: -webkit-linear-gradient(bottom, rgba(23,23,23,0), rgba(23,23,23,1)); /* For Safari 5.1 to 6.0 */
    background: -o-linear-gradient(bottom, rgba(23,23,23,0), rgba(23,23,23,1)); /* For Opera 11.1 to 12.0 */
    background: -moz-linear-gradient(bottom, rgba(23,23,23,0), rgba(23,23,23,1)); /* For Firefox 3.6 to 15 */
    background: linear-gradient(to bottom, rgba(23,23,23,0), rgba(23,23,23,1)); /* Standard syntax (must be last) */

    -webkit-background-size: cover !important;
    -moz-background-size: cover !important;
    -o-background-size: cover !important;
    background-size: cover !important;
  }
}

.bandpicstyle{
	height: 180px;
	width: 180px;
	position: relative;
	top: 145px;
	border: 2px solid #fafafa;
}

</style>

<meta name ="csrf-token" content = "{{csrf_token() }}"/>

@include('layouts.sidebar')

<div class="container" id="main" style="background: #161616;">
  <div class="row">

    @if($band->band_coverpic == null)
    <div id="bandBanner" class="panel-thumbnail" style="background: url({{asset('assets/img/banner.jpeg')}}) no-repeat center center fixed;">
      &nbsp;
    </div>
    <div id="bandBannerGradient" class="panel-thumbnail">
      &nbsp;
    </div>
    @else
    <div id="bandBanner" class="panel-thumbnail" style="background: url({{$band->band_coverpic}}) no-repeat center center fixed;">
      &nbsp;
    </div>
    <div id="bandBannerGradient" class="panel-thumbnail">
      &nbsp;
    </div>
    @endif

	<div class="container-fluid" style="padding: 0px;">

	@if($band->band_pic == null)
	<div class="panel-thumbnail">
	  <img src="{{asset('assets/img/dummy-pic.jpg')}}" class="img-responsive bandpicstyle">
	</div>
	@else
	<div class="panel-thumbnail">
	  <img src="{{$band->band_pic}}" class="img-responsive bandpicstyle">
	</div>
	@endif

	<center>
	<div style="position: relative; top: 150px;">
		<h4 style="text-transform: uppercase; letter-spacing: 2px;">{{$band->band_name}}</h4>
		@if ($band->num_followers == null)
		<p class="followers" style="margin-top: -5px; font-size: 12px; color: #9e9e9e">0 Followers</p>
		@else
		<p class="followers" style="margin-top: -5px; font-size: 12px; color: #9e9e9e">{{$followers}} Followers</p>
		@endif

		<input type="text" value="{{$band->band_id}}" id="bid" hidden>
		@if ($follower == null)
		<button class="btn-follow followButton" rel="6">Follow</button>
		@else
		<button class="btn-follow followButton following" rel="6">UnFollow</button>
		<input type="text" value="{{$follower->user_id}}" id="uid" hidden>
		@endif
	</div>
	</center>
	</div>

	<br><br><br><br><br><br><br><br><br>

	<div class="container-fluid">
		<div class="col-md-8">
			<div class="panel" style="border-radius: 0px;">
				<div class="panel-body">
					<h6 style="color: #212121; letter-spacing: 1px; line-height: 16px;">{{$band->band_desc}}</h6>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel" style="border-radius: 0px;">
			  <div class="panel-heading" style="background: #232323">
			  	<center><h6 style="color: #fafafa; text-transform: uppercase; letter-spacing: 1px;">We Are</h6></center>
			  </div>
				<div class="panel-body">
				<center>
				@forelse($band->members as $member)
					<span style="color: #212121; letter-spacing: 1px; line-height: 16px; text-transform: uppercase; font-size: 13px;">{{$member->user->fullname}} - {{$member->bandrole}}</span>
				@empty
					<span style="color: #212121; letter-spacing: 1px; line-height: 16px; text-transform: uppercase; font-size: 13px;">No members yet</span>
				@endforelse
				</center>
				</div>
			</div>
		</div>
	</div>

    {{--
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

              	--}}

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