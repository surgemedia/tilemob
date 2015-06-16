<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_GET['id'])) {
	$biography_id = $_GET['id'];
	$result_biography = mysql_query("SELECT * FROM biography WHERE biography_id='$biography_id'");
	if($row_biography = mysql_fetch_array($result_biography)) {
		$ordering = $row_biography['ordering'];
		$name = $row_biography['name'];
		$category = $row_biography['category'];
		$title = $row_biography['title'];
		$body = $row_biography['body'];
		$body2 = $row_biography['body2'];
		$imagesrc = $row_biography['imagesrc'];
		$imagefullsrc = '../biography/t'.$imagesrc;
	}
} else {
	echo '<script language="javascript">';
	echo 'self.location = "manage_biography.php;';
	echo '</script>';
}

//Save
if($_POST['save'] && !empty($_POST['category']) && !empty($_POST['name'])){
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
	
	//Update
	mysql_query("UPDATE biography SET name='$name', category='$category', title='$title', body='$body', body2='$body2', is_hidden='$is_hidden' WHERE biography_id='$biography_id'");
	
	$biography_imagedir = '../biography/';
	if(!is_dir($biography_imagedir)) {
		mkdir($biography_imagedir, 0777); 
	}
	
	$biography_videodir = '../video/';
	if(!is_dir($biography_videodir)) {
		mkdir($biography_videodir, 0777); 
	}
	
	//delete page image
	if($_POST['deleteimage'] == 'deleteme') {			
		if(is_file($imagefullsrc)) {
			//echo 'Deleting: '.$delete_original.'<br/>';
			@unlink($imagefullsrc);
			mysql_query("UPDATE biography SET imagesrc='' WHERE biography_id='$biography_id'");
		}
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
			uploadImage($biography_imagedir, $biography_id);
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
				uploadReplacementVideoImage($biography_videodir, $row_videos['thumbsrc'], $biography_id, $video_id);
			}
		}
		if(!empty($_FILES['videofile_'.$video_id])) { //update image
			if(trim($_FILES['videofile_'.$video_id]['name']) != '') {
				uploadReplacementVideo($biography_videodir, $row_videos['videosrc'], $biography_id, $video_id);
			}
		}
		//echo 'video_title '.$video_title.', video_width: '.$video_width.'<br/>';
		if(!empty($video_title) && !empty($video_width) && !empty($video_height)) { //update info
			mysql_query("UPDATE videos SET title='$video_title', width='$video_width', height='$video_height' WHERE video_id = '$video_id'");
		}
		
		//delete video
		if($_POST['deletevideo_'.$video_id] == 'yes') {
			/*//remove files
			if(is_file($biography_videodir.$row_videos['thumbsrc'])) {
				@unlink($biography_videodir.'t'.$row_videos['thumbsrc']); //thumbnail
				@unlink($biography_videodir.$row_videos['thumbsrc']); //original
			}
			if(is_file($biography_videodir.$row_videos['videosrc'])) {
				@unlink($biography_videodir.$row_videos['videosrc']); //video
			}*/
			mysql_query("UPDATE videos SET is_active='0' WHERE video_id='$video_id'");
			
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
				uploadVideo($biography_videodir, $biography_id, $_POST['new_videowidth'][$i], $_POST['new_videoheight'][$i], $i);
			}
		}
	}	

	//All done
	header('location:edit_biography.php?id='.$biography_id.'&s2='.$name.' was successfully saved.');
}

