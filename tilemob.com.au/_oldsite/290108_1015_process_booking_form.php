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
	//$subject = $_POST['textfield_subject']; $fields_array[10] = $subject;
	$subject = $yourname." has made an Appointment using the Consultation Booking form.";
	$subject2 = "TileMob.com.au - Thank you for your Consultation Booking form ".$yourname;
	if($_POST['change_appointment'] == "true"){ 
	$subject = $yourname." has rescheduled their Appointment Booking date/time."; 
	$subject2 = "TileMob.com.au - Your appointment date/time has been changed by ".$yourname; 
	}
	$fields_array[10] = $subject;
	$fields_array[11] = $subject2;
	$bookingdate = $_POST['textfield_bookingdate']; $fields_array[12] = $bookingdate;
	$bookinghour = $_POST['textfield_bookinghour']; $fields_array[13] = $bookinghour;
	$bookingminute = $_POST['textfield_bookingminute']; $fields_array[14] = $bookingminute;
	$bookingtime = substr($bookinghour, 0, -2).":".$bookingminute." ".substr($bookinghour, -2);
	$message_body2 = nl2br($_POST['textarea_message']);
	$message_body3 = $_POST['textarea_message']; $fields_array[15] = $message_body3;
	$project_address = $_POST['textarea_projectaddress']; $fields_array[16] = $project_address;
	$project_referer = $_POST['option_question4'];	$fields_array[17] = $project_referer;
	$project_referer_name = $_POST['textfield_referer'];  $fields_array[18] = $project_referer_name;
	
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
	$booking_change_url = 'http://tilemob.com.au/booking_form.php?appointment='.$encoded_array_value;
	/*echo 
	"
<script src=\"includes/ajax.js\"></script>
<script>
window.onload = function() {
	var AjaxGet = new Ajax();
	AjaxGet.addParam('link', '".$booking_change_url."');
	AjaxGet.addParam('format', 'JSON');
	AjaxGet.addCallback(getAjaxData);
	alert('works here 1');
	AjaxGet.getRequest('GET', 'http://www.g8l.us/api/shrink/', true);
	alert('works here 2');
	
}

function getAjaxData(response){
	var responseObject = eval(\"(\" + response + \")\");
		alert(\"works\"+responseObject.newLink);
		self.location.replace('send_booking_form.php?appointment=".$encoded_array_value."&reschedule='+responseObject.newLink);
}
</script>
";*/

echo "
<script type=\"text/javascript\" charset=\"utf-8\">
window.onload = function() {
var s = document.createElement('script');
var shrinkThis = escape('".$booking_change_url."');
s.setAttribute('src', 'http://remysharp.com/tinyurlapi?callback=tinyurlCallback&url='+shrinkThis);
//s.setAttribute('src', 'http://arunaurl.com/create_url.php?&type=js&url='+shrinkThis);
document.body.appendChild(s);
}

function tinyurlCallback(url) {
  //alert('URL converted to: ' + url);
  self.location.replace('send_booking_form.php?appointment=".$encoded_array_value."&reschedule='+url);
}
</script>
";
?>
</head>

<body>
</body>
</html>
