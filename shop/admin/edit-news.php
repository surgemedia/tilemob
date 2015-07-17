<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_GET['id'])) {
	$news_id = $_GET['id'];
	$result_news = mysql_query("SELECT * FROM news WHERE news_id='$news_id'");
	if($row_news = mysql_fetch_array($result_news)) {
		$news_id = $row_news['news_id'];
		$news_category_id = $row_news['news_category_id'];
		$heading = $row_news['heading'];
		$releasedate = $row_news['releasedate'];
		$shortdescription = $row_news['shortdescription'];		
		$body = $row_news['body'];
		$imgsrc = '../'.$row_news['imgsrc'];
		$attachmentsrc = $row_news['attachmentsrc'];
		if($row_news['is_hidden']==1){$is_hidden='checked="checked"';}else{$is_hidden='';}
		if($row_news['is_featured']==1){$is_featured='checked="checked"';}else{$is_featured='';}
		$news_updatedby = $row_news['news_updatedby'];
		$news_lastupdated = $row_news['news_lastupdated'];
		$news_created = $row_news['news_created'];
		$body_maxwidth = 960;
		$full_pageurl = 'http://www.smartcandleasia.com/news.php?id='.$news_id;		
	} else {
		header('location:news.php?s3=News ID not found.');
	}
} else {
	//create new
}

