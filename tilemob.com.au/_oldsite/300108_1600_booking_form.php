<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Booking Form</title>

<?
//IF THIS IS A CHANGE APPOINTMENT, WE GET THE VALUES FROM THE URL
if ((isset($_GET['id']) && isset($_GET['email'])) || (isset($_POST['booking_id']) && isset($_POST['booking_email']))){
	if (isset($_POST['booking_id']) && isset($_POST['booking_email'])) {
		$booking_id = $_POST['booking_id'];
		$booking_email = $_POST['booking_email'];
	}
	if (isset($_GET['id']) && isset($_GET['email'])) {
		$booking_id = $_GET['id'];
		$booking_email = $_GET['email'];
	}
	//check database if there is a match...
	include 'connection/bookingform.php';
	$result = mysql_query("SELECT * FROM consultation WHERE booking_id = '$booking_id' AND booker_email = '$booking_email'");
	$row = mysql_fetch_array($result);
	if($row['booking_id'] == $booking_id && $row['booker_email'] == $booking_email) { //match found
		$booking_code = $row['booking_id'];
		$youare = $row['booker_are'];
		$yourname = $row['booker_name'];
		$yourphone = $row['booker_phone1'];
		$yourphone2 = $row['booker_phone2'];
		$yourcompany = $row['booker_company'];
		$youremail = $row['booker_email'];
		$youraddress = $row['booker_address'];
		$project_commence = $row['booker_projectcommence'];
		$subject = $yourname." has made an Appointment using the Consultation Booking form.";
		$subject2 = "TileMob.com.au - Thank you for your Consultation Booking form ".$yourname;
		$bookingdate = $row['booking_date'];
		$bookinghour = $row['booking_hour'];
		$bookingminute = $row['booking_minute'];
		$bookingtime = trim(substr($bookinghour, 0, -2)).":".$bookingminute." ".substr($bookinghour, -2);
		$booker_comments = $row['booker_comments'];
		$project_address = $row['booker_address'];
		$project_type = $row['booker_projecttype'];
		$project_referer = $row['booker_referredby'];
		$project_referer_name = $row['booker_referralname'];
		$subject2 = "TileMob.com.au - Thank you for your Booking Appointment form ".$yourname;
		$change_appointment = true;
	} else {
		$change_appointment = false;
	}
} else {
	$change_appointment = false;
}
?>

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
	<?
	if($change_appointment == true){
		echo 'padding: 3px;';
		echo 'border:solid #EE3B33; border-width:2px;';
		echo 'background: #F1F1F1;';
	}
	?>
}
.style9 {color: #EE3B33}
-->
</style>
<STYLE>
	.TESTcpYearNavigation,
	.TESTcpMonthNavigation
			{
			background-color:#EE3B33;
			height: 20px;
			text-align:left;
			vertical-align:center;
			text-decoration:none;
			color:#FFFFFF;
			font-weight:bold;
			font-size: 6px;
			padding-left: 3px;
			margin-bottom: 2px;
			}
		.TESTcpMonthNavigation A:LINK, .TESTcpMonthNavigation A:VISITED
			{
			color: #FFFFFF;
			}
	.TESTcpDayColumnHeader,
	.TESTcpYearNavigation,
	.TESTcpMonthNavigation,
	.TESTcpCurrentMonthDate,
	.TESTcpCurrentMonthDateDisabled,
	.TESTcpOtherMonthDate,
	.TESTcpOtherMonthDateDisabled,
	.TESTcpCurrentDate,
	.TESTcpCurrentDateDisabled,
	.TESTcpTodayText,
	.TESTcpTodayTextDisabled,
	.TESTcpText
			{
			font-family:arial;
			font-size:8pt;
			}
	TD.TESTcpDayColumnHeader
			{
			text-align:right;
			padding-top: 2px;
			font-weight:bold;
			border:solid thin #EE3B33;
			border-width:0 0 0 0;
			}
	.TESTcpCurrentMonthDate,
	.TESTcpOtherMonthDate,
	.TESTcpCurrentDate
			{
			text-align:right;
			text-decoration:none;
			}
	.TESTcpCurrentMonthDateDisabled,
	.TESTcpOtherMonthDateDisabled,
	.TESTcpCurrentDateDisabled
			{
			color:#BBBBBB;
			text-align:right;
			text-decoration:line-through;
			}
	.TESTcpCurrentMonthDate
			{
			color:#EE3B33;
			font-weight:bold;
			}
	.TESTcpCurrentDate
			{
			color: #FFFFFF;
			font-weight:bold;
			}
	.TESTcpOtherMonthDate
			{
			color:#808080;
			}
	TD.TESTcpCurrentDate
			{
			color:#FFFFFF;
			background-color: #FFFFFF;			
			border:solid thin #000000;
			border-width:1;
			}
	TD.TESTcpCurrentDate A:LINK, TD.TESTcpCurrentDate A:VISITED
			{
			color:#EE3B33;
			}
	TD.TESTcpCurrentDateDisabled
			{
			border-width:0;
			border:solid thin #FFAAAA;
			}
	TD.TESTcpTodayText,
	TD.TESTcpTodayTextDisabled
			{
			border:solid thin #EE3B33;
			border-width:0 0 0 0;
			}
	A.TESTcpTodayText,
	SPAN.TESTcpTodayTextDisabled
			{
			height:20px;
			}
	A.TESTcpTodayText
			{
			color:#EE3B33;
			font-weight:bold;
			}
	SPAN.TESTcpTodayTextDisabled
			{
			color:#D0D0D0;
			}
	.TESTcpBorder
			{
			border:solid thin #CCCCCC;
			border-width:1px;
			}
</STYLE>
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
		emptyfields += "\n   *Your Booking date";
	}
	if (document.forms['booking_form'].textfield_bookinghour.disabled == true || document.forms['booking_form'].textfield_bookingminute.disabled == true) { emptyfields += "\n   *Your Booking time";
	}
	if (document.forms['booking_form'].option_question2.value == "------ Make a Selection ------") {
		emptyfields += "\n   *Project Type";
	}
	if (document.forms['booking_form'].option_question3.value == "------ Make a Selection ------") {
		emptyfields += "\n   *Project Commence";
	}
	if (document.forms['booking_form'].option_question4.value != "not applicable") {
		if (document.forms['booking_form'].textfield_referer.value == "") {
			emptyfields += "\n   *Referer name";
		}
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
<script language="javascript">
function checkFields2() {
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
	if (document.forms['booking_form'].option_question2.value == "------ Make a Selection ------") {
		emptyfields += "\n   *Project Type";
	}
	if (document.forms['booking_form'].option_question3.value == "------ Make a Selection ------") {
		emptyfields += "\n   *Project Commence";
	}
	if (document.forms['booking_form'].option_question4.value != "not applicable") {
		if (document.forms['booking_form'].textfield_referer.value == "") {
			emptyfields += "\n   *Referer name";
		}
	}
	
	if (emptyfields!= "") {
		emptyfields = "Please fill in all mandatory fields (marked with *) \nof the left-hand side before selecting a booking date.";
		//emptyfields + "\n\nPlease fill in all required feilds";
		alert(emptyfields);
		return false;
	} else {
		cal1x.select(document.forms['booking_form'].textfield_bookingdate,'anchor1x','EE, MMM dd, yyyy'); 
		hideTimes();
		return true;
	}
}
</script>
<SCRIPT LANGUAGE="JavaScript" SRC="includes/CalendarPopup.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
function requireReferer() {
	if(document.forms['booking_form'].option_question4.value != "not applicable") {
		//now unhide the referer name textfield
		document.forms['booking_form'].textfield_referer.style.display = 'block';
		document.forms['booking_form'].textfield_referer.style.background = '#F8F4BE';
		document.getElementById("referral_name").style.display = 'block'; 
	} else {
		document.forms['booking_form'].textfield_referer.style.display = 'none';
		document.getElementById("referral_name").style.display = 'none'; 
	}
}

function hideTimes() {
	document.forms['booking_form'].textfield_bookinghour.disabled = true;
	document.forms['booking_form'].textfield_bookingminute.disabled = true;
}
window.onload = function() {
	<? if($change_appointment == true){echo"document.forms['booking_form'].textfield_youremail.disabled = true;";}?>
	hideTimes();
	requireReferer();
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
		if (document.forms['booking_form'].option_question2.value == "Residential (new construction)" || document.forms['booking_form'].option_question2.value == "Commercial (new construction)") {
		} else {
			document.forms['booking_form'].textfield_bookinghour.options[4]=new Option("1 pm", "1 pm");
		}
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
		if (document.forms['booking_form'].option_question2.value == "Residential (new construction)" || document.forms['booking_form'].option_question2.value == "Commercial (new construction)") {
		} else {
			document.forms['booking_form'].textfield_bookinghour.options[7]=new Option("4 pm", "4 pm");
		}
		//document.forms['booking_form'].textfield_bookinghour.options[9]=new Option("5 pm", "5 pm");
	}
	} else {
		alert("You must first select a booking date, \non the above, please click CHOOSE to select a booking date.");
	}
}
</SCRIPT>
</head>

