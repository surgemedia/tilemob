<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Contact-Map</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/tilemob.ico" type="images/ico" />
<link rel="shortcut icon" href="images/tilemob.ico" />
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">

<style type="text/css">
	font-family: Arial, Geneva, Helvetica, sans-serif; 
</style>

<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAdvC7fl0lPMWtEYwSLI6D0hQaKGuMXQTkiatiyYCc2V7N3t2YDhSnm8XGrOdVtdCyXd17VmuKtDdM0A"
type="text/javascript">
</script>
<script type="text/javascript">
//<![CDATA[

function load() {
	if (GBrowserIsCompatible()) {
		var map = new GMap2(document.getElementById("map"));
		var geocoder = new GClientGeocoder();
		<?
		echo 'var address = "4-6 Blackwood St, Mitchelton Queensland Australia 4053";';
		?>
		geocoder.getLatLng(address,
			function(point) {
				if (!point) {
					alert(address + " not found");
				} else {
					map.addControl(new GSmallMapControl());
					map.addControl(new GMapTypeControl());
					map.setCenter(point, 14);
					var marker = new GMarker(point);
					map.addOverlay(marker);
					marker.openInfoWindowHtml(address);
				}
			}
		);
	}
}

//]]>
</script>
</head>

<BODY style="font-family: Arial, Geneva, Helvetica, sans-serif; padding: 4px; background: #FFFFFF;" onload="load()" onunload="GUnload()">
<div id="map" style="font-family: Arial, Geneva, Helvetica, sans-serif; width: 700px; height: 600px"></div>
</body>
</html>
