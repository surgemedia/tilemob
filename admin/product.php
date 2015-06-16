<?php
include('includes/prerun.php');
include('../../dbconnect.php'); //Database connections
include('includes/checklogin.php'); //Check login 
if($_POST['save1']!="" || $_POST['save2']!=""){
	echo $_POST['heading'];
	if($_POST['linkname']=="" && $_POST['heading']==""){
	$content_id = $_GET['id'];
	$metatitle = mysql_real_escape_string(trim($_POST['metatitle']));
	$heading2 = mysql_real_escape_string(trim($_POST['heading2']));
	$heading = mysql_real_escape_string(trim($_POST['heading']));
	$linkname = mysql_real_escape_string(trim($_POST['linkname'])); 
	$redirecturl = mysql_real_escape_string(trim($_POST['redirecturl']));
	if($_POST['indent_body2']=='1'){$indent_body2=1;}else{$indent_body2=0;}
	$body1 = trim($_POST['body1']);
	$body2 = trim($_POST['body2']);
	$body1 = str_replace('%2520',' ',$body1);
	$body2 = str_replace('%2520',' ',$body2);	
	$under_content_id = $_POST['under_content_id'];	
	date_default_timezone_set('australia/brisbane');
	$hourOffset_timedate = strtotime("+15 hour");
	//$lastupdated = date("d/m/Y (h:ia)", $hourOffset_timedate);
	$lastupdated = date("d/m/Y (h:ia)");
	
	//Update database
				
				$update_result = mysql_query("UPDATE shop_webitems AS SW SET 
				SW.Code = '".$_POST['Code']."',
				SW.Desc = '".$_POST['Desc']."',
				SW.RetailPricePce = '".$_POST['RetailPricePce']."',
				SW.RetailPriceM2 = '".$_POST['RetailPriceM2']."',
				SW.TradePricePce = '".$_POST['TradePricePce']."',
				SW.TradePriceM2 = '".$_POST['TradePriceM2']."',
				SW.WebPricePce = '".$_POST['WebPricePce']."',
				SW.Use = '".$_POST['Use']."',
				SW.Category = '".$_POST['Category']."',
				SW.CategoryDescription = '".$_POST['CategoryDescription']."',
				SW.SupplierCode = '".$_POST['SupplierCode']."',
				SW.SupplierName = '".$_POST['SupplierName']."',
				SW.SuppStock = '".$_POST['SuppStock']."',
				SW.RelatedTo = '".$_POST['RelatedTo']."',
				SW.Weight = '".$_POST['Weight']."',
				SW.Unit = '".$_POST['Unit']."',
				SW.QtyAvailable  = '".$_POST['QtyAvailable']."',
				SW.PcsM2 = '".$_POST['PcsM2']."',
				SW.PcsBox = '".$_POST['PcsBox']."',
				SW.M2Box = '".$_POST['M2Box']."',
				SW.BoxesPallet = '".$_POST['BoxesPallet']."',
				SW.M2Pallet = '".$_POST['M2Pallet']."',
				SW.Type = '".$_POST['Type']."',
				SW.Material = '".$_POST['Material']."',
				SW.Size = '".$_POST['Size']."',
				SW.Thickness = '".$_POST['Thickness']."',
				SW.Edge = '".$_POST['Edge']."',
				SW.Colour = '".$_POST['Colour']."',
				SW.Surface = '".$_POST['Surface']."',
				SW.Pattern = '".$_POST['Pattern']."',
				SW.Heading = '".$_POST['Heading']."',
				SW.SubHeading = '".$_POST['SubHeading']."',
				SW.Country = '".$_POST['Country']."',
				SW.Manufacturer = '".$_POST['Manufacturer']."',
				SW.GstCode = '".$_POST['GstCode']."',
				SW.GstDesc = '".$_POST['GstDesc']."',
				SW.is_active = '".$_POST['is_active']."',
				SW.Notepad2 = '".$_POST['item_Notepad2']."',
				SW.lastupdate = '".$lastupdated."'
				WHERE SW.item_id = ".$content_id);
	
			
/*	echo "UPDATE shop_webitems AS SW SET 
				SW.Code = '".$_POST['Code']."',
				SW.Desc = '".$_POST['Desc']."',
				SW.RetailPricePce = '".$_POST['RetailPricePce']."',
				SW.RetailPriceM2 = '".$_POST['RetailPriceM2']."',
				SW.TradePricePce = '".$_POST['TradePricePce']."',
				SW.TradePriceM2 = '".$_POST['TradePriceM2']."',
				SW.WebPricePce = '".$_POST['WebPricePce']."',
				SW.Use = '".$_POST['Use']."',
				SW.Category = '".$_POST['Category']."',
				SW.CategoryDescription = '".$_POST['CategoryDescription']."',
				SW.SupplierCode = '".$_POST['SupplierCode']."',
				SW.SupplierName = '".$_POST['SupplierName']."',
				SW.SuppStock = '".$_POST['SuppStock']."',
				SW.RelatedTo = '".$_POST['RelatedTo']."',
				SW.Weight = '".$_POST['Weight']."',
				SW.Unit = '".$_POST['Unit']."',
				SW.QtyAvailable  = '".$_POST['QtyAvailable']."',
				SW.PcsM2 = '".$_POST['PcsM2']."',
				SW.PcsBox = '".$_POST['PcsBox']."',
				SW.M2Box = '".$_POST['M2Box']."',
				SW.BoxesPallet = '".$_POST['BoxesPallet']."',
				SW.M2Pallet = '".$_POST['M2Pallet']."',
				SW.Type = '".$_POST['Type']."',
				SW.Material = '".$_POST['Material']."',
				SW.Size = '".$_POST['Size']."',
				SW.Thickness = '".$_POST['Thickness']."',
				SW.Edge = '".$_POST['Edge']."',
				SW.Colour = '".$_POST['Colour']."',
				SW.Surface = '".$_POST['Surface']."',
				SW.Pattern = '".$_POST['Pattern']."',
				SW.Heading = '".$_POST['Heading']."',
				SW.SubHeading = '".$_POST['SubHeading']."',
				SW.Country = '".$_POST['Country']."',
				SW.Manufacturer = '".$_POST['Manufacturer']."',
				SW.GstCode = '".$_POST['GstCode']."',
				SW.GstDesc = '".$_POST['GstDesc']."',
				SW.is_active = '".$is_active."',
				SW.lastupdate = '".$lastupdated."'
				WHERE SW.item_id = ".$content_id;
*///Save content
//Done.
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
		if($update_result){
			echo "was successfully saved.";
		}else{
			echo "Not success saved.";
		}
	
	
	}
}


	$result_item = mysql_query("SELECT * FROM shop_webitems WHERE item_id='".$_GET['id']."' AND WebExport LIKE 'YES' AND is_active = '1'");
	$row_item = mysql_fetch_array($result_item);
	$item_Code = $row_item['Code'];
	$item_Desc = $row_item['Desc'];
	$item_RetailPricePce = $row_item['RetailPricePce'];
	$item_RetailPriceM2 = $row_item['RetailPriceM2'];
	$item_TradePricePce = $row_item['TradePricePce'];
	$item_TradePriceM2 = $row_item['TradePriceM2'];
	$item_WebPricePce = $row_item['WebPricePce'];
	$item_WebPriceM2 = $row_item['WebPriceM2'];
	$item_images = $row_item['images'];
	$item_Weight = $row_item['Weight'];
	$item_Unit = $row_item['Unit'];
	$item_QtyAvailable = $row_item['QtyAvailable'];
	$item_PcsM2 = $row_item['PcsM2'];
	$item_PcsBox = $row_item['PcsBox'];
	$item_M2Box = $row_item['M2Box'];
	$item_BoxesPallet = $row_item['BoxesPallet'];
	$item_M2Pallet = $row_item['M2Pallet'];
	$item_Category = $row_item['Category'];
	$item_CategoryDescription = $row_item['CategoryDescription'];
	$item_SupplierCode = $row_item['SupplierCode'];
	$item_SupplierName = $row_item['SupplierName'];
	$item_SuppStock = $row_item['SuppStock'];
	$item_Type = $row_item['Type'];
	$item_Material = $row_item['Material'];
	$item_Size = $row_item['Size'];
	$item_Thickness = $row_item['Thickness'];
	$item_Use = $row_item['Use'];
	$item_Edge = $row_item['Edge'];
	$item_Colour = $row_item['Colour'];
	$item_Surface = $row_item['Surface'];
	$item_Pattern = $row_item['Pattern'];
	$item_RelatedTo = $row_item['RelatedTo'];		
	$item_Heading = $row_item['Heading'];
	$item_SubHeading = $row_item['SubHeading'];
	$item_Country = $row_item['Country'];
	$item_Manufacturer = $row_item['Manufacturer'];
	$item_Notepad2 = $row_item['Notepad2'];
	$item_GstCode = $row_item['GstCode'];
	$item_GstDesc = $row_item['GstDesc'];
	$item_lastupdate = $row_item['lastupdate'];
	$result_relatedto = mysql_query("SELECT * FROM shop_relatedto WHERE Code LIKE '".$item_RelatedTo."' AND is_active='1'");
	if($row_relatedto = mysql_fetch_array($result_relatedto)) { $item_RelatedTo_name = $row_relatedto['Description']; }
	$result_use = mysql_query("SELECT * FROM shop_use WHERE Code LIKE '".$item_Use."' AND is_active='1'");
	if($row_use = mysql_fetch_array($result_use)) { $item_Use = $row_use['Description']; }
	$result_size = mysql_query("SELECT * FROM shop_size WHERE Code LIKE '".$item_Size."' AND is_active='1'");
	if($row_size = mysql_fetch_array($result_size)) { $item_Size = $row_size['Description']; }
	$result_thickness = mysql_query("SELECT * FROM shop_thickness WHERE Code LIKE '".$item_Thickness."' AND is_active='1'");
	if($row_thickness = mysql_fetch_array($result_thickness)) { $item_Thickness = $row_thickness['Description']; }
	$result_colour = mysql_query("SELECT * FROM shop_colour WHERE Code LIKE '".$item_Colour."' AND is_active='1'");
	if($row_colour = mysql_fetch_array($result_colour)) { $item_Colour = $row_colour['Description']; }
	$item_rrp = floatval($item_RetailPricePce);
	$item_buy = floatval($item_WebPricePce);
	if($item_buy<=0){$item_buy=floatval($item_TradePricePce);}
	$item_save = $item_rrp-$item_buy;
	if($item_save<0){$item_buy=0.00;}
	$item_images = unserialize($row_item['images']);
	$images_dir = '../images/items/';
	$image1 = $image1_imgsrc = '';
	$image1 = $images_dir.$item_images[0];
	$is_active = $row_item['is_active'];
		


//add page
if(($_POST['add1']||$_POST['add2']) && !empty($_POST['linkname']) && !empty($_POST['heading'])){
	$metatitle = mysql_real_escape_string(trim($_POST['metatitle']));
	$heading2 = mysql_real_escape_string(trim($_POST['heading2']));
	$heading = mysql_real_escape_string(trim($_POST['heading']));
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
	mysql_query("INSERT INTO content 
	(content_id, under_content_id, ordering, imgsrc, metatitle, heading2, heading, linkname, pageurl, redirecturl, is_multicolumn, 
	body1, body2, is_onmenu, is_hidden, is_active, lastupdated)
	VALUES
	('','".$under_content_id."','99','','".$metatitle."','".$heading2."','".$heading."','".$linkname."','".$pageurl."','".$redirecturl."','".$is_multicolumn."',
	'".$indent_body2."','".$body1."','".$body2."','".$is_onmenu."','".$is_hidden."','1','".$lastupdated."')");

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
		mysql_query("UPDATE content SET pageimage='$imagefile_path_db' WHERE ID='$content_id'");
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
	var editor = CKEDITOR.replace('item_Notepad2',{
	height:"500",
	toolbar:'toolbar1'});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
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
					<input id="cancel1" name="cancel1" type="button" value="&laquo; Cancel, go back" onclick="location.href='products.php';" class="button2" />
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
			<h2>Make changes below. </h2>
			<table width="100%" class="table2">
				<tr>
					<td colspan="4">
						<div class="float_left" style="width:400px;">
							<table width="100%" class="table2">
								<tr>
									<td width="150"><b>Code: </b></td>
									<td><input type="text" class="textfield1" id="Code" name="Code" value="<?php echo $item_Code; ?>" style="font-weight:bold;" /></td>
								</tr>
								<tr>
									<td><b>Desc: </b></td>
									<td><input type="text" class="textfield1" id="Desc" name="Desc" value="<?php echo $item_Desc; ?>" /></td>
								</tr>
								<tr>
									<td><b>RetailPricePce ($): </b></td>
									<td><input type="text" class="textfield1" id="RetailPricePce" name="RetailPricePce" value="<?php echo $item_RetailPricePce; ?>" /></td>
								</tr>
								<tr>
									<td><b>RetailPriceM2 ($): </b></td>
									<td><input type="text" class="textfield1" id="RetailPriceM2" name="RetailPriceM2" value="<?php echo $item_RetailPriceM2; ?>" /></td>
								</tr>
								<tr>
									<td><b>TradePricePce ($): </b></td>
									<td><input type="text" class="textfield1" id="TradePricePce" name="TradePricePce" value="<?php echo $item_TradePricePce; ?>" /></td>
								</tr>
								<tr>
									<td><b>TradePriceM2 ($): </b></td>
									<td><input type="text" class="textfield1" id="TradePriceM2" name="TradePriceM2" value="<?php echo $item_TradePriceM2; ?>" /></td>
								</tr>
								<tr>
									<td><b>WebPricePce ($): </b></td>
									<td><input type="text" class="textfield1" id="WebPricePce" name="WebPricePce" value="<?php echo $item_WebPricePce; ?>" /></td>
								</tr>
							</table>
							<div class="clear"></div>
						</div>
						<div class="float_left" style="width:400px;margin-left:40px;">
							<table width="100%" class="table2">
								<tr>
									<td width="130"><b>Use: </b></td>
									<td><input type="text" class="textfield1" id="Use" name="Use" value="<?php echo $item_Use; ?>" /></td>
								</tr>
								<tr>
									<td><b>Category: </b></td>
									<td><input type="text" class="textfield1" id="Category" name="Category" value="<?php echo $item_Category; ?>" /></td>
								</tr>
								<tr>
									<td><b>CategoryDescription: </b></td>
									<td><input type="text" class="textfield1" id="CategoryDescription" name="CategoryDescription" value="<?php echo $item_CategoryDescription; ?>" /></td>
								</tr>
								<tr>
									<td><b>SupplierCode: </b></td>
									<td><input type="text" class="textfield1" id="SupplierCode" name="SupplierCode" value="<?php echo $item_SupplierCode; ?>" /></td>
								</tr>
								<tr>
									<td><b>SupplierName: </b></td>
									<td><input type="text" class="textfield1" id="SupplierName" name="SupplierName" value="<?php echo $item_SupplierName; ?>" /></td>
								</tr>
								<tr>
									<td><b>SuppStock: </b></td>
									<td><input type="text" class="textfield1" id="SuppStock" name="SuppStock" value="<?php echo $item_SuppStock; ?>" /></td>
								</tr>
								<tr>
									<td><b>RelatedTo: </b></td>
									<td><input type="text" class="textfield1" id="RelatedTo" name="RelatedTo" value="<?php echo $item_RelatedTo; ?>" /></td>
								</tr>
							</table>
							<div class="clear"></div>
						</div>
					</td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td colspan="4">
						<div class="float_left" style="width:400px;">
							<table width="100%" class="table2">
								<tr>
									<td width="150"><b>Weight: </b></td>
									<td><input type="text" class="textfield1" id="Weight" name="Weight" value="<?php echo $item_Weight; ?>" /></td>
								</tr>
								<tr>
									<td><b>Unit: </b></td>
									<td><input type="text" class="textfield1" id="Unit" name="Unit" value="<?php echo $item_Unit; ?>" /></td>
								</tr>
								<tr>
									<td><b>QtyAvailable: </b></td>
									<td><input type="text" class="textfield1" id="QtyAvailable" name="QtyAvailable" value="<?php echo $item_QtyAvailable; ?>" /></td>
								</tr>
								<tr>
									<td><b>PcsM2: </b></td>
									<td><input type="text" class="textfield1" id="PcsM2" name="PcsM2" value="<?php echo $item_PcsM2; ?>" /></td>
								</tr>
								<tr>
									<td><b>PcsBox: </b></td>
									<td><input type="text" class="textfield1" id="PcsBox" name="PcsBox" value="<?php echo $item_PcsBox; ?>" /></td>
								</tr>
								<tr>
									<td><b>M2Box: </b></td>
									<td><input type="text" class="textfield1" id="M2Box" name="M2Box" value="<?php echo $item_M2Box; ?>" /></td>
								</tr>
								<tr>
									<td><b>BoxesPallet: </b></td>
									<td><input type="text" class="textfield1" id="BoxesPallet" name="BoxesPallet" value="<?php echo $item_BoxesPallet; ?>" /></td>
								</tr>
								<tr>
									<td><b>M2Pallet: </b></td>
									<td><input type="text" class="textfield1" id="M2Pallet" name="M2Pallet" value="<?php echo $item_M2Pallet; ?>" /></td>
								</tr>
							</table>
							<div class="clear"></div>
						</div>
						<div class="float_left" style="width:400px;margin-left:40px;">
							<table width="100%" class="table2">
								<tr>
									<td width="130"><b>Type: </b></td>
									<td><input type="text" class="textfield1" id="Type" name="Type" value="<?php echo $item_Type; ?>" /></td>
								</tr>
								<tr>
									<td><b>Material: </b></td>
									<td><input type="text" class="textfield1" id="Material" name="Material" value="<?php echo $item_Material; ?>" /></td>
								</tr>
								<tr>
									<td><b>Size: </b></td>
									<td><input type="text" class="textfield1" id="Size" name="Size" value="<?php echo $item_Size; ?>" /></td>
								</tr>
								<tr>
									<td><b>Thickness: </b></td>
									<td><input type="text" class="textfield1" id="Thickness" name="Thickness" value="<?php echo $item_Thickness; ?>" /></td>
								</tr>
								<tr>
									<td><b>Edge: </b></td>
									<td><input type="text" class="textfield1" id="Edge" name="Edge" value="<?php echo $item_Edge; ?>" /></td>
								</tr>
								<tr>
									<td><b>Colour: </b></td>
									<td><input type="text" class="textfield1" id="Colour" name="Colour" value="<?php echo $item_Colour; ?>" /></td>
								</tr>
								<tr>
									<td><b>Surface: </b></td>
									<td><input type="text" class="textfield1" id="Surface" name="Surface" value="<?php echo $item_Surface; ?>" /></td>
								</tr>
								<tr>
									<td><b>Pattern: </b></td>
									<td><input type="text" class="textfield1" id="Pattern" name="Pattern" value="<?php echo $item_Pattern; ?>" /></td>
								</tr>
							</table>
							<div class="clear"></div>
						</div>
					</td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td colspan="4">
						<div class="float_left" style="width:400px;">
							<table width="100%" class="table2">
								<tr>
									<td width="150"><b>Heading: </b></td>
									<td><input type="text" class="textfield1" id="Heading" name="Heading" value="<?php echo $item_Heading; ?>" /></td>
								</tr>
								<tr>
									<td><b>SubHeading: </b></td>
									<td><input type="text" class="textfield1" id="SubHeading" name="SubHeading" value="<?php echo $item_SubHeading; ?>" /></td>
								</tr>
								<tr>
									<td><b>Country: </b></td>
									<td><input type="text" class="textfield1" id="Country" name="Country" value="<?php echo $item_Country; ?>" /></td>
								</tr>								
							</table>
							<div class="clear"></div>
						</div>
						<div class="float_left" style="width:400px;margin-left:40px;">
							<table width="100%" class="table2">
								<tr>
									<td width="130"><b>Manufacturer: </b></td>
									<td><input type="text" class="textfield1" id="Manufacturer" name="Manufacturer" value="<?php echo $item_Manufacturer; ?>" /></td>
								</tr>
								<tr>
									<td><b>GstCode: </b></td>
									<td><input type="text" class="textfield1" id="GstCode" name="GstCode" value="<?php echo $item_GstCode; ?>" /></td>
								</tr>
								<tr>
									<td><b>GstDesc: </b></td>
									<td><input type="text" class="textfield1" id="GstDesc" name="GstDesc" value="<?php echo $item_GstDesc; ?>" /></td>
								</tr>
							</table>
							<div class="clear"></div>
						</div>
					</td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>
				<tr>
					<td width="150"><b>Item is active: </b></td>
					<td colspan="3"><input type="checkbox" id="is_active" name="is_active" value="1" <?php if($is_active==1){ echo 'checked="checked"';}?> /></td>
				</tr>
				<tr><td colspan="4"><hr/></td></tr>				
				<tr>
					<td colspan="4">
						<div class="greynote" style="display:none;">Column max width: </div>
						<textarea name="item_Notepad2" id="item_Notepad2"><?php echo $item_Notepad2; ?></textarea>
						<script>loadHomeEditor();</script>
					</td>
				</tr>
			</table>		
			<div class="clear" style="margin-top:20px;">
				<hr/>
				<div class="float_left">
					<input id="cancel2" name="cancel2" type="button" value="&laquo; Cancel, go back" onclick="location.href='products.php';" class="button2" />
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