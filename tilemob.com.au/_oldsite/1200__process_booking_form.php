<html>
<head>
<?php
	//Get details from Form
	$sendto = 'sales@tilemob.com.au';
	//$sendto = 'richard@dmwcreative.com.au';
	$fields_array = array();
	$booking_code = date("dmyHis"); 
	$booking_code_temp = $booking_code{0}+$booking_code{1}.""; //1st digit
	$booking_code_temp .= $booking_code{2}+$booking_code{3}.""; //2nd digit
	$booking_code_temp .= $booking_code{4}+$booking_code{5}.""; //3rd digit
	$booking_code_temp .= $booking_code{6}+$booking_code{7}.""; //4th digit
	$booking_code_temp .= $booking_code{8}+$booking_code{9}.""; //5th digit
	$booking_code_temp .= $booking_code{10}+$booking_code{11}.""; //6th digit
	$booking_code = $booking_code_temp;
	$fields_array[0] = $booking_code;
	$youare = $_POST['option_question1']; $fields_array[1] = $youare;
	$yourname = $_POST['textfield_yourname']; $fields_array[2] = $yourname;
	$yourphone = $_POST['textfield_yournumber']; $fields_array[3] = $yourphone;
	$yourphone2 = $_POST['textfield_yournumber2']; $fields_array[4] = $yourphone2;
	$yourcompany = $_POST['textfield_company']; $fields_array[5] = $yourcompany;
	$youremail = $_POST['textfield_youremail']; $fields_array[6] = $youremail;
	$youraddress = $_POST['textarea_youraddress']; $fields_array[7] = $youraddress;
	$project_type = $_POST['option_question2'];  $fields_array[8] = $project_type;
	$project_commence = $_POST['option_question3'];  $fields_array[9] = $project_commence;
	$fields_array[10] = $subject;
	$fields_array[11] = $subject2;
	/*$bookingmonth = $_POST['textfield_bookingmonth'];
	$bookingday = $_POST['textfield_bookingday'];
	$bookingyear = $_POST['textfield_bookingyear'];*/
	$bookingmonth = date("F", strtotime($_POST['textfield_bookingfulldate']));
	$bookingday = date("d", strtotime($_POST['textfield_bookingfulldate']));
	$bookingyear = date("Y", strtotime($_POST['textfield_bookingfulldate']));
	//$bookingdate = $_POST['textfield_bookingdate']; $fields_array[12] = $bookingdate;
	$bookingdate = date("l, F d, Y", strtotime($bookingday." ".$bookingmonth." ".$bookingyear));
	$bookinghour = $_POST['textfield_bookinghour']; $fields_array[13] = $bookinghour;
	$bookingminute = $_POST['textfield_bookingminute']; $fields_array[14] = $bookingminute;
	$message_body2 = nl2br($_POST['textarea_message']);
	$message_body3 = $_POST['textarea_message']; $fields_array[15] = $message_body3;
	$project_address = $_POST['textarea_projectaddress']; $fields_array[16] = $project_address;
	$project_referer = $_POST['option_question4'];	$fields_array[17] = $project_referer;
	$project_referer_name = $_POST['textfield_referer'];  $fields_array[18] = $project_referer_name;
	$comments = $_POST['textarea_message'];
	$preferred_consultant = $_POST['preferred_consultant'];
	
	//Check which project type was selected
	//if($project_type == "Residential (new construction)" || $project_type == "Residential (renovation)"){
		//Get all checked checkbox values
		$residential_selection = $_POST['residential_selection']; //should be an array
		$residential_selection_serialized = base64_encode(serialize($residential_selection));
	//} else if($project_type == "Commercial (new construction)" || $project_type == "Commercial (renovation)") {
		$commercial_selection = $_POST['textfield_commercial_custom'];
	//}
	
	$encoded_array_value = base64_encode(serialize($fields_array));	
	
	$booking_madedate = date("d/m/y (H:ia)"); //Today's date (booking made date)
	
	//Add new booking data into the database
	include 'connection/bookingform.php';

	$result =  mysql_query("SELECT * FROM consultation");
	$num_rows = mysql_num_rows($result);
	$booking_code = $num_rows+1+11200; //number of bookings in the table + 1 + start booking off at number 11200
	//Now we add zeroes to booking_id so it makes a 5 digit code
	while(strlen($booking_code) < 5) {
		$booking_code = "0".$booking_code;
	}
	
	if($_GET['reschedule'] == "true" && isset($_GET['booking_id'])) {
		$booking_id = $_GET['booking_id'];
		
		$result = mysql_query("SELECT * FROM consultation WHERE booking_id = '$booking_id'");
		$row = mysql_fetch_array($result);
		$old_bookingdate = $row['booking_date'];
		$old_bookinghour = $row['booking_hour'];
		$old_bookingminute = $row['booking_minute'];
		$old_bookingtime = $old_bookingdate." ".trim(substr($old_bookinghour, 0, -2)).":".$old_bookingminute." ".substr($old_bookinghour, -2);
		
		//Update MYSQL database with new booking details of same booking id
		mysql_query("UPDATE consultation set
					booker_are = '$youare', 
					booker_name = '$yourname', 
					booker_phone1 = '$yourphone', 
					booker_phone2 = '$yourphone2', 
					booker_company = '$yourcompany', 
					booker_address = '$youraddress',
					booker_projecttype = '$project_type',
					booker_residential = '$residential_selection_serialized',
					booker_commercial = '$commercial_selection',
					booker_projectaddress = '$project_address', 
					booker_projectcommence = '$project_commence', 
					booker_referredby = '$project_referer', 
					booker_referralname = '$project_referer_name', 
					booker_preferredconsultant = '$preferred_consultant',
					booker_comments = '$comments', 
					booking_month = '$bookingmonth', 
					booking_day = '$bookingday', 
					booking_year = '$bookingyear', 
					booking_date = '$bookingdate', 
					booking_hour = '$bookinghour', 
					booking_minute = '$bookingminute', 
					booking_madedate = '$booking_madedate'
					WHERE booking_id = '$booking_id'") 
					or die('Error, query failed');	
		//Now send off the message
		sendBookingEmail($booking_id, true, $old_bookingtime);
	} else {
	//Add into MYSQL database
	mysql_query("ALTER TABLE consultation AUTO_INCREMENT = 1");
	mysql_query("INSERT into consultation
		(ID, booking_id, booker_email, booker_are, booker_name, booker_phone1, booker_phone2, booker_company,
		booker_address, booker_projecttype, booker_residential, booker_commercial, booker_projectaddress, booker_projectcommence, 
		booker_referredby, booker_referralname, booker_preferredconsultant, booker_comments, booking_month, booking_day, booking_year, 
		booking_date, booking_hour, booking_minute, booking_madedate)
		VALUES ('', '$booking_code', '$youremail','$youare','$yourname','$yourphone','$yourphone2','$yourcompany',	
		'$youraddress','$project_type','$residential_selection_serialized','$commercial_selection','$project_address',
		'$project_commence','$project_referer','$project_referer_name','$preferred_consultant',
		'$comments', '$bookingmonth', '$bookingday', '$bookingyear', '$bookingdate','$bookinghour','$bookingminute','$booking_madedate')") 
		or die('Error, query failed');
		//Now send off the message
		sendBookingEmail($booking_code, false, "");
	}
?>
<?
function sendBookingEmail($booking_id, $is_reschedule, $old_bookingtime) {
	$result = mysql_query("SELECT * FROM consultation WHERE booking_id = '$booking_id'");
	$row = mysql_fetch_array($result);
	
	$sendto = 'sales@tilemob.com.au';
	
	$booking_code = $row['booking_id'];
	$youare = $row['booker_are'];
	$yourname = $row['booker_name'];
	$yourphone = $row['booker_phone1'];
	$yourphone2 = $row['booker_phone2'];
	$yourcompany = $row['booker_company'];
	$youremail = $row['booker_email'];
	$youraddress = $row['booker_address'];
	$project_type = $row['booker_projecttype'];
		$residential_selection = unserialize(base64_decode($row['booker_residential'])); //should be an array
		$commercial_selection = $row['booker_commercial'];
	$project_commence = $row['booker_projectcommence'];
	$bookingdate = $row['booking_date'];
	$bookinghour = $row['booking_hour'];
	$bookingminute = $row['booking_minute'];
	$bookingtime = trim(substr($bookinghour, 0, -2)).":".$bookingminute." ".substr($bookinghour, -2);
	$booker_comments = $row['booker_comments'];
	$project_address = $row['booker_address'];
	$project_referer = $row['booker_referredby'];
	$project_referer_name = $row['booker_referralname'];
	$preferred_consultant = $row['booker_preferredconsultant'];
	if($is_reschedule == true){
		$subject = $yourname." wishes to reschedule Booking ".$booking_id;
		$subject2 = "tilemob.com.au - Your In-Showroom Consultation Booking ".$booking_id." has been rescheduled by ".$yourname;
	} else {
		$subject = $yourname." has made an Appointment using the In-Showroom Consultation Booking request.";
		$subject2 = "tilemob.com.au - Thank you for your In-Showroom Consultation Booking request ".$yourname;
	}
	
	//----------------------------------------------------------------------------------------------
	$booking_change_url = 'http://www.tilemob.com.au/booking_form.php?id='.$booking_code.'&email='.$youremail;
	
	ini_set("sendmail_from", $sendto);
	$mail_headers = "From: ".$sendto."\r\n";
	$mail_headers .= "Reply-To: ".$sendto."\r\n";
	$mail_headers .= "MIME-Version: 1.0\r\n";
	$mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$mail_headers .= "X-Mailer: PHP v".phpversion()."\r\n";  
	
	//Generate Email Message
	$message = 
		"<html><body style=\"font-family:Arial, Verdana, Geneva, sans-serif; font-size: 12px;\">
		<a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/img_tmlogoshowroom.gif\" border=\"0\" alt=\"tilemob.com.au\"></a><br/>
		<br/><b>Note: </b>This BCC email was generated for sales@tilemob.com.au only. <br/>";
	if($is_reschedule == true){
		$message .= 
		"<br>Your appointment date/time has been rescheduled, please find your new appointment booking details below.".
		"<br>Your old booking date/time was: ".$old_bookingtime." <em>(Cancelled)</em>".
		"<br><b>» Your new booking date/time is: ".$bookingdate." ".$bookingtime."</b>".
		"<br><h3>Booking reference: ".$booking_code."</h3>";
	} else {
		$message .= "<br><h3>Booking reference: ".$booking_code."</h3>".
		"Dear ".$yourname.", ".
		"<br>Thank you for your In-Showroom Consultation Booking request.".
		"<br>You recently submitted an In-Showroom Consultation Booking form at TileMob.com.au and we confirm the following details: <br><br>";
	}
		$message .= 
		"<br><h4>Your In-Showroom Consultation is confirmed for the following date/time: 
			<br>Date: ".$bookingdate.
			"<br>Time: ".$bookingtime."".
			"<br>(Requested consultant: ".$preferred_consultant.")</h4>".
			"<b>What to bring with you to your appointment: </b>".
			"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Information on your tile allowances (if applicable)".
			"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> House/project plans and drawings".
			"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Colour samples of laminates, paints, stone benchtops".
			"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Carpet samples you will be using".
			"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Magazine photos of styles and designs you like<br>";
	
		$message .= 
		"<br><b>You are:</b> ".$youare.
		"<br><b>Name:</b> ".$yourname.
		"<br><b>Phone Number:</b> " .$yourphone.
		"<br><b>Tel/Mobile(other):</b> " .$yourphone2.
		"<br><b>Company Name:</b> " .$yourcompany.
		"<br><b>Email Address:</b> " .$youremail.
		"<br><b>Address:</b> " .$youraddress.
		"<br><b>Project Type:</b> ".$project_type;
			if($project_type == "Residential (new construction)" || $project_type == "Residential (renovation)"){
				//go through all keys in the array, the key will be the values : )
				$message .= "<br><b>I will be selecting tiles for the following areas:</b>";
				foreach($residential_selection as $key => $value) {
					$message .= "<br>&nbsp;&nbsp;&nbsp;- ".stripslashes($key); //each selected checkbox will be on new bullet point line
				}
			} else if($project_type == "Commercial (new construction)" || $project_type == "Commercial (renovation)") {
				$message .= "<br><b>I will be selecting tiles for the following areas:</b> ".$commercial_selection;
			}
		$message .= "<br><b>Project Address:</b> ".$project_address.
		"<br><b>Project Commence:</b> ".$project_commence.
		"<br><b>Referred by:</b> ".$project_referer.
		"<br><b>Referrer name:</b> ".$project_referer_name.
		"<br>".
		"<br><em>".$booker_comments.
		"</em>".
		"<br> We have on street parking available as well as a customer car park at the rear of our building. We look forward
		to seeing you in our Showroom on your confirmed date.".
		"<br><a href=\"http://www.tilemob.com.au/contact-map.html\"><img src=\"http://www.tilemob.com.au/images/tile-mob-map.gif\" alt=\"4-6 Blackwood St (Cnr Samford Rd) Mitchelton Queensland Australia 4053\" border=\"0\"\"></a>".
		"<br><img src=\"http://www.tilemob.com.au/images/txt_showroom.gif\" alt=\"Showroom\" border=\"0\">".
		"<br>4-6 Blackwood St (Cnr Samford Rd) ".
		"<br>Mitchelton Queensland Australia 4053 ".
		"<br>PH (07) 3355 5055 ".
		"<br><br><a href=\"URL:".$booking_change_url."\">Reschedule my appointment</a>
		<br>or copy and paste the following URL into your browser: 
		<br>".$booking_change_url."</body></html>";
				
	//Generate Email Message - THIS IS BACK TO THE CUSTOMER (as a copy)
	$message2 = 
	"<html><body style=\"font-family:Arial, Verdana, Geneva, sans-serif; font-size: 12px;\">
	<a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/img_tmlogoshowroom.gif\" border=\"0\" alt=\"tilemob.com.au\"></a><br/>";
	if($is_reschedule == true){
		$message2 .= 
		"<br>Your appointment date/time has been rescheduled, please find your new appointment booking details below.".
		"<br>Your old booking date/time was: ".$old_bookingtime." <em>(Cancelled)</em>".
		"<br><b>» Your new booking date/time is: ".$bookingdate." ".$bookingtime."</b>".
		"<br><h3>Booking reference: ".$booking_code."</h3>";
	} else {
		$message2 .= "<br><h3>Booking reference: ".$booking_code."</h3>".
		"Dear ".$yourname.", ".
		"<br>Thank you for your In-Showroom Consultation Booking request.".
		"<br>You recently submitted an In-Showroom Consultation Booking form at TileMob.com.au and we confirm the following details: <br><br>";
	}
	$message2 .= 
	"<br><h4>Your In-Showroom Consultation is confirmed for the following date/time: 
		<br>Date: ".$bookingdate.
		"<br>Time: ".$bookingtime."".
		"<br>(Requested consultant: ".$preferred_consultant.")</h4>".
		"<b>What to bring with you to your appointment: </b>".
		"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Information on your tile allowances (if applicable)".
		"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> House/project plans and drawings".
		"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Colour samples of laminates, paints, stone benchtops".
		"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Carpet samples you will be using".
		"<br> &nbsp;&nbsp; <img src=\"http://www.tilemob.com.au/images/img_sqcheckbox.gif\" border=\"0\" align=\"absmiddle\" vspace=\"2\"> Magazine photos of styles and designs you like<br>";
	$message2 .= 
		"<br><b>You are:</b> ".$youare.
		"<br><b>Name:</b> ".$yourname.
		"<br><b>Phone Number:</b> " .$yourphone.
		"<br><b>Tel/Mobile(other):</b> " .$yourphone2.
		"<br><b>Company Name:</b> " .$yourcompany.
		"<br><b>Email Address:</b> " .$youremail.
		"<br><b>Address:</b> " .$youraddress.
		"<br><b>Project Type:</b> ".$project_type;
			if($project_type == "Residential (new construction)" || $project_type == "Residential (renovation)"){
				//go through all keys in the array, the key will be the values : )
				$message2 .= "<br><b>I will be selecting tiles for the following areas:</b>";
				foreach($residential_selection as $key => $value) {
					$message2 .= "<br>&nbsp;&nbsp;&nbsp;- ".stripslashes($key); //each selected checkbox will be on new bullet point line
				}
			} else if($project_type == "Commercial (new construction)" || $project_type == "Commercial (renovation)") {
				$message2 .= "<br><b>I will be selecting tiles for the following areas:</b> ".$commercial_selection;
			}
		$message2 .= "<br><b>Project Address:</b> ".$project_address.
		"<br><b>Project Commence:</b> ".$project_commence.
		"<br><b>Referred by:</b> ".$project_referer.
		"<br><b>Referrer name:</b> ".$project_referer_name.
		"<br>".
		"<br><em>".$booker_comments.
		"</em>".		
		"<br>".
		"<br> We have on street parking available as well as a customer car park at the rear of our building. We look forward
		to seeing you in our Showroom on your confirmed date.".
		"<br><a href=\"http://www.tilemob.com.au/contact-map.html\"><img src=\"http://www.tilemob.com.au/images/tile-mob-map.gif\" alt=\"4-6 Blackwood St (Cnr Samford Rd) Mitchelton Queensland Australia 4053\" border=\"0\"\"></a>".
		"<br><img src=\"http://www.tilemob.com.au/images/txt_showroom.gif\" alt=\"Showroom\" border=\"0\">".
		"<br>4-6 Blackwood St (Cnr Samford Rd) ".
		"<br>Mitchelton Queensland Australia 4053 ".
		"<br>PH (07) 3355 5055 ".
		"<br><br><a href=\"URL:".$booking_change_url."\">Reschedule my appointment</a>
		<br>or copy and paste the following URL into your browser: 
		<br>".$booking_change_url."</body></html>";
			   
	//Send Email		
	mail($youremail, $subject2, $message2, $mail_headers); //Send to customer copy
	mail($sendto, $subject, $message, $mail_headers); //Send to sales
	mail("richard@dmwcreative.com.au", $subject, $message, $mail_headers); //BCC me :)
	//mail("richardcwc@gmail.com", $subject, $message, $mail_headers); //BCC me :)
}
?>

<?
echo '<script type="text/javascript" charset="utf-8">';
echo 'self.location.replace("send_booking_form.php");';
echo '</script>';
?>
</head>

<body>
</body>
</html>
