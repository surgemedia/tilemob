<html>
<head>
<title></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<span class="the-tile-mob">
<form action="process_uploadfile.php" method="post" enctype="multipart/form-data">
<label for="file">Specify location to save uploads:<br>
<br>
<select class="textfields" name="select_imagelocation" id="select_imagelocation">
  <option>Select a Category</option>
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
<br>
<br>
Add a thumbnail image: </label>
<p>
  <input type="file" name="filefield_thumbnail" id="filefield_thumbnail" />
</p>
<p>Add a Display Image for your thumbnail image: </p>
<p>
  <input type="file" name="filefield_display" id="filefield_display" />
</p>
<p>Add Description:</p>
<p>
  <textarea class="textfields" name="textarea_description" cols="35" rows="5" id="textarea_description"></textarea>
</p>
<p>
  <input class="btn_textfields" type="submit" name="Submit" value="Save and Upload">
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</form>
</span>
</body>
</html>