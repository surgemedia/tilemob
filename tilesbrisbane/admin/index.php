<?php


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
include('includes/meta.php'); //Meta tags
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out
?>
<script>
function alignToVerticalCenter() {
	var windowHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
	var div_newHeight = (windowHeight/2) - 250;
	document.getElementById('clear').style.height = div_newHeight+'px';
	//alert('windowHeight: '+windowHeight+', div_newHeight: '+div_newHeight);
}
window.onresize = alignToVerticalCenter;
</script>
</head>
<body>
<div class="container">
	<div class="middle">
	<div id="clear" class="clear"></div>
	<form id="submitform" name="submitform" method="post">
	<div id="login_container" class="login_container">
	<table width="350" align="center">
		<tr>
			<td colspan="2" align="left" valign="middle"><img src="images/img_loginaccess.gif" alt="Please login" border="0" /></td>
		</tr>
		<tr>
			<td colspan="2" align="left" valign="middle"><b>Welcome Administrator</b> – please enter your username and password to login:</td>
		</tr>
		<tr><td colspan="2" align="left" valign="middle"><hr/></td></tr>
		<tr>
			<td width="100" align="left" valign="middle"><b> Username: </b></td>
			<td align="left" valign="middle"><input name="my_username" type="text" id="my_username" class="textfield1" style="width:220px;margin-bottom:3px;" /></td>
		</tr>
		<tr>
			<td align="left" valign="middle"><b> Password:</b></td>
			<td align="left" valign="middle"><input name="my_password" type="password" id="my_password" class="textfield1" style="width:220px;" /></td>
		</tr>
		<tr><td colspan="2" align="left" valign="middle"><hr/></td></tr>
		<tr>
			<td align="left" valign="bottom"><input name="clear" type="reset" id="clear" value="Clear fields" class="button1" /></td>
			<td align="right" valign="bottom"><input name="submit" type="submit" id="submit" value="Login &raquo;" class="button1" style="margin-right:15px;"/></td>
		</tr>
		<tr>
			<td colspan="2" align="left" valign="middle">
			<?php
			if(!empty($_GET['s1']) || !empty($_GET['s2']) || !empty($_GET['s3'])) {
				if(!empty($_GET['s1'])){$s = 1;}else if(!empty($_GET['s2'])){$s = 2;}else if(!empty($_GET['s3'])){$s = 3;}
				$status = $_GET['s'.$s];
				//s1: notice | s2: success | s3: error 
				echo '<div class="status'.$s.'">'.$status.'</div>';
				echo '<div class="clear"></div>';
			}
			?>
			</td>
		</tr>
	</table>
	</div>
	</form>
	</div>
</div>

<script>alignToVerticalCenter();</script>
</body>
</html>
