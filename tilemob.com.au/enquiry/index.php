<?php
session_start();
include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('../includes/prerun.php'); //Other things missed out

if(!empty($_POST['textfield_yourname']) && !empty($_POST['textfield_yournumber']) && !empty($_POST['textfield_youremail']) && !empty($_POST['textarea_youraddress'])) {	
	$yourname = $_SESSION['textfield_yourname'] = trim($_POST['textfield_yourname']);
	$yourphone = $_SESSION['textfield_yournumber'] = trim($_POST['textfield_yournumber']);
	$yourphone2 = $_SESSION['textfield_yournumber2'] = trim($_POST['textfield_yournumber2']);
	$yourcompany = $_SESSION['textfield_company'] = trim($_POST['textfield_company']);
	$youremail = $_SESSION['textfield_youremail'] = trim($_POST['textfield_youremail']);
	$youraddress = $_SESSION['textarea_youraddress'] = trim($_POST['textarea_youraddress']);
	$subject = $_SESSION['textfield_subject'] = trim($_POST['textfield_subject']);
	$message_body2 = nl2br(trim($_POST['textarea_message2']));
	$_SESSION['textarea_message2'] = trim($_POST['textarea_message2']);
	
	if(trim($_POST['security'])==$_SESSION['image_random_value_raw']) {
		$sendfrom = 'sender@tilesbrisbane.com.au';//'thetilemob@gmail.com';
		$sendto = 'sales@tilemob.com';//'thetilemob@gmail.com';
		//$sendto = 'richard@dmwcreative.com.au';
		$subject2 = "TileMob.com.au - Thank you for your enquiry ".$yourname;		
		ini_set("sendmail_from", $sendto);
		$mail_headers = "From: ".$sendto."\r\n";
		$mail_headers .= "Return-Path: ".$sendto."\r\n";
		$mail_headers .= "Reply-To: ".$sendto."\r\n";
		$mail_headers .= "MIME-Version: 1.0\r\n";
		$mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$mail_headers .= "X-Mailer: PHP v".phpversion()."\r\n";  
		
		if(($yourname!=$yourphone)&&($yourname!=$yourphone2)) {
			//Generate Email Message
			$message = 
				"<img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"><br/>".
				"<br>Name: ".$yourname.
				"<br>Phone Number: " .$yourphone.
				"<br>Tel/Mobile(other): " .$yourphone2.
				"<br>Company Name: " .$yourcompany.
				"<br>Email Address: " .$youremail.
				"<br>Address: " .$youraddress.
				"<br>".
				"<br>".$message_body2.
				"<br>";
						
			//Generate Email Message - THIS IS BACK TO THE CUSTOMER (as a copy)
			$message2 = 
			"<img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"><br/>".
				"<br>Dear ".$yourname.", ".
				"<br>Thank you for your enquiry - We will contact you shortly to help answer your enquiries!".
				"<br>You recently submitted an enquiry form at TileMob.com.au with the following details:".
				"<br>Name: ".$yourname.
				"<br>Phone Number: " .$yourphone.
				"<br>Tel/Mobile(other): " .$yourphone2.
				"<br>Company Name: " .$yourcompany.
				"<br>Email Address: " .$youremail.
				"<br>Address: " .$youraddress.
				"<br>".
				"<br>".$message_body2.
				"<br>";
					   
			//Send Email
			mail($sendto, $subject, $message, $mail_headers); //Send to sales
			mail($youremail, $subject2, $message2, $mail_headers); //Send to customer copy
			//mail("richard@dmwcreative.com.au", $subject, $message, $mail_headers); //BCC me :)
			
			$_SESSION['textfield_yourname'] = '';
			$_SESSION['textfield_yournumber'] = '';
			$_SESSION['textfield_yournumber2'] = '';
			$_SESSION['textfield_company'] = '';
			$_SESSION['textfield_youremail'] = '';
			$_SESSION['textarea_youraddress'] = '';
			$_SESSION['textfield_subject'] = '';
			$_SESSION['textarea_message2'] = '';
			header('location:index.php?sent=Thank you for your enquiry!');
		}
	} else {
		header('location:index.php?error=Please enter the correct verification code and try again');
	}
}
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
<title>Tiles Brisbane Tile Showroom | stone mosaics slate tiles terracotta ceramic tiles | Brisbane Floor & Wall Tile Supplies | Complete Tile Range Brisbane QLD | tilemob.com.au/enquiry/</title>
<script language="javascript">
function checkFields() {
	emptyfields = "";
	if (document.getElementById('textfield_yourname').value == "") {
		emptyfields += "\n   *Your Name";
	}
	if(document.getElementById('textfield_yournumber').value == "") {
		emptyfields += "\n   *Your Phone Number";
	}
	if (document.getElementById('textfield_youremail').value == "") {
		emptyfields += "\n   *Your Email";
	}
	if (document.getElementById('textarea_youraddress').value == "") {
		emptyfields += "\n   *Your Address";
	}
	if (document.getElementById('security').value == "") {
		emptyfields += "\n   *Verification Code";
	}
	if (emptyfields!= "") {
		emptyfields = "It looks like you've forgotten these fields:\n"+emptyfields;
		alert(emptyfields);
	return false;
	}
	else return true;
}
</script>
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
			<?php 
			echo $body;
			if(!empty($_GET['error'])) {
				echo '<div class="clear"><span class="status3">'.$_GET['error'].'</span></div>';
			} else if(!empty($_GET['sent'])) {
				echo '<div class="clear"><span class="status2">'.$_GET['sent'].'</span></div>';
			}
			?>
			<div class="clear">
			<form id="enquiry_form" name="enquiry_form" onsubmit="return checkFields()" method="post">
			<table width="790" border="0" align="center">  
			  <tr>
				<th width="50%" align="right" valign="top" scope="row"><table width="375" border="0" cellspacing="5">
				  <tr>
					<th valign="top" scope="row">&nbsp;</th>
					<td align="left">&nbsp;</td>
					<td align="left"><span class="asterisk">*</span> All marked fields are compulsory </td>
				  </tr>
				  <tr>
					<th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Your Name: </div></th>
					<td width="2%" align="left">&nbsp;</td>
					<td align="left"><label>
					  <input class="textfield1" name="textfield_yourname" type="text" id="textfield_yourname" value="<?php if(!empty($_SESSION['textfield_yourname'])){echo $_SESSION['textfield_yourname'];} ?>" size="30" />
					</label></td>
				  </tr>
				  <tr>
					<th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Your
						Phone Number: </div></th>
					<td align="left">&nbsp;</td>
					<td align="left"><input class="textfield1" name="textfield_yournumber" type="text" id="textfield_yournumber" value="<?php if(!empty($_SESSION['textfield_yournumber'])){echo $_SESSION['textfield_yournumber'];} ?>" size="30" /></td>
				  </tr>
				  <tr>
					<th valign="top" scope="row"><div align="right">Tel/Mobile (other): </div></th>
					<td align="left">&nbsp;</td>
					<td align="left"><input class="textfield1" name="textfield_yournumber2" type="text" id="textfield_yournumber2" value="<?php if(!empty($_SESSION['textfield_yournumber2'])){echo $_SESSION['textfield_yournumber2'];} ?>" size="30" /></td>
				  </tr>
				  <tr>
					<th valign="top" scope="row"><div align="right">Company
						Name: </div></th>
					<td align="left">&nbsp;</td>
					<td align="left"><input class="textfield1" name="textfield_company" type="text" id="textfield_company" value="<?php if(!empty($_SESSION['textfield_company'])){echo $_SESSION['textfield_company'];} ?>" size="30" /></td>
				  </tr>
				  <tr>
					<th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Email
						Address: </div></th>
					<td align="left">&nbsp;</td>
					<td align="left"><input class="textfield1" name="textfield_youremail" type="text" id="textfield_youremail" value="<?php if(!empty($_SESSION['textfield_youremail'])){echo $_SESSION['textfield_youremail'];} ?>" size="30" /></td>
				  </tr>
				  <tr>
					<th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Your
						Address: </div></th>
					<td>&nbsp;</td>
					<td align="left"><textarea class="textarea1" name="textarea_youraddress" id="textarea_youraddress" style="width:92%;height:50px;"><?php if(!empty($_SESSION['textarea_youraddress'])){echo $_SESSION['textarea_youraddress'];} ?></textarea></td>
				  </tr>
				  <tr>
					<th valign="top" scope="row">&nbsp;</th>
					<td align="left">&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>      
				</table></th>
				<th width="50%" align="left" valign="top" scope="row"><table width="385" border="0" cellspacing="5">
				  <tr>
					<th width="15%" valign="top" scope="row"><div align="left">Subject: </div></th>
					</tr>
				  <tr>
					<th valign="top" scope="row"><div align="right">
					  <div align="left">
						<input class="textfield1" name="textfield_subject" type="text" id="textfield_subject" value="Please contact me about my following enquiry" size="58"/>
					  </div>
					</div></th>
					</tr>      
				  <tr>
					<th valign="top" scope="row">
					Your additional comments - Please edit:
					</th>
				  </tr>
				  <tr>
					<th valign="top" scope="row"><div align="left">
					  <textarea class="textarea1" name="textarea_message2" cols="55" rows="10" id="textarea_message2">
<?php if(empty($_SESSION['textarea_message2'])){ 
echo 'Dear Tile Mob,

Please edit your message here...'; 
}else{echo $_SESSION['textarea_message2'];} ?></textarea>
					</div></th>
				  </tr>
				  
				</table></th>
			  </tr>
			  <tr>
					<td>&nbsp;</td>
					<td><span>To protect us from spam, please enter the below verification code:</span> <span class="asterisk">*</span></td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td><input type="text" id="security" name="security" class="textfield1" style="width:80px;display:inline;float:left;"> <img src="randomImage.php" border="0" align="absmiddle"/></td>
				  </tr>
			  <tr>
				<td valign="middle" scope="row" height="50" align="center"><input name="clear_form" type="reset" id="clear_form" value="Clear Form" /></td>
				<td valign="middle" scope="row" align="center"><input name="submit_form" type="submit" id="submit_form" value="Submit Enquiry" />
				</td>
			  </tr>
			</table>
			</form>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('../includes/footer.php'); ?></div>
	<div id="seo_footer" class="seo_footer"><?php include('../includes/seo_footer.php'); ?></div>
</div>
<?php include('../includes/end_body.php'); ?>
</body>