<?php
include('../includes/connection.php'); //Database connections
include('../includes/prerun.php'); //Other things missed out
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
//<head> includes - some files are not used, but we have them just in case.
include('../includes/meta.php'); //Meta tags
include('../includes/variables.php'); //Global variables
include('../includes/security.php'); //Security features
include('../includes/attach_styles.php'); //Cascading Style Sheets
include('../includes/attach_scripts.php'); //Javascripts and scripts
include('../includes/other.php'); //Other things missed out

//content for this page
//$current_page_url = strtolower(basename($_SERVER['PHP_SELF'])); //returns filename of page only
$current_page_url = 'tm_catalogue';
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
include('../includes/social_networking.php');
?>
<script>
function disableContextMenu() {
	window.frames["iframe_catalogue"].document.oncontextmenu = function(){alert("Sorry, right click function is unavailable on this Website."); return false;}; 
	window.frames["iframe_catalogue"].frames["iframe_display"].document.oncontextmenu = function(){alert("Sorry, right click function is unavailable on this Website."); return false;}; 
	window.frames["iframe_catalogue"].frames["iframe_display_info"].document.oncontextmenu = function(){alert("Sorry, right click function is unavailable on this Website."); return false;};
	window.frames["iframe_catalogue"].frames["iframe_collection"].document.oncontextmenu = function(){alert("Sorry, right click function is unavailable on this Website."); return false;};
}
</script>
<meta name="description" content="For quality tiles in Brisbane look no further. The Tile Mob source the best stone, mosaics, slate, terracotta and ceramic tiles for floor and wall">
<meta name="keywords" content="tiles Brisbane, stone, slate, terracotta, ceramic, floor, wall, bathroom, kitchen">
<meta name="author" content="The Tile Mob">
<meta name="copyright" content=" The Tile Mob ">
<title>Tiles Brisbane | tile catalogue | tilemob.com.au/tm_catalogue/</title>
</head>

<body>
<?php include('../includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('../includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('../includes/navigation.php'); ?></div>
	<div id="page_header" class="page_header">
		<div class="tilesnav_page"><?php include('../includes/tilesnav.php'); ?></div>
		<img src="../images/page/05.jpg" alt="Interactive Gallery" border="0"/>
	</div>
	<div id="page_body" class="page_body">
		<div id="page_body_full" class="page_body_full">
		<?php echo $body; ?>
		<div style="width:800px;margin-left:auto;margin-right:auto;">
		<iframe
		id="iframe_catalogue" name="iframe_catalogue" width="800" height="712"
		style="border:0px solid #EEEEEE" frameborder=0 scrolling=no
		src="http://www.tilemob.com.au/tm_catalogue/gallery/tiles/wall/bathrooms/page1/index.php?page=1" onload="disableContextMenu();">
		</iframe>
		</div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('../includes/footer.php'); ?></div>
	<div id="seo_footer" class="seo_footer"><?php include('../includes/seo_footer.php'); ?></div>
</div>
<?php include('../includes/end_body.php'); ?>
</body>