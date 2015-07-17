<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_GET['id'])) {
	$product_id = $_GET['id'];
	$result_product = mysql_query("SELECT * FROM product WHERE product_id='$product_id' AND is_active='1'");
	if($row_product = mysql_fetch_array($result_product)) {
		$category_id = $row_product['category_id'];
		$code = $row_product['code'];
		$name = $row_product['name'];
		$description = $row_product['description'];
		$body = $row_product['body'];
		$price = number_format($row_product['price'],2);
		$imgdir = '../product/'.$product_id.'/';
		$imgsrc1 = $imgdir.$row_product['imgsrc1'];
		$imgsrc2 = $imgdir.$row_product['imgsrc2'];
		$imgsrc3 = $imgdir.$row_product['imgsrc3'];
		$imgsrc4 = $imgdir.$row_product['imgsrc4'];
		$imgsrc5 = $imgdir.$row_product['imgsrc5'];
		if($row_content['is_hidden']==1){$is_hidden='checked="checked"';}else{$is_hidden='';}		
	} else {
		header('product-categories.php?s3=Product ID not found.');
	}
} else {
	header('product-categories.php');
}

if(($_POST['save1']||$_POST['save2']) && !empty($_POST['name']) && !empty($_POST['price'])) {
	$category_id = $_POST['category_id'];
	$code = mysql_real_escape_string(trim($_POST['code']));
	$name = mysql_real_escape_string(trim($_POST['name']));
	$description = trim($_POST['description']);
	$body = trim($_POST['body']);
	$body = str_replace('%2520',' ',$body);
	$price = mysql_real_escape_string(trim($_POST['price']));
	if($_POST['is_hidden']=='1'){$is_hidden=1;}else{$is_hidden=0;}
	mysql_query("UPDATE product SET category_id='$category_id', code='$code', name='$name', description='$description', 
		body='$body', price='$price', redirecturl='$redirecturl', is_hidden='$is_hidden' WHERE product_id='$product_id'");
	//IMAGES
	$imgdir1 = '../product/';
	if(!is_dir($imgdir1)){mkdir($imgdir1, 0777);}
	$imgdir2 = '../product/'.$product_id.'/';
	if(!is_dir($imgdir2)){mkdir($imgdir2, 0777);}
	//delete
	for($i=1;$i<=5;$i++) { //imgsrc1 to imgsrc5
		if($_POST['delete_imgsrc'.$i]=='delete') {
			$delete_original = $imgdir2.basename(${'imgsrc'.$i});
			$delete_thumbnail = $imgdir2.'t'.basename(${'imgsrc'.$i});
			$delete_display = $imgdir2.'d'.basename(${'imgsrc'.$i});
			if(is_file($delete_original)||is_file($delete_thumbnail)||is_file($delete_display)) {
				//echo 'Deleting: '.$delete_original.'<br/>';
				@unlink($delete_original);
				@unlink($delete_thumbnail);
				@unlink($delete_display);
				mysql_query("UPDATE product SET imgsrc$i='' WHERE product_id='$product_id'");
			}
		}
	}
	//upload
	for($i=1;$i<=5;$i++) { //imgsrc1 to imgsrc5
		if(!empty($_FILES['imgsrc'.$i]['name'])&&
		($_FILES['imgsrc'.$i]['type']=='image/jpeg')||
		($_FILES['imgsrc'.$i]['type']=='image/pjpeg')||
		($_FILES['imgsrc'.$i]['type']=='image/gif')||
		($_FILES['imgsrc'.$i]['type']=='image/png')) {
			uploadImage('imgsrc'.$i, $i, $imgdir2, $product_id);
		}
	}	
	
	header('location:edit-product.php?id='.$product_id.'&s2=Changes successfully saved.');
}

function uploadImage($file, $num, $imgdir, $product_id) {
	$img_basename = basename($_FILES[$file]['name']);
	$img_extension = substr($img_basename, strrpos($img_basename, '.'), strlen($img_basename));
	$img_filename = strtotime('now').$num.$img_extension;
	$img_path = $imgdir.$img_filename; //original
	//echo 'img_path: '.$img_path.'<br/>';
	if (move_uploaded_file($_FILES[$file]['tmp_name'], $img_path)) {
		createThumbnail($imgdir, $img_filename); //create thumbnail
		createDisplay($imgdir, $img_filename); //create display
		$result_product = mysql_query("SELECT * FROM product WHERE product_id='$product_id' AND is_active='1'");
		if($row_product = mysql_fetch_array($result_product)) { //remove old images
			$delete_original = $imgdir.$row_product['imgsrc'.$num];
			$delete_thumbnail = $imgdir.'t'.$row_product['imgsrc'.$num];
			$delete_display = $imgdir.'d'.$row_product['imgsrc'.$num];
			@unlink($delete_original); @unlink($delete_thumbnail); @unlink($delete_display);			
		}
		mysql_query("UPDATE product SET $file='$img_filename' WHERE product_id='$product_id'");
	}
}

function createThumbnail($dir, $img) {
	$src_original = $dir.$img; //original
	$src_thumb = $dir.'t'.$img; //thumbnail
	if(copy($src_original, $src_thumb)) {
		list($width, $height, $type, $attr) = getimagesize($src_thumb);
		if($width > 220) {
			$newWidth = 220;
			$newHeight = $height/($width/220);
		} else { $newWidth = $width; $newHeight = $height;}
		createImage($src_thumb, $newWidth, $newHeight);
	}
}

function createDisplay($dir, $img) {
	$src_original = $dir.$img; //original
	$src_display = $dir.'d'.$img; //display
	if(copy($src_original, $src_display)) {
		list($width, $height, $type, $attr) = getimagesize($src_display);
		if($width > 1000) {
			$newWidth = 1000;
			$newHeight = $height/($width/1000);
		} else { $newWidth = $width; $newHeight = $height;}
		if($newHeight > 700) {
			$tempHeight = $newHeight;
			$newHeight = 700;
			$newWidth = $newWidth/($tempHeight/700);
		}
		createImage($src_display, $newWidth, $newHeight);
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
	if (document.getElementById('name').value == "") {
		emptyfields += "\n   *Product name";
	}
	if (document.getElementById('price').value == "") {
		emptyfields += "\n   *Price";
	}
	
	//alert("checking fields");
	if (emptyfields!= "") { //mandatories not completed!
		emptyfields = "It looks like you've forgotten these fields:\n" +
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
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle" style="width:900px;">
		<h1 style="margin-bottom:10px;">Manage product <br/><span style="font-size:16px;"><?php echo $name; ?></span></h1>
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
					<input id="cancel1" name="cancel1" type="button" value="&laquo; Cancel, go back" onclick="location.href='product-categories.php?show=<?php echo $category_id; ?>';" class="button2" />
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
					<td width="150"><b>Category: </b></td>
					<td>
						<select id="category_id" name="category_id" style="padding:5px;">
					   <?php
					   $select_string = '';
					   $result_category = mysql_query("SELECT * FROM category WHERE is_active='1' ORDER BY ordering ASC");
					   while($row_category = mysql_fetch_array($result_category)) {
							if($category_id==$row_category['category_id']){$is_selected=' SELECTED';}else{$is_selected='';}
							$select_string .= '<option value="'.$row_category['category_id'].'"'.$is_selected.'>'.$row_category['name'].'</option>';
					   }
					   echo $select_string;
					   ?>
					   </select>
					</td>
				</tr>
				<tr>
					<td><b>Product name: *</b></td>
					<td><input name="name" type="text" class="textfield1" id="name" value="<?php echo $name;?>" /></td>
				</tr>
				<tr>
					<td><b>Price: *</b></td>
					<td>$ <input name="price" type="text" class="textfield1" id="price" value="<?php echo $price;?>" style="width:100px;margin-right:30px;" />
					<b>Product code: </b>
					<input name="code" type="text" class="textfield1" id="code" value="<?php echo $code;?>" style="width:150px;margin-left:10px;" /></td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td><b>Short description: </b></td>
					<td><textarea id="description" name="description" class="textarea1" style="height:100px;"><?php echo $description;?></textarea></td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td valign="top"><b>Redirect to (URL): </b></td>
					<td valign="top"><input name="redirecturl" type="text" class="textfield1" id="redirecturl" value="<?php echo $redirecturl;?>" /><br/><div style="padding-top:3px;font-size:11px;color:#666666;">If a redirection URL is provided, this page will automatically redirect to your provided URL instead of landing on this page.</div></td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td valign="top"><b>Image 1: </b></td>
					<td valign="top">
						<input id="imgsrc1" name="imgsrc1" type="file" style="padding:5px;margin-right:10px;" />
						<?php
						if(is_file($imgsrc1)){echo'<a href="'.$imgsrc1.'" target="_blank"><img src="images/ico_image.gif" alt="view" border="0" /></a> <input id="delete_imgsrc1" name="delete_imgsrc1" type="checkbox" value="delete" style="margin-left:5px;"> Delete';}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top"><b>Image 2: </b></td>
					<td valign="top">
						<input id="imgsrc2" name="imgsrc2" type="file" style="padding:5px;margin-right:10px;" />
						<?php
						if(is_file($imgsrc2)){echo'<a href="'.$imgsrc2.'" target="_blank"><img src="images/ico_image.gif" alt="view" border="0" /></a> <input id="delete_imgsrc2" name="delete_imgsrc2" type="checkbox" value="delete" style="margin-left:5px;"> Delete';}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top"><b>Image 3: </b></td>
					<td valign="top">
						<input id="imgsrc3" name="imgsrc3" type="file" style="padding:5px;margin-right:10px;" />
						<?php
						if(is_file($imgsrc3)){echo'<a href="'.$imgsrc3.'" target="_blank"><img src="images/ico_image.gif" alt="view" border="0" /></a> <input id="delete_imgsrc3" name="delete_imgsrc3" type="checkbox" value="delete" style="margin-left:5px;"> Delete';}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top"><b>Image 4: </b></td>
					<td valign="top">
						<input id="imgsrc4" name="imgsrc4" type="file" style="padding:5px;margin-right:10px;" />
						<?php
						if(is_file($imgsrc4)){echo'<a href="'.$imgsrc4.'" target="_blank"><img src="images/ico_image.gif" alt="view" border="0" /></a> <input id="delete_imgsrc4" name="delete_imgsrc4" type="checkbox" value="delete" style="margin-left:5px;"> Delete';}
						?>
					</td>
				</tr>
				<tr>
					<td valign="top"><b>Image 5: </b></td>
					<td valign="top">
						<input id="imgsrc5" name="imgsrc5" type="file" style="padding:5px;margin-right:10px;" />
						<?php
						if(is_file($imgsrc5)){echo'<a href="'.$imgsrc5.'" target="_blank"><img src="images/ico_image.gif" alt="view" border="0" /></a> <input id="delete_imgsrc5" name="delete_imgsrc5" type="checkbox" value="delete" style="margin-left:5px;"> Delete';}
						?>
					</td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td><b>Product is hidden: </b></td>
					<td><input type="checkbox" id="is_hidden" name="is_hidden" value="1" <?php echo $is_hidden; ?>/></td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td colspan="4">
						<div class="greynote">Column max width: ..</div>
						<textarea name="body" id="body"><?php echo $body; ?></textarea>
						<script>loadHomeEditor();</script>
					</td>
				</tr>
			</table>
			<div class="clear" style="margin-top:20px;">
				<hr/>
				<div class="float_left">
					<input id="cancel2" name="cancel2" type="button" value="&laquo; Cancel, go back" onclick="location.href='product-categories.php?show=<?php echo $category_id; ?>';" class="button2" />
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