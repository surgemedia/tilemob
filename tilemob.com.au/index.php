<?php
include('../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/prerun.php'); //Other things missed out
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
//<head> includes - some files are not used, but we have them just in case.
include('includes/meta.php'); //Meta tags
include('includes/variables.php'); //Global variables
include('includes/security.php'); //Security features
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out

//content for this page
$current_page_url = strtolower(basename($_SERVER['PHP_SELF'])); //returns filename of page only
$result_content = mysql_query("SELECT * FROM content WHERE pageurl = '$current_page_url' AND is_deleted != '1'") or die(mysql_error()); 
if($row_content = mysql_fetch_array($result_content)) {
	$content_id = $row_content['ID'];
	$body = str_replace("\'", "'", $row_content['body']);
	$body = str_replace('\"', '"', $body);
	$body2 = str_replace("\'", "'", $row_content['body2']);
	$body2 = str_replace('\"', '"', $body2);
	$metatitle = $row_content['metatitle'];
	$menulinkname = $row_content['menulinkname'];
	$pageurl = $row_content['pageurl'];
}
/*
//Meta title
if(trim($metatitle)!=''){echo'<title>'.$metatitle.'</title>';}else{echo'<title>'.$global_metatitle.'</title>';}
//Metatags
if(trim($metatags)!=''){echo$metatags;}else{echo$global_metatags;}
*/
//for social networking
include('includes/social_networking.php');
?>
<meta name="verify-v1" content="H5W6NISDC0fUt13zbD9aGR5oLx7jtSr3i8ouusOf3qQ=" />
<meta name="description" content="For quality tiles in Brisbane look no further. The Tile Mob source the best stone, mosaics, slate, terracotta and ceramic tiles for floor and wall">
<meta name="keywords" content="tiles Brisbane, stone, slate, terracotta, ceramic, floor, wall, bathroom, kitchen">
<meta name="author" content="The Tile Mob">
<meta name="copyright" content=" The Tile Mob ">
<title>Tiles Brisbane Tile Showroom | stone mosaics slate tiles terracotta ceramic tiles | Brisbane Floor & Wall Tile Supplies | Complete Tile Range Brisbane QLD</title>

<script>
function initChristmasClosure() {
	document.getElementById("christmas_hoverpop").style.display = "block";
}

function close_christmas_hoverpop() {
	document.getElementById("christmas_hoverpop").style.display = "none";
	//Never display again (plant cookie)
	createCookie('neverdisplayagain','true',365);
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name) {
	createCookie(name,"",-1);
}
</script>
</head>

