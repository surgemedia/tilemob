<?php
include('includes/connection.php'); //Database connections
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
<title>Tiles Brisbane | stone mosaics slate terracotta ceramic floor wall tile shop | tilemob.com.au</title>
</head>

<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="overlay_tested_tiles_1" class="overlay_tested_tiles_1"><a href="/e3-performance-system"><img src="/images/blank.gif" width="205" height="86" alt="TESTED TILES – QUALITY GUARANTEED" border="0"/></a></div>	
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="home_body" class="home_body">
		<div class="tilesnav_home"><?php include('includes/tilesnav.php'); ?></div>
		<div class="view_interactive_gallery"><a href="/tm_catalogue/" title="View Interactive Gallery"><img src="images/view-inter-gallery.png" alt="View Interactive Gallery" border="0"/></a></div>
		<div class="view_pooloutdoor"><a href="/pooloutdoor/" title="View our new Outdoor &amp; Pool Collection catalogue" target="_blank"><img src="images/view-pooloutdoor.png" alt="View our new Outdoor &amp; Pool Collection catalogue" border="0"/></a></div>
		<div class="showroom_navbar"><a href="booking/" title="Book a showroom consultation">Book a <em>showroom consultation</em></a></div>
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
			dimensions: [635, 625],
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
</div>
<?php include('includes/end_body.php'); ?>
</body>