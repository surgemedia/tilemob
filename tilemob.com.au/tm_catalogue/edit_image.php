<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function checkFields() {
	emptyfields = "";
if (document.form1.textfield_edittile.value == "") {
	emptyfields += "\n   *Tile number";
} else if (document.form1.textarea_newdescription.value == "") {
	emptyfields += "\n   *Tile description";
} else if (document.form1.textfield_edittile.length != 4) {
	emptyfields = "";
	alertmessage = "Invalid product number\n" +
	alertmessage + "\nMake sure the product number is a valid 5 digit number";
	alert(alertmessage)	
}

if (emptyfields!= "") {
	emptyfields = "These fields are mandatory:\n" +
	emptyfields + "\n\nPlease fill in all required fields";
	alert(emptyfields);
	return false;
} else {
	return true;
}
</script> 
</head>

<body>
<form id="form1" name="form1" onsubmit="return checkFields()" method="post" action="process_edit.php?prev=edit_image.php">
  <p class="the-tile-mob">Tile number to edit:</p>
  <p>
    <span class="the-tile-mob">
    <input class="textfields" name="textfield_edittile" type="text" id="textfield_edittile" size="10" />
    </span></p>
  <p class="the-tile-mob">New
  Description:</p>
  <p>
    <span class="the-tile-mob">
    <textarea class="textfields" name="textarea_newdescription" cols="35" rows="5" id="textarea_newdescription"></textarea>
    </span></p>
  <p>
    <span class="the-tile-mob">
    <input class="btn_textfields" type="submit" name="Submit" value="Save Changes" />
    </span></p>
</form>
</body>
</html>
