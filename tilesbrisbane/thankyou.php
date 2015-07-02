<?php 
session_start();
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
?>
</head>

<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="body" class="body ">
            <div class="thankyou">
                <h2>Thank you</h2> 
                <p>Your payment has been successfully completed.</p>
                <a href="index.php" class="btn-red">Go to Home</a>
            </div>
	</div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
	<div class="clear"></div>
</div>
<?php include('includes/end_body.php'); ?>
</body>
</html>