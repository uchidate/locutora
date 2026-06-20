<?php session_start(); 
// Developed By TechnologyMantraBlog.com
// Author: Mr. Hrishabh Sharma
// http://technologymantrablog.com/
// Please do not remove the credit info if you respect my efforts
?>

  
	 <div class="container1">
		
		<div class="row">
			<div class="col-md-12">
				 
			</div>
		</div>
	
		
			<div class="row">
				<div class="col-md-12">
					<div class="searchBox">
						<div class="searchForm">
						<form role="form" method="post" action="" onSubmit="getVideoList(keyword.value); return false;">  
							 
					<div id="playerContainer">
					<div id="player"></div>
					<br>
 				</div><!-- player container-->
							 
						</form>
					</div> <!-- searchForm-->
					<div class="videoList" id="videoList"></div>
				</div> <!--searchBox-->
			</div> <!--col md 8-->
			<div class="col-md-4">
				
			</div> <!--col md 4-->
			
			 
			
		</div> <!--row-->
		
		
 
		
		
	</div>	 <!--container-->
	
	
	 <footer class="footers">
      <div class="container">
       </div>
    </footer>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://www.locutora.com/TMB/javas.js"></script>
<script>
	 getVideoList('adrianalocutoracom');
	 var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	  var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '263',
          width: '350',
          videoId: '0dhIww44slE',
		  playerVars: {
            controls: 1,
            disablekb: 1
        },
		  events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }
	function onPlayerReady(event) {
        event.target.playVideo();
		myVidId.innerHTML = '0dhIww44slE';
      }

      function onPlayerStateChange(event) {
        
      }

</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

 