<?php session_start(); 
// Developed By TechnologyMantraBlog.com
// Author: Mr. Hrishabh Sharma
// http://technologymantrablog.com/
// Please do not remove the credit info if you respect my efforts
?>
                <!--CSS-->
                <style>
                    .botao{
                        height:70px;
                        width:70px;
                        <!--GRADIENTE-->
                        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e2e2e2+0,dbdbdb+50,d1d1d1+51,fefefe+100;Grey+Gloss+%231 */
background: rgb(226,226,226); /* Old browsers */
background: -moz-linear-gradient(top,  rgba(226,226,226,1) 0%, rgba(219,219,219,1) 50%, rgba(209,209,209,1) 51%, rgba(254,254,254,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(226,226,226,1)), color-stop(50%,rgba(219,219,219,1)), color-stop(51%,rgba(209,209,209,1)), color-stop(100%,rgba(254,254,254,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* IE10+ */
background: linear-gradient(to bottom,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#fefefe',GradientType=0 ); /* IE6-9 */

                        <!--GRADIENTE-->
                        border:none;
                        cursor:pointer;
                        border-radius:10px;
                        }
                    .image{
                        height:;
                        width:30px;
                        }
                    .alinha_centro{
                        text-align:center;
                    }
                </style>

                <!--FINAL CSS-->
  
	 <div class="container1">
		
		<div class="row">
			<div class="col-md-12">
				 
			</div>
		</div>
	
		
			<div class="row">
				<div class="col-md-12">
                    
                    <div id="video-placeholder" style="width:100%; height:300px"></div>
                    
                    <p class="alinha_centro">
                    <button class="botao" id="prev"><img class="image" src="../images/prev.png"/></button>
                    <button class="botao" id="play"><img class="image" src="../images/play.png"/></button>
                    <button class="botao" id="pause"><img class="image" src="../images/pause.png"/></button>
                    <button class="botao" id="next"><img class="image" src="../images/next.png"/></button></p>
                     
					<!--<div class="searchBox">
						<div class="searchForm">
						<form role="form" method="post" action="" onSubmit="getVideoList(keyword.value); return false;">  
							 
					<div id="playerContainer">
					<div id="player"></div>
					<br>
 				</div>--><!-- player container-->
							 
						<!--</form>
					</div>--> <!-- searchForm-->
					<!--<div class="videoList" id="videoList"></div>
				</div>--> <!--searchBox-->
			</div><!--col md 8-->
			<div class="col-md-4">
				
			</div> <!--col md 4-->
			
			 
			
		</div> <!--row-->
		
		
 
		
		
	</div>	 <!--container-->
	
	
	 <footer class="footers">
      <div class="container">
       </div>
    </footer>
	
	<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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

</script>-->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<!--LINKS YOUTUBE JS-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>
<script src="js/script_youtube.js"></script>
<!--LINKS YOUTUBE JS-->