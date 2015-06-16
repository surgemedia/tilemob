<?
if(!empty($_SESSION['login_username'])) {
	$checklogin_username = trim($_SESSION['login_username']);
} else {
	//boot user - disallow viewing this page
	/*echo '<meta http-equiv="Refresh" content="0; url=">';
	echo '<script language="javascript">';
	echo 'self.location = "index.php?status=Session expired. Please login to continue.";';
	echo '</script>';*/
	header("location:index.php?status=Session expired. Please login to continue.");
}
?>