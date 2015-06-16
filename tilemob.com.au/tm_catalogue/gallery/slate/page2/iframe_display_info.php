<?
if(isset($_GET['description'])) { $txt_description = $_GET['description']; }
else { $txt_description = ""; }
if(isset($_GET['image'])) { $img_filename = $_GET['image'].".jpg"; }
else { $img_filename = ""; }

$tilecode=stripslashes(substr($img_filename, 0, -4)); //Tile code number reference (from filename)
//echo 'tilecode: '.$tilecode;
$server_url_this = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/")+1); //Server directory address where this file resides
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
$tilelink=$server_url_this.$img_filename; //Tile image link (Insert image URL path in front)

//Set Cookie
//setcookie($tilecode, $tilelink);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title></title>
<script language="javascript">
function checkAddSuccess(tilecode, tilelink, tilepath) {
	//alert("checking tilecode: "+tilecode);
	if (tilecode != null && tilecode != "") {
		//alert("tilecode is: "+tilecode);
		//document.cookie = tilecode+ "=" +escape(tilelink)+ "; expires=0; path=/";
		parent.frames.iframe_collection.location.replace("<?=$server_dir_main?>
iframe_collection.php?tilecode=<?=$tilecode?>&tilelink=<?=$tilelink?>");
	}
}

function checkTilesSelected() {
	<?
	$cookie_tilecount = 0;
	foreach ($_COOKIE as $value) {
		$tilecode_temp = substr($value, (count($value)-10), 5);
		if($tilecode_temp != ""){
			$cookie_tilecount++;
		}
	}
	if($cookie_tilecount > 0){ 
	echo "window.open('".$server_dir_main."enquiry_form.php?tilecode=".$tilecode_temp."&tilelink=".$tilelink."','Enquire','status=yes,width=790,height=500')"; }
	else { echo 'alert("You have not selected any tiles. \nPlease select at least 1 tile before making an enquiry. \nThank you.");'; }
	?>
}
</script>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>


<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<?



//Refresh the Display iFrame to display the display jpg image ---------------------------------------------------------------------------------------------
echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.frames.iframe_display.location.replace("iframe_display.php?image='; 
			echo $img_filename; echo'");
		//-->
		</script>';
?>
<form>
  <table width="250" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" scope="row"><textarea name="img_description" cols="34" rows="2" id="img_description"><?=$txt_description?>
    </textarea></th>
  </tr>
  <tr>
    <th width="50%" scope="row"><input type="image" name="add_tile" src="<?=$server_dir_main?>images/btn_addtile.gif" type="submit" id="add_tile" value="Add this Tile" onclick="checkAddSuccess('<?=$tilecode?>', '<?=$tilelink?>', '<?=$server_dir_main?>');" onsubmit="" action=""/></th>
    <th scope="row"><input type="image" name="enquire_tile" src="
	<?=$server_dir_main?>images/btn_makeenquiry.gif" 
	type="submit" id="enquire_tile" onclick= "checkTilesSelected();" value="Make Enquiry" /></th>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>

</form>
</body>
</html>
