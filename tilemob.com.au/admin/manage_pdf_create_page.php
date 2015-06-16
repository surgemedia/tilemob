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
	
	mysql_query("UPDATE news SET 
				title = '$title',
				url = '$url',
				body = '$body',
				lastupdated = '$lastupdated'
				WHERE news_id = '1'") or die(mysql_error());	//Done.

	//All done
	header('location:manage_newsflash.php?s2='.$title.' was successfully updated.');
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

$result_news = mysql_query("SELECT * FROM news WHERE news_id = '1'");
if($row_news = mysql_fetch_array($result_news)) {
	$title = $row_news['title'];
	$url = $row_news['url'];
	$body = $row_news['body'];
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
	<? include('sub_menu.php');?>
   <div class="middle">
   <?
		$time = time();
   		if($_POST['name']!="" &&  $_FILES['img_file']['name']!=""){

			$target_path2 = "../pdffiles_upload/";
			$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
			$detectedType = exif_imagetype($_FILES['img_file']['tmp_name']);
			if(!in_array($detectedType, $allowedTypes)){
				echo "Your uploaded image file type is not correct!";	
				exit;
			}
			
			if($_FILES['img_file']["size"]!=""){
				$target_path2 = $target_path2 . basename($time."two".$_FILES['img_file']['name']); 
					if(move_uploaded_file($_FILES['img_file']['tmp_name'], $target_path2)){
						echo "";
					} else{
						echo "There was an error uploading the file-Image, please try again!<br />";
					}
				$uppic2 = "http://www.tilemob.com.au/pdffiles_upload/".($time."two".$_FILES['img_file']['name']);
			}else{
				$uppic2 = "";
			}
	
			$pdfs_upload = "INSERT INTO file_pdfs VALUES(NULL, '".$_POST['name']."', 'COLLECTION', '".$uppic2."', 0, 1)";
			echo $pdfs_upload;
			$pdfs_upload_result = mysql_query($pdfs_upload);
			if(!$pdfs_upload_result){
				echo 'upload failure!';	
			}else{
				echo 'Upload success!';	
			}
		}
   ?>
      <h1>Create new menu Page</h1>
      <form id="submitform" name="submitform" method="post" action="#" enctype="multipart/form-data" onsubmit="if(this.name.value==''){ alert('Name cannot empty!'); this.name.focus(); return false}
      if(this.pdf_file.value==''){ alert('Have not upload PDF!'); this.pdf_file.focus(); return false}
      if(this.img_file.value==''){ alert('Have not upload image!'); this.img_file.focus(); return false}">
         <table width="460" border="0" cellspacing="0" cellpadding="3" class="table1" align="center">
            <tr>
               <td class="table1_body"><h3>Display Image: *<br/> Just support JPG, PNG and GIF</h3></td>
               <td class="table1_body"><input type="file" name="img_file" ></td>
            </tr>
			<tr>
               <td class="table1_body" valign="top"><h3>Collection Name: *</h3></td>
               <td class="table1_body"><input name="name"/></td>
            </tr>
			<tr><td colspan="2" height="50"><input type="submit" id="save" name="save" value="Upload"></td></tr>
		 </table>
      </form>
   </div>
   <div class="footer"></div>
</div>
<script>loadHomeEditor();</script>
</body>
</html>
