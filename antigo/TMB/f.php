<?php
// Developed By TechnologyMantraBlog.com
// Author: Mr. Hrishabh Sharma
// http://technologymantrablog.com/
// Please do not remove the credit info if you respect my efforts

if(isset($_GET['keyword']) and !isset($_GET['nextPage']))
{
	$keyword = $_GET['keyword'];
	
	$keyword=preg_replace("/ /","+",$keyword);
	
	$response = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q={$keyword}&type=video&key=AIzaSyBqhtJ3_FLsK74e0qh9FyDlnGyaggVsIk0&maxResults=50");
	
	$searchResponse = json_decode($response,true);
	foreach ($searchResponse['items'] as $searchResult) {
	$a = $searchResult['id']['videoId'];
	$b = preg_replace('/[^a-zA-Z0-9]/', '_', $searchResult['snippet']['title']);
	 
	
	?>
		<div id="<?php echo $a; ?>" draggable="true" ondragstart="drag(event)" class="videoItemContainer" onClick="playThis('<?php echo $a; ?>', '<?php echo $b; ?>')"> 
			 <div class="videoItemImage"> 
		 		<img src="<?php echo $searchResult['snippet']['thumbnails']['default']['url']; ?>" alt="Youtube Video">
			</div> 
		
			<div class="videoItemCaption"> 
				<?php echo $searchResult['snippet']['title']; ?>
			</div>
		
		</div>
		
		<?php
		
		}
			$nextPage = $searchResponse['nextPageToken'];
		?>
		
		
		<!--<div onClick="nextPage('<?php //echo $keyword; ?>', '<?php //echo $nextPage; ?>')" class="next">NEXT PAGE</div>-->
		
		
	<?php
	//echo $response;
	// $nextPage = $searchResponse['nextPageToken'];
}

if(isset($_GET['keyword']) and isset($_GET['nextPage']))
{
	$nextPage = $_GET['nextPage'];
	
	$keyword = $_GET['keyword'];
	
	$keyword = preg_replace("/ /","+",$keyword);
	
	$response = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q={$keyword}&type=video&key=AIzaSyBqhtJ3_FLsK74e0qh9FyDlnGyaggVsIk0&maxResults=50&pageToken={$nextPage}");
	
	$searchResponse = json_decode($response,true);
	foreach ($searchResponse['items'] as $searchResult) {
	$a = $searchResult['id']['videoId'];
	$b = preg_replace('/[^a-zA-Z0-9]/', '_', $searchResult['snippet']['title']);
	 
	
	?>
		<div id="<?php echo $a; ?>" draggable="true" ondragstart="drag(event)" class="videoItemContainer" onClick="playThis('<?php echo $a; ?>', '<?php echo $b; ?>')"> 
			 <div class="videoItemImage"> 
		 		<img src="<?php echo $searchResult['snippet']['thumbnails']['default']['url']; ?>" alt="Youtube Video">
			</div> 
		
			<div class="videoItemCaption"> 
				<?php echo $searchResult['snippet']['title']; ?>
			</div>
		
		</div>
		
		<?php
		
		}$nextPage = $searchResponse['nextPageToken'];
		?>
		
		
		<!--<div onClick="nextPage('<?php //echo $keyword; ?>', '<?php //echo $nextPage; ?>')" class="next">NEXT PAGE</div>-->
	<?php } ?>