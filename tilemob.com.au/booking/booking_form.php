<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Book now for your VIP consultation with a tile expert...  - The Tile Mob Pty Ltd, Brisbane</title>
<?
error_reporting(0);
include('connect.php');

//Pull all disable dates from database and STORE IT INTO AN ARRAY
$disabledDates = array();	
$result = mysql_query("SELECT * FROM disabledates");
while($row = mysql_fetch_array($result)) {
	$date_id = $row['ID'];
	$startdate = $row['startdate']; $format_startdate = date("Y-m-d", strtotime($startdate));
	$enddate = $row['enddate']; $format_enddate = date("Y-m-d", strtotime($enddate));
	$description = $row['description'];
	//echo 'cal1x.addDisabledDates("'.$format_startdate.'", "'.$format_enddate.'");';
	//Add all the range of dates in between as well
	if(!in_array(date("d m Y", strtotime($startdate)), $disabledDates)){
		$disabledDates[] = date("d m Y", strtotime($startdate));
		//echo 'Stored date: '.$startdate.'<br/>';
	}		
	$temp_current_strtotime = strtotime($startdate);
	//Add all days of month in between start to end date
	while($temp_current_strtotime < strtotime($enddate)){
		$temp_current_strtotime = strtotime("+1 day", $temp_current_strtotime);
		if(!in_array(date("d m Y", $temp_current_strtotime), $disabledDates)){
			$disabledDates[] = date("d m Y", $temp_current_strtotime);			
			//echo 'Stored date: '.date("d M Y", $temp_current_strtotime).'<br/>';
		}
	}		
	if(!in_array(date("d m Y", strtotime($enddate)), $disabledDates)){
		$disabledDates[] = date("d m Y", strtotime($enddate));
		//echo 'Stored date: '.$enddate.'<br/>';
	}
}
//$disabledDates array will now contain all dates that are disabled in back-end using date format: 05 Feb 2008
$result = mysql_query("SELECT * FROM consultation ORDER BY booking_id DESC");
$row = mysql_fetch_array($result);
$last_booking_id = $row['booking_id'];		

//IF THIS IS A CHANGE APPOINTMENT, WE GET THE VALUES FROM THE URL
if (trim($_GET['id'])!="" && trim($_GET['email'])!="" || trim($_POST['booking_id'])!="" && trim($_POST['booking_email'])!=""){
	if (isset($_POST['booking_id']) && isset($_POST['booking_email'])) {
		$booking_id = $_POST['booking_id'];
		$booking_email = $_POST['booking_email'];
	}
	if (isset($_GET['id']) && isset($_GET['email'])) {
		$booking_id = $_GET['id'];
		$booking_email = $_GET['email'];
	}
	//check database if there is a match...
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
		$bookingmonth = $row['booking_month'];
		$bookingday = $row['booking_day'];
		$bookingyear = $row['booking_year'];
		$bookingdate = $row['booking_date'];
		$bookinghour = $row['booking_hour'];
		$bookingminute = $row['booking_minute'];
		$bookingtime = trim(substr($bookinghour, 0, -2)).":".$bookingminute." ".substr($bookinghour, -2);
		$booker_comments = $row['booker_comments'];
		$project_address = $row['booker_address'];
		$project_type = $row['booker_projecttype'];
			$residential_selection = unserialize(base64_decode($row['booker_residential'])); //should be an array
			$commercial_selection = $row['booker_commercial'];
			/*foreach($residential_selection as $key => $value){
				echo 'key: '.$key.' value: '.$value.'<br/>';
			}*/
		$project_referer = $row['booker_referredby'];
		$project_referer_name = $row['booker_referralname'];
		$preferred_consultant = $row['booker_preferredconsultant'];		
		$subject2 = "TileMob.com.au - Thank you for your Booking Appointment form ".$yourname;
		$change_appointment = true;
	} else {
		$change_appointment = false;
	}
} else {
	$change_appointment = false;
}

