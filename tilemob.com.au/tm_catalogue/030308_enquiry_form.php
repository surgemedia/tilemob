<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Enquiry Form - The Tile Mob Pty Ltd, Brisbane</title>
<style type="text/css">
<!--
.Details {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #999999;
	font-style: normal;
	font-weight: normal;
}
body {
	margin-top: 0px;
}
.style9 {color: #EE3B33}
-->
</style>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function checkFields() {
	emptyfields = "";
if (document.enquiry_form.option_question1.value == "------ Make a Selection ------") {
	emptyfields += "\n   *You are";
}
if (document.enquiry_form.option_question2.value == "------ Make a Selection ------") {
	emptyfields += "\n   *Project Type";
}
if (document.enquiry_form.option_question3.value == "------ Make a Selection ------") {
	emptyfields += "\n   *Project Commence";
}
if (document.enquiry_form.textfield_yourname.value == "") {
	emptyfields += "\n   *Your Name";
}
if(document.enquiry_form.textfield_yournumber.value == "") {
	emptyfields += "\n   *Your Phone Number";
}
if (document.enquiry_form.textfield_youremail.value == "") {
	emptyfields += "\n   *Your Email";
}
if (document.enquiry_form.textarea_youraddress.value == "") {
	emptyfields += "\n   *Your Address";
}

if (emptyfields!= "") {
	emptyfields = "These fields are mandatory:\n" +
	emptyfields + "\n\nPlease fill in all required feilds";
	alert(emptyfields);
return false;
}
else return true;
}

</script> 
</head>

<body>
<?
$auto_message = "";
$message = "";
$empty_collection = true;
$strenc_cookies_collection = "";
generateMessage();
function generateMessage() {
	global $auto_message, $message, $empty_collection, $strenc_cookies_collection;
	$temp_message = "";	
	//$txt_tilecode = $_GET['tilecode'];
	//$url_tilelink = $_GET['tilelink'];
	$i = 0;
	//Store all cookies in array called $cookies_collection
	foreach ($_COOKIE as $value) {
		$tilecode = substr($value, (count($value)-10), 5);
		//$tilelink = $value;
		$tilelink = '<a href="'.$value.'">'.$value.'</a>';
		$cookies_collection[$i] = $tilecode;
		$auto_message .= ($i+1).". #".$cookies_collection[$i]." \n";
		$temp_message .= ($i+1).". #".$cookies_collection[$i].": ".$tilelink." \n";
		$i++;
	}
	if ($auto_message != "") { $empty_collection = false; } else { $empty_collection = true; }
	$message = urlencode($temp_message);
	$str_cookies_collection = serialize($cookies_collection);
	$strenc_cookies_collection = urlencode($str_cookies_collection);
}
?>
<p></p>
<form id="enquiry_form" name="enquiry_form" onsubmit="return checkFields()" method="post" action="send_enquiry.php?message=<?=$message?>&collection=<?=$strenc_cookies_collection;?>">
<table width="790" border="0">  
  <tr>
    <th width="50%" align="right" valign="top" scope="row"><table width="375" border="0" cellspacing="5">
      <tr>
        <th valign="top" class="Details" scope="row"><div align="right"><span class="style9">*</span>You are: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><select class="textfields2" name="option_question1" id="option_question1">
          <option value="------ Make a Selection ------">------ Make a Selection ------</option>
          <option value="Home-Owner">Home-Owner</option>
          <option value="Architect/Designer">Architect/Designer</option>
          <option value="Builder/Tradesperson">Builder/Tradesperson</option>
		  <option value="Builder/Tradesperson">Developer</option>
           </select></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Name: </div></th>
        <td width="2%" align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><label>
          <input class="textfields2" name="textfield_yourname" type="text" id="textfield_yourname" size="30" />
        </label></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Phone Number: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input class="textfields2" name="textfield_yournumber" type="text" id="textfield_yournumber" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details">Tel/Mobile (other): </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input class="textfields2" name="textfield_yournumber2" type="text" id="textfield_yournumber2" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details">Company
            Name: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input class="textfields2" name="textfield_company" type="text" id="textfield_company" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Email
            Address: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input class="textfields2" name="textfield_youremail" type="text" id="textfield_youremail" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Address: </div></th>
        <td class="Details">&nbsp;</td>
        <td align="left" class="Details"><textarea class="textfields2" name="textarea_youraddress" cols="29" rows="2" id="textarea_youraddress"></textarea></td>
      </tr>
      <tr>
        <th valign="top" scope="row">&nbsp;</th>
        <td align="left" class="Details">&nbsp;</td>
        <td class="Details">&nbsp;</td>
      </tr>
      <tr>
        <th valign="top" scope="row"><label>
          <div align="right" class="Details"><span class="style9">*</span>Project Type: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details"><select class="textfields2" name="option_question2" size="1" id="option_question2">
          <option value="------ Make a Selection ------">------ Make a Selection ------</option>
          <option value="Residential (new construction)">Residential (new construction)</option>
          <option value="Commercial (new construction)">Commercial (new construction)</option>
          <option value="Residential (renovation)">Residential (renovation)</option>
          <option value="Commercial (renovation)">Commercial (renovation)</option>
                                </select></td>
      </tr>
      <tr>
        <th scope="row"><div align="right" class="Details">Project Address: </div></th>
        <td class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details"><textarea class="textfields2" name="textarea_projectaddress" cols="29" rows="2" id="textarea_projectaddress"></textarea></td>
      </tr>
      <tr>
        <th scope="row"><div align="right"><span class="Details"><span class="style9">*</span>Project Commence: </span></div></th>
        <td class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details"><select class="textfields2" name="option_question3" size="1" id="option_question3">
          <option value="------ Make a Selection ------">------ Make a Selection ------</option>
          <option value="Less than 1 month">Less than 1 month</option>
          <option value="1-3 months">1-3 months</option>
          <option value="More than 3 months">More than 3 months</option>
                                        </select></td>
      </tr>
      
      <tr>
        <th valign="top" class="Details" scope="row"><div align="right"></div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><div align="right"></div></td>
      </tr>
      <tr>
        <th valign="top" class="Details" scope="row">&nbsp;</th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><span class="style9">*</span> All marked fields are compulsory </td>
      </tr>
    </table></th>
    <th width="50%" align="left" valign="top" scope="row"><table width="385" border="0" cellspacing="5">
      <tr>
        <th width="15%" valign="top" class="Details" scope="row"><div align="left">Subject: </div></th>
        </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details">
          <div align="left">
            <input class="textfields2" name="textfield_subject" type="text" id="textfield_subject" value="Please contact me about the following tiles" size="58"/>
          </div>
        </div></th>
        </tr>
      <tr>
        <th valign="top" scope="row"><span class="Details">
          <div align="left">Your selected tiles (for our reference only) </div>
        </span></th>
        </tr>
      <tr>
        <th valign="top" scope="row"><div align="left"><span class="Details">
          <textarea class="textfields2" name="textarea_message" disabled="true" cols="55" rows="3" id="textarea_message"><?=$auto_message?></textarea>
        </span></div></th>
        </tr>
      <tr>
        <th valign="top" scope="row"><span class="Details">
          <div align="left">Your additional comments - Please edit:</div>
        </span></th>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="left"><span class="Details">
          <textarea class="textfields2" name="textarea_message2" cols="55" rows="10" id="textarea_message2">Dear Tile Mob,
I wish to enquire about my above selected tiles.

Please contact me as soon as you can.
Thank you.
</textarea>
        </span></div></th>
      </tr>
      
    </table></th>
  </tr>
  
  <tr>
    <th valign="top" scope="row"><input class="btn_textfields" name="clear_form" type="reset" id="clear_form" value="Clear Form" /></th>
    <th valign="top" scope="row">
	<?
	if ($empty_collection == true) {
		echo '<span class="Details">
		<b>"Submit Enquiry"</b> button disabled! <br>
		Sorry no selected tiles, you cannot submit this enquiry form!</span>';
	} else{ 
		echo '<input class="btn_textfields" name="submit_form" type="submit" id="submit_form" value="Submit Enquiry" />';
	}
	?>
	</th>
  </tr>
</table>
</form> 
<p><span class="Details">
<label></label>
</span></p>
</body>

</html>
