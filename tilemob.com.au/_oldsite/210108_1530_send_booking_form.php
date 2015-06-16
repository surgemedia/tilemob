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
		//Get details from Form
		$sendto = 'sales@tilemob.com.au';
		//$sendto = 'richard@dmwcreative.com.au';
		$fields_array = array();
		/*$booking_code = date("dmyHis"); 
		$booking_code_temp = $booking_code{0}+$booking_code{1}.""; //1st digit
		$booking_code_temp .= $booking_code{2}+$booking_code{3}.""; //2nd digit
		$booking_code_temp .= $booking_code{4}+$booking_code{5}.""; //3rd digit
		$booking_code_temp .= $booking_code{6}+$booking_code{7}.""; //4th digit
		$booking_code_temp .= $booking_code{8}+$booking_code{9}.""; //5th digit
		$booking_code_temp .= $booking_code{10}+$booking_code{11}.""; //6th digit
		$booking_code = $booking_code_temp;*/
		$fields_array = unserialize(base64_decode($_GET['appointment']));
		/*$booking_code = $_GET['bookingcode'];
		//$fields_array[0] = $booking_code;
		$youare = $_POST['option_question1']; $fields_array[1] = $youare;
		$yourname = $_POST['textfield_yourname']; $fields_array[2] = $yourname;
		$yourphone = $_POST['textfield_yournumber']; $fields_array[3] = $yourphone;
		$yourphone2 = $_POST['textfield_yournumber2']; $fields_array[4] = $yourphone2;
		$yourcompany = $_POST['textfield_company']; $fields_array[5] = $yourcompany;
		$youremail = $_POST['textfield_youremail']; $fields_array[6] = $youremail;
		$youraddress = $_POST['textarea_youraddress']; $fields_array[7] = $youraddress;
		$project_type = $_POST['option_question2'];  $fields_array[8] = $project_type;
		$project_commence = $_POST['option_question3'];  $fields_array[9] = $project_commence;
		//$subject = $_POST['textfield_subject']; $fields_array[10] = $subject;
		$subject = $yourname." has made an Appointment using the Consultation Booking form.";
		$subject2 = "TileMob.com.au - Thank you for your Consultation Booking form ".$yourname;
		if($_POST['change_appointment'] == "true"){ 
		$subject = $yourname." has rescheduled their Appointment Booking date/time."; 
		$subject2 = "TileMob.com.au - Your appointment date/time has been changed by ".$yourname; 
		}
		 $fields_array[11] = $subject2;
		$bookingdate = $_POST['textfield_bookingdate']; $fields_array[12] = $bookingdate;
		$bookinghour = $_POST['textfield_bookinghour']; $fields_array[13] = $bookinghour;
		$bookingminute = $_POST['textfield_bookingminute']; $fields_array[14] = $bookingminute;
		$bookingtime = substr($bookinghour, 0, -2).":".$bookingminute." ".substr($bookinghour, -2);
		$message_body2 = nl2br($_POST['textarea_message']);
		$message_body3 = $_POST['textarea_message']; $fields_array[15] = $message_body3;
		$project_address = $_POST['textarea_projectaddress']; $fields_array[16] = $project_address;
		$project_referer = $_POST['option_question4'];	$fields_array[17] = $project_referer;
		$project_referer_name = $_POST['textfield_referer'];  $fields_array[18] = $project_referer_name;*/
		$booking_code = $fields_array[0];
		$youare = $fields_array[1];
		$yourname = $fields_array[2];
		$yourphone = $fields_array[3];
		$yourphone2 = $fields_array[4];
		$yourcompany = $fields_array[5];
		$youremail = $fields_array[6];
		$youraddress = $fields_array[7];
		$project_type = $fields_array[8];
		$project_commence = $fields_array[9];
		$subject = $fields_array[10];
		$subject2 = $fields_array[11];
		$bookingdate = $fields_array[12];
		$bookinghour = $fields_array[13];
		$bookingminute = $fields_array[14];
		$bookingtime = substr($bookinghour, 0, -2).":".$bookingminute." ".substr($bookinghour, -2);
		$message_body3 = $fields_array[15];
		$project_address = $fields_array[16];
		$project_referer = $fields_array[17];
		$project_referer_name = $fields_array[18];
		
		//Link to change appointment page, contains all submitted values rawurlencoded (this is the passer)
		/*$booking_change_url = "http://tilemob.com.au/booking_form.php?"."booking_code=".rawurlencode($booking_code)."&youare=".rawurlencode($youare)."&yourname=".rawurlencode($yourname)."&yourphone=".rawurlencode($yourphone)."&yourphone2=".rawurlencode($yourphone2)."&yourcompany=".rawurlencode($yourcompany)."&youremail=".rawurlencode($youremail)."&youraddress=".rawurlencode($youraddress)."&project_type=".rawurlencode($project_type)."&project_commence=".rawurlencode($project_commence)."&subject=".rawurlencode($subject)."&bookingdate=".rawurlencode($bookingdate).
		"&bookinghour=".rawurlencode($bookinghour)."&bookingminute=".rawurlencode($bookingminute)."&message_body3=".rawurlencode($message_body3);*/
		$encoded_array_value = base64_encode(serialize($fields_array));
		/*require 'includes/std.encryption.class.inc';
		$crypt = new encryption_class;
		$encrypt_result = $crypt->encrypt("appointment", $encoded_array_value, 20);
		$errors = $crypt->errors;*/
		//$read = fopen('http://www.snipurl.com/site/snip?r=simple&link=http://tilemob.com.au/booking_form.php?appointment='.$encoded_array_value, 'r');
		//$read = fopen('http://tinylink.co.za/api/rest.php?url=http://tilemob.com.au/booking_form.php?appointment='.$encoded_array_value, 'rb');
		//$booking_change_url = fread($read, 8192);
		//$booking_change_url = tinyurl('http://tilemob.com.au/booking_form.php?appointment='.$encoded_array_value);
		$booking_change_url = $_GET['reschedule'];
		
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
			"<br><br><a href=\"URL:".$booking_change_url."\"> » Reschedule my appointment</a></body></html>";
				   
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
