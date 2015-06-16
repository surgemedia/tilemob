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
		//Get details from database
		if(isset($_GET['booking_id']) && $_GET['booking_id'] != "") {
			$booking_id = $_GET['booking_id'];
			include 'connection/bookingform.php';
			$result = mysql_query("SELECT * FROM consultation WHERE booking_id = '$booking_id'");
			$row = mysql_fetch_array($result);
			
			$sendto = 'sales@tilemob.com.au';
			
			$booking_id = $row['booking_id'];
			$youare = $row['booker_are'];
			$yourname = $row['booker_name'];
			$yourphone = $row['booker_phone1'];
			$yourphone2 = $row['booker_phone2'];
			$yourcompany = $row['booker_company'];
			$youremail = $row['booker_email'];
			$youraddress = $row['booker_address'];
			$project_type = $row['booker_projecttype'];
			$project_commence = $row['booker_projectcommence'];
			$subject = $yourname." has made an Appointment using the Consultation Booking form.";
			$subject2 = "TileMob.com.au - Thank you for your Consultation Booking form ".$yourname;
			$bookingdate = $row['booking_date'];
			$bookinghour = $row['booking_hour'];
			$bookingminute = $row['booking_minute'];
			$bookingtime = $bookingdate." ".$bookinghour.":".$bookingminute;
			$booker_comments = $row['booker_comments'];
			$project_address = $row['booker_address'];
			$project_referer = $row['booker_referredby'];
			$project_referer_name = $row['booker_referredname'];
			
			//----------------------------------------------------------------------------------------------
			//$booking_change_url = $_GET['reschedule'];
			
			ini_set("sendmail_from", $sendto);
			$mail_headers = "From: ".$sendto."\r\n";
			$mail_headers .= "Reply-To: ".$sendto."\r\n";
			$mail_headers .= "MIME-Version: 1.0\r\n";
			$mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mail_headers .= "X-Mailer: PHP v".phpversion()."\r\n";  
			
			//Generate Email Message
			$message = 
				"<html><body style=\"font-family:Arial, Verdana, Geneva, sans-serif; font-size: 12px;\">
				<a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"></a><br/>
				Note: This BCC email was generated for sales@tilemob.com.au only. <br/>";
			if($_POST['change_appointment'] == "true"){
				$message .= 
				"<br>Your appointment date/time has been changed, please find your new appointment booking reference number and details below. 
				<br><b>Old Booking reference: #".$_POST['old_booking_code']."</b> <em>(cancelled)</em>
				<br><h3>New Booking reference: #".$booking_code."</h3>";
			} else {
				$message .= "<br><h3>Booking reference: #".$booking_code."</h3>".
				"Dear ".$yourname.", ".
				"<br>Thank you for your In-Showroom Consultation Booking form - We will contact you shortly!".
				"<br>You recently submitted an In-Showroom Consultation Booking form at TileMob.com.au with the following details: <br><br>";
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
				"<br><b>Project Address:</b> ".$project_address.
				"<br><b>Project Commence:</b> ".$project_commence.
				"<br><b>Referred by:</b> ".$project_referer.
				"<br><b>Referrer name:</b> ".$project_referer_name.
				"<br>".
				"<br>".$message_body2.
				"<br>".
				"<br><h5>I wish to make an appointment at the following date/time: 
				<br>Date: ".$bookingdate.
				"<br>Time: ".$bookingtime."</h5>".
				"<b>What to bring with you to your appointment: </b>".
				"<br> &nbsp;&nbsp; - Information on your tile and allowances (if applicable)".
				"<br> &nbsp;&nbsp; - House/project plans and drawings".
				"<br> &nbsp;&nbsp; - Colour samples of laminates, paints, stone benchtops".
				"<br> &nbsp;&nbsp; - Carpet samples you will be using".
				"<br> &nbsp;&nbsp; - Magazine photos of styles and designers you like".
				"<br>".
				"<br> We have street parking available as well as a custom car park at the rear of our building. We look forward
				to your In-Showroom appointment on your confirmation date.".
				"<br><a href=\"http://tilemob.com.au/contact-map.html\"><img src=\"http://tilemob.com.au/images/tile-mob-map.gif\" alt=\"4-6 Blackwood St (Cnr Samford Rd) Mitchelton Queensland Australia 4053\" border=\"0\"\"></a>".
				"<br><img src=\"http://tilemob.com.au/images/txt_showroom.gif\" border=\"0\">".
				"<br>4-6 Blackwood St (Cnr Samford Rd) ".
				"<br>Mitchelton Queensland Australia 4053 ".
				"<br>PH (07) 3355 5055 ".
				"<br><br><a href=\"URL:".$booking_change_url."\">Reschedule my appointment</a></body></html>";
						
			//Generate Email Message - THIS IS BACK TO THE CUSTOMER (as a copy)
			$message2 = 
			"<html><body style=\"font-family:Arial, Verdana, Geneva, sans-serif; font-size: 12px;\">
			<a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"></a><br/>";
			if($_POST['change_appointment'] == "true"){
				$message2 .= 
				"<br>Your appointment date/time has been changed, please find your new appointment booking reference number and details below. 
				<br><b>Old Booking reference: #".$_POST['old_booking_code']."</b> <em>(cancelled)</em>
				<br><h3>New Booking reference: #".$booking_code."</h3>";
			} else {
				$message2 .= "<br><h3>Booking reference: #".$booking_code."</h3>".
				"Dear ".$yourname.", ".
				"<br>Thank you for your In-Showroom Consultation Booking form - We will contact you shortly!".
				"<br>You recently submitted an In-Showroom Consultation Booking form at TileMob.com.au with the following details: <br><br>";
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
				"<br><b>Project Address:</b> ".$project_address.
				"<br><b>Project Commence:</b> ".$project_commence.
				"<br><b>Referred by:</b> ".$project_referer.
				"<br><b>Referrer name:</b> ".$project_referer_name.
				"<br>".
				"<br>".$message_body2.
				"<br>".
				"<br><h5>I wish to make an appointment at the following date/time: 
				<br>Date: ".$bookingdate.
				"<br>Time: ".$bookingtime."</h5>".
				"<b>What to bring with you to your appointment: </b>".
				"<br> &nbsp;&nbsp; - Information on your tile and allowances (if applicable)".
				"<br> &nbsp;&nbsp; - House/project plans and drawings".
				"<br> &nbsp;&nbsp; - Colour samples of laminates, paints, stone benchtops".
				"<br> &nbsp;&nbsp; - Carpet samples you will be using".
				"<br> &nbsp;&nbsp; - Magazine photos of styles and designers you like".
				"<br>".
				"<br> We have street parking available as well as a custom car park at the rear of our building. We look forward
				to your In-Showroom appointment on your confirmation date.".
				"<br><a href=\"http://tilemob.com.au/contact-map.html\"><img src=\"http://tilemob.com.au/images/tile-mob-map.gif\" alt=\"4-6 Blackwood St (Cnr Samford Rd) Mitchelton Queensland Australia 4053\" border=\"0\"\"></a>".
				"<br><img src=\"http://tilemob.com.au/images/txt_showroom.gif\" border=\"0\">".
				"<br>4-6 Blackwood St (Cnr Samford Rd) ".
				"<br>Mitchelton Queensland Australia 4053 ".
				"<br>PH (07) 3355 5055 ".
				"<br><br><a href=\"URL:".$booking_change_url."\"> » Reschedule my appointment</a></body></html>";
					   
			//Send Email		
			mail($youremail, $subject2, $message2, $mail_headers); //Send to customer copy
			//mail($sendto, $subject, $message, $mail_headers); //Send to sales
			mail("richard@dmwcreative.com.au", $subject, $message, $mail_headers); //BCC me :)
			//mail("richardcwc@gmail.com", $subject, $message, $mail_headers); //BCC me :)
		}
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
          </table></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></th>
  </tr>
</table>
</body>

</html>
