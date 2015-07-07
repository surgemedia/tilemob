<?php

session_start();
include('../includes/connection.php'); //Database connections

//Process login
if($_POST['submit'] && !empty($_POST['my_username']) && !empty($_POST['my_password'])) {
	$login_success = 0; //not logged in yet
	$my_username = mysql_real_escape_string(trim($_POST['my_username']));
	$my_password = mysql_real_escape_string(trim($_POST['my_password']));
	//echo 'my_username: '.$my_username.' my_password: '.$my_password.'<br/>';
	$my_password_md5 = md5($my_password);
	//echo 'my_username: '.$my_username.'<br/>';
	//Access database check if login is valid
	$result_admin = mysql_query("SELECT * FROM administrators WHERE username LIKE '".$my_username."' AND password LIKE '".$my_password_md5."' AND is_active = 1");
	$result_admin_num = mysql_num_rows($result_admin);
	if($result_admin_num!=0) { //username and password is correct and account is active
		$row_admin = mysql_fetch_array($result_admin);
		$admin_id = $row_admin['admin_id'];
		if($row_admin['access_level']=='admin1' || $row_admin['access_level']=='admin2') { //access allowed
			//Access user information - Store into session 
			$_SESSION['cms_admin_id'] = $admin_id;
			$_SESSION['cms_username'] = $row_admin['username'];
			$_SESSION['cms_firstname'] = $row_admin['firstname'];
			$_SESSION['cms_lastname'] = $row_admin['lastname'];
			$_SESSION['cms_access_level'] = $row_admin['access_level'];
			$_SESSION['cms_successful_logins'] = $row_admin['successful_logins'];
			$_SESSION['cms_failed_logins'] = $row_admin['failed_logins'];
			$_SESSION['cms_last_login'] = $row_admin['last_login'];
			$_SESSION['cms_last_ip'] = $row_admin['last_ip'];
			
			$successful_logins = intval($row_admin['successful_logins'])+1;
			$last_ip = $_SERVER['REMOTE_ADDR'];
			
			//Track login
			mysql_query("UPDATE administrators SET 
					successful_logins = '$successful_logins', 
					last_login = NOW(),
					last_ip = '$last_ip'
					WHERE admin_id = '$admin_id'") or die(mysql_error());
					
			$login_success = 1;
			header('Location: http://localhost:8888/tilemob/tilesbrisbane/admin/products.php?s2=Welcome back'); 
		} else {
			$login_success = 0;
		}
	} else {
		$login_success = 0;
	}
	//Login not successful
	if(empty($login_success)||$login_success==0) {
		//Record failed attempt for this user
		$result_admin2 = mysql_query("SELECT * FROM administrators WHERE username LIKE '".$username."' AND is_active= 1 ");
		if($row_admin2 = mysql_fetch_array($result_admin2)) {
			$admin_id = $row_admin2['admin_id'];
			$failed_logins = intval($row_admin2['failed_logins'])+1;
			$last_ip = $_SERVER['REMOTE_ADDR'];
			//Update database with login details
			mysql_query("UPDATE administrators SET 
					failed_logins = '$failed_logins', 
					last_login = NOW(),
					last_ip = '$last_ip'
					WHERE admin_id = '$admin_id'") or die(mysql_error());	//Done.
		}
		echo "Please check your username and password and try again.";
		exit;
	}
} else if($_POST['submit_login']) {
	echo "Please enter a username and password to proceed.";
	exit;
} else {
	//This page clears user's sessions
	session_destroy();
}
?>
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