/*$val1 = rand(1, 20);
$val2 = rand(1, 20);
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val1.' + '.$val2.' = ';*/
$rand_chars = array('1','2','3','4','5','6','7','8','9','0',
'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o',
'p','q','r','s','t','u','v','w','x','y','z');
$rand = ''; //random string
for($i=0;$i<=5;$i++){
	$rand .= $rand_chars[rand(0,count($rand_chars))];
}
$_SESSION['image_random_value_raw'] = $rand;
?>
<style type="text/css">
<!--
a {
	color: #EF3E34;
	text-decoration: none;
}
a:hover {
	color: #EF3E34;
	text-decoration: underline;
}
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
	/*if($change_appointment == true){
		echo 'padding: 3px;';
		echo 'border:solid #EE3B33; border-width:2px;';
		echo 'background: #F1F1F1;';
	}*/
	?>
}
.style9 {color: #EE3B33}
-->
</style>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />
<link href="../styles/calendarstyles.css" rel="stylesheet" type="text/css" />
<SCRIPT language="JavaScript">
<!--
function silentErrorHandler() {return true;}
window.onerror=silentErrorHandler;
//-->
</SCRIPT>
<script language="javascript">
function disableEmail() {
	<? if($change_appointment == true){echo"document.forms['booking_form'].textfield_youremail.disabled = true;";}?>
}

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
	if (document.forms['booking_form'].textfield_bookinghour.disabled == true || document.forms['booking_form'].textfield_bookingminute.disabled == true) { emptyfields += "\n   *Your Booking time";
	}
	if (document.forms['booking_form'].option_question1.value == "------ Make a Selection ------") {
		emptyfields += "\n   *You Are";
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
	
	if(document.forms['booking_form'].textfield_sum.value != '<?php echo $rand; ?>') {
		emptyfields += "\n   *To protect us from spam, please enter the verification code on the form";
	}
	
	if (emptyfields!= "") { //mandatories not completed!
		emptyfields = "These fields are mandatory:\n" +
		emptyfields + "\n\nPlease fill in all required feilds";		
		alert(emptyfields);
		return false;
	} else { //all mandatories filled in!
		return true;
	}
}
function checkFields2(checktype) {
	emptyfields = "";
	/*if (document.booking_form.textfield_yourname.value == "") {
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
	}*/
	if (document.forms['booking_form'].option_question2.value == "------ Make a Selection ------") {
		emptyfields += "\n   *Project Type";
	}
	/*if (document.forms['booking_form'].option_question3.value == "------ Make a Selection ------") {
		emptyfields += "\n   *Project Commence";
	}
	if (document.forms['booking_form'].option_question4.value != "not applicable") {
		if (document.forms['booking_form'].textfield_referer.value == "") {
			emptyfields += "\n   *Referer name";
		}
	}*/
	
	if (emptyfields!= "") {
		emptyfields = 'Please select a "Project Type" from above before selecting a booking date."';
		//emptyfields + "\n\nPlease fill in all required feilds";
		if(checktype!='silent'){
			alert(emptyfields);
		}
		hideTimes();
		return false;
	} else { //all mandatories filled out for calendar display
		showTimes();
		cal1x.select(document.forms['booking_form'].textfield_bookingdate,'anchor1x','EE, MMM dd, yyyy'); 		
		return true;
	}
}
function checkRetrieveValid() {	
	var booking_id = parseInt(""+document.forms['retrieve_form'].booking_id.value,10);	
	var last_booking_id = parseInt("<?=$last_booking_id?>",10);
	
	//alert(booking_id+" and "+last_booking_id);
	//if the booking number and email is empty, we popup with alert
	var alertMessage = 'Sorry, your booking number is invalid, if you had previously \nmade a booking, please find your booking reference number \nin your email entitled: \n"TileMob.com.au - Your In-Showroom Consultation Booking"';
	if(document.forms['retrieve_form'].booking_id.value == "" && document.forms['retrieve_form'].booking_email.value == ""){
		alert(alertMessage);
		return false;
	} else if(booking_id.length < 4 || booking_id > last_booking_id || booking_id == 0) {
		alert(alertMessage);
		return false;
	} else {
		return true;
	}
}

function requireReferer() {
	if(document.forms['booking_form'].option_question4.value != "not applicable") {
		//now unhide the referer name textfield
		document.forms['booking_form'].textfield_referer.style.display = 'block';
		document.forms['booking_form'].textfield_referer.style.background = '#F8F4BE';
		document.getElementById("referral_name").style.display = 'block'; 
		var referral_id = document.getElementById("referral_id");
		referral_id.firstChild.nodeValue = document.forms['booking_form'].option_question4.value;
	} else {
		document.forms['booking_form'].textfield_referer.style.display = 'none';
		document.getElementById("referral_name").style.display = 'none'; 
	}
}

function requireProjectType() {
	//alert("requireProjectType");
	if(document.forms['booking_form'].option_question2.value == "Residential (new construction)" || document.forms['booking_form'].option_question2.value == "Residential (renovation)") {
		showTimes();
		document.getElementById("commercial_row").style.display = 'none';
		document.getElementById("residential_row").style.display = '';
	} else if(document.forms['booking_form'].option_question2.value == "Commercial (new construction)" || document.forms['booking_form'].option_question2.value == "Commercial (renovation)") {
		showTimes();
		document.getElementById("residential_row").style.display = 'none';
		document.getElementById("commercial_row").style.display = '';
		//document.getElementById("commercial_row").style.background = '#F8F4BE';
	} else {
		document.getElementById("residential_row").style.display = 'none';
		document.getElementById("commercial_row").style.display = 'none';
		hideTimes();
	}
}

function residentialSelectAll() {
	//alert("residentialSelectAll() executed!");
	//if residential_select_all is checked, we check all those checkboxes
	if(document.forms['booking_form'].residential_selection_all.checked == true) {
		//alert("residential_select_all was checked: "+document.forms['booking_form'].length);
		for(i=0;i<document.forms['booking_form'].length;i++){
			//document.forms['booking_form'].residential_selection[i].checked = true;
			if(document.forms['booking_form'].elements[i].type == "checkbox"){
				//alert("element name: "+document.forms['booking_form'].elements[i].name);
				document.forms['booking_form'].elements[i].checked = true;
				//document.forms['booking_form'].elements[i].disabled = true;
			}
		}
	} else {
		for(i=0;i<document.forms['booking_form'].length;i++){
			//document.forms['booking_form'].residential_selection[i].checked = true;
			if(document.forms['booking_form'].elements[i].type == "checkbox"){
				//alert("element name: "+document.forms['booking_form'].elements[i].name);
				document.forms['booking_form'].elements[i].checked = false;
				//document.forms['booking_form'].elements[i].disabled = false;
			}
		}
	}
}

function hideTimes() { //show/hides pulldown and calendar selectable times
	document.forms['booking_form'].textfield_bookingfulldate.disabled = true;
	document.forms['booking_form'].textfield_bookingdate.disabled = true;
	document.forms['booking_form'].textfield_bookingmonth.disabled = true;
	document.forms['booking_form'].textfield_bookingday.disabled = true;
	document.forms['booking_form'].textfield_bookingyear.disabled = true;
	document.forms['booking_form'].textfield_bookinghour.disabled = true;
	document.forms['booking_form'].textfield_bookingminute.disabled = true;
}
function showTimes() {
	document.forms['booking_form'].textfield_bookingfulldate.disabled = false;
	document.forms['booking_form'].textfield_bookingdate.disabled = false;
	document.forms['booking_form'].textfield_bookingmonth.disabled = false;
	document.forms['booking_form'].textfield_bookingday.disabled = false;
	document.forms['booking_form'].textfield_bookingyear.disabled = false;
	document.forms['booking_form'].textfield_bookinghour.disabled = false;
	document.forms['booking_form'].textfield_bookingminute.disabled = false;
}

function showSelectableDates() { //populates selectable days of that selected month from pulldown
	//alert("showing selectable dates..");
	//firstly, check the selected month and show all the available days in that month
	var selectedYear = document.forms['booking_form'].textfield_bookingyear.value;
	var selectedMonth = document.forms['booking_form'].textfield_bookingmonth.value; //today's month is generated by this field by php
	var thisMonth = new Date(); //thisMonth.getMonth() will return this month in digits
	var thisDay = new Date(); // thisDay.getDate() will return the day of the month of today
	var mm = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	var numDays = new Date(selectedYear, mm.indexOf(selectedMonth), 0); //2008, 02, 0
	var daysInMonth = numDays.getDate(); //eg 28 number of days in selectedMonth of selectedYear
	document.forms['booking_form'].textfield_bookingday.length = 0;	
	//alert("thisMonth is: "+mm[thisMonth.getMonth()+1]+" of day: "+thisDay.getDate());
	var arrayindex = 0;
	for(var i=0; i<daysInMonth; i++) { //we are now outputting all days of that month (with restrictions) as pulldown options 
		var temp_date = selectedMonth+" "+(i+1)+", "+selectedYear;	
		var temp_bookingdate = new Date(eval('"'+temp_date+'"'));
		var daysofweek2 = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
		var daysofweek = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
		//alert("temp_bookingdate is: "+temp_bookingdate);
		
		//We must first make sure i is not pointing to a day of the month in disabledDates array
		if(i < 9){ //currentDateOutput holds the selected date stamp in example format: 05 02 2008
			if(mm.indexOf(selectedMonth)<9){ var currentDateOutput = "0"+(i+1)+" "+"0"+(mm.indexOf(selectedMonth))+" "+selectedYear; 
			}else{ var currentDateOutput = "0"+(i+1)+" "+(mm.indexOf(selectedMonth))+" "+selectedYear; }
		} else {
			if(mm.indexOf(selectedMonth)<9){ var currentDateOutput = (i+1)+" "+"0"+(mm.indexOf(selectedMonth))+" "+selectedYear; 
			}else{ var currentDateOutput = (i+1)+" "+(mm.indexOf(selectedMonth))+" "+selectedYear; }
		}
		//alert('currentDateOutput is: '+currentDateOutput); //good format output : )
		//Go through disabledDates array and check if an element in this array equals to this currentDateOutput
		var foundDateMatch = false;
		if(disabledDates.length>0){
			for(dIndex=0; dIndex<disabledDates.length; dIndex++){
				if(disabledDates[dIndex]==currentDateOutput){ foundDateMatch = true; } //found a match
			}
		}
		
		if(foundDateMatch == false){
			if(daysofweek[temp_bookingdate.getDay()] != "Sunday") { //don't output sundays
				if(i < 9){ //1 digit days must start with a 0
					if(mm[thisMonth.getMonth()+1] != selectedMonth){//check if the selected month is not today's month			
						document.forms['booking_form'].textfield_bookingday.options[arrayindex]=new Option("0"+(i+1)+" ("+daysofweek2[temp_bookingdate.getDay()]+")", "0"+(i+1));
					} else { //But if it is today's month selected, we handle it differently
						if ((i+1) >= thisDay.getDate()) { //output all days after today's date, i is days after today's day
							document.forms['booking_form'].textfield_bookingday.options[arrayindex]=new Option("0"+(i+1)+" ("+daysofweek2[temp_bookingdate.getDay()]+")", "0"+(i+1));
						} else { //and i is a date before today's date... we don't output it, we move the arrayindex back up
							arrayindex--;
						}
					}
				} else if(i < daysInMonth){ //2 digit days don't need to have a starting 0 filler
					if(mm[thisMonth.getMonth()+1] != selectedMonth){//don't output all days before today's date	
						document.forms['booking_form'].textfield_bookingday.options[arrayindex]=new Option(i+1+" ("+daysofweek2[temp_bookingdate.getDay()]+")", i+1);
					} else {
						if (i > thisDay.getDate()-2) {
							document.forms['booking_form'].textfield_bookingday.options[arrayindex]=new Option(i+1+" ("+daysofweek2[temp_bookingdate.getDay()]+")", "0"+(i+1));
						}
					}
				}
				arrayindex++;
			}
		}
	}
	//alert("Month of "+mm.indexOf(selectedMonth)+" has "+daysInMonth+" days.");
	var temp_bookingday = thisDay.getDate();
	<? if($bookingday!=""){echo'temp_bookingday ='.$bookingday;}?>;
	if(temp_bookingday != "" && temp_bookingday < 9 && temp_bookingday > 0){
		document.forms['booking_form'].textfield_bookingday.value = temp_bookingday;
	}	
}

function changeDayDate() { //Check selected dates from pulldown and populates the hours/mins options for those days
	//alert("changeDayDate...");
	//document.forms['booking_form'].textfield_bookingdate.value = document.forms['booking_form'].textfield_bookingmonth.value+" "+document.forms['booking_form'].textfield_bookingday.value+", "+document.forms['booking_form'].textfield_bookingyear.value;
	document.forms['booking_form'].textfield_bookingdate.value = document.forms['booking_form'].textfield_bookingfulldate.value;
	//alert("document.forms['booking_form'].textfield_bookingdate.value is: "+document.forms['booking_form'].textfield_bookingdate.value);
	var temp_bookingdate = new Date(eval('"'+document.forms['booking_form'].textfield_bookingdate.value+'"'));
	var daysofweek = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
	//alert("date field: "+document.forms['booking_form'].textfield_bookingdate.value+" which is: "+daysofweek[temp_bookingdate.getDay()]);
	
	var temp_datenow = "<?=date("F d, Y");?>";//Today's date, same format as textfield_bookingdate field value
	var temp_hournow = "<?=date("g a");?>";//Today's time - hour
	var temp_minnow = "<?=date("i");?>";//Today's minute - hour
	
	if(document.forms['booking_form'].textfield_bookingdate.value != "" && document.forms['booking_form'].textfield_bookingdate.value.length > 5){
		//Now we update the booking time hour
		document.forms['booking_form'].textfield_bookinghour.options.length = 0;
		/*if(document.forms['booking_form'].textfield_bookingdate.value == temp_datenow) { //if selected date is today's date
			if(daysofweek[temp_bookingdate.getDay()] == "Saturday"){ //if selected date falls on a saturday
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
			}
		} else*/ if(daysofweek[temp_bookingdate.getDay()] == "Saturday"){ //if selected date falls on a saturday
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
		} else if(daysofweek[temp_bookingdate.getDay()] == "Sunday"){ //if selected date falls on a sunday
			document.forms['booking_form'].textfield_bookinghour.disabled = true;
			document.forms['booking_form'].textfield_bookingminute.disabled = true;
			alert("Sorry we are closed on Sundays. \nOur opening times are: \nMon-Fri: 8:30 am - 5:00 pm and \nSat: 9:00 am - 2:00 pm \nPlease choose a different booking date (day of the week)");
		} else { //if selected date falls on any other day such as a weekday
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
		//alert("You must first select a booking date, \non the above, please click CHOOSE to select a booking date.");
	}
	<? if(trim($bookinghour)!=""){echo'document.forms[\'booking_form\'].textfield_bookinghour.value="'.$bookinghour.'"';}?>
}

function addLoadEvent(func) { 
	var oldonload = window.onload; 
	if (typeof window.onload != 'function') { 
		window.onload = func; 
	} else { 
		window.onload = function() { 
			if (oldonload) { 
				oldonload(); 
			} 
			func(); 
		} 
	} 
}

//Global variables
var disabledDates = new Array();

function createDisabledDates(){
	//alert("createDisabledDates executed...");
<? //Pass all values in this array to javascript array
	$i = 0;
	foreach($disabledDates as $value){
		echo 'disabledDates['.$i.'] = "'.$value.'"; ';
		$i++;
	}
?>
}

addLoadEvent(disableEmail); 
addLoadEvent(createDisabledDates); 
//addLoadEvent(showSelectableDates); 
addLoadEvent(changeDayDate); 
addLoadEvent(requireReferer); 
addLoadEvent(requireProjectType); 
<? //if($change_appointment != true){ echo'addLoadEvent(hideTimes);';}//hide date/times if not a reschedule ?>

addLoadEvent(function() {
  /* more code to run on page load */
});
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="CalendarPopup.js"></SCRIPT>
</head>
<body style="background:#FFFFFF;">
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="440" align="left" valign="middle"><table width="99%" border="0" cellspacing="20" cellpadding="0">
      <tr>
        <td><h2 style="font-family:Arial, Verdana;color:#AAAAAA;font-size:20px;line-height:24px;font-weight:medium;margin-bottom:10px;">Book now for your VIP consultation with a tile expert...</h2>
		     <span class="Details" style="font-size:12px;color:#666666;">Each building project is unique and we want to make sure your tile selection experience in our showroom is as enjoyable & productive as possible. Nominate a suitable day & time from the calendar below and one of our experienced consultants will be ready to meet with you one-on-one. Get ready to explore the possibilities as we bring our energy and expertise to your tiling project!</span><h2 style="font-family:Arial, Verdana;color:#AAAAAA;font-size:14px;font-weight:medium;text-align:right;padding-bottom:0;margin-top:15px;margin-bottom:0;">Tell us when you�ll be visiting...</h2><br/></td>
      </tr>
    </table></td>
    <td width="350" align="right" valign="bottom"><form id="retrieve_form" name="retrieve_form" method="post" action="booking_form.php" onSubmit="return checkRetrieveValid();">
        <div style="align:right;padding:10px;border-width:1px;border-left-style:solid;border-color:#D3D3D3;">
		  <table width="320" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="20" colspan="3" align="left"><img src="/~titi2698/tilemob.com.au/images/the-tile-mob-location2.jpg" alt="Come visit The Tile Mob" width="229" height="157" border="0"/></td>
          </tr>
          <tr>
            <td height="20" colspan="3">&nbsp;</td>
          </tr>
          <tr>
		  	<td height="20" colspan="3" align="left" valign="middle"><span class="Details"><strong>Need to change your existing  booking? </strong></span></td>
          </tr>
          <tr>
            <td width="130" height="25" align="left" valign="middle"><span class="Details">Your booking number: </span></td>
            <td width="30" align="left" valign="middle">&nbsp;</td>
            <td align="left"><span class="Details">Your email: </span></td>
            </tr>
          <tr>
            <td align="left"><input name="booking_id" type="text" class="textfield1" id="booking_id" size="15" /></td>
            <td align="left">&nbsp;</td>
            <td align="left"><input name="booking_email" type="text" class="textfield1" id="booking_email" size="30" /></td>
            </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td height="30" align="right" valign="bottom"><input class="btn_textfields" name="submit_retrieve" type="submit" id="submit_retrieve" value="Retrieve it" /></td>
            </tr>
        </table>
		</div>
    </form></td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="left" valign="middle"><img src="/~titi2698/tilemob.com.au/images/img_horizontal.gif" border="0" width="100%" height="1px" vspace="3px"/></td>
  </tr>
</table>
<form id="booking_form" name="booking_form" onsubmit="return checkFields()" method="post" action="process_booking_form.php<? if($change_appointment==true){echo'?reschedule=true&booking_id='.$booking_code;}?>">
  <table width="790" border="0" cellpadding="0" cellspacing="1">
    <tr>
      <td height="25" align="center" valign="middle" scope="row">&nbsp;</td>
      <th rowspan="2" align="center" valign="top" scope="row"><table width="370" border="0" cellpadding="0" cellspacing="0" style="border:solid #FFFFFF; border-width:0px;">
        <tr>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="130" align="center"><a href="http://www.tilemob.com.au/"><img src="/~titi2698/tilemob.com.au/images/img_tm_logo_02.gif" alt="The Tile Mob" width="100" height="70" border="0"/></a></td>
          <td align="left" valign="middle"><span class="Details"><img src="/~titi2698/tilemob.com.au/images/txt_showroom.gif" alt="Showroom" vspace="3" border="0" /><br />
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
      <td height="20" align="center" valign="middle" scope="row">
         <img src="/~titi2698/tilemob.com.au/images/txt_visitourshowroom2.gif" alt="Visit our Showroom" />
         <span class="Details">
		   <? 
		if($change_appointment == true){ echo'<h2 style="color:#EE3B33; font-size:16px;margin-top:2px;"><strong><img src="/~titi2698/tilemob.com.au/images/img_arrowbullet.gif" border="0" hspace="0px" align="absmiddle" vspace="4px">&nbsp;Consultation reschedule form </strong></h2>'; }
		else { echo'<h2 style="color:#EE3B33; font-size:16px;margin-top:2px;"><strong><img src="/~titi2698/tilemob.com.au/images/img_arrowbullet.gif" border="0" hspace="0px" align="absmiddle" vspace="4px">&nbsp;Make an In-Showroom Consultation Booking </strong></h2>'; }
		?>
         </span></td>
    </tr>
    <tr>
      <th width="50%" align="center" valign="top" bgcolor="#E5E5E5" scope="row"><table width="375" border="0" cellpadding="5" cellspacing="0">
          
          <tr>
            <th width="800" valign="middle" scope="row"><div align="right" class="Details"><span class="style9">*</span>Project Type: </div></th>
            <td width="5" align="left" class="Details">&nbsp;</td>
            <td height="50" align="left" valign="middle" class="Details"><select name="option_question2" size="1" id="option_question2" onchange="requireProjectType();">
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
            <th colspan="3" align="right" valign="top" scope="row">
			<span id="residential_row" style="display:none;">
			<table width="330" border="0" cellpadding="0" cellspacing="0" style="margin:0px;padding:0px;border:solid #CCCCCC;border-width:1px;">			
			   <tr>
                  <td height="20" colspan="4" align="left"><span class="Details">&nbsp;&nbsp;<strong>I will be selecting tiles for the following areas:</strong></span></td>
                </tr>
                <tr>
                  <td width="20" align="left">
				  <?
				  if($residential_selection['\"Kitchen Wall\"']==""){
				  echo'<input name=\'residential_selection["Kitchen Wall"]\' type=\'checkbox\' id=\'residential_selection["Kitchen Wall"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Kitchen Wall"]\' type=\'checkbox\' id=\'residential_selection["Kitchen Wall"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?>				  </td>
                  <td width="145" align="left"><span class="Details">Kitchen Wall</span></td>
                  <td width="20" align="left">
				  <?
				  if($residential_selection['\"Laundry Wall & Floor\"']==""){
				  echo'<input name=\'residential_selection["Laundry Wall & Floor"]\' type=\'checkbox\' id=\'residential_selection["Laundry Wall & Floor"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Laundry Wall & Floor"]\' type=\'checkbox\' id=\'residential_selection["Laundry Wall & Floor"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?>				  </td>
                  <td width="145" align="left"><span class="Details">Laundry Wall &amp; Floor</span></td>
                </tr>
                <tr>
                  <td align="left">
				  <?
				  if($residential_selection['\"Bathroom Wall & Floor\"']==""){
				  echo'<input name=\'residential_selection["Bathroom Wall & Floor"]\' type=\'checkbox\' id=\'residential_selection["Bathroom Wall & Floor"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Bathroom Wall & Floor"]\' type=\'checkbox\' id=\'residential_selection["Bathroom Wall & Floor"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?>				  </td>
                  <td align="left"><span class="Details">Bathroom Wall &amp; Floor</span></td>
                  <td align="left">
				  <?
				  if($residential_selection['\"Living Area/Main Area Floors\"']==""){
				  echo'<input name=\'residential_selection["Living Area/Main Area Floors"]\' type=\'checkbox\' id=\'residential_selection["Living Area/Main Area Floors"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Living Area/Main Area Floors"]\' type=\'checkbox\' id=\'residential_selection["Living Area/Main Area Floors"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?>				  </td>
                  <td align="left"><span class="Details">Living Area/Main Area Floors</span></td>
                </tr>
                <tr>
                  <td align="left">
				  <?
				  if($residential_selection['\"Ensuite Wall & Floor\"']==""){
				  echo'<input name=\'residential_selection["Ensuite Wall & Floor"]\' type=\'checkbox\' id=\'residential_selection["Ensuite Wall & Floor"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Ensuite Wall & Floor"]\' type=\'checkbox\' id=\'residential_selection["Ensuite Wall & Floor"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?>				  </td>
                  <td align="left"><span class="Details">Ensuite/Wall &amp; Floor</span></td>
                  <td align="left">
				  <?
				  if($residential_selection['\"External Floors/Driveway\"']==""){
				  echo'<input name=\'residential_selection["External Floors/Driveway"]\' type=\'checkbox\' id=\'residential_selection["External Floors/Driveway"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["External Floors/Driveway"]\' type=\'checkbox\' id=\'residential_selection["External Floors/Driveway"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?>				  </td>
                  <td align="left"><span class="Details">External Floors/Driveway</span></td>
                </tr>
                <tr>
                  <td align="left">
				  <?
				  if($residential_selection['\"Pool Tiles\"']==""){
				  echo'<input name=\'residential_selection["Pool Tiles"]\' type=\'checkbox\' id=\'residential_selection["Pool Tiles"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Pool Tiles"]\' type=\'checkbox\' id=\'residential_selection["Pool Tiles"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?>				  </td>
                  <td align="left"><span class="Details">Pool Tiles</span></td>
                  <td align="left">
				  <?
				  if($residential_selection['\"Other\"']==""){
				  echo'<input name=\'residential_selection["Other"]\' type=\'checkbox\' id=\'residential_selection["Other"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Other"]\' type=\'checkbox\' id=\'residential_selection["Other"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?></td>
				<td align="left"><span class="Details">Other </span></td>
                </tr>
                <tr>
                  <td align="left"><?
				  if($residential_selection['\"Powder Room\"']==""){
				  echo'<input name=\'residential_selection["Powder Room"]\' type=\'checkbox\' id=\'residential_selection["Powder Room"]\' value=\'checkbox\' />'; 
				  } else{
				  	 echo'<input name=\'residential_selection["Powder Room"]\' type=\'checkbox\' id=\'residential_selection["Powder Room"]\' value=\'checkbox\' checked=\'checked\' />';
				  }
				  ?></td>
                  <td align="left"><span class="Details">WC / Powder Room </span></td>
                  <td style="border-top:solid #CCCCCC; border-width:1px;" align="left"><input name="residential_selection_all" type="checkbox" id="residential_selection_all" value="checkbox" onclick="residentialSelectAll()"/></td>
                  <td style="border-top:solid #CCCCCC; border-width:1px;" align="left"><span class="Details">All Areas/Select All </span></td>
                </tr>              
            </table></span></th>
          </tr>
          <tr>
            <th colspan="3" align="right" valign="top" scope="row">
			<span id="commercial_row" style="display:none;">
			<table width="227" border="0" cellspacing="0" cellpadding="0" style="padding:3px;border:solid #CCCCCC;border-width:1px;margin-right:3px;">              
			  <tr>
                <td height="40" align="left"><span class="Details">&nbsp;&nbsp;<strong>I will be selecting tiles for the <br/>&nbsp;&nbsp;following areas: </strong></span></td>
              </tr>
              <tr>
                <td height="30" align="center" valign="top"><span class="Details">
                  <input name="textfield_commercial_custom" type="text" class="textfield1" id="textfield_commercial_custom" value="<?=$commercial_selection;?>" size="30" style="background:#F8F4BE;"/>
                </span></td>
              </tr>
            </table>
			</span>			</th>
          </tr>
          <tr>
            <th colspan="3" align="left" valign="top" scope="row"><span class="Details">Please specify your preferred consultation booking time below. Click 'CHOOSE' first to select a booking date from our pop-up calendar and then select a booking time. </span></th>
          </tr>
          <tr>
            <th align="left" valign="top" scope="row"></th>
            <th colspan="2" align="left" valign="top" scope="row"><span class="Details"><span class="style9">*</span><strong>1. Select a booking date:</strong> </span></th>
          </tr>
          <tr>
            <td colspan="2" align="right" valign="middle" scope="row"><span class="Details"><A HREF="#" NAME="anchor1x" TITLE="CHOOSE A DATE" ID="anchor1x" onClick="checkFields2(); return false;"><strong> CHOOSE <img src="/~titi2698/tilemob.com.au/images/calendar.gif" alt="CHOOSE A DATE" width="16" height="16" border="0" align="absmiddle" style="margin-right:3px;"/></strong></A></span></td>
            <td align="left" valign="top" class="Details" scope="row"><select name="textfield_bookingfulldate" id="textfield_bookingfulldate" onchange="changeDayDate();">
                  <?
					//List all dates from today's date to +3months ahead
					$todays_date = date("l d F Y"); // from today
					$end_date = date("l d F Y", strtotime("+3 months first day")); // in 3 months
					
					$output_date = $todays_date;
					$days = 1; //default
					while(strtotime($output_date) < strtotime($end_date)){ //List all dates between
						//don't output if it is a disabled date
						if(!in_array(date("d m Y", strtotime($output_date)), $disabledDates)){
							//don't output if it is a Sunday
							if(date("l", strtotime($output_date)) != "Sunday"){
								//if $bookingdate is output_date, we have it selected
								if(date("l d F Y", strtotime($bookingdate)) == $output_date){
									echo '<option value="'.$output_date.'" SELECTED>'.$output_date.'</option>';	
								} else {
									echo '<option value="'.$output_date.'">'.$output_date.'</option>';	
								}					
							}
						}
						$output_date = date("l d F Y", strtotime("+".$days." day"));
						$days++;
					}
					?>
                </select>
                  <select name="textfield_bookingmonth" id="textfield_bookingmonth" style="display:none;" onchange="showSelectableDates();">
                <?
				//don't show months pass 3 months of current month
				$future_month1 = date("F", strtotime("this month"));
				$future_month2 = date("F", strtotime("+1 months first day"));
				$future_month3 = date("F", strtotime("+2 months first day"));
				echo 'future months: '.$future_month1.$future_month2.$future_month3.'<br/>';
		  
		  if($bookingmonth==$future_month1){echo'<option value="'.$future_month1.'" SELECTED>'.$future_month1.'</option>';
		  }else{echo'<option value="'.$future_month1.'">'.$future_month1.'</option>';}

		  if($bookingmonth==$future_month2){echo'<option value="'.$future_month2.'" SELECTED>'.$future_month2.'</option>';
		  }else{echo'<option value="'.$future_month2.'">'.$future_month2.'</option>';}
		  
		  if($bookingmonth==$future_month3){echo'<option value="'.$future_month3.'" SELECTED>'.$future_month3.'</option>';
		  }else{echo'<option value="'.$future_month3.'">'.$future_month3.'</option>';}
		  ?>
              </select>
              <select name="textfield_bookingday" id="textfield_bookingday" style="display:none;" onchange="changeDayDate();">
          <?
		  /*for($i=1; $i<31; $i++){
		  	if($i < 9){
		  		if($bookingday=="0".$i){echo'<option value="0'.$i.'" SELECTED>0'.$i.'</option>';}else{echo'<option value="0'.$i.'">0'.$i.'</option>';}
			} else {
				if($bookingday==$i){echo'<option value="'.$i.'" SELECTED>'.$i.'</option>';}else{echo'<option value="'.$i.'">'.$i.'</option>';}
			}
		  }*/
		  ?>
              </select>
              <select name="textfield_bookingyear" id="textfield_bookingyear" style="display:none;">
                <?	
		  if($bookingyear=="2008"){echo'<option value="2008" SELECTED>2008</option>';}else{echo'<option value="2008">2008</option>';}
		  ?>
              </select>
              <input name="textfield_bookingdate" type="hidden" id="textfield_bookingdate" value="<?=$bookingdate;?>" onchange="javascript:showSelectableDates();"/>
			  
			  <DIV ID="testdiv1" STYLE="position:absolute;z-index:1000;margin-left:210px;visibility:hidden;background-color:white;layer-background-color:white;font:11px Arial, Verdana, Helvetica, sans-serif;text-align:right;padding:4px;line-height:12px;"></DIV>
			  <iframe id="selectblocker" style="position:absolute;z-index:500;margin-top:20px;left:150px;display:none;filter:progid:DXImageTransform.Microsoft.Alpha(style=0, opacity=0);" frameBorder="0" width="150" height="150" scrolling="no" src="blank.html"></iframe>
			  
		      <span class="Details"> 				
        <SCRIPT LANGUAGE="JavaScript" ID="jscal1x">
		var cal1x = new CalendarPopup("testdiv1");
		cal1x.setReturnFunction("setMultipleValues3");
		function setMultipleValues3(y,m,d) { //sets the values in month/day pulldown
			var mm = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			var daysofweek = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];			
			var calendarDate = new Date((d+1)+" "+mm[m]+" "+y);
			var daysofweek_num = calendarDate.getDay()-1; if(daysofweek_num == -1){ daysofweek_num = 6; }
			//alert("getDay is: "+daysofweek_num);
			document.forms['booking_form'].textfield_bookingmonth.value = mm[m];
			if(d <= 9){
				//alert(daysofweek[daysofweek_num]+" "+"0"+d+" "+mm[m]+" "+y);
				document.forms['booking_form'].textfield_bookingday.value = "0"+d;
				document.forms['booking_form'].textfield_bookingfulldate.value = daysofweek[daysofweek_num]+" "+"0"+d+" "+mm[m]+" "+y;
			} else {
				//alert(daysofweek[daysofweek_num]+" "+d+" "+mm[m]+" "+y);
				document.forms['booking_form'].textfield_bookingday.value = d;
				document.forms['booking_form'].textfield_bookingfulldate.value = daysofweek[daysofweek_num]+" "+d+" "+mm[m]+" "+y;				
			}
			//alert("y: "+y+" m: "+m+" d: "+d);
		}
		
		cal1x.setDisabledWeekDays(0,0);
		cal1x.setCssPrefix("TEST");
		//cal1x.showNavigationDropdowns();
		//cal1x.addDisabledDates("2008-01-15");
		//var now = new Date();
		cal1x.addDisabledDates(null,"<?=date("M j, Y", strtotime("-1 day"))?>"); //disable dates before today
		cal1x.addDisabledDates("<?=date("M j, Y", strtotime("+90 day"))?>",null); //disable dates 90 days ahead
		<?
		//Pull all disable dates from database and echo it in javascript
		$result = mysql_query("SELECT * FROM disabledates");
		while($row = mysql_fetch_array($result)) {
			$date_id = $row['ID'];
			$startdate = $row['startdate']; $format_startdate = date("Y-m-d", strtotime($startdate));
			$enddate = $row['enddate']; $format_enddate = date("Y-m-d", strtotime($enddate));
			$description = $row['description'];
			echo 'cal1x.addDisabledDates("'.$format_startdate.'", "'.$format_enddate.'");';	
		}		
		?>
		</SCRIPT>
              <!-- The next line prints out the source in this example page. It should not be included when you actually use the calendar popup code -->
              <SCRIPT LANGUAGE="JavaScript">writeSource("jscal1x");</SCRIPT>
	        </span></td>
          </tr>
          <tr>
            <th align="left" valign="top" scope="row"></th>
            <th colspan="2" align="left" valign="top" scope="row"><span class="Details"><span class="style9">*</span><strong>2. Select a booking time:</strong></span></th>
          </tr>
          <tr>
            <th align="left" valign="top" scope="row"></th>
            <th align="left" valign="top" scope="row">&nbsp;</th>
            <td height="35" align="left" valign="top" class="Details" scope="row"><select name="textfield_bookinghour" id="textfield_bookinghour" style="z-index:1;">
          <?
		  if($bookinghour=="9 am"){echo'<option value="9 am" SELECTED>9 am</option>';}
		  if($bookinghour=="10 am"){echo'<option value="10 am" SELECTED>10 am</option>';}
		  if($bookinghour=="11 am"){echo'<option value="11 am" SELECTED>11 am</option>';}
		  if($bookinghour=="12 pm"){echo'<option value="12 pm" SELECTED>12 pm</option>';}
		  if($bookinghour=="1 pm"){echo'<option value="1 pm" SELECTED>1 pm</option>';}
		  if($bookinghour=="2 pm"){echo'<option value="2 pm" SELECTED>2 pm</option>';}
		  if($bookinghour=="3 pm"){echo'<option value="3 pm" SELECTED>3 pm</option>';}
		  if($bookinghour=="4 pm"){echo'<option value="4 pm" SELECTED>4 pm</option>';}
		  ?>
              </select>
              <select name="textfield_bookingminute" id="textfield_bookingminute" style="z-index:1;">
                <?
		  if($bookingminute=="00"){echo'<option value="00" SELECTED>00</option>';}else{echo'<option value="00">00</option>';}
		  if($bookingminute=="15"){echo'<option value="15" SELECTED>15</option>';}else{echo'<option value="15">15</option>';}
		  if($bookingminute=="30"){echo'<option value="30" SELECTED>30</option>';}else{echo'<option value="30">30</option>';}
		  if($bookingminute=="45"){echo'<option value="45" SELECTED>45</option>';}else{echo'<option value="45">45</option>';}
		  ?>
            </select></td>
          </tr>
      </table>      </th>
      <th width="50%" align="center" valign="top" bgcolor="#E5E5E5" scope="row"><table width="375" border="0" cellpadding="5" cellspacing="0">
          
          <tr>
            <td height="190" align="left" valign="bottom" scope="row"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              
              
              <tr>
                <td width="120" valign="top"><div align="right" class="Details">Project Address: </div></td>
                <td width="10" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><span class="Details">
                  <textarea class="textfield1" name="textarea_projectaddress" style="height:60px;" id="textarea_projectaddress"><?=$project_address;?></textarea>
                </span></td>
              </tr>
              <tr>
                <td valign="top"><div align="right"><span class="Details"><span class="style9">*</span>Project Commence: </span></div></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><span class="Details">
                  <select class="textfields3" name="option_question3" size="1" id="option_question3" >
                    <option value="------ Make a Selection ------">------ Make a Selection ------</option>
                    <?
		if($project_commence=="Less than 1 month"){echo'<option value="Less than 1 month" SELECTED>Less than 1 month</option>';}
			else{echo'<option value="Less than 1 month">Less than 1 month</option>';}
		if($project_commence=="1-3 months"){echo'<option value="1-3 months" SELECTED>1-3 months</option>';}
			else{echo'<option value="1-3 months">1-3 months</option>';}
 		if($project_commence=="More than 3 months"){echo'<option value="More than 3 months" SELECTED>More than 3 months</option>';}
			else{echo'<option value="More than 3 months">More than 3 months</option>';}
		?>
                  </select>
                </span></td>
              </tr>
              <tr>
                <td valign="top"><div align="right"><span class="Details"><span class="style9">*</span>Referred by: </span></div></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><span class="Details">
                  <select class="textfields3" name="option_question4" size="1" id="option_question4" onchange="requireReferer();">
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
                  </select>
                </span></td>
              </tr>
              <tr>
                <td align="right" valign="top"><span id="referral_name"><span class="Details"><span class="style9">*</span><span ID="referral_id">Referral</span> name:</span></span></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><span class="Details">
                  <input name="textfield_referer" type="text" class="textfield1" id="textfield_referer" value="<?=$project_referer_name;?>" size="30" />
                </span></td>
              </tr>
              <tr>
                <td align="right" valign="top"><span id="referral_name"><span class="Details"><span class="style9">*</span>Requested consultant:</span></span></td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><span class="Details">
                  <select class="textfields3" name="preferred_consultant" id="preferred_consultant">
                    <option value="------ Make a Selection ------">------ Make a Selection ------</option>
                    <?
		if($preferred_consultant=="No request"){echo'<option value="No request" SELECTED>No request</option>';}
			else{echo'<option value="No request">No request</option>';}
		if($preferred_consultant=="Grant"){echo'<option value="Grant" SELECTED>Grant</option>';}
			else{echo'<option value="Grant">Grant</option>';}
		if($preferred_consultant=="Craig"){echo'<option value="Craig" SELECTED>Craig</option>';}
			else{echo'<option value="Craig">Craig</option>';}
		if($preferred_consultant=="Tracy"){echo'<option value="Tracy" SELECTED>Tracy</option>';}
			else{echo'<option value="Tracy">Tracy</option>';} 		
		if($preferred_consultant=="Donna"){echo'<option value="Donna" SELECTED>Donna</option>';}
			else{echo'<option value="Donna">Donna</option>';}
		if($preferred_consultant=="Darryl"){echo'<option value="Darryl" SELECTED>Darryl</option>';}
			else{echo'<option value="Darryl">Darryl</option>';}
		if($preferred_consultant=="Sean"){echo'<option value="Sean" SELECTED>Sean</option>';}
			else{echo'<option value="Sean">Sean</option>';}
		?>
                  </select>
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <th align="left" valign="top" scope="row"></th>
          </tr>
          <tr>
            <th align="left" valign="top" scope="row"></th>
          </tr>
          
          <tr>
            <th align="left" valign="top" scope="row"></th>
          </tr>
          <tr>
            <th align="left" valign="top" scope="row"></th>
          </tr>
      </table></th>
    </tr>
    <tr>
      <th align="center" valign="top" bgcolor="#E5E5E5" scope="row"><table width="375" border="0" cellpadding="5" cellspacing="0">

        <tr>
          <th align="right" valign="middle" scope="row"><span class="Details"><span class="style9">*</span>You
            are:</span></th>
          <td width="5" align="left" class="Details">&nbsp;</td>
          <td width="110" height="50" align="left" valign="middle" class="Details"><select name="option_question1" id="option_question1" style="z-index:1;">
              <option value="------ Make a Selection ------">------ Make a Selection ------</option>
              <?
		if($youare=="Home-Owner"){echo'<option value="Home-Owner" SELECTED>Home-Owner</option>';}
			else{echo'<option value="Home-Owner">Home-Owner</option>';}
		if($youare=="Architect/Designer"){echo'<option value="Architect/Designer" SELECTED>Architect/Designer</option>';}
			else{echo'<option value="Architect/Designer">Architect/Designer</option>';}
 		if($youare=="Builder/Tradesperson"){echo'<option value="Builder/Tradesperson">Builder/Tradesperson</option>';}
			else{echo'<option value="Builder/Tradesperson">Builder/Tradesperson</option>';}
		if($youare=="Developer"){echo'<option value="Developer" SELECTED>Developer</option>';}
			else{echo'<option value="Developer">Developer</option>';}
		?>
          </select></td>
        </tr>
        <tr>
          <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Name: </div></th>
          <td align="left" class="Details">&nbsp;</td>
          <td align="left" class="Details"><label>
            <input name="textfield_yourname" type="text" class="textfield1" id="textfield_yourname" value="<?=$yourname;?>" size="30"/>
          </label></td>
        </tr>
        <tr>
          <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Phone Number: </div></th>
          <td align="left" class="Details">&nbsp;</td>
          <td align="left" class="Details"><input name="textfield_yournumber" type="text" class="textfield1" id="textfield_yournumber" value="<?=$yourphone;?>" size="30" /></td>
        </tr>
        <tr>
          <th valign="top" scope="row"><div align="right" class="Details">Tel/Mobile (other): </div></th>
          <td align="left" class="Details">&nbsp;</td>
          <td align="left" class="Details"><input name="textfield_yournumber2" type="text" class="textfield1" id="textfield_yournumber2" value="<?=$yourphone2;?>" size="30" /></td>
        </tr>
        <tr>
          <th valign="top" scope="row"><div align="right" class="Details">Company
            Name: </div></th>
          <td align="left" class="Details">&nbsp;</td>
          <td align="left" class="Details"><input name="textfield_company" type="text" class="textfield1" id="textfield_company" value="<?=$yourcompany;?>" size="30" /></td>
        </tr>
        <tr>
          <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Email
            Address: </div></th>
          <td align="left" class="Details">&nbsp;</td>
          <td align="left" class="Details"><input name="textfield_youremail" type="text" class="textfield1" id="textfield_youremail" value="<?=$youremail;?>" size="30" /></td>
        </tr>
        <tr>
          <th valign="top" scope="row"><div align="right" class="Details"><span class="style9">*</span>Your
            Address: </div></th>
          <td class="Details">&nbsp;</td>
          <td align="left" valign="top" class="Details"><textarea class="textfield1" name="textarea_youraddress" style="height:60px;" id="textarea_youraddress" ><?=$youraddress;?></textarea></td>
        </tr>
        <tr>
          <th valign="top" class="Details" scope="row">&nbsp;</th>
          <td align="left" class="Details">&nbsp;</td>
          <td height="40" align="left" class="Details"><span class="style9">*</span> All marked fields are compulsory </td>
        </tr>
      </table></th>
      <th align="center" valign="top" bgcolor="#E5E5E5" scope="row"><table width="375" border="0" cellpadding="5" cellspacing="0">

        <tr>
          <th height="30" valign="middle" scope="row"><span class="Details">
            <div align="left">Your additional comments - Please edit:</div>
          </span></th>
        </tr>
        <tr>
          <th align="center" valign="top" scope="row"><div align="left"><span class="Details">
              <textarea class="textfield1" name="textarea_message" style="height:100px;" id="textfield1" onclick="if(this.value=='Please edit your message here...'){this.value='';}" onblur="if(this.value==''){this.value='Please edit your message here...';}"><? if($change_appointment==true){echo $booker_comments;}else{echo'Please edit your message here...';} ?></textarea>
          </span></div></th>
        </tr>
        <tr>
          <th align="left" valign="bottom" scope="row"><table width="370" border="0" cellpadding="0" cellspacing="0" style="border:solid #FFFFFF; border-width:0px;">
              <tr>
                <td height="20" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                 <td height="20" colspan="2"><span class="Details">To protect us from spam, please enter the below verification code: </span><span class="style9">*</span></td>
              </tr>
              <tr>
                 <td height="20" colspan="2">
					  <span class="Details">					  
					  <img src="randomImage.php?r=<?php echo $rand; ?>" border="0" align="absmiddle"/>
					  <input name="textfield_sum" type="text" class="textfield1" id="textfield_sum" style="width:100px;" value="" size="30"/>
					  <input name="random" type="hidden" id="random" value="<?=$rand;?>" />
					  </span></td>
              </tr>
              <tr>
                 <td height="20" colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td width="130" align="center"><a href="http://www.tilemob.com.au/"><img src="/~titi2698/tilemob.com.au/images/img_tm_logo_03.gif" alt="The Tile Mob" width="100" height="70" border="0"/></a></td>
                <td align="left" valign="middle"><span class="Details"><img src="/~titi2698/tilemob.com.au/images/txt_showroom.gif" alt="Showroom" vspace="3" border="0" /><br />
                  4-6 Blackwood St (Cnr Samford Rd) <br />
                  Mitchelton Queensland Australia 4053 <br />
                  PH (07) 3355 5055</span></td>
              </tr>
              
          </table></th>
        </tr>
        <tr>
          <th align="left" valign="bottom" scope="row"><img src="/~titi2698/tilemob.com.au/images/img_bformpics.jpg" alt="We source from the best manufacturers around the world to offer you Brisbane&rsquo;s widest selection of premium floor and wall tiles." width="370" height="70" border="0" style="margin-top:10px;margin-bottom:10px;"/></th>
        </tr>
        <tr>
          <th align="left" valign="bottom" scope="row"> <? 
		if($change_appointment==true){
		echo'<br/><span class="Details">By submitting this appointment form, your appointment booking number: <b>#'.$booking_code.'</b> will be updated with new appointment details specified above. You will also recieve a confirmation email about this new appointment.</span><br/>';}
		?></th>
        </tr>
        
      </table></th>
    </tr>
    <tr>
      <th height="50" valign="middle" bgcolor="#E5E5E5" scope="row"><input class="btn_textfields" name="clear_form" type="reset" id="clear_form" value="Clear Form" onclick='document.getElementById("residential_row").style.display = "none";document.getElementById("commercial_row").style.display = "none";hideTimes();'/></th>
      <th valign="middle" bgcolor="#E5E5E5" scope="row"> <?
	if($change_appointment==true){
	echo '<input name="change_appointment" type="hidden" id="change_appointment" value="true" />';
	echo '<input name="old_booking_code" type="hidden" id="old_booking_code" value="'.$booking_code.'" />';
	echo'<input class="btn_textfields" name="submit_form" type="submit" id="submit_form" value="Reschedule my appointment" />';}
	else{echo'<input class="btn_textfields" name="submit_form" type="submit" id="submit_form" value="Submit New Appointment" />';}?>      </th>
    </tr>
    <tr>
      <th height="20" colspan="2" valign="top" scope="row">&nbsp;</th>
    </tr>
  </table>
</form>
</body>
</html>
