<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
include('includes/meta.php'); //Meta tags
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/other.php'); //Other things missed out

//This page clears user sessions
$_SESSION['admin_id'] = '';
$_SESSION['login_username'] = '';
$_SESSION['admin_firstname'] = '';
$_SESSION['admin_lastname'] = '';
$_SESSION['admin_address'] = '';
$_SESSION['admin_postcode'] = '';
$_SESSION['admin_city'] = '';
$_SESSION['admin_state'] = '';
$_SESSION['admin_contactnumber1'] = '';
$_SESSION['admin_contactnumber2'] = '';
$_SESSION['access_level'] = '';
$_SESSION['last_successlogins'] = '';
$_SESSION['last_failedlogins'] = '';
$_SESSION['last_logindate'] = '';
$_SESSION['last_loginip'] = '';
$_SESSION['last_updatedate'] = '';

//Process login
if(!empty($_POST['login_username']) && !empty($_POST['login_password'])) {
	$login_success = ''; //assume null login until proven elsewise
	$login_username = mysql_real_escape_string(trim($_POST['login_username']));
	$login_password = mysql_real_escape_string(trim($_POST['login_password']));
	//echo 'login_username: '.$login_username.' login_password: '.$login_password.'<br/>';
	$login_password_md5 = md5($login_password);
	//echo 'username: '.$login_username.'<br/>';
	//Access database check if login is valid
	//$result_admin = mysql_query("SELECT * FROM administrators WHERE admin_username='$login_username' AND admin_password='$login_password_md5'");
	$result_admin = mysql_query("SELECT * FROM administrators WHERE username='$login_username' AND password='$login_password_md5' AND is_active='1'");
	$row_admin = mysql_fetch_array($result_admin);
	$admin_id = $row_admin['admin_id'];
	if(trim($row_admin['username']) == $login_username) { //username correct - 1. success
		//echo 'username correct: '.$login_username.'<br/>';
		//echo 'md5 password is: '.$login_password_md5.'<br/>';
		if(trim($row_admin['password']) == $login_password_md5) { //password correct - 2. success			
			if(trim($row_admin['access_level']) == 'admin1' || trim($row_admin['access_level']) == 'admin2') { //access level correct - 3. success				
				//Access user information - Store into session 
				$_SESSION['admin_id'] = $admin_id;
				$_SESSION['login_username'] = $login_username;
				$_SESSION['admin_firstname'] = $row_admin['firstname'];
				$_SESSION['admin_lastname'] = $row_admin['lastname'];				
				$_SESSION['access_level'] = $row_admin['access_level'];
				$_SESSION['last_successlogins'] = $row_admin['successful_logins'];
				$_SESSION['last_failedlogins'] = $row_admin['failed_logins'];
				$_SESSION['last_logindate'] = $row_admin['last_login'];
				$_SESSION['last_loginip'] = $row_admin['last_ip'];
				
				$last_successlogins = intval($row_admin['successful_logins']) + 1;
				$hourOffset_timedate = strtotime("+15 hour");
				$last_logindate =  date("d/m/Y (h:i a)", $hourOffset_timedate);
				$last_loginip = $_SERVER['REMOTE_ADDR'];
				
				//Update database with login details
				mysql_query("UPDATE administrators SET 
						successful_logins = '$last_successlogins', 
						last_login = NOW(),
						last_ip = '$last_loginip'
						WHERE admin_id = '$admin_id'") or die(mysql_error());	//Done.
				
				//Take user to page editor
				$login_success = 1;
				echo '<script language="javascript">';
				echo 'self.location = "manage_newsflash.php";';
				echo '</script>';
			} else { //username correct but access level incorrect - record failed login
				$login_success = 0;
			}
		} else { //username correct but password failed - record failed login
			$login_success = 0;
		}
	} else { //username does not exist
		$login_success = 0;
	}
	//Login failed...
	if($login_success == 0 || $login_success == '') {
		if($login_success == 0) {
			//Go to this username and record failed attempt for this user id
			$result_admin2 = mysql_query("SELECT * FROM administrators WHERE username='$login_username'");
			$row_admin2 = mysql_fetch_array($result_admin2);
			$admin_id2 = $row_admin2['ID'];
			
			$last_failedlogins = intval($row_admin2['last_failedlogins']) + 1;
			$hourOffset_timedate = strtotime("+15 hour");
			$last_logindate =  date("d/m/Y (h:i a)", $hourOffset_timedate);
			$last_loginip = $_SERVER['REMOTE_ADDR'];
			
			//Update database with login details
			mysql_query("UPDATE administrators SET 
					failed_logins = '$last_failedlogins', 
					last_login = NOW(),
					last_ip = '$last_loginip'
					WHERE admin_id = '$admin_id'") or die(mysql_error());	//Done.
		}
		echo '<script language="javascript">';
		echo 'self.location = "index.php?s3=Login unsuccessful: Please check your <br/>username and password and try again.";';
		echo '</script>';
	}
}
?>
</head>

<div class="container">
   <div class="middle">
      <form id="form_login" name="form_login" method="post" action="">
         <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:auto;margin-right:auto;">
            <tr>
               <td height="100" colspan="3">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="3" align="left" valign="middle"><img src="images/img_loginaccess.gif" alt="administrators area" vspace="5" border="0" /></td>
            </tr>
            <tr>
               <td width="4" align="left" valign="middle">&nbsp;</td>
               <td height="40" colspan="2" align="left" valign="middle">Welcome Administrator - please enter your username and password below to proceed:</td>
            </tr>
            <tr>
               <td width="4" align="left" valign="middle">&nbsp;</td>
               <td width="100" align="left" valign="middle"><h3> Username: </h3></td>
               <td align="left" valign="middle"><input name="login_username" type="text" id="login_username" class="textfield_1" style="width:200px;margin-bottom:3px;" /></td>
            </tr>
            <tr>
               <td align="left" valign="middle">&nbsp;</td>
               <td align="left" valign="middle"><h3> Password:</h3></td>
               <td align="left" valign="middle"><input name="login_password" type="password" id="login_password" class="textfield_1" style="width:200px;" /></td>
            </tr>
            <tr>
               <td width="4" align="left" valign="middle">&nbsp;</td>
               <td height="40" align="left" valign="middle"><input name="clear" type="reset" id="clear" value="Clear fields" class="button_1" /></td>
               <td align="right" valign="middle"><input name="submit_login" type="submit" id="submit_login" value="Login &raquo;" class="button_1" style="margin-right:35px;"/></td>
            </tr>
            <tr>
               <td width="4" align="left" valign="middle">&nbsp;</td>
               <td colspan="2" align="left" valign="middle">
			<?
			if(!empty($_GET['s1']) || !empty($_GET['s2']) || !empty($_GET['s3'])) {
				if(!empty($_GET['s1'])){$s = 1;}else if(!empty($_GET['s2'])){$s = 2;}else if(!empty($_GET['s3'])){$s = 3;}
				$status = $_GET['s'.$s];
				//s1: notice | s2: success | s3: error 
				echo '<div class="status'.$s.'" style="margin-top:15px;">'.$status.'</div>';
				echo '<div class="clear"></div>';
			}
			?>
			</td>
            </tr>
         </table>
         <div align="center"></div>
      </form>
   </div>
</div>
</body></html>