//Save content
if(($_POST['save1']||$_POST['save2']) && !empty($_POST['heading']) && !empty($_POST['releasedate']) && !empty($_POST['shortdescription'])){
	$news_category_id = $_POST['news_category_id'];
	$heading = mysql_real_escape_string($_POST['heading']);
	$releasedate = $_POST['releasedate'];
	$shortdescription = mysql_real_escape_string($_POST['shortdescription']);		
	$body = $_POST['body'];
	if($_POST['is_hidden']==1){$is_hidden='checked="checked"';}else{$is_hidden='';}
	if($_POST['is_featured']==1){$is_featured='checked="checked"';}else{$is_featured='';}
	$news_updatedby = $_cms_username;
	
	//Update database
	mysql_query("UPDATE news SET 
				news_category_id = '$news_category_id',
				heading = '$heading',
				releasedate = '$releasedate',
				shortdescription = '$shortdescription',
				body = '$body',
				is_hidden = '$is_hidden',
				is_featured = '$is_featured',
				news_updatedby = '$news_updatedby',
				news_lastupdated = NOW()
				WHERE news_id = '$news_id'") or die(mysql_error()); //Done.
				
	$imagedir_path = '../news/';
	
	//remove image
	if($_POST['delete_imgsrc'] == 'yes' && is_file($imgsrc)) {
		$old_thumbsrc = $imgsrc;
		$old_originalsrc = str_replace('/t','/',$old_thumbsrc);
		@unlink($old_thumbsrc);
		@unlink($old_originalsrc);
		mysql_query("UPDATE news SET imgsrc='' WHERE news_id='$news_id'");
	}
	
	//add image	
	if(!is_dir($imagedir_path)) {
		//image directory
		mkdir($imagedir_path, 0777); 
	}
	if(trim($_FILES['imgsrc']['name']) != '' && 
		($_FILES['imgsrc']['type'] == 'image/jpeg') ||
		($_FILES['imgsrc']['type'] == 'image/pjpeg') ||
		($_FILES['imgsrc']['type'] == 'image/gif') ||
		($_FILES['imgsrc']['type'] == 'image/png')) {
		uploadImage($imagedir_path, $news_id);
	}

	//All done
	header('location:edit-news.php?id='.$news_id.'&s2='.$heading.' was successfully saved.');
}

//add page
if(($_POST['add1']||$_POST['add2']) && !empty($_POST['heading']) && !empty($_POST['releasedate']) && !empty($_POST['shortdescription'])){
	$news_category_id = $_POST['news_category_id'];
	$heading = mysql_real_escape_string($_POST['heading']);
	$releasedate = $_POST['releasedate'];
	$shortdescription = mysql_real_escape_string($_POST['shortdescription']);	
	$body = $_POST['body'];
	if($_POST['is_hidden']==1){$is_hidden='checked="checked"';}else{$is_hidden='';}
	if($_POST['is_featured']==1){$is_featured='checked="checked"';}else{$is_featured='';}
	$news_updatedby = $_cms_username;
	
	//Update database
	mysql_query("INSERT INTO news 
	(news_id, news_category_id, heading, releasedate, shortdescription, body, imgsrc, attachmentsrc, 
	is_hidden, is_featured, is_active, news_updatedby, news_lastupdated,news_created)
	VALUES
	('','$news_category_id','$heading','$releasedate','$shortdescription','$body','','',
	'$is_hidden','$is_featured','1','$news_updatedby',NOW(),NOW())");
	
	$news_id = mysql_insert_id();
	
	$imagedir_path = '../news/';
	if(!is_dir($imagedir_path)) {
		//image directory
		mkdir($imagedir_path, 0777); 
	}
	if(trim($_FILES['imgsrc']['name']) != '' && 
		($_FILES['imgsrc']['type'] == 'image/jpeg') ||
		($_FILES['imgsrc']['type'] == 'image/pjpeg') ||
		($_FILES['imgsrc']['type'] == 'image/gif') ||
		($_FILES['imgsrc']['type'] == 'image/png')) {
		uploadImage($imagedir_path, $news_id);
	}

	//All done
	header('location:news.php?s2='.$heading.' was successfully created.');
}

function uploadImage($imagedir_path, $news_id) {
	$imagefile_basename = basename($_FILES['imgsrc']['name']);
	$imagefile_extension = substr($imagefile_basename, strrpos($imagefile_basename, '.'), strlen($imagefile_basename));
	$imagefile_filename = $iteration.strtotime('now').$imagefile_extension;
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	//$imagefile_path_db = substr($imagefile_path, 2, strlen($imagefile_path));
	//echo 'imagefile_path: '.$imagefile_path.'<br/>';
	if (move_uploaded_file($_FILES['imgsrc']['tmp_name'], $imagefile_path)) {
		//echo $_FILES['imgsrc']['name'].' has been uploaded<br/>'; 		
		$thumbnailsrc = createThumbnail($imagedir_path, $imagefile_filename); //Create thumbnail
		$result_news_imgsrc = mysql_query("SELECT * FROM news WHERE news_id='$news_id'");
		if($row_news_imgsrc = mysql_fetch_array($result_news_imgsrc)) {
			//echo 'news_id: '.$news_id.', thumbnailsrc: '.$thumbnailsrc;
			//remove old file
			$old_thumbsrc = $row_news_imgsrc['imgsrc'];
			$old_originalsrc = str_replace('/t','/',$old_thumbsrc);
			if(is_file($old_thumbsrc)) {
				@unlink($old_thumbsrc);
				@unlink($old_originalsrc);
			}
			//update
			mysql_query("UPDATE news SET imgsrc='$thumbnailsrc' WHERE news_id='$news_id'");
		}
	}
}

function createThumbnail($imagedir_path, $imagefile_filename) {
	$imagefile_path = $imagedir_path.$imagefile_filename; //original
	$imagefile_path_thumb = $imagedir_path.'t'.$imagefile_filename; //thumbnail
	if(copy($imagefile_path, $imagefile_path_thumb)) {
		list($width, $height, $type, $attr) = getimagesize($imagefile_path_thumb);
		if($width > 300) {
			$newWidth = 300;
			$newHeight = $height/($width/300);
		} else { $newWidth = $width; $newHeight = $height;}
		//echo 'resizing '.$imagefile_path_thumb.' to '.$newWidth.' x '.$newHeight.'<br/>';
		createImage($imagefile_path_thumb, $newWidth, $newHeight);
		return str_replace('../','',$imagefile_path_thumb);
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
	var editor = CKEDITOR.replace('body',{
	height:"700",
	toolbar:'toolbar1'});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
}

function checkFields() {
	//alert("checking fields");
	emptyfields = "";
	if (document.getElementById('heading').value == "") {
		emptyfields += "\n   *News heading";
	}
	if (document.getElementById('releasedate').value == "") {
		emptyfields += "\n   *Release date";
	}
	if (document.getElementById('shortdescription').value == "") {
		emptyfields += "\n   *Short description";
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
		<h1>Edit news</h1>
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
					<input id="cancel1" name="cancel1" type="button" value="&laquo; Cancel, go back" onclick="location.href='news.php';" class="button2" />
				</div>
				<div class="float_right">
					<?php
					if(empty($_GET['id'])) {
						echo '<input name="add1" type="submit" id="add1" value="Save news item &raquo;" class="button2" />';					
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
					<td width="150"><b>News heading: *</b></td>
					<td colspan="3"><input name="heading" type="text" class="textfield1" id="heading" value="<?php echo $heading;?>" /></td>
				</tr>
				<tr>
					<td width="150"><b>Release date: *</b></td>
					<td colspan="3"><input name="releasedate" type="text" class="textfield1" id="releasedate" value="<?php echo $releasedate;?>" /></td>
				</tr>
				<tr>
					<td><b>Category: </b></td>
					<td colspan="3">
						
					</td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td><b>Short description: *</b></td>
					<td colspan="3">
						<textarea id="shortdescription" name="shortdescription" class="textarea1" style="height:100px;"><?php echo $shortdescription; ?></textarea>
					</td>
				</tr>
				<!--<tr>
					<td width="150"><b>Image for thumbnail: </b></td>
					<td colspan="3">
						<input name="imgsrc" type="file" id="imgsrc"/>
						<?php
						if(is_file($imgsrc)){
							echo '<a href="'.$imgsrc.'" target="_blank" style="margin-left:10px;margin-right:10px;"><img src="images/ico_image.gif" alt="Image" border="0" /></a>';
							echo '<input type="checkbox" id="delete_imgsrc" name="delete_imgsrc" value="yes"> Remove image';
						}
						?>
					</td>
				</tr>-->
				<?php 
				if(!empty($_GET['id'])) {
					echo '
					<tr><td colspan="4"><hr/></td></tr>
					<tr>
					   <td><b>News URL: </b></td>
					   <td colspan="3"><input name="pageurl" type="text" class="textfield1" id="pageurl" value="'.$full_pageurl.'" DISABLED style="background:#EEEEEE;"/></td>
					</tr>
					';
				}
				?>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td><b>Hide news: </b></td>
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
				?>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
				   <td colspan="4">
					   <div class="greynote">Column max width: <?php echo $body_maxwidth; ?>px</div>
					   <textarea name="body" id="body"><?php echo $body; ?></textarea>
					   <script>loadHomeEditor();</script>
				   </td>
				</tr>
			</table>		
			<div class="clear" style="margin-top:20px;">
				<hr/>
				<div class="float_left">
					<input id="cancel2" name="cancel2" type="button" value="&laquo; Cancel, go back" onclick="location.href='news.php';" class="button2" />
				</div>
				<div class="float_right">
					<?php
					if(empty($_GET['id'])) {
						echo '<input name="add2" type="submit" id="add2" value="Save news item &raquo;" class="button2" />';					
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