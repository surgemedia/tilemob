<?php 
session_start();
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');

//Captcha
/*require_once('captcha/recaptchalib.php');
$privatekey = "6LfNKM8SAAAAAAigIlknCLC8b6FRMBCxbRDWTBct";
$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);*/

if(!empty($_POST['fullname']) && !empty($_POST['email']) && !empty($_POST['enquiry'])) {
	$fullname = $_SESSION['contact_fullname'] = trim($_POST['fullname']);
	$email = $_SESSION['contact_email'] = trim($_POST['email']);
	$phone = $_SESSION['contact_phone'] = trim($_POST['phone']);
	if(empty($_POST['subject'])){$_SESSION['contact_subject']=$subject='Website enquiry form';}else{$_SESSION['contact_subject']=$subject=trim($_POST['subject']);}
	$enquiry = $_SESSION['contact_enquiry'] = trim($_POST['enquiry']);
	
	$message = $responder = '';
	
	//if (!$resp->is_valid) { //check that captcha code is correct
	if(trim($_POST['security'])!=$_SESSION['image_random_value_raw']) {
		header('location:contact-us.php?s3=Your form could not been sent because the verification code at the end of the form was entered incorrectly. Please try again.');
	} else {
		$message .= 'WEBSITE ENQUIRY FORM'."\n";
		$message .= 'TILESBRISBANE.COM'."\n";
		$message .= '******************************************************************'."\n";
		$message .= 'NAME: '.$fullname."\n";
		$message .= 'E-MAIL ADDRESS: '.$email."\n";	
		if(!empty($phone)){
			$message .= 'PHONE: '.$phone."\n";
		}		
		$message .= '******************************************************************'."\n";
		$message .= 'ENQUIRY/MESSAGE: '."\n";
		$message .= $enquiry."\n";
		$message .= '******************************************************************'."\n";
		$message .= 'End of message.'."\n";
		
		$store_message = $message;
		
		$sendto_admin = 'thetilemob@gmail.com';
		
		$strtotime = strtotime('now');
		
		ini_set('sendmail_from', $email);
		$mail_headers = "From: ".$email."\r\nReply-To: ".$email."";	
				
		if (mail($sendto_admin, $subject, $message, $mail_headers)) { //Send to admin
			mysql_query("INSERT INTO shop_forms 
			(form_id, form, subject, message, sendername, senderemail, receivername, receiveremail, is_deleted, strtotime) 
			VALUES ('', 'Contact form', '$subject', '$store_message', '$fullname', '$email', 'Admin', '$sendto_admin', '0', '$strtotime')");
			$last_insert_id = mysql_insert_id();
		}else{
			echo 'STOP MAIL!';
			exit;
		}
		
		ini_set('sendmail_from', $sendto_admin);
		$mail_headers = "From: ".$sendto_admin."\r\nReply-To: ".$sendto_admin.""; 
		
		$_SESSION['contact_fullname'] = '';
		$_SESSION['contact_email'] = '';
		$_SESSION['contact_phone'] = '';
		$_SESSION['contact_subject'] = '';
		$_SESSION['contact_enquiry'] = '';
		
		header('location:contact-us.php?s2=Thank you, your enquiry was sent!');
	}
}

$result_content = mysql_query("SELECT * FROM shop_content WHERE pageurl='$_pageurl' AND is_active='1'");
if($row_content = mysql_fetch_array($result_content)) {
	$content_id = $row_content['content_id'];
	$heading1 = $row_content['heading1'];
	$is_multicolumn = $row_content['is_multicolumn'];
	$indent_body2 = $row_content['indent_body2'];
	$body1 = str_replace("\'", "'", $row_content['body1']);
	$body1 = str_replace('\"', '"', $body1);
	$body2 = str_replace("\'", "'", $row_content['body2']);
	$body2 = str_replace('\"', '"', $body2);
	$metatitle = $row_content['metatitle'];
	$menulinkname = $row_content['menulinkname'];
	$pageurl = $row_content['pageurl'];
} else {
	header('location:index.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
?>
<script language="javascript">
function checkFields() {
	//alert("checking fields");
	emptyfields = "";		
	if(document.getElementById('fullname').value == '') {
		emptyfields += "\n   Your name *";
	}
	if(document.getElementById('email').value == '') {
		emptyfields += "\n   Your e-mail *";
	}
	if(document.getElementById('enquiry').value == '') {
		emptyfields += "\n   Your message *";
	}
	if(document.getElementById('security').value=='') {
		emptyfields += "\n   Spam protection verification code *";
	}
	
	//alert("checking fields");
	if (emptyfields!="") { //mandatories not completed!
		alertmessage = "You've forgotten these fields:\n";
		alert(alertmessage+emptyfields);
		return false;
	} else { //all mandatories filled in!
		return true;
	}
}
</script>
</head>

<body oncontextmenu="return false">
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="body" class="body">
		<div id="body_left" class="body_left">
			<?php include('includes/finder.php'); ?>
			<?php include('includes/store-categories.php'); ?>
                        <?php include('includes/featured-products.php'); ?>
			<div class="clear"></div>
		</div>
		<div id="body_right" class="body_right">
			<div id="pagebody" class="pagebody">
				<?php 
				if($_GET['s2']!=""){
					echo  '<h1 style="color:green;">'.$_GET['s2'].'</h1>';
				}
				if($_GET['s3']!=""){
					echo '<h1 style="color:RED;">'.$_GET['s3'].'</h1>';
				}
				$string = '<h1>'.$heading1.'</h1>';
				if($is_multicolumn==1) {
					if($indent_body2==1){$require_indent_style='<div class="indent_body2"></div>';}else{$require_indent_style='';}
					$string .= '
					<div id="col1" class="col1">
						'.$body1.'
					</div>
					<div id="col2" class="col2">
						'.$require_indent_style.'
						'.$body2.'
					</div>';
				} else {
					$string .= $body1;
				}
				echo $string;
				?>
				<div class="divider"></div>
				<h1>Send us an online enquiry</h1>
				<p>Please fill in all information marked with *</p>
				<form id="submitform" name="submitform" method="post" enctype="multipart/form-data" onsubmit="return checkFields();">				
				<table class="enquiry_table" width="100%">
					<tr>
						<td width="130"><b>Your name: </b>*</td>
						<td><input type="text" id="fullname" name="fullname" value="<?php echo $_SESSION['contact_fullname']; ?>" class="textfield1" style="width:300px;"></td>	
					</tr>
					<tr>
						<td><b>Your e-mail: </b>*</td>
						<td><input type="text" id="email" name="email" value="<?php echo $_SESSION['contact_email']; ?>" class="textfield1" style="width:300px;"></td>	
					</tr>
					<tr>
						<td><b>Phone number: </b></td>
						<td><input type="text" id="phone" name="phone" value="<?php echo $_SESSION['contact_phone']; ?>" class="textfield1" style="width:300px;"></td>	
					</tr>
					<tr>
						<td><b>Subject:</b></td>
						<td><input type="text" id="subject" name="subject" value="<?php echo $_SESSION['contact_subject']; ?>" class="textfield1" style="width:75%;"></td>
					</tr>
					<tr>
						<td colspan="2" height="30"><b>Please type your message below: *</b></td>
					</tr>
					<tr>
						<td colspan="2">
						<textarea id="enquiry" name="enquiry" class="textarea1" style="width:80%;height:80px;"><?php echo $_SESSION['contact_enquiry']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div style="float:left;width:250px;padding-top:5px;padding-right:15px;"><b>Spam protection</b><p>Please verify that you are human by entering this code into the field before submitting: <span class="asterisk">*</span></p></div>
							<div style="float:left;padding-top:15px;">
							<?php
							/*require_once('captcha/recaptchalib.php');
							$publickey = "6LfNKM8SAAAAAIAnQbkCNy-OiUbaYzJrCswONkfI"; 
							echo recaptcha_get_html($publickey);*/
							?>
							<img src="randomImage.php" border="0" align="absmiddle"/><br/>
							<input type="text" name="security" id="security" class="textfield1" style="width:100px;margin-top:3px;"/>
							</div>
						</td>
					</tr>
					<tr>
					<td height="30" colspan="2">
						<input type="reset" id="clear" name="clear" value="Clear form"> 
						<input type="submit" id="submit" name="submit" value="Submit">
					</td>
					</tr>
				</table>
				</form>
				<div class="clear"></div>
			</div>
			<div id="backtotop" class="backtotop"><?php include('includes/backtotop.php'); ?></div>
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