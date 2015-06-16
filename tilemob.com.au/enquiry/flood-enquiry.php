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
$current_page_url = 'enquiry';
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
<title>Tiles Brisbane | contact The Tile Mob | tilemob.com.au/enquiry/</title>
</head>

<body>
<?php include('../includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('../includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('../includes/navigation.php'); ?></div>
	<div id="page_header" class="page_header">
		<div class="tilesnav_page"><?php include('../includes/tilesnav.php'); ?></div>
		<img src="../images/page/07.jpg" alt="Equiry Form" border="0"/>
	</div>
	<div id="page_body" class="page_body">
		<div id="page_body_full" class="page_body_full">
			<h1>News Flash</h1>
			<h2>Attention: owners of flood-affected homes.</h2>
			<p><b>Until the end of May, we're conducting special after hours showroom appointments so flood-affected home owners can select their new tiles with added convenience. Contact us on (07) 3355 5055 or please complete the enquiry form below to book an appointment.</b></p>
			<iframe src="general_enquiry_form.php" width="910px" height="500" frameborder="0" scrolling="no"></iframe>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('../includes/footer.php'); ?></div>
	<div id="seo_footer" class="seo_footer"><?php include('../includes/seo_footer.php'); ?></div>
</div>
<?php include('../includes/end_body.php'); ?>
</body>