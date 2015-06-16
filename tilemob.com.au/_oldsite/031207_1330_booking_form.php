<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Booking Form</title>
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
if (document.booking_form.textfield_yourname.value == "") {
	emptyfields += "\n   *Your Name";
}
if(document.booking_form.textfield_yournumber.value == "") {
	emptyfields += "\n   *Your Phone Number";
}
if (document.booking_form.textfield_youremail.value == "") {
	emptyfields += "\n   *Your Email";
}
if (document.booking_form.textarea_youraddress.value == "") {
	emptyfields += "\n   *Your Address";
}
if (document.booking_form.textfield_bookingdate.value == "") {
	emptyfields += "\n   *Your Booking date/time";
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
<SCRIPT LANGUAGE="JavaScript" SRC="includes/CalendarPopup.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
function hideTimes() {
	document.forms['booking_form'].textfield_bookinghour.disabled = true;
	document.forms['booking_form'].textfield_bookingminute.disabled = true;
}
window.onload = function() {
	hideTimes();
}
function changeDayDate() {
	if(document.forms['booking_form'].textfield_bookingdate.value != "" && document.forms['booking_form'].textfield_bookingdate.value.length > 5){
	//alert("booking date: "+document.forms['booking_form'].textfield_bookingdate.value);
	var temp_bookingdate = new Date(eval('"'+document.forms['booking_form'].textfield_bookingdate.value+'"'));
	var daysofweek = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
	//alert("booking day: "+daysofweek[temp_bookingdate.getDay()]);
	//Now we update the booking time hour
	document.forms['booking_form'].textfield_bookinghour.options.length = 0;
	if(daysofweek[temp_bookingdate.getDay()] == "Saturday"){
		document.forms['booking_form'].textfield_bookinghour.disabled = false;
		document.forms['booking_form'].textfield_bookingminute.disabled = false;
		document.forms['booking_form'].textfield_bookinghour.options[0]=new Option("9 am", "9 am");
		document.forms['booking_form'].textfield_bookinghour.options[1]=new Option("10 am", "10 am");
		document.forms['booking_form'].textfield_bookinghour.options[2]=new Option("11 am", "11 am");
		document.forms['booking_form'].textfield_bookinghour.options[3]=new Option("12 pm", "12 pm");
		document.forms['booking_form'].textfield_bookinghour.options[4]=new Option("1 pm", "1 pm");
		//document.forms['booking_form'].textfield_bookinghour.options[5]=new Option("2 pm", "2 pm");
	} else if(daysofweek[temp_bookingdate.getDay()] == "Sunday"){
		document.forms['booking_form'].textfield_bookinghour.disabled = true;
		document.forms['booking_form'].textfield_bookingminute.disabled = true;
		alert("Sorry we are closed on Sundays. \nOur opening times are: \nMon-Fri: 8:30 am - 5:00 pm and \nSat: 9:00 am - 2:00 pm \nPlease choose a different booking date (day of the week)");
	} else {
		document.forms['booking_form'].textfield_bookinghour.disabled = false;
		document.forms['booking_form'].textfield_bookingminute.disabled = false;
		//document.forms['booking_form'].textfield_bookinghour.options[0]=new Option("8 am", "8 am");
		document.forms['booking_form'].textfield_bookinghour.options[0]=new Option("9 am", "9 am");
		document.forms['booking_form'].textfield_bookinghour.options[1]=new Option("10 am", "10 am");
		document.forms['booking_form'].textfield_bookinghour.options[2]=new Option("11 am", "11 am");
		document.forms['booking_form'].textfield_bookinghour.options[3]=new Option("12 pm", "12 pm");
		document.forms['booking_form'].textfield_bookinghour.options[4]=new Option("1 pm", "1 pm");
		document.forms['booking_form'].textfield_bookinghour.options[5]=new Option("2 pm", "2 pm");
		document.forms['booking_form'].textfield_bookinghour.options[6]=new Option("3 pm", "3 pm");
		document.forms['booking_form'].textfield_bookinghour.options[7]=new Option("4 pm", "4 pm");
		//document.forms['booking_form'].textfield_bookinghour.options[9]=new Option("5 pm", "5 pm");
	}
	}
}
</SCRIPT>
</head>

<body>
<p></p>
<form id="booking_form" name="booking_form" onsubmit="return checkFields()" method="post" action="send_booking_form.php">
<table width="790" border="0">  
  <tr>
    <th width="50%" align="right" valign="top" scope="row"><table width="375" border="0" cellspacing="5">
      
      <tr>
        <td height="30" colspan="3" align="center" class="Details"><h2><strong>Appointment Booking form </strong></h2></td>
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
        <th valign="top" class="Details" scope="row">&nbsp;</th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><span class="style9">*</span> All marked fields are compulsory </td>
      </tr>
    </table></th>
    <th width="50%" align="left" valign="top" scope="row"><table width="385" border="0" cellspacing="5">
      <tr>
        <th width="15%" colspan="2" valign="top" class="Details" scope="row"><div align="left">Subject: </div></th>
        </tr>
      <tr>
        <th colspan="2" valign="top" scope="row"><div align="right" class="Details">
          <div align="left">
            <input class="textfields2" name="textfield_subject" type="text" id="textfield_subject" value="I wish to book an appointment" size="58"/>
          </div>
        </div></th>
        </tr>
      <tr>
        <th colspan="2" align="left" valign="top" scope="row"><span class="Details">Please specify booking appointment below. You must CHOOSE a valid appointment date first. When that is done, click SHOW available booking times. </span></th>
      </tr>
      
      
      <tr>
        <th align="left" valign="top" scope="row"><span class="Details"><span class="style9">*</span><strong>Select a booking date:</strong> </span></th>
        <th align="left" valign="top" scope="row"><span class="Details">
		<SCRIPT LANGUAGE="JavaScript" ID="jscal1x">
		var cal1x = new CalendarPopup("testdiv1");
		</SCRIPT>
		<!-- The next line prints out the source in this example page. It should not be included when you actually use the calendar popup code -->
		<SCRIPT LANGUAGE="JavaScript">writeSource("jscal1x");</SCRIPT>
          <input class="textfields2" name="textfield_bookingdate" type="text" id="textfield_bookingdate" size="20"/>
        <A HREF="#" NAME="anchor1x" TITLE="cal1x.select(document.forms['booking_form'].textfield_bookingdate,'anchor1x','MMM dd, yyyy'); return false;" ID="anchor1x" onClick="cal1x.select(document.forms['booking_form'].textfield_bookingdate,'anchor1x','MMM dd, yyyy'); hideTimes(); return false;"><strong> 1. <img src="images/calendar.gif" alt="CHOOSE DATE" width="13" height="14" border="0" align="absmiddle" /> CHOOSE </strong></A></span></th>
      </tr>
      <tr>
        <th align="left" valign="top" scope="row"><span class="Details"><span class="style9">*</span><strong>Select a booking time:</strong></span></th>
        <th align="left" valign="top" scope="row"><select name="textfield_bookinghour" id="textfield_bookinghour" ">
          <option value="9 am">9 am</option>
          <option value="10 am">10 am</option>
          <option value="11 am">11 am</option>
          <option value="12 pm">12 pm</option>
          <option value="1 pm">1 pm</option>
          <option value="2 pm">2 pm</option>
          <option value="3 pm">3 pm</option>
          <option value="4 pm">4 pm</option>
          <option value="5 pm">5 pm</option>
        </select>
          <select name="textfield_bookingminute" id="textfield_bookingminute">
            <option value="00">00</option>
            <option value="05">05</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25">25</option>
            <option value="30">30</option>
            <option value="35">35</option>
            <option value="40">40</option>
            <option value="45">45</option>
            <option value="50">50</option>
            <option value="55">55</option>
          </select>
          <span class="Details"><strong><a href="#" onclick="changeDayDate();">2. <img src="images/16clock.gif" alt="CHOOSE AVAILABLE TIMES" width="16" height="16" border="0" align="absmiddle" /> SHOW </a></strong></span></th>
      </tr>
      <tr>
        <th colspan="2" valign="top" scope="row"><span class="Details">
          <div align="left">Your additional comments - Please edit:</div>
        </span></th>
      </tr>
      <tr>
        <th colspan="2" valign="top" scope="row"><div align="left"><span class="Details">
          <textarea class="textfields2" name="textarea_message" cols="55" rows="4" id="textarea_message">Dear Tile Mob,

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
<DIV ID="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;font:11px Arial, Verdana, Helvetica, sans-serif;text-align:right;padding:4px;line-height:12px;"></DIV>
<p><span class="Details">
<label></label>
</span></p>
</body>

</html>
