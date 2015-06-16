<?
//Get cookies collection array passed from enquiry form, loop through it and delete all cookies
$temp_collection = stripslashes($_GET['collection']);
$collection = unserialize(urldecode($temp_collection));
foreach($collection as $value) {
	setcookie($value,'',time()-3600, '/');
}
/*foreach($collection as $value) {
	echo 'value: '.$value.'<br/>';
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>The Tile Mob Pty Ltd, Brisbane</title>
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
		$youare = $_POST['option_question1'];
		$yourname = $_POST['textfield_yourname'];
		$yourphone = $_POST['textfield_yournumber'];
		$yourphone2 = $_POST['textfield_yournumber2'];
		$yourcompany = $_POST['textfield_company'];
		$youremail = $_POST['textfield_youremail'];
		$youraddress = $_POST['textarea_youraddress'];
		$projecttype = $_POST['option_question2'];
		$projectaddress = $_POST['textarea_projectaddress'];
		$projectcommence = $_POST['option_question3'];
		$subject = $_POST['textfield_subject'];
		$subject2 = "TileMob.com.au - Thank you for your enquiry ".$yourname;
		//$message_body = $_POST['textarea_message'];
		//$message_body = $_GET['auto_message_hidden'];
		$message_body = nl2br(stripslashes(urldecode($_GET['message'])));
		$message_body2 = nl2br($_POST['message2']);
		//$message_body2 = hyperlink($message_body2);
		//$message_body2 = hyperlink($_POST['message2']);
		//$message_body2 = nl2br($message_body2);
		
		ini_set("sendmail_from", $sendto);
		$mail_headers = "From: ".$sendto."\r\n";
		$mail_headers .= "Reply-To: ".$sendto."\r\n";
		$mail_headers .= "MIME-Version: 1.0\r\n";
		$mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$mail_headers .= "X-Mailer: PHP v".phpversion()."\r\n";  
		
		//Generate Email Message
		$message = 	"<a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"></a><br/>".
					"You are: ".$youare.
					"<br>Name: ".$yourname.
					"<br>Phone Number: " .$yourphone.
					"<br>Tel/Mobile(other): " .$yourphone2.
					"<br>Company Name: " .$yourcompany.
					"<br>Email Address: " .$youremail.
					"<br>Address: " .$youraddress.
					"<br>Project Type: " .$projecttype.
					"<br>Project Address: " .$projectaddress.
					"<br>Project Commence: " .$projectcommence.
					"<br>".
					"<br>Please contact me about the following tiles: <br>" .$message_body.
					"<br>".
					"<br>".$message_body2.
					"<br><a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/Map-Contact.jpg\" border=\"0\" alt=\"Tilemob.com.au\"></a><br/>";
					
		//Generate Email Message - THIS IS BACK TO THE CUSTOMER (as a copy)
		$message2 = 
			"<a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/Tilemob-Logo-Small.gif\" border=\"0\" alt=\"Tilemob.com.au\"></a><br/>".
			"<br>Dear ".$yourname.", ".
			"<br>Thank you for your enquiry - We're taking care of your enquiry and will contact you shortly to help with your tile requirements!".
			"<br>You recently submitted an enquiry form at Tilemob.com.au with the following details:".
			"<br>You are: ".$youare.
			"<br>Name: ".$yourname.
			"<br>Phone Number: " .$yourphone.
			"<br>Tel/Mobile(other): " .$yourphone2.
			"<br>Company Name: " .$yourcompany.
			"<br>Email Address: " .$youremail.
			"<br>Address: " .$youraddress.
			"<br>Project Type: " .$projecttype.
			"<br>Project Address: " .$projectaddress.
			"<br>Project Commence: " .$projectcommence.
			"<br>".
			"<br>Please contact me about the following tiles: <br>" .$message_body.
			"<br>".
			"<br>".$message_body2.
			"<br><a href=\"http://www.tilemob.com.au/\"><img src=\"http://www.tilemob.com.au/images/Map-Contact.jpg\" border=\"0\" alt=\"Tilemob.com.au\"></a><br/>";
				   
		//Send Email
		mail($sendto, $subject, $message, $mail_headers); //Send to sales
		mail($youremail, $subject2, $message2, $mail_headers); //Send to customer copy
		mail("richard@dmwcreative.com.au", $subject, $message, $mail_headers); //BCC me :)
		mail("richardcwc@gmail.com", $subject, $message, $mail_headers); //BCC me :)
		
		
function hyperlink($text) {
    // match protocol://address/path/file.extension?some=variable&another=asf%
    $text = preg_replace("/\s([a-zA-Z]+:\/\/[a-z][a-z0-9\_\.\-]*
            [a-z]{2,6}[a-zA-Z0-9\/\*\-\?\&\%]*)([\s|\.|\,])/i",
            " <a href=\"$1\" target=\"_blank\">$1</a>$2", $text);
    // match www.something.domain/path/file.extension?some=variable&another=asf%
    $text = preg_replace("/\s(www\.[a-z][a-z0-9\_\.\-]*
            [a-z]{2,6}[a-zA-Z0-9\/\*\-\?\&\%]*)([\s|\.|\,])/i",
            " <a href=\"http://$1\" target=\"_blank\">$1</a>$2", $text);
    // match name@address
    $text = preg_replace("/\s([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*
            \@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})([\s|\.|\,])/i",
            " <a href=\"mailto://$1\">$1</a>$2", $text);
    return $text;
}
		?></td>
      </tr>
      <tr>
        <td align="left" valign="top"><p></p>
          <table width="400" border="0" cellspacing="0">
            <tr>
              <th width="40" align="left" valign="top" scope="row">&nbsp;</th>
              <th align="left" valign="top" scope="row"><span class="Details">Thank
                you, your enquiry has been submitted. We will contact you shortly to help with your tile requirements. <br/><br/><a href="#" onClick="javascript:self.close(); window.opener.parent.iframe_collection.location.reload();"><b>Close this window and clear my tile collection.</b></a></span></th>
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