<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_GET['id'])) {
	$content_id = $_GET['id'];
	$result_content = mysql_query("SELECT * FROM shop_content WHERE content_id='$content_id' AND is_active='1'");
	if($row_content = mysql_fetch_array($result_content)) {
		$under_content_id = $row_content['under_content_id'];
		$ordering = $row_content['ordering'];
		$imgsrc = $row_content['imgsrc'];
		$metatitle = stripslashes($row_content['metatitle']);
		$heading1 = stripslashes($row_content['heading1']);
		$heading2 = stripslashes($row_content['heading2']);		
		$linkname = stripslashes($row_content['linkname']);
		$pageurl = stripslashes($row_content['pageurl']);
		$redirecturl = $row_content['redirecturl'];
		$is_multicolumn = $row_content['is_multicolumn'];
		if($row_content['indent_body2']==1){$indent_body2='checked="checked"';}else{$indent_body2='';}
		$body1 = $row_content['body1'];
		$body2 = $row_content['body2'];
		$body1_maxwidth = $row_content['body1_maxwidth'];
		$body2_maxwidth = $row_content['body2_maxwidth'];
		if(!empty($pageurl)){$full_pageurl=$pageurl;
		}else{$full_pageurl='page.php?id='.$content_id;}
		if($row_content['is_onmenu']==1){$is_onmenu='checked="checked"';}else{$is_onmenu='';}
		if($row_content['is_hidden']==1){$is_hidden='checked="checked"';}else{$is_hidden='';}		
	} else {
		header('location:pages.php?s3=Page ID not found.');
	}
} else {
	header('location:pages.php');
}

