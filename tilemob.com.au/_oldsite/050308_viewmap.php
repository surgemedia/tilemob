<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Contact-Map</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/tilemob.ico" type="images/ico" />
<link rel="shortcut icon" href="images/tilemob.ico" />
<link href="styles.css" rel="stylesheet" type="text/css">
<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAdvC7fl0lPMWtEYwSLI6D0hQaKGuMXQTkiatiyYCc2V7N3t2YDhSnm8XGrOdVtdCyXd17VmuKtDdM0A"
type="text/javascript"></script>
<script type="text/javascript">
var map;
var directionsPanel;
var directions;

function load() {
	map = new GMap2(document.getElementById("map"));
	directionsPanel = document.getElementById("directions");
	
	map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	map.setCenter(new GLatLng(-27.4128215,152.9742417), 14);
	var marker = new GMarker(new GLatLng(-27.4128215,152.9742417));
	map.addOverlay(marker);

	directions = new GDirections(map, directionsPanel);
	<?
	if(isset($_POST['directions_from']) && $_POST['directions_from'] != "") { 
		echo 'directions.load("from: '.$_POST['directions_from'].' to: 4-6 Blackwood St Mitchelton Queensland Australia 4053");'; }
	else { 
		echo 'directions.load("4-6 Blackwood St Mitchelton Queensland Australia 4053");'; 
	}
	?>	
	//alert("directions loading");
}
</script>
</head>

<BODY style="font-family: Arial, Geneva, Helvetica, sans-serif; padding: 20px; background: #FFFFFF;" onload="load()">
<div id="find_directions" style="margin-bottom: 10px; font-family: Arial, Geneva, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color:#999999; width: 700px; height: 70px">
  <form id="form1" name="form1" method="post" action="">
    <table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50" align="left" valign="middle">From: </td>
        <td align="left" valign="middle"><input name="directions_from" type="text" id="directions_from" size="55" /></td>
        <td width="30" align="left" valign="top">To:</td>
        <td align="left" valign="top">          Showroom<br />
          4-6 Blackwood St (Cnr Samford Rd) <br />
Mitchelton Queensland Australia 4053 </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35" align="left" valign="top"><input type="submit" name="Submit" value="Get Directions" /></td>
        <td colspan="2">&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
<div id="map" style="font-family: Arial, Geneva, Helvetica, sans-serif; width: 700px; height: 400px; border:solid #CCCCCC; border-width:1px;"></div>
<div id="directions" style="margin-top: 10px; font-family: Arial, Geneva, Helvetica, sans-serif; font-size: 12px; width: 688px; min-height: 70px; border:solid #CCCCCC; border-width:1px; padding: 6px;"><b style="color:#999999;">Directions: </b></div>
</body>
</html>
