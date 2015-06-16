<?
if(isset($_GET['tilecode'])) { $tilecode = $_GET['tilecode']; }
else { $tilecode = ""; }
if(isset($_GET['tilelink'])) { $tilelink = $_GET['tilelink']; }
else { $tilelink = ""; }
if(isset($_GET['remove'])) { $remove = $_GET['remove']; }
else { $remove = ""; }

if ($remove == "true") {
	if ($tilecode != null) {
		setcookie($tilecode,"", time() - 3600);
		header('location:iframe_collection.php');
	}
} else {
	if ($tilecode != null && $tilelink != null) {
		setcookie($tilecode,$tilelink,0,"/");
		header('location:iframe_collection.php');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<title></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function removeCookie(tilecode) {
		var browserName=navigator.appName; 
		if (browserName=="Microsoft Internet Explorer")	{
			document.cookie = tilecode+ "=; expires=Thu, 01-Jan-70 00:00:01 GMT; path=/";
			self.location.replace("iframe_collection.php?tilecode="+tilecode+"&remove=true");
		} else {
			document.cookie = tilecode+ "=; expires=Thu, 01-Jan-70 00:00:01 GMT; path=/";
			self.location.replace("iframe_collection.php");
		}
	}
</script>
<style type="text/css">
body { 
	overflow-x: auto;
	overflow-y: hidden;
	scrollbar-face-color: #FFFFFF;
	scrollbar-highlight-color: #FFFFFF;
	scrollbar-3dlight-color: #FFFFFF;
	scrollbar-shadow-color: #FFFFFF;
	scrollbar-darkshadow-color: #FFFFFF;
	scrollbar-arrow-color: #EE3B33;
	scrollbar-track-color: #F0F0F0;
}
</STYLE>
</head>
<body STYLE="background-color:transparent;">
<?
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Date: 21/03/07, 22/03/07, 23/03/07
//Script: Process Collections
//Description: 	
//			
//			
//----------------------------------------------------------------------------------------------------------------------------------------------


//General Variables below ---------------------------------------------------------------------------------------------------------------
$cookies_collection = array(); //Stores an array of collections from cookie file
$collection_td = "";
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
//Function Executions below  -----------------------------------------------------------------------------------------------------------
createCollection(); //1. Execute Function to create a collection from cookies file
createListing(); //2. Execute Function to create a listing of product images added to collection
//-----------------------------------------------------------------------------------------------------------------------------------------------


function createCollection() {
	global $cookies_collection;
	//print_r($_COOKIE);
	$i = 0;
	//Store all cookies in array called $cookies_collection
	foreach ($_COOKIE as $value) {
		//echo "This is a cookie: " .$value;
		$cookies_collection[$i] = $value;
		$i++;
	}	
}


function createListing() {
	global $cookies_collection, $collection_td, $server_dir_main;
	
	//Create table
	$collection_td .= ' <span class="the-tile-mob">
						<table height="80" border="0" cellspacing="8" cellpadding="0"
						align="left" valign="middle"><tr>';	
	foreach($cookies_collection as $value) {
		/*$value = substr($value, 0, (count($value)-10))."t_".
		substr($value, (count($value)-10));*/		
		$tilecode = substr($value, (strrpos($value,'/')+1));
		$value = substr($value, 0, (count($value)-10)).'/t_'.$tilecode;
		$tilefolder = substr($value, 0, (count($value)-10));
		if(strstr($value, 'http') && strstr($value, 't_')){
			$collection_td .= '	
				<td width="80" height="80" align="center" valign="middle" 
				background="'.$server_dir_main.'images/bkg_thumb_cell2.gif">
					<!-- value: '.$value.'--> 
					<!-- tilecode: '.$tilecode.'-->
					<img src="'.$value.'">
				</td>		
			';
		}
	}
	$collection_td .= '
				<tr>';
	foreach($cookies_collection as $value) {
		$tilecode = substr($value, (strrpos($value,'/')+1), -4);
		$value = substr($value, 0, (count($value)-10))."t_".
		substr($value, (count($value)-10));
		//$tilecode = stripslashes(substr($value, (count($value)-10), 5));		
		$tilefolder = substr($value, 0, (count($value)-10));
		if(strstr($value, 'http') && strstr($value, 't_')){
			$collection_td .= '
					<td width="80" height="10" align="right" valign="top" 
					scope="row">
						<a href="#" onclick="removeCookie('.$tilecode.');">
						<img src="images/btn_removetile.gif" border="0">
						</a>
					</td>
			';
		}
	}
	$collection_td .= '</tr></tr></table></span>';
	echo $collection_td;	
}


?>
</body>
</html>