//Save content
if(($_POST['save1']||$_POST['save2']) && !empty($_POST['linkname']) && !empty($_POST['heading1'])){
	$content_id = $_GET['id'];
	$metatitle = mysql_real_escape_string(trim($_POST['metatitle']));
	$heading1 = mysql_real_escape_string(trim($_POST['heading1']));
	$heading2 = mysql_real_escape_string(trim($_POST['heading2']));	
	$linkname = mysql_real_escape_string(trim($_POST['linkname'])); 
	$redirecturl = mysql_real_escape_string(trim($_POST['redirecturl']));
	if($_POST['indent_body2']=='1'){$indent_body2=1;}else{$indent_body2=0;}
	$body1 = trim($_POST['body1']);
	$body2 = trim($_POST['body2']);
	$body1 = str_replace('%2520',' ',$body1);
	$body2 = str_replace('%2520',' ',$body2);	
	$under_content_id = $_POST['under_content_id'];	
	if($_POST['is_onmenu']=='1'){$is_onmenu=1;}else{$is_onmenu=0;}
	if($_POST['is_hidden']=='1'){$is_hidden=1;}else{$is_hidden=0;}
	
	$hourOffset_timedate = strtotime("+15 hour");
	//$lastupdated = date("d/m/Y (h:ia)", $hourOffset_timedate);
	$lastupdated = date("d/m/Y (h:ia)");
	
	//Update database
	mysql_query("UPDATE shop_content SET 
				under_content_id = '$under_content_id',
				metatitle = '$metatitle',
				heading1 = '$heading1',
				heading2 = '$heading2',				
				linkname = '$linkname',
				redirecturl = '$redirecturl',
				indent_body2 = '$indent_body2',
				body1 = '$body1',
				body2 = '$body2',
				is_onmenu = '$is_onmenu',
				is_hidden = '$is_hidden',
				lastupdated = '$lastupdated'
				WHERE content_id = '$content_id'") or die(mysql_error()); //Done.
	/*
	if($content_id == 3) { //gallery page allows you to add multiple images to the page
		$imagedir_path = '../gallery/';
		if(!is_dir($imagedir_path)) {
			//image directory
			mkdir($imagedir_path, 0777); 
		}
		//remove images
		if(!empty($_POST['deleteimage']) && count($_POST['deleteimage']) > 0) {
			foreach($_POST['deleteimage'] as $key => $value) {
				$delete_original = $imagedir_path.$value;
				$delete_thumbnail = $imagedir_path.'t'.$value;
				$delete_display = $imagedir_path.'d'.$value;
				if(is_file($delete_original) || is_file($delete_thumbnail) || is_file($delete_display)) {
					//echo 'Deleting: '.$delete_original.'<br/>';
					@unlink($delete_original);
					@unlink($delete_thumbnail);
					@unlink($delete_display);
					mysql_query("UPDATE gallery SET is_active='0' WHERE filename='$value' AND is_active='1'");
				}
			}
		}
		
		//replace current images
		$result_gallery = mysql_query("SELECT * FROM gallery WHERE is_active='1' AND casestudy_id = '0'");
		if(mysql_num_rows($result_gallery) > 0) {
			while($row_gallery = mysql_fetch_array($result_gallery)) {
				$image_id = $row_gallery['image_id'];
				if(trim($_FILES['imagefile_'.$image_id]['name']) != '' && 
					($_FILES['imagefile_'.$image_id]['type'] == 'image/jpeg') ||
					($_FILES['imagefile_'.$image_id]['type'] == 'image/pjpeg') ||
					($_FILES['imagefile_'.$image_id]['type'] == 'image/gif') ||
					($_FILES['imagefile_'.$image_id]['type'] == 'image/png')) {
					//echo $_FILES['imagefile_'.$row_gallery['image_id']]['name'].'<br/>';
					//upload replacement
					uploadReplacementImage($image_id, $imagedir_path, $row_gallery['filename']);
				}
				//update image caption and order
				//if(!empty($_POST['imagecaption_'.$image_id])) {
					$ordering = trim($_POST['imageorder_'.$image_id]);
					$imagecaption = trim($_POST['imagecaption_'.$image_id]);
					mysql_query("UPDATE gallery SET ordering='$ordering', caption='$imagecaption' WHERE image_id='$image_id'");
				//}
			}
		}
						
		//upload new images	
		$uploaded = false;
		if($_FILES['new_imagefile'] != '' && count($_FILES['new_imagefile'] > 0)) {
			for($i=0; $i < count($_FILES['new_imagefile']); $i++) {
				if(trim($_FILES['new_imagefile']['name'][$i]) != '' && 
				($_FILES['new_imagefile']['type'][$i] == 'image/jpeg') ||
				($_FILES['new_imagefile']['type'][$i] == 'image/pjpeg') ||
				($_FILES['new_imagefile']['type'][$i] == 'image/gif') ||
				($_FILES['new_imagefile']['type'][$i] == 'image/png')) {
					//echo $_FILES['new_imagefile']['name'][$i].'<br/>';
					$imagecaption = $_POST['new_imagecaption'][$i];
					//Upload files individually
					uploadImage($i, $imagedir_path, $imagecaption);
					$uploaded = true;
				}
			}
		}
	}*/

	//All done
	header('location:edit-page.php?id='.$content_id.'&s2='.$heading.' was successfully saved.');
}

//add page
if(($_POST['add1']||$_POST['add2']) && !empty($_POST['linkname']) && !empty($_POST['heading'])){
	$metatitle = mysql_real_escape_string(trim($_POST['metatitle']));
	$heading1 = mysql_real_escape_string(trim($_POST['heading1']));
	$heading2 = mysql_real_escape_string(trim($_POST['heading2']));
	$linkname = mysql_real_escape_string(trim($_POST['linkname']));
	$redirecturl = mysql_real_escape_string(trim($_POST['redirecturl']));
	if($_POST['indent_body2']=='1'){$indent_body2=1;}else{$indent_body2=0;}
	$body1 = trim($_POST['body1']);
	$body2 = trim($_POST['body2']);
	$body1 = str_replace('%2520',' ',$body1);
	$body2 = str_replace('%2520',' ',$body2);
	$under_content_id = $_POST['under_content_id'];
	if($_POST['is_onmenu']=='1'){$is_onmenu=1;}else{$is_onmenu=0;}
	if($_POST['is_hidden']=='1'){$is_hidden=1;}else{$is_hidden=0;}
	
	$hourOffset_timedate = strtotime("+15 hour");
	//$lastupdated =  date("d/m/Y (h:ia)", $hourOffset_timedate);
	$lastupdated =  date("d/m/Y (h:ia)");
	
	//Update database
	mysql_query("INSERT INTO shop_content 
	(content_id, under_content_id, ordering, imgsrc, metatitle, pagecaption, heading1, heading2, linkname, pageurl, redirecturl, is_multicolumn, 
	indent_body2, body1, body2, body1_maxwidth, body2_maxwidth, body_fullwidth, is_onmenu, is_hidden, is_active, lastupdated)
	VALUES
	('','$under_content_id','99','','$metatitle','','$heading1','$heading2','$linkname','$pageurl','$redirecturl','$is_multicolumn',
	'$indent_body2','$body1','$body2','','','','$is_onmenu','$is_hidden','1','$lastupdated')");

	//All done
	header('location:pages.php?s2='.$heading.' was successfully created.');
}

function uploadReplacementImage($image_id, $imagedir_path, $current_image) {
	$imagefile_basename = basename($_FILES['imagefile_'.$image_id]['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $image_id.strtotime('now').$imagefile_extension;
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	if (move_uploaded_file($_FILES['imagefile_'.$image_id]['tmp_name'], $imagefile_path)) {
		echo $_FILES['imagefile_'.$image_id]['name'].' has been uploaded as '.$imagefile_filename.'<br/>'; 
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
		//$new_ordering = mysql_num_rows($result_count)+1;
		$new_ordering = 0;
		//insert
		mysql_query("INSERT INTO gallery (image_id, ordering, filename, caption, casestudy_id, is_active) VALUES 
			('', '$new_ordering', '$imagefile_filename', '$imagecaption', '0', '1')");
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
		mysql_query("UPDATE shop_content SET pageimage='$imagefile_path_db' WHERE ID='$content_id'");
	}
}

function resizePageImage($imagedir_path, $imagefile_filename) {
	//resize page image to 315px width (and proportional height)
	$imagefile_path = $imagedir_path.$imagefile_filename;
	if(is_file($imagefile_path)) {
		list($width, $height, $type, $attr) = getimagesize($imagefile_path);
		if($width > 315) {
			$newWidth = 315;
			$newHeight = $height/($width/315);
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
function loadHomeEditor() {
	var editor = CKEDITOR.replace('body1',{
	height:"700",
	toolbar:'toolbar1'});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
}

function loadSubpageEditor() {
	var editor2 = CKEDITOR.replace('body1',{
	height:"700",
	toolbar:'toolbar2'});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
	
	var editor3 = CKEDITOR.replace('body2',{
	height:"700",
	toolbar:'toolbar2'});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css';
	CKEDITOR.config.forcePasteAsPlainText = true;
}

function checkFields() {
	//alert("checking fields");
	emptyfields = "";
	if (document.getElementById('heading').value == "") {
		emptyfields += "\n   *Page name";
	}
	if (document.getElementById('linkname').value == "") {
		emptyfields += "\n   *Link name";
	}
	
	//alert("checking fields");
	if (emptyfields!= "") { //mandatories not completed!
		emptyfields = "It looks like you've forgotten these fields:\n" +
		emptyfields + "\n\nPlease remember to fill in all fields marked with *";
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
	newfield.innerHTML = '<input type="file" id="new_imagefile[]" name="new_imagefile[]"></td><td><input type="text" id="new_imagecaption[]" name="new_imagecaption[]" value="" class="textfield1" style="width:200px;margin-left:2px;margin-right:5px;">';
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
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle">
		<h1>Edit page</h1>
		<?php
		if(!empty($_GET['s1']) || !empty($_GET['s2']) || !empty($_GET['s3'])) {
			if(!empty($_GET['s1'])){$s = 1;}else if(!empty($_GET['s2'])){$s = 2;}else if(!empty($_GET['s3'])){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			echo '<div class="status'.$s.'">'.$status.'</div>';
			echo '<div class="clear"></div>';
		}
		?>
		<div id="content" class="content">
			<form id="submitform" name="submitform" method="post" enctype="multipart/form-data" onsubmit='return checkFields();'>
			<div class="clear" style="margin-bottom:20px;">
				<div class="float_left">
					<input id="cancel1" name="cancel1" type="button" value="&laquo; Cancel, go back" onclick="location.href='pages.php';" class="button2" />
				</div>
				<div class="float_right">
					<?php
					if(empty($_GET['id'])) {
						echo '<input name="add1" type="submit" id="add1" value="Create this page &raquo;" class="button2" />';					
					} else {
						echo '<input name="save1" type="submit" id="save1" value="Save changes &raquo;" class="button2" />';
					}
					?>
				</div>
				<div class="clear"></div>
				<hr/>
			</div>		
			<h2>Make changes to page content below. </h2>		
			<table width="100%" class="table2">
				<tr>
					<td width="150"><b>Page heading: *</b></td>
					<td colspan="3"><input name="heading1" type="text" class="textfield1" id="heading1" value="<?php echo $heading1;?>" style="font-weight:bold;" /></td>
				</tr>
				<tr>
					<td><b>Subheading: </b></td>
					<td colspan="3"><input name="heading2" type="text" class="textfield1" id="heading2" value="<?php echo $heading2;?>" /></td>
				</tr>
				<tr>
					<td><b>Windowbar title: </b></td>
					<td colspan="3"><input name="metatitle" type="text" class="textfield1" id="metatitle" value="<?php echo $metatitle;?>" /></td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td><b>Link name: *</b></td>
					<td colspan="3"><input name="linkname" type="text" class="textfield1" id="linkname" value="<?php echo $linkname;?>" /></td>
				</tr>
				<?php 
				if(!empty($_GET['id'])) {
					echo '
					<tr>
					   <td><b>Page URL: </b></td>
					   <td colspan="3"><input name="pageurl" type="text" class="textfield1" id="pageurl" value="'.$full_pageurl.'" DISABLED style="background:#EEEEEE;"/></td>
					</tr>
					';
				}
				?>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td valign="top"><b>Redirect to (URL): </b></td>
					<td colspan="3" valign="top"><input name="redirecturl" type="text" class="textfield1" id="redirecturl" value="<?php echo $redirecturl;?>" /><br/><div style="padding-top:3px;font-size:11px;color:#666666;">If a redirection URL is provided, this page will automatically redirect to your provided URL instead of landing on this page.</div></td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
				   <td><b>Nest this page under: </b></td>
				   <td colspan="3">
				   <select id="under_content_id" name="under_content_id" style="padding:5px;">
				   <option value="" SELECTED>-- None (do not nest) -- </option>
				   <?php
				   $select_string = '';
				   $result_category = mysql_query("SELECT * FROM content WHERE under_content_id = '0' ORDER BY ordering ASC");
				   while($row_category = mysql_fetch_array($result_category)) {
						if($under_content_id == $row_category['content_id']) { $is_selected = ' SELECTED'; } else { $is_selected = ''; }
						if($row_category['content_id']!=$content_id) {
							$select_string .= '<option value="'.$row_category['content_id'].'"'.$is_selected.'>'.$row_category['linkname'].'</option>';
						}
				   }
				   echo $select_string;
				   ?>
				   </select>
				   </td>
				</tr>
				<tr>
					<td><b>Show on menu: </b></td>
					<td colspan="3"><input type="checkbox" id="is_onmenu" name="is_onmenu" value="1" <?php echo $is_onmenu; ?>/></td>
				</tr>
				<tr>
					<td><b>Page is hidden: </b></td>
					<td colspan="3"><input type="checkbox" id="is_hidden" name="is_hidden" value="1" <?php echo $is_hidden; ?>/></td>
				</tr>
				<?php
				$string = '';
				/*
				if($content_id == 3) {
					//available images
					$string .= '<tr><td colspan="4"><hr/></td></tr>';
					$string .= '<tr><td valign="top"><b>Available images: </b></td><td colspan="3">';
					$string .= '<table>';
					$result_gallery = mysql_query("SELECT * FROM gallery WHERE casestudy_id = '0' AND is_active = '1' ORDER BY ordering ASC");
					$run = false;
					while($row_gallery = mysql_fetch_array($result_gallery)) {
						if(is_file('../gallery/t'.$row_gallery['filename']) && is_file('../gallery/'.$row_gallery['filename'])) {
							$imagefile_path = '../gallery/t'.$row_gallery['filename'];
							if($run == false){ $string.= '<tr><td><b>#</b></td><td><b>File</b></td><td><b>Caption</b></td><td>&nbsp;</td></tr>'; $run = true;}
							if(is_file($imagefile_path)) {
								$string .= '<tr><td><input type="text" id="imageorder_'.$row_gallery['image_id'].'" name="imageorder_'.$row_gallery['image_id'].'" value="'.$row_gallery['ordering'].'" class="textfield1" style="width:20px;text-align:center;"></td>';
								$string .= '<td><input type="file" id="imagefile_'.$row_gallery['image_id'].'" name="imagefile_'.$row_gallery['image_id'].'"></td>';
								$string .= '<td><input type="text" id="imagecaption_'.$row_gallery['image_id'].'" name="imagecaption_'.$row_gallery['image_id'].'" value="'.$row_gallery['caption'].'" class="textfield1" style="width:200px;margin-left:2px;margin-right:5px;"></td>';
								$string .= '<td><a href="'.$imagefile_path.'" class="preview" target="_blank">view</a>&nbsp;&nbsp;<input type="checkbox" id="deleteimage[]" name="deleteimage[]" value="'.$row_gallery['filename'].'"> Remove</td></tr>';
							}
						}
					}
					$string .= '</table></td></tr>';
					if(mysql_num_rows($result_gallery) == 0) {
						$string .= '<tr><td colspan="4"><em>There are no images currently available.</em></td></tr>';
					}
					//new images
					$string .= '<tr><td valign="top"><b>Upload images: </b><a href="#" onclick="addRow(\'imagefields\');return false;">+ Add field</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#" onclick="deleteRow(\'imagefields\');return false;">- Remove field</a></td><td colspan="3">';				
					$string .= '<table id="imagefields">';
					$string .= '<tr><td><div style="float:left;width:225px;"><b>File</b></div><div style="float:left;"><b>Caption</b></div></tr>';
					$string .= '<tr><td colspan="2"><input type="file" id="new_imagefile[]" name="new_imagefile[]"><input type="text" id="new_imagecaption[]" name="new_imagecaption[]" value="" class="textfield1" style="width:200px;margin-left:2px;margin-right:5px;"></td></tr>';
					$string .= '</table></td></tr>';
				}
				*/
				echo $string;			

				if(!empty($content_id)) {
					$string = '';
					/*
					//link to brochure
					$string .= '<tr><td colspan="4"><hr/></td></tr>';
					$string .= '<tr><td><b>Link to brochure: </b></td>';				
					$string .= '<td><select id="brochure_id" name="brochure_id">';
					$string .= '<option value="">Please select</option>';
					$result_brochures = mysql_query("SELECT * FROM brochures WHERE is_active = '1'");
					while($row_brochures = mysql_fetch_array($result_brochures)) {
						if($brochure_id==$row_brochures['brochure_id']){$is_selected=' SELECTED';}else{$is_selected='';}
						if(is_file('../'.$row_brochures['filepath'])) {
							$string .= '<option value="'.$row_brochures['brochure_id'].'"'.$is_selected.'>'.basename($row_brochures['filepath']).'</option>';
						}
					}
					$string .= '</select></td></tr>';					
					
					//page image
					$string .= '<tr><td colspan="4"><hr/></td></tr>';
					if($content_id!=1){
					$string.='<tr><td><b>Page image: </b></td>
					<td colspan="3" height="55" valign="top">
					<em style="color:#888888;">Recommended image width: 315px (image will automatically resize)</em><br/>';
					
					if(is_file($pageimage)) {
						$string .= '<input type="file" id="page_imagefile" name="page_imagefile"> <a href="'.$pageimage.'" class="preview" target="_blank">view</a>&nbsp;&nbsp;<input type="checkbox" id="deletepageimage" name="deletepageimage" value="deleteme"> Remove</td>';
					} else {
						$string .= '<input type="file" id="page_imagefile" name="page_imagefile"></td>';
					}
					$string .= '</tr><tr><td colspan="4"><hr/></td></tr>';
					}
					
					
					$string .= '<tr><td colspan="4"><hr/></td></tr>';
					*/				
				}
				$string .= '<tr><td colspan="4"><hr/></td></tr>';
				echo $string;
				?>
				<!--
				<tr>
				   <td><b>Hide from side/page menu:  </b></td>
				   <td colspan="3"><input type="checkbox" id="is_hidden_onpagemenu" name="is_hidden_onpagemenu" value="1" <?php echo $is_hidden_onpagemenu; ?>/></td>
				</tr>
				-->
				<?php
				if($is_multicolumn==1){
					echo '<tr>
						   <td colspan="4" valign="top">
							   <div class="greynote" style="width:450px;float:left;">Column max width: '.$body1_maxwidth.'</div>
							   <div class="greynote" style="width:450px;float:right;">Column max width: '.$body1_maxwidth.'<div style="float:right;"><input type="checkbox" id="indent_body2" name="indent_body2" value="1" '.$indent_body2.'/> Indent this column</div></div>
							   <div style="width:450px;float:left;"><textarea name="body1" id="body1">'.$body1.'</textarea></div>
							   <div style="width:450px;float:right;"><textarea name="body2" id="body2">'.$body2.'</textarea></div>
							   <script>loadSubpageEditor();</script>
						   </td>
						</tr>';				
				} else {			
					echo '<tr>
						   <td colspan="4">
							   <div class="greynote">Column max width: '.$body1_maxwidth.'</div>
							   <textarea name="body1" id="body1">'.$body1.'</textarea>
							   <script>loadHomeEditor();</script>
						   </td>
						</tr>';
				}
				?>
				<!--<tr>
					<td colspan="4">			   
					<textarea name="body1" id="body1"><?php echo $body1 ?></textarea>
					<script>loadHomeEditor();</script>
					</td>
				</tr>-->
			</table>		
			<div class="clear" style="margin-top:20px;">
				<hr/>
				<div class="float_left">
					<input id="cancel2" name="cancel2" type="button" value="&laquo; Cancel, go back" onclick="location.href='pages.php';" class="button2" />
				</div>
				<div class="float_right">
					<?php
					if(empty($_GET['id'])) {
						echo '<input name="add2" type="submit" id="add2" value="Create this page &raquo;" class="button2" />';					
					} else {
						echo '<input name="save2" type="submit" id="save2" value="Save changes &raquo;" class="button2" />';
					}
					?>
				</div>
				<div class="clear"></div>
			</div>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
</div>
<?php include('includes/end_body.php'); ?>
</body>
</html>