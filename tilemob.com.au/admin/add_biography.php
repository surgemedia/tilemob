<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

//Add
if($_POST['add'] && !empty($_POST['category']) && !empty($_POST['name'])){
	$category = $_POST['category'];	
	$name = mysql_escape_string(trim($_POST['name'])); 
	$title = mysql_escape_string(trim($_POST['title']));
	$body = trim($_POST['body']);
	$body = str_replace('%2520',' ',$body);
	$body2 = trim($_POST['body2']);
	$body2 = str_replace('%2520',' ',$body2);
	
	if($_POST['is_hidden'] == '1') {
		$is_hidden = 1;
	} else {
		$is_hidden = 0;
	}	
	
	$hourOffset_timedate = strtotime("+15 hour");
	$last_updated =  date("d/m/Y (h:i a)", $hourOffset_timedate);
	
	$new_ordering = 99;
	
	//Add
	mysql_query("INSERT INTO biography (biography_id, ordering, name, category, title, 
		body, body2, imagesrc, is_hidden, is_active) VALUES 
		('', '$new_ordering', '$name', '$category', '$title', '$body', '$body2', '', '$is_hidden', '1')");
		
	$last_insert_id = mysql_insert_id();
	
	$biography_imagedir = '../biography/';
	if(!is_dir($biography_imagedir)) {
		//page image directory
		mkdir($biography_imagedir, 0777); 
	}
	
	//upload new image
	if($_FILES['imagesrc'] != '') {
		if(trim($_FILES['imagesrc']['name']) != '' && 
		($_FILES['imagesrc']['type'] == 'image/jpeg') ||
		($_FILES['imagesrc']['type'] == 'image/pjpeg') ||
		($_FILES['imagesrc']['type'] == 'image/gif') ||
		($_FILES['imagesrc']['type'] == 'image/png')) {
			//echo $_FILES['imagesrc']['name'].'<br/>';
			//Upload files individually
			uploadImage($biography_imagedir, $last_insert_id);
		}
	}

	//All done
	header('location:manage_biography.php?s2='.$name.' was successfully created.');
}

