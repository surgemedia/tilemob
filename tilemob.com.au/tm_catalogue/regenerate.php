<html>
<head>
<title></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function checkFields() {
	emptyfields = "";
if (document.getElementById('select_imagelocation') == "") {
	emptyfields += "\n   *Please select a category";
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
<span class="the-tile-mob">
<form action="regenerate_gallery.php?prev=regenerate.php" method="post" enctype="multipart/form-data" onsubmit="return checkFields();">
<label for="file">Select a gallery category to regenerate:<br>
<br>
<select class="textfields" name="select_imagelocation" id="select_imagelocation">
  <option value="">Select a Category</option>
  <option value="tiles/floors/internal/page1">&nbsp;&nbsp;» tiles/floors/internal</option>
  <option value="tiles/floors/external/page1">&nbsp;&nbsp;» tiles/floors/external</option>
  <option value="tiles/floors/commercial/page1">&nbsp;&nbsp;» tiles/floors/commercial</option>
  <option value="tiles/pool/page1">&nbsp;&nbsp;» tiles/pool</option>
  <option value="tiles/wall/bathrooms/page1">&nbsp;&nbsp;» tiles/wall/bathrooms</option>
  <option value="tiles/wall/feature walls/page1">&nbsp;&nbsp;» tiles/wall/feature walls</option>
  <option value="tiles/wall/kitchen/page1">&nbsp;&nbsp;» tiles/wall/kitchen</option>
  <option value="stone/page1">&nbsp;&nbsp;» stone</option>
  <option value="mosaics/page1">&nbsp;&nbsp;» mosaics</option>
  <option value="slate/page1">&nbsp;&nbsp;» slate</option>
  <option value="terracotta/page1">&nbsp;&nbsp;» terracotta</option>
</select>
<p>
  <input class="btn_textfields" type="submit" name="Submit" value="Regenerate">
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
</span>
</body>
</html>