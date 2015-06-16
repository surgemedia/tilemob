<? 
	header('location:tile-finder.php?ke=Bathroom');
	session_start();
	include('../dbconnect.php');
	include('includes/global_variables.php');
	include('includes/requests.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<?php 
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
?>
</head>
<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="body" class="body">
		<div id="body_left" class="body_left">
			<?php include('includes/finder.php'); ?>
			<div class="clear"></div>
		</div>
		<div id="body_right" class="body_right">
			<div id="pagebody" class="pagebody">
				
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
	<div class="clear"></div>
</div>
<?php include('includes/end_body.php'); ?>
</body>
</html>