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
		$subject = $_POST['textfield_subject'];
		$subject2 = "TileMob.com.au - Thank you for your Booking Appointment form ".$yourname;
		$bookingdate = $_POST['textfield_bookingdate'];
		$bookinghour = $_POST['textfield_bookinghour'];
		$bookingminute = $_POST['textfield_bookingminute'];
		$message_body2 = nl2br($_POST['textarea_message']);
		
		ini_set("sendmail_from", $sendto);
		$mail_headers = "From: ".$sendto."\r\n";
		$mail_headers .= "Reply-To: ".$sendto."\r\n";
		$mail_headers .= "MIME-Version: 1.0\r\n";
		$mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$mail_headers .= "X-Mailer: PHP v".phpversion()."\r\n";  
		
		//Generate Email Message
		$message = 
			"<img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"><br/>".
					"<br><h3>Booking reference: #".$booking_code."</h3>".
					"<br>Name: ".$yourname.
					"<br>Phone Number: " .$yourphone.
					"<br>Tel/Mobile(other): " .$yourphone2.
					"<br>Company Name: " .$yourcompany.
					"<br>Email Address: " .$youremail.
					"<br>Address: " .$youraddress.
					"<br>".
					"<br>".$message_body2.
					"<br>".
					"<br>I wish to make an appointment at the following date/time: 
					<br><b>&nbsp;&nbsp; on ".$bookingdate.
					"<br>&nbsp;&nbsp; at ".$bookinghour." and ".$bookingminute." minutes.</b>";
					
		//Generate Email Message - THIS IS BACK TO THE CUSTOMER (as a copy)
		$message2 = 
		"<img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"><br/>".
			"<br>Dear ".$yourname.", ".
			"<br>Thank you for your Appointment Booking form - We will contact you shortly!".
			"<br>You recently submitted an Appointment Booking form at TileMob.com.au with the following details:".
			"<br><h3>Booking reference: #".$booking_code."</h3>".
			"<br>Name: ".$yourname.
			"<br>Phone Number: " .$yourphone.
			"<br>Tel/Mobile(other): " .$yourphone2.
			"<br>Company Name: " .$yourcompany.
			"<br>Email Address: " .$youremail.
			"<br>Address: " .$youraddress.
			"<br>".
			"<br>".$message_body2.
			"<br>".
			"<br>I wish to make an appointment at the following date/time: 
			<br><b>&nbsp;&nbsp; on ".$bookingdate.
			"<br>&nbsp;&nbsp; at ".$bookinghour." and ".$bookingminute." minutes.</b>";
				   
		//Send Email		
		mail($youremail, $subject2, $message2, $mail_headers); //Send to customer copy
		mail($sendto, $subject, $message, $mail_headers); //Send to sales
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
