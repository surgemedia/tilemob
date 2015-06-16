<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title></title>
<style type="text/css">
<!--
.Details {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #999999;
	font-style: normal;
	font-weight: normal;
}
.style5 {color: #666666}
.style6 {color: #990000}
body {
	margin-top: 0px;
}
-->
</style>
</head>

<body>
<table width="600" border="0">
  
  <tr>
    <th width="227" colspan="2" scope="row"><table width="600" border="0">
      <tr>
        <td width="560" align="left" valign="top">
		<img src="images/img_tm_logo_02.gif" alt="The Tile Mob"/>
		<?php
		$booking_code = date("dmyHis");
		
		//Get details from Form
		$sendto = 'sales@tilemob.com.au';
		//$sendto = 'richard@dmwcreative.com.au';
		$youare = $_POST['option_question1'];
		$yourname = $_POST['textfield_yourname'];
		$yourphone = $_POST['textfield_yournumber'];
		$yourphone2 = $_POST['textfield_yournumber2'];
		$yourcompany = $_POST['textfield_company'];
		$youremail = $_POST['textfield_youremail'];
		$youraddress = $_POST['textarea_youraddress'];
		$project_type = $_POST['option_question2']; 
		$project_commence = $_POST['option_question3']; 
		$subject = $_POST['textfield_subject'];
		$subject2 = "TileMob.com.au - Thank you for your Booking Appointment form ".$yourname;
		if($_POST['change_appointment'] == "true"){ $subject2 = "TileMob.com.au - Your appointment date/time has been changed by ".$yourname; }
		$bookingdate = $_POST['textfield_bookingdate'];
		$bookinghour = $_POST['textfield_bookinghour'];
		$bookingminute = $_POST['textfield_bookingminute'];
		$message_body2 = nl2br($_POST['textarea_message']);
		$message_body3 = $_POST['textarea_message'];
		
		//Link to change appointment page, contains all submitted values rawurlencoded (this is the passer)
		$booking_change_url = "http://tilemob.com.au/booking_form.php?"."booking_code=".rawurlencode($booking_code)."&youare=".rawurlencode($youare)."&yourname=".rawurlencode($yourname)."&yourphone=".rawurlencode($yourphone)."&yourphone2=".rawurlencode($yourphone2)."&yourcompany=".rawurlencode($yourcompany)."&youremail=".rawurlencode($youremail)."&youraddress=".rawurlencode($youraddress)."&project_type=".rawurlencode($project_type)."&project_commence=".rawurlencode($project_commence)."&subject=".rawurlencode($subject)."&bookingdate=".rawurlencode($bookingdate).
		"&bookinghour=".rawurlencode($bookinghour)."&bookingminute=".rawurlencode($bookingminute)."&message_body3=".rawurlencode($message_body3);
		
		ini_set("sendmail_from", $sendto);
		$mail_headers = "From: ".$sendto."\r\n";
		$mail_headers .= "Reply-To: ".$sendto."\r\n";
		$mail_headers .= "MIME-Version: 1.0\r\n";
		$mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$mail_headers .= "X-Mailer: PHP v".phpversion()."\r\n";  
		
		//Generate Email Message
		$message = 
			"<html><body style=\"font-family:Arial, Verdana, Geneva, sans-serif; font-size: 12px;\">
			<img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"><br/>
			Note: This BCC email was generated for sales@tilemob.com.au only. <br/>";
		if($_POST['change_appointment'] == "true"){
			$message .= 
			"<br>Your appointment date/time has been changed, please find your new appointment booking reference number and details below. 
			<br><b>Old Booking reference: #".$_POST['old_booking_code']."</b> <em>(cancelled)</em>
			<br><h3>New Booking reference: #".$booking_code."</h3>";
		} else {
			$message .= "<br><h3>Booking reference: #".$booking_code."</h3>".
			"Dear ".$yourname.", ".
			"<br>Thank you for your Appointment Booking form - We will contact you shortly!".
			"<br>You recently submitted an Appointment Booking form at TileMob.com.au with the following details: <br><br>";
		}
			$message .= 
			"<b>You are:</b> ".$youare.
			"<br><b>Name:</b> ".$yourname.
			"<br><b>Phone Number:</b> " .$yourphone.
			"<br><b>Tel/Mobile(other):</b> " .$yourphone2.
			"<br><b>Company Name:</b> " .$yourcompany.
			"<br><b>Email Address:</b> " .$youremail.
			"<br><b>Address:</b> " .$youraddress.
			"<br><b>Project Type:</b> ".$project_type.
			"<br><b>Project Commence:</b> ".$project_commence.
			"<br>".
			"<br>".$message_body2.
			"<br>".
			"<br>I wish to make an appointment at the following date/time: 
			<br><b>&nbsp;&nbsp; on ".$bookingdate.
			"<br>&nbsp;&nbsp; at ".$bookinghour." and ".$bookingminute." minutes.</b>
			<br><br><a href=\"URL:".$booking_change_url."\">Change my appointment</a></body></html>";
					
		//Generate Email Message - THIS IS BACK TO THE CUSTOMER (as a copy)
		$message2 = 
		"<html><body style=\"font-family:Arial, Verdana, Geneva, sans-serif; font-size: 12px;\">
		<img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"><br/>";
		if($_POST['change_appointment'] == "true"){
			$message2 .= 
			"<br>Your appointment date/time has been changed, please find your new appointment booking reference number and details below. 
			<br><b>Old Booking reference: #".$_POST['old_booking_code']."</b> <em>(cancelled)</em>
			<br><h3>New Booking reference: #".$booking_code."</h3>";
		} else {
			$message2 .= "<br><h3>Booking reference: #".$booking_code."</h3>".
			"Dear ".$yourname.", ".
			"<br>Thank you for your Appointment Booking form - We will contact you shortly!".
			"<br>You recently submitted an Appointment Booking form at TileMob.com.au with the following details: <br><br>";
		}
		$message2 .= 
			"<b>You are:</b> ".$youare.
			"<br><b>Name:</b> ".$yourname.
			"<br><b>Phone Number:</b> " .$yourphone.
			"<br><b>Tel/Mobile(other):</b> " .$yourphone2.
			"<br><b>Company Name:</b> " .$yourcompany.
			"<br><b>Email Address:</b> " .$youremail.
			"<br><b>Address:</b> " .$youraddress.
			"<br><b>Project Type:</b> ".$project_type.
			"<br><b>Project Commence:</b> ".$project_commence.
			"<br>".
			"<br>".$message_body2.
			"<br>".
			"<br>I wish to make an appointment at the following date/time: 
			<br><b>&nbsp;&nbsp; on ".$bookingdate.
			"<br>&nbsp;&nbsp; at ".$bookinghour." and ".$bookingminute." minutes.</b>
			<br><br><a href=\"URL:".$booking_change_url."\">Change my appointment</a></body></html>";
				   
		//Send Email		
		mail($youremail, $subject2, $message2, $mail_headers); //Send to customer copy
		//mail($sendto, $subject, $message, $mail_headers); //Send to sales
		mail("richard@dmwcreative.com.au", $subject, $message, $mail_headers); //BCC me :)
		//mail("richardcwc@gmail.com", $subject, $message, $mail_headers); //BCC me :)
		?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><p></p>
          <table width="400" border="0" cellspacing="0">
            <tr>
              <th width="40" align="left" valign="top" scope="row">&nbsp;</th>
              <th align="left" valign="top" scope="row"><p class="Details">Thank
                you, Appointment Booking form has been submitted. We will contact you shortly!<br/>
                    <br/>
                    <a href="#" onClick="javascript:self.close();"><b>Close this window.</b></a></p>
                </th>
            </tr>
          </table>          </td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></th>
  </tr>
</table>
</body>

</html>
