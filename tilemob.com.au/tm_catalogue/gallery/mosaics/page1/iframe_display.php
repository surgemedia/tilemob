<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title></title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>

<body>
<?
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
if(isset($_GET['image']) && $_GET['image'] != "") { $getImage = $_GET['image']; }
else { $getImage = ""; }

if ($getImage == "") {
	$getImage = $server_dir_main."images/bkg_empty_display.gif";
}
?>
<table width="300" height="300" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th background="<?=$server_dir_main?>images/bkg_display_cell.gif" scope="row">
	<img src="<?=$getImage?>"><?=$_GET['image'];?></th>
  </tr>
</table>
</body>
</html>
