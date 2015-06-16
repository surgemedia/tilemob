<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<? include('includes/meta_data.inc'); ?>
<? include('includes/attach_styles.inc'); ?>
<? include('includes/attach_scripts.inc'); ?>
<?
//RETRIEVE POST CONTACT FORM DATA
$contactform_status = ""; //Later echoes whether it was submitted or not
if (isset($_POST['penquiry_submit'])) {
	$penquiry_name = $_POST['penquiry_name'];
	$penquiry_email = $_POST['penquiry_email'];
	$penquiry_preferrednumber = $_POST['penquiry_preferrednumber'];
	$penquiry_preferredtime = $_POST['penquiry_preferredtime'];
	$penquiry_message = $_POST['penquiry_message'];
	
	//$mail_headers = "From: enquiries@pampered.com.au\r\nReply-To: admin@pampered.com.au"; 
	$penquiry_subject = "Glynis Austin - Property Enquiry contact form";
	$penquiry_fullmessage = 
		'<html><body style="font-family: Arial, Verdana, Geneva, sans-serif; font-size: 12px; a:LINK, a:VISITED {color: #CC9966;text-decoration: underline;}">
		<img src="http://www.dmwcreative.com.au/richard/glynisaustin/images/img_logo_white.gif" alt="Glynis Austin Properties" border="0">'.
		'<br/>'.$penquiry_name." has submitted an enquiry using the Property Enquiry contact form.
		<br/><b>Name:</b> ".$penquiry_name.
		"<br/><b>Email:</b> ".$penquiry_email.
		"<br/><b>Preferred Number:</b> ".$penquiry_preferrednumber.
		"<br/><b>Preferred Time:</b> ".$penquiry_preferredtime.
		"<br/><b>Message:</b> \"".$penquiry_message."\"<br/></body></html>";
	
	$mail_headers = "MIME-Version: 1.0\r\n";
	$mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$mail_headers .= "X-Mailer: PHP v".phpversion()."\r\n"; 
	
	//Now send message
	mail("richard@dmwcreative.com.au", stripslashes($penquiry_subject), stripslashes($penquiry_fullmessage), $mail_headers);
	
	//Message sent, update status
	$contactform_status = "Thank you for your enquiry!"; 
}
?>
<script language=javascript>
function checkMandatoryFields(this_form) {
	emptyfields = "";
	if (document.form_propertyenquiry.penquiry_name.value == "") {
		emptyfields += "\nYour Name!";
	}
	if (document.form_propertyenquiry.penquiry_email.value == "") {
		emptyfields += "\nYour Email Address!";
	}
	if (document.form_propertyenquiry.penquiry_preferrednumber.value == "") {
		emptyfields += "\nPreferred Number!";
	}
	if (document.form_propertyenquiry.penquiry_preferredtime.value == "") {
		emptyfields += "\nPreferred Time!";
	}
	if (document.form_propertyenquiry.penquiry_message.value == "") {
		emptyfields += "\nYour Message!";
	}
	
	if (emptyfields != "") {
		alert("The following fields are mandatory "+emptyfields);
		return false;
	} else { 
		return true;
	}
}
</script>
<script type="text/JavaScript">
window.onload = function(){
	document.getElementById("hidable_row3").style.display = 'none'; 
	document.getElementById("hidable_row4").style.display = 'none'; 
}
function rollover_img (bi, im){
document.getElementById(bi).src = im;
}

function showMoreImages(){
	if(document.getElementById("hidable_row3").style.display == 'none') {
		if (navigator.appName == "Microsoft Internet Explorer") {
			document.getElementById("hidable_row3").style.display = 'inline'; 
			document.getElementById("hidable_row4").style.display = 'inline'; 
		} else {
			document.getElementById("hidable_row3").style.display = 'table-row'; 
			document.getElementById("hidable_row4").style.display = 'table-row'; 
		}
	} else {
		document.getElementById("hidable_row3").style.display = 'none';
		document.getElementById("hidable_row4").style.display = 'none';
	}
}
</script>
<link rel = "stylesheet" type = "text/css" href = "styles/lightbox.css" />
<script type="text/javascript" src="includes/prototype.js"></script>
<script type="text/javascript" src="includes/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="includes/lightbox.js"></script>
<STYLE TYPE="text/css">
ul {
	padding: 0;
	margin: 0;
	margin-left: 2px;
}
</STYLE>
</head>

<body>
<div class="container">
<div class="site">
<div class="header"><? include('content/header.inc'); ?></div>
<div class="nav_main">
<div class="menu" id="menu"><? include('content/nav_main.inc'); ?></div>
</div>
<div class="body">
<span class="body_text1">
<div class="body_column_full">
<? include('content/property-details.inc'); ?>
</div>
</span>
</div>
<div class="contact_footer">
<? include('content/contact_footer.inc'); ?>
</div>
<div class="footer">
<? include('content/footer.inc'); ?>
</div>
</div>
</div>
</body>
</html>
