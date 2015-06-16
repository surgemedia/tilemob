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
<p></p>
<form id="enquiry_form" name="enquiry_form" onsubmit="return checkFields()" method="post" action="general_send_enquiry.php">
<table width="790" border="0">  
  <tr>
    <th width="50%" align="right" valign="top" scope="row"><table width="375" border="0" cellspacing="5">
      
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
            <input class="textfields2" name="textfield_subject" type="text" id="textfield_subject" value="Please contact me about my following enquiry" size="58"/>
          </div>
        </div></th>
        </tr>
      
      
      <tr>
        <th valign="top" scope="row"><span class="Details">
          <div align="left">Your additional comments - Please edit:</div>
        </span></th>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="left"><span class="Details">
          <textarea class="textfields2" name="textarea_message2" cols="55" rows="10" id="textarea_message2">Dear Tile Mob,

Please edit your message here...</textarea>
        </span></div></th>
      </tr>
      
    </table></th>
  </tr>
  
  <tr>
    <th valign="top" scope="row"><input class="btn_textfields" name="clear_form" type="reset" id="clear_form" value="Clear Form" /></th>
    <th valign="top" scope="row"><input class="btn_textfields" name="submit_form" type="submit" id="submit_form" value="Submit Enquiry" />
	</th>
  </tr>
</table>
</form> 
<p><span class="Details">
<label></label>
</span></p>
</body>

</html>
