<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function checkFields() {
	emptyfields = "";
if (document.enquiry_form.textfield_searchtile.value == "") {
	emptyfields += "\n   *Your Name";
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
<form action="process_search.php" method="post" name="form1" class="the-tile-mob" id="form1">
<p>Tile number to search:</p>
<p>
  <input class="textfields" name="textfield_searchtile" type="text" id="textfield_searchtile" size="10" />
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <input class="btn_textfields" type="submit" name="Submit" value="Search" />
</p>
</form>
</body>
</html>
