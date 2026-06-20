  
<!doctype html>
<html class="no-js" lang="en">
  <head>
  	<meta name="viewport" content="width=470, maximum-scale=1, user-scalable=no, target-densitydpi=device-dpi">
  	<title>Demo: Responsive YouTube Player with Scrolling Thumbnail Playlist</title> 
  	<link rel="stylesheet" href="css/font-awesome.min.css" />

  	<style type="text/css">

  		body {
  			margin: 30px;
  			padding: 0;
  			background: #ddd;
  			font-family: Arial, Helvetica, sans-serif;
  		}

  		.title {
  			width: 100%;
  			max-width: 854px;
  			margin: 0 auto;
  		}

  		.caption {
  			width: 100%;
  			max-width: 854px;
  			margin: 0 auto;
  			padding: 20px 0;
  		}

  		.container {
  			width: 100%;
  			max-width: 854px;
  			min-width: 440px;
  			background: #fff;
  			margin: 0 auto;
  		}


  		/*  VIDEO PLAYER CONTAINER
 		############################### */
  		.vid-container {
		    position: relative;
		    padding-bottom: 52%;
		    padding-top: 30px; 
		    height: 0; 
		}
		 
		.vid-container iframe,
		.vid-container object,
		.vid-container embed {
		    position: absolute;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		}


		/*  VIDEOS PLAYLIST 
 		############################### */
		.vid-list-container {
			width: 92%;
			overflow: hidden;
			margin-top: 20px;
			margin-left:4%;
			padding-bottom: 20px;
		}

		.vid-list {
			width: 1344px;
			position: relative;
			top:0;
			left: 0;
		}

		.vid-item {
			display: block;
			width: 148px;
			height: 148px;
			float: left;
			margin: 0;
			padding: 10px;
		}

		.thumb {
			/*position: relative;*/
			overflow:hidden;
			height: 84px;
		}

		.thumb img {
			width: 100%;
			position: relative;
			top: -13px;
		}

		.vid-item .desc {
			color: #21A1D2;
			font-size: 15px;
			margin-top:5px;
		}

		.vid-item:hover {
			background: #eee;
			cursor: pointer;
		}

		.arrows {
			position:relative;
			width: 100%;
		}

		.arrow-left {
			color: #fff;
			position: absolute;
			background: #777;
			padding: 15px;
			left: -25px;
			top: -130px;
			z-index: 99;
			cursor: pointer;
		}

		.arrow-right {
			color: #fff;
			position: absolute;
			background: #777;
			padding: 15px;
			right: -25px;
			top: -130px;
			z-index:100;
			cursor: pointer;
		}

		.arrow-left:hover {
			background: #CC181E;
		}

		.arrow-right:hover {
			background: #CC181E;
		}


		@media (max-width: 624px) {
			body {
				margin: 15px;
			}
			.caption {
				margin-top: 40px;
			}
			.vid-list-container {
				padding-bottom: 20px;
			}

			/* reposition left/right arrows */
			.arrows {
				position:relative;
				margin: 0 auto;
				width:96px;
			}
			.arrow-left {
				left: 0;
				top: -17px;
			}

			.arrow-right {
				right: 0;
				top: -17px;
			}
		}

  	</style>

  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


  </head>

  <body>
  	<div class="title"><h2>Demo: Responsive YouTube Player with Scrolling Thumbnail Playlist</h2></div>

  	<div class="container">

  		<!-- THE YOUTUBE PLAYER -->
  		<div class="vid-container">
		    <iframe id="vid_frame" src="https://www.youtube.com/embed/5Hhp69582iE?rel=0" frameborder="0" width="560" height="315"></iframe>
		</div>

		<!-- THE PLAYLIST -->
		<div class="vid-list-container">
	        <div class="vid-list">
	         	
 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/5Hhp69582iE?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/5Hhp69582iE/0.jpg"></div>
 	              <div class="desc"> </div>
 	            </div>

 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/JZoAFR1-xfI?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/JZoAFR1-xfI/0.jpg"></div>
 	              <div class="desc"> </div>
 	            </div>
 	          
 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/__xTUB_akY0?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/__xTUB_akY0/0.jpg"></div>
 	              <div class="desc"> </div>
 	            </div>

 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/jUazklJ6mKE?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/jUazklJ6mKE/0.jpg"></div>
 	              <div class="desc">Eleanor Turner plays Baroque Flamenco</div>
 	            </div>

 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/qejT7jUZ964?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/qejT7jUZ964/0.jpg"></div>
 	              <div class="desc">Sleepy Man Banjo Boys: Bluegrass</div>
 	            </div>

 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/yc88wO3U9Ns?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/yc88wO3U9Ns/0.jpg"></div>
 	              <div class="desc">Edmar Castaneda: NPR Music Tiny Desk Concert</div>
 	            </div>

 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/0dhIww44slE?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/0dhIww44slE/0.jpg"></div>
 	              <div class="desc">Winter Harp performs Caravan</div>
 	            </div>
 	          
 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/OnQnNQYAPG8?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/OnQnNQYAPG8/0.jpg"></div>
 	              <div class="desc">The Avett Brothers Tiny Desk Concert</div>
 	            </div>

 	            <div class="vid-item" onClick="document.getElementById('vid_frame').src='http://youtube.com/embed/FSxoOiQcMV8?autoplay=1&rel=0&showinfo=0&autohide=1'">
 	              <div class="thumb"><img src="http://img.youtube.com/vi/FSxoOiQcMV8/0.jpg"></div>
 	              <div class="desc">Tracy Chapman - Give Me One Reason</div>
 	            </div>

	 	    </div>
        </div>

        <!-- LEFT AND RIGHT ARROWS -->
        <div class="arrows">
        	<div class="arrow-left"><i class="fa fa-chevron-left fa-lg"></i></div>
        	<div class="arrow-right"><i class="fa fa-chevron-right fa-lg"></i></div>
        </div>

  	</div>

 
  	<!-- JS FOR SCROLLING THE ROW OF THUMBNAILS -->
  	<script type="text/javascript">
  		$(document).ready(function () {
		    $(".arrow-right").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "+=336"
		        }, 750);
		    });
		    $(".arrow-left").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "-=336"
		        }, 750);
		    });
		});
  	</script>


  	 
<script src="http://www.yvoschaap.com/ytpage/ytembed.js"></script>
<div id="ytThumbs"></div>

<script>
	ytEmbed.init({'block':'ytThumbs','key':'your-youtube-developer-key','q':'adrianalocutoracom','type':'user','results':5,'meta':false,'player':'embed','layout':'thumbnails'});
</script>
  </body>
</html>
