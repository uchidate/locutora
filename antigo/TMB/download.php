<?php

  $config['ThumbnailImageMode']=1;    
  $config['VideoLinkMode']='direct'; 
  $config['feature']['browserExtensions']=true; 
date_default_timezone_set("Asia/Kolkata");
 $debug=false; 

 function curlGet($URL) {
    $ch = curl_init();
    $timeout = 3;
    curl_setopt( $ch , CURLOPT_URL , $URL );
    curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
    curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT , $timeout );
	$tmp = curl_exec( $ch );
    curl_close( $ch );
    return $tmp;
}  

function get_location($url) {
	$my_ch = curl_init();
	curl_setopt($my_ch, CURLOPT_URL,$url);
	curl_setopt($my_ch, CURLOPT_HEADER,         true);
	curl_setopt($my_ch, CURLOPT_NOBODY,         true);
	curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
	$r = curl_exec($my_ch);
	 foreach(explode("\n", $r) as $header) {
		if(strpos($header, 'Location: ') === 0) {
			return trim(substr($header,10)); 
		}
	 }
	return '';
}
function get_size($url) {
	$my_ch = curl_init();
	curl_setopt($my_ch, CURLOPT_URL,$url);
	curl_setopt($my_ch, CURLOPT_HEADER,         true);
	curl_setopt($my_ch, CURLOPT_NOBODY,         true);
	curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
	$r = curl_exec($my_ch);
	 foreach(explode("\n", $r) as $header) {
		if(strpos($header, 'Content-Length:') === 0) {
			return trim(substr($header,16)); 
		}
	 }
	return '';
}
function get_description($url) {
	$fullpage = curlGet($url);
	$dom = new DOMDocument();
	@$dom->loadHTML($fullpage);
	$xpath = new DOMXPath($dom); 
	$tags = $xpath->query('//div[@class="info-description-body"]');
	foreach ($tags as $tag) {
		$my_description .= (trim($tag->nodeValue));
	}	
	
	return utf8_decode($my_description);
}

ob_start();
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'); 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . '' . $units[$pow]; 
} 
function is_chrome(){
	$agent=$_SERVER['HTTP_USER_AGENT'];
	if( preg_match("/like\sGecko\)\sChrome\//", $agent) ){	// if user agent is google chrome
		if(!strstr($agent, 'Iron')) // but not Iron
			return true;
	}
	return false;
}
if(isset($_REQUEST['videoid'])) {
	$my_id = $_REQUEST['videoid'];
	
	if(strpos($my_id,"https://youtu.be/") !== false)
	{
		$my_id = str_replace("https://youtu.be/","",$my_id);
	}
	
	if($my_id == "")
	{
		echo'Please Enter Youtube Video URL';
		exit;
	}
	
	if(strlen($my_id)>11){
		$url   = parse_url($my_id);
		$my_id = NULL;
		if( is_array($url) && count($url)>0 && isset($url['query']) && !empty($url['query']) ){
			$parts = explode('&',$url['query']);
			if( is_array($parts) && count($parts) > 0 ){
				foreach( $parts as $p ){
					$pattern = '/^v\=/';
					if( preg_match($pattern, $p) ){
						$my_id = preg_replace($pattern,'',$p);
						break;
					}
				}
			}
			if( !$my_id ){
				echo '<p>Please Enter Link of Video</p>';
				exit;
			}
			
		}else{
			echo '<p>Invalid url</p>';
			exit;
		}
	}
} else {
	echo '<p>Please Enter Link of Video</p>';
	exit;
}
?>
<div class="download_cotainer">
<?php

//$my_video_info = 'http://www.youtube.com/get_video_info?&video_id='. $my_id;
$my_video_info = 'http://www.youtube.com/get_video_info?&video_id='. $my_id.'&asv=3&el=detailpage&hl=en_US'; //video details fix *1
$my_video_info = curlGet($my_video_info);
/* TODO: Check return from curl for status code */
$thumbnail_url = $title = $url_encoded_fmt_stream_map = $type = $url = '';
parse_str($my_video_info);
?>

<div class="download_info">
<table>
<tr>
<td><img class="downloadThumbnail" src="<?php echo $thumbnail_url; ?>" border="0" hspace="2" vspace="2"></td>
<td><span class="download_title"><?php echo $title; ?></span></td>
</tr>
</table>
</div>

<?php
$my_title = $title;
$cleanedtitle = clean($title);
if(isset($url_encoded_fmt_stream_map)) {
	/* Now get the url_encoded_fmt_stream_map, and explode on comma */
	$my_formats_array = explode(',',$url_encoded_fmt_stream_map);
	if($debug) {
		echo '<pre>';
		print_r($my_formats_array);
		echo '</pre>';
	}
} else {
	echo '<p>No encoded format stream found.</p>';
	echo '<p>Here is what we got from YouTube:</p>';
	echo $my_video_info;
}
if (count($my_formats_array) == 0) {
	echo '<p>No format stream map found - was the video id correct?</p>';
	exit;
}
/* create an array of available download formats */
$avail_formats[] = '';
$i = 0;
$ipbits = $ip = $itag = $sig = $quality = '';
$expire = time(); 
foreach($my_formats_array as $format) {
	parse_str($format);
	$avail_formats[$i]['itag'] = $itag;
	$avail_formats[$i]['quality'] = $quality;
	$type = explode(';',$type);
	$avail_formats[$i]['type'] = $type[0];
	$avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
	parse_str(urldecode($url));
	$avail_formats[$i]['expires'] = date("G:i:s T", $expire);
	$avail_formats[$i]['ipbits'] = $ipbits;
	$avail_formats[$i]['ip'] = $ip;
	$i++;
}

	
	echo'<div class="format_list">';
	echo'<br>';
	echo'<table>';
	
	/* now that we have the array, print the options */
	for ($i = 0; $i < count($avail_formats); $i++) {
		if($config['VideoLinkMode']=='direct'||$config['VideoLinkMode']=='both')
		  ?> <tr><td><?php echo $avail_formats[$i]['type']; ?></td>
		
		<td><small>(<?php echo $avail_formats[$i]['quality']; ?>)</small> </td>
		<td><small><span class="size"><?php echo formatBytes(get_size($avail_formats[$i]['url'])); ?></span></small>
		</td>
		
		<td><a href="<?php echo $avail_formats[$i]['url']; ?> '&title='<?php echo $cleanedtitle; ?>'" class="downloadButton">DOWNLOAD</a></td>
		</tr>
	<?php 
	}
	?>
	</table>
	</div>