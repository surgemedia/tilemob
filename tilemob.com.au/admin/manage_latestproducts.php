<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['title']) && !empty($_POST['body'])) { 
	$title = trim($_POST['title']);
	$url = trim($_POST['url']);
	$body = $_POST['body'];
	$body = str_replace('<p>','',$body);
	$body = str_replace('</p>','',$body);
	$body = str_replace('font-size: 14px;','font-size:14px;line-height:16px;>',$body);
	$body = str_replace('font-size: 16px;','font-size:16px;line-height:18px;>',$body);
	$body = str_replace('font-size: 18px;','font-size:18px;line-height:20px;>',$body);
	$body = str_replace('font-size: 20px;','font-size:20px;line-height:22px;>',$body);
	$body = str_replace('font-size: 22px;','font-size:22px;line-height:24px;>',$body);
	$body = str_replace('font-size: 24px;','font-size:24px;line-height:26px;>',$body);
	$body = str_replace('font-size: 26px;','font-size:26px;line-height:28px;>',$body);
	$body = str_replace('font-size: 28px;','font-size:28px;line-height:30px;>',$body);
	$body = trim($body);
	
	$lastupdated =  date('d/m/Y (h:i a)');
	
	mysql_query("UPDATE latest_products SET 
				title = '$title',
				url = '$url',
				body = '$body',
				lastupdated = '$lastupdated'
				WHERE latest_product_id = '1'") or die(mysql_error());	//Done.

	//All done
	header('location:manage_latestproducts.php?s2='.$title.' was successfully updated.');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
include('includes/meta.php'); //Meta tags
include('includes/variables.php'); //Global variables
include('includes/security.php'); //Security features
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out

$result_latest = mysql_query("SELECT * FROM latest_products WHERE latest_product_id = '1'");
if($row_latest = mysql_fetch_array($result_latest)) {
	$title = $row_latest['title'];
	$url = $row_latest['url'];
	$body = $row_latest['body'];
}
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script>
<?php
$cur_servdir = '/'.substr(dirname($_SERVER['PHP_SELF']), 1).'/';
?>
function loadHomeEditor() {
	var editor = CKEDITOR.replace('body',{
	height:"130",
	toolbar:'toolbar2',
	filebrowserBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserImageBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserFlashBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php'
	});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
	CKEDITOR.config.resize_enabled = false;
	CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
}
function checkFields() {
	//alert("checking fields");
	emptyfields = "";
	if (document.getElementById('title').value == "") {
		emptyfields += "\n   * Heading";
	}
	if (document.getElementById('body').value == "") {
		emptyfields += "\n   * Body";
	}
	
	//alert("checking fields");
	if (emptyfields!= "") { //mandatories not completed!
		emptyfields = "These fields cannot be empty:\n" +
		emptyfields + "\n\nPlease fill in all fields marked with *";
		alert(emptyfields);
		return false;
	} else { //all mandatories filled in!
		return true;
	}
}
</script>
</head>
<body>
<div class="container">
   <div class="header"></div>
   <div class="navigation">
      <? include('includes/navigation.php'); ?>
   </div>
   <div class="middle">
      <h1>Homepage / Latest product</h1>
			<?
			if(!empty($_GET['s1']) || !empty($_GET['s2']) || !empty($_GET['s3'])) {
				if(!empty($_GET['s1'])){$s = 1;}else if(!empty($_GET['s2'])){$s = 2;}else if(!empty($_GET['s3'])){$s = 3;}
				$status = $_GET['s'.$s];
				//s1: notice | s2: success | s3: error 
				echo '<div class="status'.$s.'" style="margin-top:15px;">'.$status.'</div>';
				echo '<div class="clear"></div>';
			}
			?>
      <form id="submitform" name="submitform" method="post" action="" onsubmit="return checkFields();">
         <table width="460" border="0" cellspacing="0" cellpadding="3" class="table1" align="center">
			<tr>
               <td width="120" class="table1_body"><h3>Heading: *</h3></td>
               <td class="table1_body"><input type="text" id="title" name="title" value="<?php echo $title; ?>" class="textfield_1"></td>
            </tr>
            <tr>
               <td class="table1_body"><h3>Link to URL: </h3></td>
               <td class="table1_body"><input type="text" id="url" name="url" value="<?php echo $url; ?>" class="textfield_1"></td>
            </tr>
			<tr>
               <td class="table1_body" valign="top"><h3>Body: *</h3></td>
               <td class="table1_body"><textarea id="body" name="body" class="textfield_1" style="height:100px;"><?php echo $body; ?></textarea></td>
            </tr>
			<tr><td colspan="2" height="50"><input type="submit" id="save" name="save" value="Save changes »"></td></tr>
		 </table>
      </form>
   </div>
   <div class="footer"></div>
</div>
<form id="deleteform" name="deleteform" method="post">
<input type="hidden" id="delete_id" name="delete_id" value="">
</form>
<script>loadHomeEditor();</script>
</body>
</html>
