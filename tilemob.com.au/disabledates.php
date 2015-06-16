<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Disable Dates</title>
<?
error_reporting(0);
include('includes/connection.php');

//Check if the add this date button was submitted
if($_POST['submit_adddate'] && trim($_POST['new_startdate'])!= "" && trim($_POST['new_enddate'])!="") {
	$startdate = $_POST['new_startdate'];
	$enddate = $_POST['new_enddate'];
	$description = $_POST['new_description'];
	//Now we have all the values, we add them to the database
	mysql_query("ALTER TABLE disabledates AUTO_INCREMENT = 1");
	mysql_query("INSERT into disabledates  
		(ID, startdate, enddate, description, datedisabled)
		VALUES ('', '$startdate', '$enddate','$description', '')") 
		or die('Error, query failed');
	//Done : )
}

//Go through each delete button array and check if it was submitted
if($_POST['deletedate']) {
	$deletedate = $_POST['deletedate'];
	foreach($deletedate as $key => $value) {
		//Delete the key (ID) from database
		mysql_query("DELETE FROM disabledates WHERE ID='$key'") 
		or die(mysql_error());
	}
}

// If the savechanges button was submitted, we go through all textfield elements in 
// that form and save them to the database, updating appropriate ID rows
if($_POST['submit_savechanges']) {
	//check the number of mysql rows in the database so we know how many textfields to expect
	$result = mysql_query("SELECT * FROM disabledates");
	$dates_numrows = mysql_num_rows($result);
	for($i=1; $i<($dates_numrows+1); $i++){
		$temp_startdate = $_POST['startdate_'.$i];
		$temp_enddate = $_POST['enddate_'.$i];
		$temp_description = $_POST['description_'.$i];
		mysql_query("UPDATE disabledates set 
			startdate = '$temp_startdate', enddate = '$temp_enddate', description = '$temp_description'
			WHERE ID = '$i'") or die('Error, query failed');	
	}
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
	<? if (isset($_GET['appointment'])){
		echo '';
	}
	?>
}
.table_header {
	font-family: Arial, Verdana, Helvetica, sans-serif;
	color: #FFFFFF; 
	font-size: 12px;
	font-weight: bold;
	margin: 0;
	padding: 0;
}
.table_header2 {
	font-family: Arial, Verdana, Helvetica, sans-serif;
	color: #AAAAAA; 
	font-size: 14px;
	font-weight: bold;
	margin: 0;
	padding: 0;
}
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
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function handleError(){
return true;
}
window.onerror = handleError;
</script>
<SCRIPT LANGUAGE="JavaScript" SRC="/booking/CalendarPopup.js"></SCRIPT>
</head>

<body style="background:#FFFFFF;">
<div style="width:100%; height:auto;">
<div style="position:relative; margin-left:auto; margin-right:auto; width:700px; text-align:center; padding:10px;padding-top:50px;">
<table width="650" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="50" align="center"></td>
    <td width="600" height="30" align="left" valign="middle"><span class="table_header2">Disabled calendar dates (<a href="http://www.tilemob.com.au/booking_form.php" target="_blank">In-Showroom Consultation Booking Form</a>)</span></td>
  </tr>
  
  <tr>
    <td colspan="2" align="right">
	<form id="form_newdate" name="form_newdate" method="post" action="">    
    <table width="600" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
        <td height="15" colspan="4" align="left" bgcolor="#CCCCCC"><span class="table_header">Add Date </span></td>
        </tr>
      <tr>
        <td width="30" align="left">&nbsp;</td>
        <td width="120" align="left">
		<SCRIPT LANGUAGE="JavaScript" ID="jscal1x">
		var cal1x = new CalendarPopup("testdiv1");
		cal1x.setCssPrefix("TEST");
		</SCRIPT>
		<SCRIPT LANGUAGE="JavaScript">writeSource("jscal1x");</SCRIPT>
		<span class="Details"><strong>Start date </strong></span> <A HREF="#" NAME="anchor1x" TITLE="CHOOSE A DATE" ID="anchor1x" onClick="cal1x.select(document.forms['form_newdate'].new_startdate,'anchor1x','dd NNN yyyy'); hideTimes();return false;"><img src="images/calendar.gif" alt="CHOOSE A DATE" width="16" height="16" border="0" align="absmiddle" /></A></td>
        <td width="120" align="left">
		<SCRIPT LANGUAGE="JavaScript" ID="jscal1y">
		var cal1y = new CalendarPopup("testdiv1");
		cal1y.setCssPrefix("TEST");
		</SCRIPT>
		<SCRIPT LANGUAGE="JavaScript">writeSource("jscal1y");</SCRIPT>
		<span class="Details"><strong>End date </strong></span> <A HREF="#" NAME="anchor1y" TITLE="CHOOSE A DATE" ID="anchor1y" onClick="cal1y.select(document.forms['form_newdate'].new_enddate,'anchor1y','dd NNN yyyy'); hideTimes();return false;"><img src="images/calendar.gif" alt="CHOOSE A DATE" width="16" height="16" border="0" align="absmiddle" /></A></td>
        <td width="300" align="left"><span class="Details"><strong>Description / Reference </strong></span></td>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="left"><input class="textfields2" name="new_startdate" type="text" id="new_startdate" size="15" /></td>
        <td align="left"><input class="textfields2" name="new_enddate" type="text" id="new_enddate" size="15" /></td>
        <td align="left"><input class="textfields2" name="new_description" type="text" id="new_description" size="45" /></td>
        <td align="left"><input name="submit_adddate" type="submit" id="submit_adddate" value="Add" /></td>
      </tr>
    </table>
	</form>	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
   <td colspan="2" align="right">
	 <form id="form_disableddates" name="form_disableddates" method="post" action="">
	 <table width="600" border="0" cellspacing="0" cellpadding="2">
	<tr>
	<td align="left" bgcolor="#CCCCCC"></td>
	  <td height="15" colspan="4" align="left" bgcolor="#CCCCCC"><span class="table_header">Edit/Remove disabled dates </span></td>
	  </tr>
	<tr>
	  <td width="30" align="left"><span class="Details"><strong># </strong></span></td>
        <td width="120" align="left"><span class="Details"><strong>Start date </strong></span></td>
        <td width="120" align="left"><span class="Details"><strong>End date </strong></span></td>
        <td width="300" align="left"><span class="Details"><strong>Description / Reference </strong></span></td>
        <td align="left">&nbsp;</td>
      </tr>
<?
	//This area lists all added disabled dates from the database
	$result = mysql_query("SELECT * FROM disabledates");
	$rowcount = 1;
	while($row = mysql_fetch_array($result)) {
		echo 
		'
		<tr>
		<td><span class="Details">'.$rowcount.'.<span></td>
        <td>
		<input class="textfields2" name="startdate_'.$row['ID'].'" type="text" id="startdate_'.$row['ID'].'" size="15" 
		value="'.$row['startdate'].'"/></td>
        <td>
		<input class="textfields2" name="enddate_'.$row['ID'].'" type="text" id="enddate_'.$row['ID'].'" size="15" value="'.$row['enddate'].'"/></td>
        <td><input class="textfields2" name="description_'.$row['ID'].'" type="text" id="description_'.$row['ID'].'" size="45" 
		value="'.$row['description'].'"/></td>
        <td>
		<input name="deletedate['.$row['ID'].']" type="submit" id="deletedate['.$row['ID'].']" value="[X]" /></td>
      	</tr>
		';
		$rowcount++;
	}
?>  
<tr>
  <td align="left">&nbsp;</td>
  <td height="35" colspan="4" align="left" valign="middle"><input name="submit_savechanges" type="submit" id="submit_savechanges" value="Save Changes" /></td>
  </tr>
    </table>
	 </form></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</div>
</div>
<DIV ID="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;font:11px Arial, Verdana, Helvetica, sans-serif;text-align:right;padding:4px;line-height:12px;"></DIV>
</body>
</html>
