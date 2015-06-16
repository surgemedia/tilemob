<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Enquiry Form - The Tile Mob Pty Ltd, Brisbane</title>
<?php include('../includes/attach_styles.php'); //Cascading Style Sheets ?>
<script language="javascript">
function checkFields() {
	emptyfields = "";
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
	if (document.enquiry_form.security.value == "") {
		emptyfields += "\n   *Verification Code";
	}
	if (emptyfields!= "") {
		emptyfields = "It looks like you've forgotten these fields:\n"+emptyfields;
		alert(emptyfields);
	return false;
	}
	else return true;
}
</script> 
</head>

<body style="background:#FFFFFF;">
<?php
if(!empty($_GET['error'])) {
	echo '<div class="clear"><span class="status3">'.$_GET['error'].'</span></div>';
}
?>
<div class="clear">
<form id="enquiry_form" name="enquiry_form" onsubmit="return checkFields()" method="post" action="general_send_enquiry.php">
<table width="790" border="0" align="center">  
  <tr>
    <th width="50%" align="right" valign="top" scope="row"><table width="375" border="0" cellspacing="5">
      <tr>
        <th valign="top" scope="row">&nbsp;</th>
        <td align="left">&nbsp;</td>
        <td align="left"><span class="asterisk">*</span> All marked fields are compulsory </td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Your Name: </div></th>
        <td width="2%" align="left">&nbsp;</td>
        <td align="left"><label>
          <input class="textfield1" name="textfield_yourname" type="text" id="textfield_yourname" value="<?php if(!empty($_SESSION['textfield_yourname'])){echo $_SESSION['textfield_yourname'];} ?>" size="30" />
        </label></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Your
            Phone Number: </div></th>
        <td align="left">&nbsp;</td>
        <td align="left"><input class="textfield1" name="textfield_yournumber" type="text" id="textfield_yournumber" value="<?php if(!empty($_SESSION['textfield_yournumber'])){echo $_SESSION['textfield_yournumber'];} ?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right">Tel/Mobile (other): </div></th>
        <td align="left">&nbsp;</td>
        <td align="left"><input class="textfield1" name="textfield_yournumber2" type="text" id="textfield_yournumber2" value="<?php if(!empty($_SESSION['textfield_yournumber2'])){echo $_SESSION['textfield_yournumber2'];} ?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right">Company
            Name: </div></th>
        <td align="left">&nbsp;</td>
        <td align="left"><input class="textfield1" name="textfield_company" type="text" id="textfield_company" value="<?php if(!empty($_SESSION['textfield_company'])){echo $_SESSION['textfield_company'];} ?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Email
            Address: </div></th>
        <td align="left">&nbsp;</td>
        <td align="left"><input class="textfield1" name="textfield_youremail" type="text" id="textfield_youremail" value="<?php if(!empty($_SESSION['textfield_youremail'])){echo $_SESSION['textfield_youremail'];} ?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right"><span class="asterisk">*</span>Your
            Address: </div></th>
        <td>&nbsp;</td>
        <td align="left"><textarea class="textarea1" name="textarea_youraddress" id="textarea_youraddress" style="width:92%;height:50px;"><?php if(!empty($_SESSION['textarea_youraddress'])){echo $_SESSION['textarea_youraddress'];} ?></textarea></td>
      </tr>
      <tr>
        <th valign="top" scope="row">&nbsp;</th>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>      
    </table></th>
    <th width="50%" align="left" valign="top" scope="row"><table width="385" border="0" cellspacing="5">
      <tr>
        <th width="15%" valign="top" scope="row"><div align="left">Subject: </div></th>
        </tr>
      <tr>
        <th valign="top" scope="row"><div align="right">
          <div align="left">
            <input class="textfield1" name="textfield_subject" type="text" id="textfield_subject" value="Please contact me about my following enquiry" size="58"/>
          </div>
        </div></th>
        </tr>      
      <tr>
        <th valign="top" scope="row">
        Your additional comments - Please edit:
        </th>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="left">
          <textarea class="textarea1" name="textarea_message2" cols="55" rows="10" id="textarea_message2"><?php if(empty($_SESSION['textfield_yourname'])){ 
echo 'Dear Tile Mob,

Please edit your message here...'; }else{echo $_SESSION['textarea_message2'];} ?></textarea>
        </div></th>
      </tr>
      
    </table></th>
  </tr>
  <tr>
		<td>&nbsp;</td>
		<td><span>To protect us from spam, please enter the below verification code:</span> <span class="asterisk">*</span></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="text" id="security" name="security" class="textfield1" style="width:80px;display:inline;float:left;"> <img src="randomImage.php" border="0" align="absmiddle"/></td>
	  </tr>
  <tr>
    <td valign="middle" scope="row" height="50" align="center"><input name="clear_form" type="reset" id="clear_form" value="Clear Form" /></td>
    <td valign="middle" scope="row" align="center"><input name="submit_form" type="submit" id="submit_form" value="Submit Enquiry" />
	</td>
  </tr>
</table>
</form>
</div>
</body>
</html>
