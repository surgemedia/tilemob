<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_GET['id'])) {
	$content_id = $_GET['id'];
	$result_content = mysql_query("SELECT * FROM content WHERE ID='$content_id'");
	if($row_content = mysql_fetch_array($result_content)) {
		$kick_me = false;
		$pageheading = stripslashes(trim($row_content['pageheading']));
		$metatitle = stripslashes(trim($row_content['metatitle']));
		$menulinkname = stripslashes(trim($row_content['menulinkname']));
		$pageurl = stripslashes(trim($row_content['pageurl']));
		$content_headimage = trim($row_content['content_headimage']);
		$pageimage = '../'.$row_content['pageimage'];
		$body = trim($row_content['body']);
		$body2 = trim($row_content['body2']);
		if(!empty($pageurl)){
			$full_pageurl = $pageurl;
		} else {
			$full_pageurl = 'page.php?id='.$content_id;
		}
		$under_content_id = $row_content['under_content_id'];
		$brochure_id = $row_content['brochure_id'];
		if ($row_content['is_hidden'] == 1) {
			$is_hidden = 'checked="checked"';
		} else {
			$is_hidden = '';
		}
	}
}

//Save content
if(!empty($_GET['id']) && $_POST['save_content'] && !empty($_POST['menulinkname'])){
	$content_id = $_GET['id'];
	$pageheading = mysql_escape_string(trim($_POST['pageheading']));
	$metatitle = mysql_escape_string(trim($_POST['metatitle']));
	$menulinkname = mysql_escape_string(trim($_POST['menulinkname']));	
	$body = trim($_POST['body']);
	$body2 = trim($_POST['body2']);
	$body = str_replace('%2520',' ',$body);
	$body2 = str_replace('%2520',' ',$body2);
	$brochure_id = $_POST['brochure_id'];
	
	$under_content_id = $_POST['under_content_id'];
	
	if($_POST['is_hidden'] == '1') {
		$is_hidden = 1;
	} else {
		$is_hidden = 0;
	}	
	
	$hourOffset_timedate = strtotime("+15 hour");
	$last_updated =  date("d/m/Y (h:i a)", $hourOffset_timedate);
	
	//Update database
	mysql_query("UPDATE content SET 
				pageheading = '$pageheading',
				is_hidden = '$is_hidden',
				under_content_id = '$under_content_id',
				menulinkname = '$menulinkname',
				metatitle = '$metatitle',
				brochure_id = '$brochure_id',
				body = '$body',
				body2 = '$body2'
				WHERE ID = '$content_id'") or die(mysql_error());	//Done.
	
	$pageimagedir_path = '../pageimage/';
	if(!is_dir($pageimagedir_path)) {
		//page image directory
		mkdir($pageimagedir_path, 0777); 
	}
	
	$biography_videodir = '../video/';
	if(!is_dir($biography_videodir)) {
		mkdir($biography_videodir, 0777); 
	}
	
	//delete page image
	if($_POST['deletepageimage'] == 'deleteme') {			
		if(is_file($pageimage)) {
			//echo 'Deleting: '.$delete_original.'<br/>';
			@unlink($pageimage);
			mysql_query("UPDATE content SET pageimage='' WHERE ID='$content_id'");
		}
	}
	
	//upload new image
	if($_FILES['page_imagefile'] != '') {
		if(trim($_FILES['page_imagefile']['name']) != '' && 
		($_FILES['page_imagefile']['type'] == 'image/jpeg') ||
		($_FILES['page_imagefile']['type'] == 'image/pjpeg') ||
		($_FILES['page_imagefile']['type'] == 'image/gif') ||
		($_FILES['page_imagefile']['type'] == 'image/png')) {
			//echo $_FILES['page_imagefile']['name'].'<br/>';
			//Upload files individually
			uploadPageImage($pageimagedir_path, $content_id, $pageimage);
		}
	}
	
	//update current videos
	$result_videos = mysql_query("SELECT * FROM videos WHERE is_active = '1'");
	while($row_videos = mysql_fetch_array($result_videos)) {
		$video_id = $row_videos['video_id'];
		$video_title = $_POST['videotitle_'.$video_id];
		$video_width = $_POST['videowidth_'.$video_id];
		$video_height = $_POST['videoheight_'.$video_id];
		if(!empty($_FILES['videoimage_'.$video_id])) { //update image
			if(trim($_FILES['videoimage_'.$video_id]['name']) != '' && 
			($_FILES['videoimage_'.$video_id]['type'] == 'image/jpeg') ||
			($_FILES['videoimage_'.$video_id]['type'] == 'image/pjpeg') ||
			($_FILES['videoimage_'.$video_id]['type'] == 'image/gif') ||
			($_FILES['videoimage_'.$video_id]['type'] == 'image/png')) {
				uploadReplacementVideoImage($biography_videodir, $row_videos['thumbsrc'], $content_id, $video_id);
			}
		}
		if(!empty($_FILES['videofile_'.$video_id])) { //update image
			if(trim($_FILES['videofile_'.$video_id]['name']) != '') {
				uploadReplacementVideo($biography_videodir, $row_videos['videosrc'], $content_id, $video_id);
			}
		}
		//echo 'video_title '.$video_title.', video_width: '.$video_width.'<br/>';
		if(!empty($video_title) && !empty($video_width) && !empty($video_height)) {
			mysql_query("UPDATE videos SET title='$video_title', width='$video_width', height='$video_height' WHERE video_id = '$video_id'");
		}
	}
	
	//upload videos
	if(!empty($_FILES['new_videoimage']) && !empty($_FILES['new_videofile']) && count($_FILES['new_videofile']) > 0) {
		for($i=0; $i < count($_FILES['new_videofile']); $i++) {
			if(trim($_FILES['new_videoimage']['name'][$i]) != '' && 
			($_FILES['new_videoimage']['type'][$i] == 'image/jpeg') ||
			($_FILES['new_videoimage']['type'][$i] == 'image/pjpeg') ||
			($_FILES['new_videoimage']['type'][$i] == 'image/gif') ||
			($_FILES['new_videoimage']['type'][$i] == 'image/png')) {				
				uploadVideo($biography_videodir, $content_id, $_POST['new_videowidth'][$i], $_POST['new_videoheight'][$i], $i);
			}
		}
	}

	//All done
	header('location:edit_content.php?id='.$content_id.'&s2='.$pageheading.' was successfully saved.');
}

//add page
if($_POST['add_content'] && !empty($_POST['menulinkname']) && !empty($_POST['pageheading'])){
	$pageheading = mysql_escape_string(trim($_POST['pageheading']));
	$metatitle = mysql_escape_string(trim($_POST['metatitle']));
	$menulinkname = mysql_escape_string(trim($_POST['menulinkname']));
	$body = trim($_POST['body']);
	$body2 = trim($_POST['body2']);
	$body = str_replace('%2520',' ',$body);
	$body2 = str_replace('%2520',' ',$body2);
	$brochure_id = $_POST['brochure_id'];
	
	$under_content_id = $_POST['under_content_id'];
	
	if($_POST['is_hidden'] == '1') {
		$is_hidden = 1;
	} else {
		$is_hidden = 0;
	}
	
	$hourOffset_timedate = strtotime("+15 hour");
	$last_updated =  date("d/m/Y (h:i a)", $hourOffset_timedate);
	
	//Update database
	mysql_query("INSERT INTO content 
	(ID, under_content_id, ordering, show_specialfield, is_custompage, is_hidden, is_locked, is_deleted, pageimage, pageheading, 
	metatitle, menulinkname, pageurl, brochure_id, specialfield, body, body2)
	VALUES
	('','$under_content_id','99','0','1','0','0','0','','$pageheading','$metatitle','$menulinkname','$pageurl','$brochure_id','','$body','$body2')");

	//All done
	header('location:manage_content.php?s2='.$pageheading.' was successfully created.');
}

function uploadVideo($videodir_path, $content_id, $video_width, $video_height, $iteration) {
	//echo 'uploading.. '.$videodir_path.', '.$content_id.', '.$video_width.', '.$video_height.', '.$iteration.'<br/>';
	$videofile_basename = basename($_FILES['new_videofile']['name'][$iteration]);
	$videofile_extension = substr($videofile_basename, strrpos($videofile_basename, '.'), strlen($videofile_basename));
	$videofile_filename = $content_id.$iteration.strtotime('now').$videofile_extension;
	$videofile_path = $videodir_path.$videofile_filename;
	$video_title = $_POST['new_videotitle'][$iteration];
	if (move_uploaded_file($_FILES['new_videofile']['tmp_name'][$iteration], $videofile_path)) { //upload video file
		$imagefile_basename = basename($_FILES['new_videoimage']['name'][$iteration]);
		$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
		$imagefile_filename = $content_id.$iteration.strtotime('now').$imagefile_extension;
		$imagefile_path = $videodir_path.$imagefile_filename;
		if (move_uploaded_file($_FILES['new_videoimage']['tmp_name'][$iteration], $imagefile_path)) { //upload image file
			createVideoThumbnail($videodir_path, $imagefile_filename, 180);
			mysql_query("INSERT INTO videos (video_id, content_id, biography_id, title, description, videosrc, 
			thumbsrc, width, height, format, is_active) VALUES 
			('', '$content_id', '0', '$video_title', '', '$videofile_filename', '$imagefile_filename', '$video_width', '$video_height', '$videofile_extension', '1')");
		}
	}
}

function uploadReplacementVideo($videodir_path, $current_videosrc, $content_id, $video_id) {
	$videofile_basename = basename($_FILES['videofile_'.$video_id]['name']);
	$videofile_extension = substr($videofile_basename, strrpos($videofile_basename, '.'), strlen($videofile_basename));
	$videofile_filename = $content_id.$video_id.strtotime('now').$videofile_extension;
	$videofile_path = $videodir_path.$videofile_filename;
	if (move_uploaded_file($_FILES['videofile_'.$video_id]['tmp_name'], $videofile_path)) { //upload video file
		mysql_query("UPDATE videos SET videosrc='$videofile_filename', format='$videofile_extension' WHERE video_id = '$video_id'");
		//delete old video
		if(is_file($videodir_path.$current_videosrc)){
			@unlink($videodir_path.$current_videosrc);
		}
	}
}

function uploadReplacementVideoImage($videodir_path, $current_thumbsrc, $content_id, $video_id) {
	$imagefile_basename = basename($_FILES['videoimage_'.$video_id]['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $content_id.$video_id.strtotime('now').$imagefile_extension;
	$imagefile_path = $videodir_path.$imagefile_filename;
	if (move_uploaded_file($_FILES['videoimage_'.$video_id]['tmp_name'], $imagefile_path)) { //upload image file
		createVideoThumbnail($videodir_path, $imagefile_filename, 180);
		mysql_query("UPDATE videos SET thumbsrc='$imagefile_filename' WHERE video_id = '$video_id'");
		//delete old images and thumbnail
		if(is_file($videodir_path.$current_thumbsrc)){
			@unlink($videodir_path.$current_thumbsrc);
			@unlink($videodir_path.'t'.$current_thumbsrc);
		}
	}
}

function uploadReplacementImage($image_id, $imagedir_path, $current_image) {
	$imagefile_basename = basename($_FILES['imagefile_'.$image_id]['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $iteration.strtotime('now').$imagefile_extension;
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	if (move_uploaded_file($_FILES['imagefile_'.$image_id]['tmp_name'], $imagefile_path)) {
		//echo $_FILES['imagefile_'.$image_id]['name'].' has been uploaded<br/>'; 
		//Create thumbnail
		createThumbnail($imagedir_path, $imagefile_filename);
		createDisplay($imagedir_path, $imagefile_filename);
		//remove old images
		$delete_original = $imagedir_path.$current_image;
		$delete_thumbnail = $imagedir_path.'t'.$current_image;
		$delete_display = $imagedir_path.'d'.$current_image;
		if(is_file($delete_original) || is_file($delete_thumbnail) || is_file($delete_display)) {
			@unlink($delete_original);
			@unlink($delete_thumbnail);
			@unlink($delete_display);
		}
		mysql_query("UPDATE gallery SET filename='$imagefile_filename', is_active='1' WHERE image_id='$image_id'");
	}
}

function uploadImage($iteration, $imagedir_path, $imagecaption) {
	$imagefile_basename = basename($_FILES['new_imagefile']['name'][$iteration]);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $iteration.strtotime('now').$imagefile_extension;
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	//$imagefile_path_db = substr($imagefile_path, 2, strlen($imagefile_path));
	//echo 'imagefile_path: '.$imagefile_path.'<br/>';
	if (move_uploaded_file($_FILES['new_imagefile']['tmp_name'][$iteration], $imagefile_path)) {
		//echo $_FILES['new_imagefile']['name'][$iteration].' has been uploaded<br/>'; 
		//Create thumbnail
		createThumbnail($imagedir_path, $imagefile_filename);
		createDisplay($imagedir_path, $imagefile_filename);
		$result_count = mysql_query("SELECT * FROM gallery WHERE is_active = '1'");
		$new_ordering = mysql_num_rows($result_count)+1;
		//insert
		mysql_query("INSERT INTO gallery (image_id, ordering, filename, caption, is_active) VALUES 
			('', '$new_ordering', '$imagefile_filename', '$imagecaption', '1')");
	}
}

function uploadPageImage($pageimagedir_path, $content_id, $old_pageimage) {
	$imagefile_basename = basename($_FILES['page_imagefile']['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = strtotime('now').$imagefile_extension;
	$imagefile_path = $pageimagedir_path.$imagefile_filename;
	$imagefile_path_db = substr($imagefile_path, 3, strlen($imagefile_path));
	//echo 'imagefile_path: '.$imagefile_path.'<br/>';
	if (move_uploaded_file($_FILES['page_imagefile']['tmp_name'], $imagefile_path)) {
		//echo $_FILES['page_imagefile']['name'].' has been uploaded<br/>'; 
		//Create thumbnail
		resizePageImage($pageimagedir_path, $imagefile_filename);
		//delete the old image
		if(is_file($old_pageimage)) {
			@unlink($old_pageimage);
		}
		//update
		mysql_query("UPDATE content SET pageimage='$imagefile_path_db' WHERE ID='$content_id'");
	}
}

function resizePageImage($imagedir_path, $imagefile_filename) {
	//resize page image to 315px width (and proportional height)
	$imagefile_path = $imagedir_path.$imagefile_filename;
	if(is_file($imagefile_path)) {
		list($width, $height, $type, $attr) = getimagesize($imagefile_path);
		if($width > 345) {
			$newWidth = 345;
			$newHeight = $height/($width/345);
		} else { $newWidth = $width; $newHeight = $height;}
		//$imagefile_path_resized = $imagedir_path.'t'.$imagefile_filename;
		createImage($imagefile_path, $newWidth, $newHeight);
	}
}

function createThumbnail($imagedir_path, $imagefile_filename) {
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	$imagefile_path_thumb = $imagedir_path.'t'.$imagefile_filename; //thumbnail
	if(copy($imagefile_path, $imagefile_path_thumb)) {
		list($width, $height, $type, $attr) = getimagesize($imagefile_path_thumb);
		if($width > 185) {
			$newWidth = 185;
			$newHeight = $height/($width/185);
		} else { $newWidth = $width; $newHeight = $height;}
		//echo 'resizing '.$imagefile_path_thumb.' to '.$newWidth.' x '.$newHeight.'<br/>';
		createImage($imagefile_path_thumb, $newWidth, $newHeight);
	}
}

function createVideoThumbnail($imagedir_path, $imagefile_filename, $size) {
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	$imagefile_path_thumb = $imagedir_path.'t'.$imagefile_filename; //thumbnail
	if(copy($imagefile_path, $imagefile_path_thumb)) {
		list($width, $height, $type, $attr) = getimagesize($imagefile_path_thumb);
		if($width > $size) {
			$newWidth = $size;
			$newHeight = $height/($width/$size);
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
<?
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
function loadHomeEditor() {
	var editor = CKEDITOR.replace('body',{
	height:"500",
	toolbar:'toolbar1',
	filebrowserBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserImageBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserFlashBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php'
	});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
}

function loadSubpageEditor() {	
	var editor2 = CKEDITOR.replace('body',{
	height:"500",
	toolbar:'toolbar1',
	filebrowserBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserImageBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserFlashBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php'
	});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
	
	var editor3 = CKEDITOR.replace('body2',{
	height:"500",
	toolbar:'toolbar2',
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
	if (document.form_editcontent.menulinkname.value == "") {
		emptyfields += "\n   *Menu link text";
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

var rowCount = 0;
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	var cell1 = row.insertCell(0);
	/*var element1 = document.createElement("input");
	element1.type = "file";*/
	var newfield = document.createElement('div');
	newfield.innerHTML = '<input type="text" id="new_videotitle[]" name="new_videotitle[]" class="textfield_1" style="margin-right:3px;width:180px;"><input type="file" id="new_videoimage[]" name="new_videoimage[]"><input type="file" id="new_videofile[]" name="new_videofile[]" style="margin-left:3px;"><input type="text" id="new_videowidth[]" name="new_videowidth[]" value="" class="textfield_1" style="width:30px;margin-left:4px;margin-right:2px;">x<input type="text" id="new_videoheight[]" name="new_videoheight[]" value="" class="textfield_1" style="width:30px;margin-left:2px;margin-right:5px;">px';
	cell1.appendChild(newfield);
	//alert('fieldnum: '+rowCount);
}

function deleteRow(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = (table.rows.length)-1;
		//alert("rowCount: "+rowCount);
		if(rowCount > 1) {
			table.deleteRow((rowCount-1));		
			rowCount--;
		}
	} catch(e) {
		alert(e);
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
      <h2>Please make changes to page content below. </h2>
      <form id="submitform" name="submitform" method="post" enctype="multipart/form-data" action="" onsubmit='return checkFields();'>
         <table width="960" border="0" cellspacing="3" cellpadding="0">
            <tr>
               <td width="130">&nbsp;</td>
               <td width="200">&nbsp;</td>
               <td width="70">&nbsp;</td>
               <td width="560">&nbsp;</td>
            </tr>
			<tr>
               <td><h3>Page heading: </h3></td>
               <td colspan="3"><input name="pageheading" type="text" class="textfield_1" id="pageheading" value="<?=$pageheading;?>" /></td>
            </tr>
            <tr>
               <td><h3>Windowbar title: </h3></td>
               <td colspan="3"><input name="metatitle" type="text" class="textfield_1" id="metatitle" value="<?=$metatitle;?>" /></td>
            </tr>
			<tr>
               <td><h3>Menu link title:  * </h3></td>
               <td colspan="3"><input name="menulinkname" type="text" class="textfield_1" id="menulinkname" value="<?=$menulinkname;?>" /></td>
            </tr>
			<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<?php
			if($_GET['id'] != 8 && $_GET['id'] != 9 && $_GET['id'] != 10 && $_GET['id'] != 11) {
				echo '
				<tr>
				   <td><h3>Nest this page under:  </h3></td>
				   <td colspan="3">
				   <select id="under_content_id" name="under_content_id">
				   <option value="" SELECTED>-- None (do not nest) -- </option>';
			   $result_category = mysql_query("SELECT * FROM content WHERE under_content_id = '0' ORDER BY ordering ASC");
			   while($row_category = mysql_fetch_array($result_category)) {
					if($under_content_id == $row_category['ID']) { $is_selected = ' SELECTED'; } else { $is_selected = ''; }
					echo '<option value="'.$row_category['ID'].'"'.$is_selected.'>'.$row_category['menulinkname'].'</option>';
			   }
				echo '   
				   </select>
				   </td>
				</tr>
				';
			}
			?>			
			<tr>
               <td><h3>Hide from menu: </h3></td>
               <td colspan="3"><input type="checkbox" id="is_hidden" name="is_hidden" value="1" <?php echo $is_hidden; ?>/></td>
            </tr>
			<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<?php 
			if(!empty($_GET['id'])) {
				echo '
				<tr>
				   <td><h3>Page URL: </h3></td>
				   <td colspan="3"><input name="pageurl" type="text" class="textfield_1" id="pageurl" value="http://www.film-headquarters.com/'.$full_pageurl.'" DISABLED style="background:#EEEEEE;"/></td>
				</tr>
				';
			}
			$string = '<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>';
			if(!empty($_GET['id']) && $_GET['id'] != 1 && $_GET['id'] != 8 && $_GET['id'] != 9 && $_GET['id'] != 10 && $_GET['id'] != 11) {
				//page image				
				$string .= '<tr><td><h3>Page image: </h3></td>
				<td colspan="3" height="55" valign="top">
				<em style="color:#888888;">Recommended image width: 345px (image will automatically resize)</em><br/>';
				
				if(is_file($pageimage)) {
					$string .= '<input type="file" id="page_imagefile" name="page_imagefile"> <a href="'.$pageimage.'" class="preview" target="_blank">view</a>&nbsp;&nbsp;<input type="checkbox" id="deletepageimage" name="deletepageimage" value="deleteme"> Remove</td>';
				} else {
					$string .= '<input type="file" id="page_imagefile" name="page_imagefile"></td>';
				}
				$string .= '</tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>';	
				
				//videos
				$string .= '
				<tr>
					<td valign="top"><h3>Upload videos</h3></td>
					<td colspan="3">
						<table>
							<tr><td valign="top" height="25"><a href="#" onclick="addRow(\'imagefields\');return false;">+ Add field</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteRow(\'imagefields\');return false;">- Remove field</a></td></tr>
							<tr><td><span style="color:#AAAAAA;font-size:10px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </span></td></tr>
							<tr><td>
								<table id="imagefields">';
								//New video field
								$string .= '<tr><td><div style="float:left;width:185px;"><b>Title</b></div><div style="float:left;width:225px;"><b>Thumbnail (image)</b></div><div style="float:left;width:225px;"><b>Video</b></div><div style="float:left;"><b>Width x height</b></div></tr>';
								$string .= '<tr><td><input type="text" id="new_videotitle[]" name="new_videotitle[]" class="textfield_1" style="margin-right:3px;width:180px;"><input type="file" id="new_videoimage[]" name="new_videoimage[]"><input type="file" id="new_videofile[]" name="new_videofile[]" style="margin-left:3px;"><input type="text" id="new_videowidth[]" name="new_videowidth[]" value="" class="textfield_1" style="width:30px;margin-left:4px;margin-right:2px;">x<input type="text" id="new_videoheight[]" name="new_videoheight[]" value="" class="textfield_1" style="width:30px;margin-left:2px;margin-right:5px;">px</td></tr>';
								$string .= '</table>
							</td></tr>
						</table>
					</td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
				<tr>
					<td valign="top"><h3>Current videos</h3></td>
					<td colspan="3">
						<table>';
						//Current videos
						$result_videos = mysql_query("SELECT * FROM videos WHERE content_id = '$content_id' AND is_active = '1'");
						if(mysql_num_rows($result_videos) > 0) {
							$string .= '<tr><td><div style="float:left;width:50px;"><b>Delete</b></div><div style="float:left;width:185px;"><b>Title</b></div><div style="float:left;width:225px;"><b>Replace thumbnail (image)</b></div><div style="float:left;width:225px;"><b>Replace video</b></div><div style="float:left;"><b>Width x height</b></div></tr>';
							while($row_videos = mysql_fetch_array($result_videos)) {
								$string .= '<tr><td><input type="checkbox" id="deletevideo_'.$row_videos['video_id'].'" name="deletevideo_'.$row_videos['video_id'].'" style="margin-left:5px;margin-right:25px;"> <input type="text" id="videotitle_'.$row_videos['video_id'].'" name="videotitle_'.$row_videos['video_id'].'" value="'.$row_videos['title'].'" class="textfield_1" style="margin-right:3px;width:150px;"><a href="../video/t'.$row_videos['thumbsrc'].'" class="preview"><img src="images/ico_image.gif" alt="view" border="0"/></a> <input type="file" id="videoimage_'.$row_videos['video_id'].'" name="videoimage_'.$row_videos['video_id'].'"><a href="../video/'.$row_videos['videosrc'].'" target="_blank"><img src="images/ico_video.png" alt="view" border="0"/></a><input type="file" id="videofile_'.$row_videos['video_id'].'" name="videofile_'.$row_videos['video_id'].'" style="margin-left:3px;"><input type="text" id="videowidth_'.$row_videos['video_id'].'" name="videowidth_'.$row_videos['video_id'].'" value="'.$row_videos['width'].'" value="" class="textfield_1" style="width:30px;margin-left:4px;margin-right:2px;">x<input type="text" id="videoheight_'.$row_videos['video_id'].'" name="videoheight_'.$row_videos['video_id'].'" value="'.$row_videos['height'].'" class="textfield_1" style="width:30px;margin-left:2px;margin-right:5px;">px</td></tr>';
							}
						} else {
							$string .= '<tr><td><em>There are no videos uploaded.</em></td></tr>';
						}
						$string .= '</table>
					</td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>';
			}			
			
			if($_GET['id'] != 1) {
				$string .= '
				<tr>
					<td valign="top"><h3>Left column-box text: </h3></td>
					<td colspan="3"><textarea id="boxy2" name="body2" class="textarea_1" style="height:100px;font-family:Verdana,Arial;font-size:16px;line-height:20px;font-weight:bold;color: #12456B;">'.$body2.'</textarea></td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr><tr><td colspan="4"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
				';
			}
			
			echo $string;
			?>		
			
			<tr>
			   <td colspan="4">			   
			   <textarea name="body" id="body"><?php echo $body; ?></textarea>
			   <script>loadHomeEditor();</script>
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
			   <?php
			   if(empty($_GET['id'])) {
					echo '<input name="add_content" type="submit" id="add_content" value="Create this page &raquo;" class="button_1" />';					
			   } else {
					echo '<input name="save_content" type="submit" id="save_content" value="Save changes &raquo;" class="button_1" />';
			   }
			   ?>
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