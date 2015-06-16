<?
session_start();
//Clear user sessions
$_SESSION['user_id'] = '';
$_SESSION['login_username'] = '';
$_SESSION['user_firstname'] = '';
$_SESSION['user_lastname'] = '';
$_SESSION['user_address'] = '';
$_SESSION['user_postcode'] = '';
$_SESSION['user_city'] = '';
$_SESSION['user_state'] = '';
$_SESSION['user_contactnumber1'] = '';
$_SESSION['user_contactnumber2'] = '';
$_SESSION['access_level'] = '';
$_SESSION['last_successlogins'] = '';
$_SESSION['last_failedlogins'] = '';
$_SESSION['last_logindate'] = '';
$_SESSION['last_loginip'] = '';
$_SESSION['last_updatedate'] = '';
//proceed to admin login screen
header('location:index.php?s1=You have successfully logged out.');
?>
