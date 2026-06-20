// Developed By TechnologyMantraBlog.com
// Author: Mr. Hrishabh Sharma
// http://technologymantrablog.com/
// Please do not remove the credit info if you respect my efforts

var playListArray;

$(document).ready(function(){
   playListArray = new Array();
 });

function playInPlayList(index)
{
	player.playVideoAt(index);
}

function playThis(videoID)
{
	 player.loadVideoById(videoID);
	
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
	
	playListArray.push(data);
	player.cuePlaylist(playListArray);
	
	var vidIndex = playListArray.length - 1;
	document.getElementById(data).setAttribute('onClick', 'playInPlayList('+vidIndex+')');
}

function nextPage(keyword,token) {
	document.getElementById("videoList").innerHTML="Video list is loading. Please wait...";
	  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp1=new XMLHttpRequest();
	  } else { // code for IE6, IE5
		xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp1.onreadystatechange=function() {
		if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
		  document.getElementById("videoList").innerHTML=xmlhttp1.responseText;
		}
	  }
	  	keyword = keyword.replace(/ /g, '%2B');
		xmlhttp1.open("GET","TMB/f.php?keyword="+keyword+"&nextPage="+token,true);
	  	xmlhttp1.send();
	}
	


function getVideoList(keyword) {
	document.getElementById("videoList").innerHTML="Video list is loading. Please wait...";
	  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2 = new XMLHttpRequest();
	  } else { // code for IE6, IE5
		xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp2.onreadystatechange=function() {
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
		  document.getElementById("videoList").innerHTML = xmlhttp2.responseText;
		}
	  }
	  
	  if(keyword.length > 0)
	  {
	  	keyword = keyword.replace(/ /g, '%2B');
		xmlhttp2.open("GET","TMB/f.php?keyword="+keyword,true);
	  }
	  else
	  {
	    xmlhttp2.open("GET","TMB/f.php",true);
	  }
	  
	  xmlhttp2.send();
	}
	
	function downloadVideo() {
		var videoID = player.getVideoData()['video_id']
		document.getElementById("downloadFormatList").innerHTML="Please wait. Processing...";
	  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp3 = new XMLHttpRequest();
	  } else { // code for IE6, IE5
		xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp3.onreadystatechange=function() {
		if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
		  document.getElementById("downloadFormatList").innerHTML=xmlhttp3.responseText;
		}
	  }
	  
	  //keyword = keyword.replace(/ /g, '%2B');
		xmlhttp3.open("GET","TMB/download.php?videoid="+videoID,true);
	  xmlhttp3.send();
		
	}
	
// Developed By TechnologyMantraBlog.com
// Author: Mr. Hrishabh Sharma
// http://technologymantrablog.com/
// Please do not remove the credit info if you respect my efforts