<body>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="160" align="center" valign="middle"></td>
    <td align="right" valign="middle">
	<form id="retrieve_form" name="retrieve_form" method="post" action="booking_form.php">    
    <table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="3" align="left"><span class="Details"><strong>Need to update your existing  booking? </strong></span></td>
      </tr>
      <tr>
        <td width="130" align="left"><span class="Details">Retrieve booking #: </span></td>
        <td width="220" align="left"><span class="Details">Booking email: </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left"><input name="booking_id" type="text" class="textfields2" id="booking_id" size="15" /></td>
        <td align="left"><input name="booking_email" type="text" class="textfields2" id="booking_email" size="30" /></td>
        <td align="left"><input class="btn_textfields" name="submit_retrieve" type="submit" id="submit_retrieve" value="Retrieve it" /></td>
      </tr>
      <tr>
        <td height="30" colspan="3" align="left" valign="bottom"><hr align="left" width="95%" size="1" noshade="noshade" /></td>
      </tr>
    </table>
	</form>	</td>
  </tr>
</table>
<form id="booking_form" name="booking_form" onsubmit="return checkFields()" method="post" action="process_booking_form.php<? if($change_appointment==true){echo'?reschedule=true&booking_id='.$booking_code;}?>">
  <table width="790" border="0">  
  
  
  <tr>
    <th width="50%" align="right" valign="top" scope="row"><table width="375" border="0" cellspacing="5">
      
      <tr>
        <td height="30" colspan="3" align="center" class="Details">
		<? 
		if($change_appointment == true){ echo'<h2 style="color:#EE3B33; font-size:16px;"><strong>Consultation reschedule form </strong></h2>'; }
		else { echo'<h2 style="color:#EE3B33; font-size:16px;"><strong>In-Showroom Consultation Booking </strong></h2>'; }
		?></td>
      </tr>
      <tr>
        <th align="right" valign="top" scope="row"><span class="Details"><span class="style9">*</span>You
            are:</span></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details">
		<select class="textfields2" name="option_question1" id="option_question1">
		<option value="------ Make a Selection ------">------ Make a Selection ------</option>
		<?
		if($youare=="Home-Owner"){echo'<option value="Home-Owner" SELECTED>Home-Owner</option>';}
			else{echo'<option value="Home-Owner">Home-Owner</option>';}
		if($youare=="Architect/Designer"){echo'<option value="Architect/Designer" SELECTED>Architect/Designer</option>';}
			else{echo'<option value="Architect/Designer">Architect/Designer</option>';}
 		if($youare=="Builder/Tradesperson"){echo'<option value="Builder/Tradesperson">Builder/Tradesperson</option>';}
			else{echo'<option value="Builder/Tradesperson">Builder/Tradesperson</option>';}
		?>
        </select></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Name: </div></th>
        <td width="2%" align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><label>
          <input name="textfield_yourname" type="text" class="textfields2" id="textfield_yourname" value="<?=$yourname;?>" size="30" />
        </label></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Phone Number: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input name="textfield_yournumber" type="text" class="textfields2" id="textfield_yournumber" value="<?=$yourphone;?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details">Tel/Mobile (other): </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input name="textfield_yournumber2" type="text" class="textfields2" id="textfield_yournumber2" value="<?=$yourphone2;?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details">Company
            Name: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input name="textfield_company" type="text" class="textfields2" id="textfield_company" value="<?=$yourcompany;?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Email
            Address: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" class="Details"><input name="textfield_youremail" type="text" class="textfields2" id="textfield_youremail" value="<?=$youremail;?>" size="30" /></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Address: </div></th>
        <td class="Details">&nbsp;</td>
        <td align="left" class="Details"><textarea class="textfields2" name="textarea_youraddress" cols="29" rows="2" id="textarea_youraddress"><?=$youraddress;?></textarea></td>
      </tr>
      
      <tr>
        <th valign="top" scope="row">
          <div align="right" class="Details"><span class="style9">*</span>Project Type: </div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details">
		<select class="textfields2" name="option_question2" size="1" id="option_question2" onchange="javascript:document.forms['booking_form'].textfield_bookinghour.disabled = true; document.forms['booking_form'].textfield_bookingminute.disabled = true; document.forms['booking_form'].textfield_bookingdate.value = '';">
          <option value="------ Make a Selection ------">------ Make a Selection ------</option>
		<?
		if($project_type=="Residential (new construction)"){echo' <option value="Residential (new construction)" SELECTED>Residential (new construction)</option>';}
			else{echo' <option value="Residential (new construction)">Residential (new construction)</option>';}
		if($project_type=="Commercial (new construction)"){echo'<option value="Commercial (new construction)" SELECTED>Commercial (new construction)</option>';}
			else{echo'<option value="Commercial (new construction)">Commercial (new construction)</option>';}
 		if($project_type=="Residential (renovation)"){echo'<option value="Residential (renovation)" SELECTED>Residential (renovation)</option>';}
			else{echo'<option value="Residential (renovation)">Residential (renovation)</option>';}
		if($project_type=="Commercial (renovation)"){echo'<option value="Commercial (renovation)" SELECTED>Commercial (renovation)</option>';}
			else{echo'<option value="Commercial (renovation)">Commercial (renovation)</option>';}
		?>
        </select></td>
      </tr>
      <tr>
        <th scope="row"><div align="right" class="Details">Project Address: </div></th>
        <td class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details"><textarea class="textfields2" name="textarea_projectaddress" cols="29" rows="2" id="textarea_projectaddress"><?=$project_address;?></textarea></td>
      </tr>
      <tr>
        <th scope="row"><div align="right"><span class="Details"><span class="style9">*</span>Project Commence: </span></div></th>
        <td class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details"><select class="textfields2" name="option_question3" size="1" id="option_question3">
          <option value="------ Make a Selection ------">------ Make a Selection ------</option>
		<?
		if($project_commence=="Less than 1 month"){echo'<option value="Less than 1 month" SELECTED>Less than 1 month</option>';}
			else{echo'<option value="Less than 1 month">Less than 1 month</option>';}
		if($project_commence=="1-3 months"){echo'<option value="1-3 months" SELECTED>1-3 months</option>';}
			else{echo'<option value="1-3 months">1-3 months</option>';}
 		if($project_commence=="More than 3 months"){echo'<option value="More than 3 months" SELECTED>More than 3 months</option>';}
			else{echo'<option value="More than 3 months">More than 3 months</option>';}
		?>
		</select></td>
      </tr>
      <tr>
        <th valign="top" scope="row"><div align="right"><span class="Details"><span class="style9">*</span>Referred by: </span></div></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details">
		<select class="textfields2" name="option_question4" size="1" id="option_question4" onChange="requireReferer();">
          <option value="not applicable">not applicable</option>
		<?
		if($project_referer=="Builder"){echo'<option value="Builder" SELECTED>Builder</option>';}
			else{echo'<option value="Builder">Builder</option>';}
 		if($project_referer=="Architect"){echo'<option value="Architect" SELECTED>Architect</option>';}
			else{echo'<option value="Architect">Architect</option>';}
		if($project_referer=="Designer"){echo'<option value="Designer" SELECTED>Designer</option>';}
			else{echo'<option value="Designer">Designer</option>';}
		if($project_referer=="Tiler"){echo'<option value="Tiler" SELECTED>Tiler</option>';}
			else{echo'<option value="Tiler">Tiler</option>';}
		?>
		</select></td>
      </tr>
      <tr>
        <th align="right" valign="top" scope="row"><span id="referral_name"><span class="Details"><span class="style9">*</span>Referral name:</span></span></th>
        <td align="left" class="Details">&nbsp;</td>
        <td align="left" valign="top" class="Details"><input name="textfield_referer" type="text" class="textfields2" id="textfield_referer" value="<?=$project_referer_name;?>" size="30" /></td>
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
        <th height="40" colspan="2" align="left" valign="top" scope="row">&nbsp;</th>
      </tr>
      <tr>
        <th colspan="2" align="left" valign="top" scope="row"><span class="Details">Please specify your preferred consultation booking time below. Click 'CHOOSE' first to select a booking date from our pop-up calendar and then select a booking time. </span></th>
      </tr>
      
      
      <tr>
        <th colspan="2" align="left" valign="top" scope="row"><span class="Details"><span class="style9">*</span><strong>1. Select a booking date:</strong> </span></th>
        </tr>
      <tr>
        <th colspan="2" align="left" valign="top" scope="row"><span class="Details">
		<SCRIPT LANGUAGE="JavaScript" ID="jscal1x">
		var cal1x = new CalendarPopup("testdiv1");
		cal1x.setDisabledWeekDays(0,0);
		cal1x.setCssPrefix("TEST");
		//cal1x.showNavigationDropdowns();
		//cal1x.addDisabledDates("2008-01-15");
		var now = new Date();
		cal1x.addDisabledDates(null,formatDate(now,"yyyy-MM-dd")); //disable dates before today
		cal1x.addDisabledDates("<?=date("M j, Y", strtotime("+30 day"))?>",null); //disable dates 30 days ahead
		</SCRIPT>
		<!-- The next line prints out the source in this example page. It should not be included when you actually use the calendar popup code -->
		<SCRIPT LANGUAGE="JavaScript">writeSource("jscal1x");</SCRIPT>
          <input name="textfield_bookingdate" type="text" class="textfields2" id="textfield_bookingdate" onchange="javascript:document.forms['booking_form'].textfield_bookinghour.disabled = true; document.forms['booking_form'].textfield_bookingminute.disabled = true;" value="<?=$bookingdate;?>" size="40" readonly/>
        <A HREF="#" NAME="anchor1x" TITLE="CHOOSE A DATE" ID="anchor1x" onClick="checkFields2();"><strong><img src="images/calendar.gif" alt="CHOOSE A DATE" width="16" height="16" border="0" align="absmiddle" /> CHOOSE </strong></A></span></th>
        </tr>
      <tr>
        <th width="15%" align="left" valign="top" scope="row"><span class="Details"><span class="style9">*</span><strong>2. Select a booking time:</strong></span></th>
        <th width="15%" align="left" valign="top" scope="row">
		<select name="textfield_bookinghour" id="textfield_bookinghour" ">
          <?
		  if($bookinghour=="9 am"){echo'<option value="9 am" SELECTED>9 am</option>';}else{echo'<option value="9 am">9 am</option>';}
		  if($bookinghour=="10 am"){echo'<option value="10 am" SELECTED>10 am</option>';}else{echo'<option value="10 am">10 am</option>';}
		  if($bookinghour=="11 am"){echo'<option value="11 am" SELECTED>11 am</option>';}else{echo'<option value="11 am">11 am</option>';}
		  if($bookinghour=="12 pm"){echo'<option value="12 pm" SELECTED>12 pm</option>';}else{echo'<option value="12 pm">12 pm</option>';}
		  if($bookinghour=="1 pm"){echo'<option value="1 pm" SELECTED>1 pm</option>';}else{echo'<option value="1 pm">1 pm</option>';}
		  if($bookinghour=="2 pm"){echo'<option value="2 pm" SELECTED>2 pm</option>';}else{echo'<option value="2 pm">2 pm</option>';}
		  if($bookinghour=="3 pm"){echo'<option value="3 pm" SELECTED>3 pm</option>';}else{echo'<option value="3 pm">3 pm</option>';}
		  if($bookinghour=="4 pm"){echo'<option value="4 pm" SELECTED>4 pm</option>';}else{echo'<option value="4 pm">4 pm</option>';}
		  if($bookinghour=="5 pm"){echo'<option value="5 pm" SELECTED>5 pm</option>';}else{echo'<option value="5 pm">5 pm</option>';}
		  ?>
        </select>
          <select name="textfield_bookingminute" id="textfield_bookingminute">
		  <?
		  if($bookingminute=="00"){echo'<option value="00" SELECTED>00</option>';}else{echo'<option value="00">00</option>';}
		  if($bookingminute=="15"){echo'<option value="15" SELECTED>15</option>';}else{echo'<option value="15">15</option>';}
		  if($bookingminute=="30"){echo'<option value="30" SELECTED>30</option>';}else{echo'<option value="30">30</option>';}
		  if($bookingminute=="45"){echo'<option value="45" SELECTED>45</option>';}else{echo'<option value="45">45</option>';}
		  ?>
          </select></th>
      </tr>
      <tr>
        <th colspan="2" valign="top" scope="row"><span class="Details">
          <div align="left">Your additional comments - Please edit:</div>
        </span></th>
      </tr>
      <tr>
        <th colspan="2" valign="top" scope="row"><div align="left"><span class="Details">
          <textarea class="textfields2" name="textarea_message" cols="55" rows="6" id="textarea_message"><? if($change_appointment==true){echo $booker_comments;}else{echo'Please edit your message here...';} ?></textarea>
        </span></div></th>
      </tr>
      
      <tr>
        <th colspan="2" align="left" valign="bottom" scope="row"><table width="370" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid #FFFFFF; border-width:1px;">
          <tr>
            <td height="20" colspan="2">&nbsp;</td>
            </tr>
          <tr>
            <td width="130" align="center"><a href="http://www.tilemob.com.au/"><img src="images/img_tm_logo_02.gif" alt="The Tile Mob" border="0"/></a></td>
            <td><span class="Details"><img src="http://tilemob.com.au/images/txt_showroom.gif" vspace="3" border="0"><br />
            4-6 Blackwood St (Cnr Samford Rd) <br />
		Mitchelton Queensland Australia 4053 <br />
		PH (07) 3355 5055</span></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></th>
      </tr>
      <tr>
        <th colspan="2" align="left" valign="bottom" scope="row">
		<? 
		if($change_appointment==true){
		echo'<br/><span class="Details">By submitting this appointment form, your appointment booking number: <b>#'.$booking_code.'</b> will be updated with new appointment details specified above. You will also recieve a confirmation email about this new appointment.</span><br/>';}
		?></th>
      </tr>
      
    </table></th>
  </tr>
  
  <tr>
    <th valign="top" scope="row"><input class="btn_textfields" name="clear_form" type="reset" id="clear_form" value="Clear Form" /></th>
    <th valign="top" scope="row">
	<?
	if($change_appointment==true){
	echo '<input name="change_appointment" type="hidden" id="change_appointment" value="true" />';
	echo '<input name="old_booking_code" type="hidden" id="old_booking_code" value="'.$booking_code.'" />';
	echo'<input class="btn_textfields" name="submit_form" type="submit" id="submit_form" value="Reschedule my appointment" />';}
	else{echo'<input class="btn_textfields" name="submit_form" type="submit" id="submit_form" value="Submit New Appointment" />';}?>	</th>
  </tr>
</table>
</form> 
<DIV ID="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;font:11px Arial, Verdana, Helvetica, sans-serif;text-align:right;padding:4px;line-height:12px;"></DIV>
<p><span class="Details">
<label></label>
</span></p>
</body>

</html>