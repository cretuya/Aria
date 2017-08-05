@extends('layouts.master')

@section('title')
{{$band->band_name}}
@endsection

@include('includes.navbar')

@section('content')


<div class="container-fluid">

	<br>
    <div class="col-md-12">
        <!-- content -->                      
      	<div class="row">
          
         <!-- main col left --> 
         <div class="col-md-5">
           
              <div class="panel panel-default">

                <div class="panel-thumbnail"><img src=" {{ asset('assets/img/band-pic.jpg') }}" class="img-responsive"></div>
	                <div class="panel-body">
		                <div class="row">
			                <div class="col-md-8">
			                  <p class="band-name-title">Linkin Park</p>
			                  <h4>Alternative Rock / Alternative Metal</h4>
								<!-- <ul class="social-icons-ul" style="padding-left: 0">
									<li><span class="fa fa-facebook-square social-icons" style="color: #3C5B9A"></span></li>
									<li><span class="fa fa-twitter-square social-icons" style="color: #0FB5EE"></span></li>
									<li><span class="fa fa-youtube-square social-icons" style="color: #CD201F"></span></li>
								</ul> -->
			                  <p>Established on 1996</p>
			                  <p>45 Followers</p>
			                </div>
			                <div class="col-md-4">
			                	<div class="row" style="padding-right: 15px">
			                		<button class="btn-follow followButton pull-right" rel="6">Follow</button>
		                		</div>
			                </div>
		                </div>
                	</div>
              	</div>

           
              <div class="panel panel-default">
                <div class="panel-heading"><h4>About the Band</h4></div>
                  <div class="panel-body" style="padding: 30px">
                    <p style="text-indent: 20px; text-align: justify;">Linkin Park is an American rock band from Agoura Hills, California. Formed in 1996, the band rose to international fame with their debut album Hybrid Theory (2000), which was certified Diamond by the RIAA in 2005 and multi-Platinum in several other countries. Their following studio album Meteora continued the band's success, topping the Billboard 200 album chart in 2003, and was followed by extensive touring and charity work.</p>
                  </div>
              </div>
           
              <div class="panel panel-default">
                 <div class="panel-heading"><h4>Heading Text Here</h4></div>
                  <div class="panel-body">
                    
                  </div>
              </div>
           
              <div class="panel panel-default">
                <div class="panel-heading"><h4>Heading Text Here</h4></div>
               	<div class="panel-body">
                
                </div>
              </div>
              <div id="addArticle">
              <button type="button" class='add' value="{{$band->band_name.'/articles'}}">View Article</button>
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
                 <div class="panel-heading"><a href="{{$band->band_name.'/albums'}}" class="pull-right">See all Tracks</a><h4>Featured Songs</h4></div>
                  <div class="panel-body" style="padding: 0;">
                    <div class="container-fluid" style="padding: 0;">
					    <div class="column center">
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
					    </div>
					</div>
                  </div>
               </div>

               <div class="panel panel-default">
                 <div class="panel-heading"><h4>Heading Text Here</h4></div>
                  <div class="panel-body">
                    
                  </div>
               </div>
            
               <div class="panel panel-default">
                 <div class="panel-heading"><h4>Heading Text Here</h4></div>
                  <div class="panel-body">
                    
                  </div>
               </div>
            
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
	        
	        //$.ajax(); Do Unfollow
	        
	        $button.removeClass('following');
	        $button.removeClass('unfollow');
	        $button.text('Follow');
	    } else {
	        
	        // $.ajax(); Do Follow
	        
	        $button.addClass('following');
	        $button.text('Following');
	    }
	});

	$('button.followButton').hover(function(){
	     $button = $(this);
	    if($button.hasClass('following')){
	        $button.addClass('unfollow');
	        $button.text('Unfollow');
	    }
	}, function(){
	    if($button.hasClass('following')){
	        $button.removeClass('unfollow');
	        $button.text('Following');
	    }
	});
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