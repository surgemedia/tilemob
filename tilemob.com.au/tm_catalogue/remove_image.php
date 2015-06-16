<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function checkFields() {
	emptyfields = "";
if (document.form1.textfield_removetile.value == "") {
	emptyfields += "\nPlease enter a tile number to remove";
} else if (document.form1.textfield_removetile.length != 4) {
	emptyfields = "";
	alertmessage = "Invalid product number\n" +
	alertmessage + "\nMake sure the product number is a valid 5 digit number";
	alert(alertmessage)	
}

if (emptyfields!= "") {
	alert(emptyfields);
	return false;
}
	else return true;
}
</script> 
</head>

<body>
<form action="process_delete.php" method="post" name="form1" onsubmit="return checkFields()" class="the-tile-mob" id="form1">
<p>Tile number to remove:</p>
<p>
  <input class="textfields" name="textfield_removetile" type="text" id="textfield_removetile" size="10" />
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <input class="btn_textfields" type="submit" name="Submit" value="Save Changes" />
</p>
</form>
</body>
</html>