<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
		
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="home_body" class="home_body">
		<div id="overlay_tested_tiles_1" class="overlay_tested_tiles_1"><a href="/e3-performance-system"><img src="/~titi2698/tilemob.com.au/images/blank.gif" width="205" height="86" alt="TESTED TILES – QUALITY GUARANTEED" border="0"/></a></div>
		<div class="tilesnav_home"><?php include('includes/tilesnav.php'); ?></div>
		<div class="view_interactive_gallery"><a href="/tm_catalogue/" title="View Interactive Tile Gallery - Brisbane Tiles"><img src="images/view-inter-gallery.png" alt="View Interactive Tile Gallery - Brisbane Tiles" border="0"/></a></div>
		<div class="view_pooloutdoor"><a href="/pooloutdoor/" title="View our new outdoor tile & pool tile collection catalogue" target="_blank"><img src="images/view-pooloutdoor.png" alt="View our new outdoor tile & pool tile collection catalogue" border="0"/></a></div>
		<div class="showroom_navbar"><a href="booking/" title="Book a consultation in our Brisbane Tile Showroom">Book a <em>showroom consultation</em></a></div>
		<div id="home_body_left" class="home_body_left">
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> 
			<script language="javascript" type="text/javascript" src="scripts/fadeshow.js"></script> 
			<script type="text/javascript"> 
			var homegallery = new fadeSlideShow({
				wrapperid: "home_body_left", //ID of blank DIV on page to house Slideshow			 				
			imagearray: [
			["images/slideshow/01.jpg", "", "", ""],
			["images/slideshow/02.jpg", "", "", ""],
			["images/slideshow/03.jpg", "", "", ""],
			["images/slideshow/04.jpg", "", "", ""],
			["images/slideshow/05.jpg", "", "", ""],
			["images/slideshow/06.jpg", "", "", ""],
			["images/slideshow/07.jpg", "", "", ""],
			["images/slideshow/08.jpg", "", "", ""],
			["images/slideshow/09.jpg", "", "", ""]
			],
			dimensions: [635, 575],
			displaymode: {type:'auto', pause:2500, cycles:0, wraparound:false, randomize:true},
				persist: false, //remember last viewed slide and recall within same session?
				fadeduration: 5000, //transition duration (milliseconds)
				descreveal: "ondemand",
				togglerid: ""
			})
			</script> 
		</div>
		<div id="home_body_right" class="home_body_right">			
			<div id="home_body_right_a" class="home_body_right_a">
			<?php echo $body; ?>
			</div>
			<div id="home_body_right_b" class="home_body_right_b">
				<?php
				$result_news = mysql_query("SELECT * FROM news WHERE news_id = '1'");
				if($row_news = mysql_fetch_array($result_news)) {
					$news_title = $row_news['title'];
					$news_url = $row_news['url'];
					$news_body = $row_news['body'];
					if(!empty($news_url)) {
						$news_body = '<a href="'.$news_url.'">'.$news_body.'</a>';
					}
				}
				?>				
				<div id="home_head_newsflash" class="home_head_newsflash"><?php echo $news_title; ?> <span style="font-weight:normal;font-size:18px;">›</span></div>
				<?php echo $news_body; ?>
			</div>
			<div id="home_body_right_c" class="home_body_right_c">
				<?php
				$result_latest = mysql_query("SELECT * FROM latest_products WHERE latest_product_id = '1'");
				if($row_latest = mysql_fetch_array($result_latest)) {
					$latest_title = $row_latest['title'];
					$latest_url = $row_latest['url'];
					$latest_body = $row_latest['body'];
					if(!empty($latest_url)) {
						$latest_body = '<a href="'.$latest_url.'">'.$latest_body.'</a>';
					}
				}
				?>
				<div id="home_head_latestproduct" class="home_head_latestproduct"><?php echo $latest_title; ?> <span style="font-weight:normal;font-size:18px;">›</span></div>
				<?php echo $latest_body; ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
	<div id="seo_footer" class="seo_footer"><?php include('includes/seo_footer.php'); ?></div>
	<div class="christmas_closure" id="christmas_hoverpop" style="display:none;"> <img src="images/christmas_closure_12.png" alt="Christmas Closure" name="non_ie6_image" border="0" usemap="#Map" id="non_ie6_image"/>
		<!--[if IE 6]>
		<div style="padding-top:8px;padding-left:8px;background:#FFFFFF;">
		<img src="images/blank.gif" style="width: 350px; height: 210px; filter:
		progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/christmas_closure_10.png', sizingMethod='scale')" usemap="#Map" border="0"/>
		</div>
		<script>
		document.getElementById("non_ie6_image").style.display = "none";
		</script>
		<![endif]-->
		<map name="Map" id="Map">
			<area shape="rect" coords="89,225,266,245" href="#" alt="Thanks, close this notice" onclick="close_christmas_hoverpop();" />
			<area shape="rect" coords="85,160,260,185" href="#" alt="Thanks, close this notice" onclick="close_christmas_hoverpop();"/>
	</map>
	</div>
</div>
<?php 
include('includes/end_body.php');
$exp_date = "2013-01-07"; 
$todays_date = date("Y-m-d"); 
$today = strtotime($todays_date); 
$expiration_date = strtotime($exp_date); 
if ($expiration_date > $today) { 
	echo '<script>initChristmasClosure();</script>';
}
?>
</body>