function uploadImage($imagedir_path, $biography_id) {
	$imagefile_basename = basename($_FILES['imagesrc']['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $biography_id.$imagefile_extension;
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	if (move_uploaded_file($_FILES['imagesrc']['tmp_name'], $imagefile_path)) {
		//echo $_FILES['imagefile_'.$image_id]['name'].' has been uploaded<br/>'; 
		//Create thumbnail
		createThumbnail($imagedir_path, $imagefile_filename);
		createDisplay($imagedir_path, $imagefile_filename);
		mysql_query("UPDATE biography SET imagesrc='$imagefile_filename' WHERE biography_id='$biography_id'");
	}
}

function createThumbnail($imagedir_path, $imagefile_filename) {
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	$imagefile_path_thumb = $imagedir_path.'t'.$imagefile_filename; //thumbnail
	if(copy($imagefile_path, $imagefile_path_thumb)) {
		list($width, $height, $type, $attr) = getimagesize($imagefile_path_thumb);
		if($width > 200) {
			$newWidth = 200;
			$newHeight = $height/($width/200);
		} else { $newWidth = $width; $newHeight = $height;}
		//echo 'resizing '.$imagefile_path_thumb.' to '.$newWidth.' x '.$newHeight.'<br/>';
		createImage($imagefile_path_thumb, $newWidth, $newHeight);
	}
}

function createDisplay($imagedir_path, $imagefile_filename) {
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	$imagefile_path_thumb = $imagedir_path.'d'.$imagefile_filename; //display
	if(copy($imagefile_path, $imagefile_path_thumb)) {
		list($width, $height, $type, $attr) = getimagesize($imagefile_path_thumb);
		if($width > 900) {
			$newWidth = 900;
			$newHeight = $height/($width/900);
		} else { $newWidth = $width; $newHeight = $height;}
		if($newHeight > 600) {
			$tempHeight = $newHeight;
			$newHeight = 600;
			$newWidth = $newWidth/($tempHeight/600);
		}
		createImage($imagefile_path_thumb, $newWidth, $newHeight);
	}
}

function createImage($imgsrc, $newWidth, $newHeight) {
	list($curWidth, $curHeight, $imageType) = getimagesize($imgsrc);
	switch ($imageType) {
		case 1: $src = imagecreatefromgif($imgsrc); break;
		case 2: $src = imagecreatefromjpeg($imgsrc); break;
		case 3: $src = imagecreatefrompng($imgsrc); break;
		default: echo '';  break;
	}
	
	$tmp = imagecreatetruecolor($newWidth, $newHeight);
	imageantialias($tmp, true); //add antialiasing
	//$src = imagecreatefromjpeg($imgsrc); 
	//Check if this image is PNG or GIF to preserve its transparency
	if(($imageType == 1) OR ($imageType == 3)) {
		imagealphablending($tmp, false);
		imagesavealpha($tmp,true);
		$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
		imagefilledrectangle($tmp, 0, 0, $newWidth, $newHeight, $transparent);
	}
	
	/*//find the x and y destination point (we want to crop to the center of the image)
	$src_x = ceil(($curWidth-$newWidth)/2);
	$src_y = ceil(($curHeight-$newHeight)/2);
	if($src_x<0){$src_x=0;}
	if($src_y<0){$src_y=0;}*/
	
	//imagecopyresampled($tmp, $src, 0, 0, $src_x, $src_y, $curWidth, $curHeight, $curWidth, $curHeight); 
	imagecopyresized($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $curWidth, $curHeight);
	
	switch ($imageType) {
		case 1: imagegif($tmp); break;
		case 2: imagejpeg($tmp, $imgsrc, 100); break; // best quality
		case 3: imagepng($tmp, $imgsrc, 0); break; // no compression
		default: echo ''; break;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
include('includes/meta.php'); //Meta tags
include('includes/variables.php'); //Global variables
include('includes/security.php'); //Security features
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
<?php
$cur_servdir = '/'.substr(dirname($_SERVER['PHP_SELF']), 1).'/';
?>
function loadEditor() {
	var editor = CKEDITOR.replace('body',{
	height:"400",
	toolbar:'toolbar1',
	filebrowserBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserImageBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserFlashBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php'
	});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
}

function checkFields() {
	//alert("checking fields");
	emptyfields = "";
	if (document.getElementById('name').value == "") {
		emptyfields += "\n   *Name";
	}
	if (document.getElementById('title').value == "") {
		emptyfields += "\n   *Title";
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
      <h1>Edit page</h1>
		<?
		if($_GET['s1'] != '' || $_GET['s2'] != '' || $_GET['s3'] != '') {
			if($_GET['s1']!=''){$s = 1;}else if($_GET['s2']!=''){$s = 2;}else if($_GET['s3']!=''){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			echo '<div class="status'.$s.'">'.$status.'</div>';
			echo '<div class="clear"></div>';
		}
		?>
      <div class="clear" style="margin-bottom:20px;"><input name="cancel" type="button" id="cancel" value="&laquo; Cancel, return to previous page" onclick="location.href='manage_content.php';" class="button_1" /></div>
      <div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div>
      <form id="submitform" name="submitform" method="post" enctype="multipart/form-data" action="" onsubmit='return checkFields();'>
         <table width="960" border="0" cellspacing="3" cellpadding="0">
            <tr>
               <td width="130">&nbsp;</td>
               <td width="670">&nbsp;</td>
            </tr>
			<tr>
               <td><h3>Category: *</h3></td>
               <td>
			   <select id="category" name="category">
			   <option value="director">Director</option>
			   </select>
			   </td>
            </tr>
			<tr><td colspan="2">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<tr>
               <td><h3>Name: *</h3></td>
               <td><input name="name" type="text" class="textfield_1" id="name" value="<?=$name;?>" /></td>
            </tr>			
            <!--<tr>
               <td><h3>Title: *</h3></td>
               <td><input name="title" type="text" class="textfield_1" id="title" value="<?=$title;?>" /></td>
            </tr>-->
			<tr>
               <td><h3>Profile image: </h3></td>
               <td><input type="file" id="imagesrc" name="imagesrc"></td>
            </tr>
			<tr><td colspan="2">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<tr>
               <td><h3>Hide on Website: </h3></td>
               <td><input type="checkbox" id="is_hidden" name="is_hidden" value="1" <?php echo $is_hidden; ?>/></td>
            </tr>
			<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<tr>
				<td valign="top"><h3>Left column-box text: </h3></td>
				<td colspan="3"><textarea id="boxy2" name="body2" class="textarea_1" style="height:100px;font-family:Verdana,Arial;font-size:16px;line-height:20px;font-weight:bold;color: #12456B;"><?php echo $body2; ?></textarea></td>
			</tr>
			<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<tr><td colspan="4">&nbsp;</td></tr>
			<tr>
			   <td colspan="4">			   
			   <textarea name="body" id="body"><?php echo $body; ?></textarea>
			   <script>loadEditor();</script>
			   </td>
			</tr>
            <tr>
               <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="3" align="left" valign="middle"><input name="cancel2" type="button" id="cancel2" value="&laquo; Cancel, return to previous page" onclick="location.href='manage_content.php';" class="button_1" /></td>
               <td align="right" valign="middle">
			   <input name="add" type="submit" id="add" value="Create &raquo;" class="button_1" />
			   </td>
			</tr>
         </table>
      </form>
      <p>&nbsp;</p>
   </div>
   <div class="footer"></div>
</div>
</body>
</html>