function uploadImage($imagedir_path, $biography_id) {
	$imagefile_basename = basename($_FILES['imagesrc']['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $biography_id.$imagefile_extension;
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	if (move_uploaded_file($_FILES['imagesrc']['tmp_name'], $imagefile_path)) {
		//echo $_FILES['imagefile_'.$image_id]['name'].' has been uploaded<br/>'; 
		//Create thumbnail
		createThumbnail($imagedir_path, $imagefile_filename, 300);
		createDisplay($imagedir_path, $imagefile_filename);
		mysql_query("UPDATE biography SET imagesrc='$imagefile_filename' WHERE biography_id='$biography_id'");
	}
}

function uploadVideo($videodir_path, $biography_id, $video_width, $video_height, $iteration) {
	//echo 'uploading.. '.$videodir_path.', '.$biography_id.', '.$video_width.', '.$video_height.', '.$iteration.'<br/>';
	$videofile_basename = basename($_FILES['new_videofile']['name'][$iteration]);
	$videofile_extension = substr($videofile_basename, strrpos($videofile_basename, '.'), strlen($videofile_basename));
	$videofile_filename = $biography_id.$iteration.strtotime('now').$videofile_extension;
	$videofile_path = $videodir_path.$videofile_filename;
	$video_title = $_POST['new_videotitle'][$iteration];
	if (move_uploaded_file($_FILES['new_videofile']['tmp_name'][$iteration], $videofile_path)) { //upload video file
		$imagefile_basename = basename($_FILES['new_videoimage']['name'][$iteration]);
		$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
		$imagefile_filename = $biography_id.$iteration.strtotime('now').$imagefile_extension;
		$imagefile_path = $videodir_path.$imagefile_filename;
		if (move_uploaded_file($_FILES['new_videoimage']['tmp_name'][$iteration], $imagefile_path)) { //upload image file
			createThumbnail($videodir_path, $imagefile_filename, 180);
			mysql_query("INSERT INTO videos (video_id, content_id, biography_id, title, description, videosrc, 
			thumbsrc, width, height, format, is_active) VALUES 
			('', '0', '$biography_id', '$video_title', '', '$videofile_filename', '$imagefile_filename', '$video_width', '$video_height', '$videofile_extension', '1')");
		}
	}
}

function uploadReplacementVideo($videodir_path, $current_videosrc, $biography_id, $video_id) {
	$videofile_basename = basename($_FILES['videofile_'.$video_id]['name']);
	$videofile_extension = substr($videofile_basename, strrpos($videofile_basename, '.'), strlen($videofile_basename));
	$videofile_filename = $biography_id.$video_id.strtotime('now').$videofile_extension;
	$videofile_path = $videodir_path.$videofile_filename;
	if (move_uploaded_file($_FILES['videofile_'.$video_id]['tmp_name'], $videofile_path)) { //upload video file
		mysql_query("UPDATE videos SET videosrc='$videofile_filename', format='$videofile_extension' WHERE video_id = '$video_id'");
		//delete old video
		if(is_file($videodir_path.$current_videosrc)){
			@unlink($videodir_path.$current_videosrc);
		}
	}
}

function uploadReplacementVideoImage($videodir_path, $current_thumbsrc, $biography_id, $video_id) {
	$imagefile_basename = basename($_FILES['videoimage_'.$video_id]['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $biography_id.$video_id.strtotime('now').$imagefile_extension;
	$imagefile_path = $videodir_path.$imagefile_filename;
	if (move_uploaded_file($_FILES['videoimage_'.$video_id]['tmp_name'], $imagefile_path)) { //upload image file
		createThumbnail($videodir_path, $imagefile_filename, 180);
		mysql_query("UPDATE videos SET thumbsrc='$imagefile_filename' WHERE video_id = '$video_id'");
		//delete old images and thumbnail
		if(is_file($videodir_path.$current_thumbsrc)){
			@unlink($videodir_path.$current_thumbsrc);
			@unlink($videodir_path.'t'.$current_thumbsrc);
		}
	}
}

function createThumbnail($imagedir_path, $imagefile_filename, $size) {
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
      <div class="clear" style="margin-bottom:20px;"><input name="cancel" type="button" id="cancel" value="&laquo; Cancel, return to previous page" onclick="location.href='manage_biography.php';" class="button_1" /></div>
      <div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div>
      <form id="submitform" name="submitform" method="post" enctype="multipart/form-data" action="" onsubmit='return checkFields();'>
         <table width="960" border="0" cellspacing="3" cellpadding="0">
            <tr>
               <td width="130">&nbsp;</td>
               <td width="650">&nbsp;</td>
			   <td width="20">&nbsp;</td>
            </tr>
			<tr>
               <td><h3>Category: *</h3></td>
               <td>
			   <select id="category" name="category">
				<?php
				if($category == 'director') {
					echo '<option value="director" SELECTED>Director</option>';
				} else {
					echo '<option value="director">Director</option>';
				}
				?>
			   
			   </select>
			   </td>
            </tr>
			<tr><td colspan="3">&nbsp;</td></tr><tr><td colspan="3"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
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
               <td>
			   <input type="file" id="imagesrc" name="imagesrc">
				<?php
				if(is_file($imagefullsrc)) {
					echo '<a href="'.$imagefullsrc.'" class="preview" target="_blank">view</a>&nbsp;&nbsp;<input type="checkbox" id="deleteimage" name="deleteimage" value="deleteme"> Remove</td>';
				}
				?>
			   </td>
            </tr>
			<tr><td colspan="3">&nbsp;</td></tr><tr><td colspan="3"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<tr>
				<td valign="top"><h3>Upload videos</h3></td>
				<td colspan="2">
					<table>
						<tr><td valign="top" height="25"><a href="#" onclick="addRow('imagefields');return false;">+ Add field</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteRow('imagefields');return false;">- Remove field</a></td></tr>
						<tr><td><span style="color:#AAAAAA;font-size:10px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </span></td></tr>
						<tr><td>
							<table id="imagefields">
							<?php
							//New video field
							$string = '';
							$string .= '<tr><td><div style="float:left;width:185px;"><b>Title</b></div><div style="float:left;width:225px;"><b>Thumbnail (image)</b></div><div style="float:left;width:225px;"><b>Video</b></div><div style="float:left;"><b>Width x height</b></div></tr>';
							$string .= '<tr><td><input type="text" id="new_videotitle[]" name="new_videotitle[]" class="textfield_1" style="margin-right:3px;width:180px;"><input type="file" id="new_videoimage[]" name="new_videoimage[]"><input type="file" id="new_videofile[]" name="new_videofile[]" style="margin-left:3px;"><input type="text" id="new_videowidth[]" name="new_videowidth[]" value="" class="textfield_1" style="width:30px;margin-left:4px;margin-right:2px;">x<input type="text" id="new_videoheight[]" name="new_videoheight[]" value="" class="textfield_1" style="width:30px;margin-left:2px;margin-right:5px;">px</td></tr>';
							echo $string;
							?>
							</table>
						</td></tr>
					</table>
				</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr><tr><td colspan="3"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
			<tr>
				<td valign="top"><h3>Current videos</h3></td>
				<td colspan="2">
					<table>
					<?php
					//Current videos
					$result_videos = mysql_query("SELECT * FROM videos WHERE biography_id = '$biography_id' AND is_active = '1'");
					if(mysql_num_rows($result_videos) > 0) {
						$string = '<tr><td><div style="float:left;width:50px;"><b>Delete</b></div><div style="float:left;width:185px;"><b>Title</b></div><div style="float:left;width:225px;"><b>Replace thumbnail (image)</b></div><div style="float:left;width:225px;"><b>Replace video</b></div><div style="float:left;"><b>Width x height</b></div></tr>';
						while($row_videos = mysql_fetch_array($result_videos)) {
							$string .= '<tr><td><input type="checkbox" id="deletevideo_'.$row_videos['video_id'].'" name="deletevideo_'.$row_videos['video_id'].'" value="yes" style="margin-left:5px;margin-right:25px;"> <input type="text" id="videotitle_'.$row_videos['video_id'].'" name="videotitle_'.$row_videos['video_id'].'" value="'.$row_videos['title'].'" class="textfield_1" style="margin-right:3px;width:150px;"><a href="../video/t'.$row_videos['thumbsrc'].'" class="preview"><img src="images/ico_image.gif" alt="view" border="0"/></a> <input type="file" id="videoimage_'.$row_videos['video_id'].'" name="videoimage_'.$row_videos['video_id'].'"><a href="../video/'.$row_videos['videosrc'].'" target="_blank"><img src="images/ico_video.png" alt="view" border="0"/></a><input type="file" id="videofile_'.$row_videos['video_id'].'" name="videofile_'.$row_videos['video_id'].'" style="margin-left:3px;"><input type="text" id="videowidth_'.$row_videos['video_id'].'" name="videowidth_'.$row_videos['video_id'].'" value="'.$row_videos['width'].'" value="" class="textfield_1" style="width:30px;margin-left:4px;margin-right:2px;">x<input type="text" id="videoheight_'.$row_videos['video_id'].'" name="videoheight_'.$row_videos['video_id'].'" value="'.$row_videos['height'].'" class="textfield_1" style="width:30px;margin-left:2px;margin-right:5px;">px</td></tr>';
						}
					} else {
						$string .= '<tr><td><em>There are no videos uploaded.</em></td></tr>';
					}
					echo $string;
					?>
					</table>
				</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr><tr><td colspan="3"><div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div></td></tr>
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
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
			   <td colspan="3">			   
			   <textarea name="body" id="body"><?php echo $body; ?></textarea>
			   <script>loadEditor();</script>
			   </td>
			</tr>
            <tr>
               <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="2" align="left" valign="middle"><input name="cancel2" type="button" id="cancel2" value="&laquo; Cancel, return to previous page" onclick="location.href='manage_biography.php';" class="button_1" /></td>
               <td align="right" valign="middle">
			   <input name="save" type="submit" id="save" value="Save Changes &raquo;" class="button_1" />
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