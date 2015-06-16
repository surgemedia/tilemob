<?php
include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
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
$current_page_url = 'tiles-by-room';
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
<meta name="description" content="For quality tiles in Brisbane look no further. The Tile Mob source the best stone, mosaics, slate, terracotta and ceramic tiles for floor and wall">
<meta name="keywords" content="tiles Brisbane, stone, slate, terracotta, ceramic, floor, wall, bathroom, kitchen">
<meta name="author" content="The Tile Mob">
<meta name="copyright" content=" The Tile Mob ">
<title>Tiles Brisbane Tile Showroom | stone mosaics slate tiles terracotta ceramic tiles | Brisbane Floor & Wall Tile Supplies | Complete Tile Range Brisbane QLD | tilemob.com.au/tiles-by-room/</title>
</head>
<body>
<?php include('../includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('../includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('../includes/navigation.php'); ?></div>
	<div id="page_header" class="page_header">
		<div class="tilesnav_page"><?php include('../includes/tilesnav.php'); ?></div>
		<img src="../images/page/04.jpg" alt="Tiles by Room" border="0"/>
	</div>
	<div id="page_body" class="page_body">
		<div id="page_body_full" class="page_body_full">
			<?php echo $body; ?>
			<div class="clear" style="height:20px;"></div>
		  <img src="images/floorplan2.gif" width="293" height="400" border="0" usemap="#Map" style="margin-left:100px;margin-right:30px;margin-bottom:45px;float:left;"></p>
			<iframe src="bedroom-1.html" id="photo" name="photo" scrolling="no" frameborder="0" width="450" height="420" style="margin-top:10px;"></iframe>
			<map name="Map">
			<area shape="rect" coords="183,145,241,236" href="bedroom-1.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Bedroom">
			<area shape="rect" coords="84,145,175,203" href="lounge.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Lounge">
			<area shape="rect" coords="25,145,84,218" href="bath.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Bathroom">
			<area shape="rect" coords="7,105,182,137" href="patio.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Patio">
			<area shape="rect" coords="106,307,172,356" href="study.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Study">
			<area shape="rect" coords="108,258,174,305" href="kitchen.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Kitchen">
			<area shape="rect" coords="245,144,281,237" href="ensuite.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Ensuite">
			<area shape="rect" coords="86,258,106,357" href="hallway.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Hallway">
			<area shape="poly" coords="197,354,212,396,273,395,257,352,197,353" href="driveway.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Driveway">
			<area shape="rect" coords="177,239,280,356" href="garage.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Garage">
			<area shape="rect" coords="85,204,176,257" href="dining-room.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Dining">
			<area shape="rect" coords="117,9,280,90" href="pool.html?rand=<?php echo rand(0,9999); ?>" target="photo" alt="Pool" />
			</map>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('../includes/footer.php'); ?></div>
	<div id="seo_footer" class="seo_footer"><?php include('../includes/seo_footer.php'); ?></div>
</div>
<?php include('../includes/end_body.php'); ?>
</body>