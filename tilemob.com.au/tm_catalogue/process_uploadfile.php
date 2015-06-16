<?php
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Start Date: 22/03/07
//Script: 
//Description: Upload file process handles the adding of new product images into the given category. It correctly
//		uploads files in correct page folders and also 
//----------------------------------------------------------------------------------------------------------------------------------------------

//error_reporting(0);
//General Variables below ---------------------------------------------------------------------------------------------------------------
//$image_thumbnail = $_FILES['filefield_thumbnail']; //Filename for upload
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
//$image_thumbnail = $_FILES['filefield_thumbnail']['name'];
$image_display = $_FILES['filefield_display']['name'];
//$image_code = substr($image_thumbnail, 2, -4); //Image tile reference number code
$image_code = substr($image_display, 0, -4); //Image tile reference number code
$image_folder = "gallery/".$_POST['select_imagelocation']."/"; //Folder to upload images to
$write_filename = "photogallery_info.txt"; //Filename to write to
$image_description = $_POST['textarea_description']; //Get description from description textarea
$pagecount = 0; //Reset pagecount to start afresh
$product_limit = 16; //Limit number of product images per gallery page
//Function Executions below  -----------------------------------------------------------------------------------------------------------
checkFolder(); // 1. Execute function to check page folder for product images
//writeDescription(); // 2. Execute function to save description for file
proceedProcess(); // 3. Execute function to proceed to next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Check page folder for number of current product images
function checkFolder() {
	//Declare global variables
	global $image_code, $image_display, $image_description, $image_folder, $product_limit, $write_filename, $pagecount;
	
	$image_folder_root = substr($image_folder, 0, strpos($image_folder, '/page')).'/'; 
	$this_page_folder = $image_folder_root.'page1/'; //This is the page1 folder we want to check
	$pagecount = countTotalPages($image_folder_root); //Count number of pages in this category root folder, returns with pagecount value
	
	//upload thumbnail to first page (temporarily)
	if(uploadFiles($this_page_folder, $image_display)) {
		//write description
		if(!empty($image_description)) {
			$image_code_exist = $stringData = '';
			$readFile = $this_page_folder.$write_filename; //read file
			if(is_file($readFile)) {
				$fh = fopen($readFile, 'r');
				while (!feof($fh)) { // Go through each line in file
					$currentLine = fgets($fh);
					//$line_image_code = substr($currentLine, 0, 5); //Get image code of that line
					$line_image_code = substr($currentLine, 0, strpos($currentLine, ' ')); //Get image code of that line
					if ($currentLine != "") {
						if ($line_image_code == $image_code) { //If image_code exists in file, replace it
							$stringData .= trim($image_code).' '.trim($image_description)."\r\n";
							$image_code_exist = "yes";
						} else {
							$stringData .= trim($currentLine)."\r\n"; //No replacement required for line
						}
					}
				}
				if ($image_code_exist != 'yes') {
					$stringData .= $image_code.' '.trim($image_description)."\r\n";
				}
				//Write description to file
				$writeFile = $image_folder.$write_filename;
				//echo '$writeFile: '.$writeFile;
				$fh = fopen($writeFile, 'w') or die("can't open file");
				//$stringData .= "\r\n".$image_code." ".$image_description;
				fwrite($fh, $stringData);
				fclose($fh);
			}
		}
		//collect tiles
		$alltiles = array();
		for ($i = 0; $i < $pagecount; $i++) { //Go through all page folders in this category folder
			$this_page_folder = $image_folder_root.'page'.($i+1).'/'; //This is the page folder we want to check
			echo '</br>$this_page_folder is: '.$this_page_folder; 
			 //Create an array that will hold product images of the folder we want to check
			$alltiles = array_merge($alltiles, storeDirList($this_page_folder));		
		}
		//sort tiles
		$alltiles_sorted = array();
		if(!empty($alltiles)) {
			$alltiles_sorted = bubbleSort($alltiles);			
		}		
		//move tiles
		if(!empty($alltiles_sorted)) {
			$count = 1;
			$page = 1;
			foreach($alltiles_sorted as $key => $value) { //value is thumbnail filepath				
				if($count > $product_limit) {
					$count = 1; //reset
					$page++; //next page
				}
				$old_page_folder = substr($value, 0, stripos($value, basename($value)));
				$this_page_folder = $image_folder_root.'page'.$page.'/';
				$thumb_newpath = $this_page_folder.basename($value);
				$display_newpath = str_replace('/t_','/',$thumb_newpath);
				if(!is_dir($this_page_folder)){
					mkdir($this_page_folder, 0777);
					copyTemplateFiles($this_page_folder);
				}
				if($value!=$thumb_newpath) {
					rename($value, $thumb_newpath); //thumbnail
					echo '</br>moving: '.$value.' to: '.$thumb_newpath;
				}
				if(str_replace('/t_','/',$value)!=$display_newpath) {
					rename(str_replace('/t_','/',$value), $display_newpath); //display
				}
				//copy description text
				$image_code_exist = $stringData = '';
				$readFile = $old_page_folder.$write_filename; //read file
				$fh = fopen($readFile, 'r');
				while (!feof($fh)) { // Go through each line in file
					$currentLine = fgets($fh);
					$line_image_code = substr($currentLine, 0, strpos($currentLine, ' ')); //Get image code of that line
					if (!empty($currentLine) && trim($currentLine)!="\r\n") {
						if ($line_image_code == $image_code) { //If image_code exists in file, replace it
							$stringData .= $image_code.' '.trim($image_description)."\r\n";
							$image_code_exist = 'yes';
						} else {
							$stringData .= trim($currentLine)."\r\n"; //No replacement required for line
						}
					}
				}
				if ($image_code_exist != 'yes') {
					$stringData .= $image_code.' '.trim($image_description)."\r\n";
				}				
				//Write description to file
				$writeFile = $this_page_folder.$write_filename;
				$fh = fopen($writeFile, 'w') or die("can't open file");
				fwrite($fh, $stringData);
				fclose($fh);
				$count++;
			}
			$pagecount = $page;
		}
	}
}


//Function: Stores selected product image files from given folder directory into an array
function storeDirList($store_this_dir) {
	$dirList = array(); //Create an array to store these product images
	$handler = @opendir($store_this_dir);
    // keep going until all files in directory have been read
    while ($file = @readdir($handler)) {
        if ($file != '.' && $file != '..' && substr($file, 0, 2) == 't_') {
			//Substring filename to take only reference number of product image
			$file_number = substr($file, 2, -4);
            $dirList[] = $store_this_dir.'t_'.$file_number.'.jpg';
		}
    }
    // tidy up: close the handler
    @closedir($handler);
	/*//Do the final good deed by Bubble-sorting the populated array of products as well
	$dirList_sorted = array();
	if(!empty($dirList)) {
		$dirList_sorted = bubbleSort($dirList);
		foreach($dirList_sorted as $key => $value) {
			$dirList_sorted[$key] = $store_this_dir.'t_'.$value.'.jpg';
			echo '</br>found: '.$store_this_dir.'t_'.$value.'.jpg';
		}
	}
	//Now we can return the array back to the task-master
	return $dirList_sorted;*/
	return $dirList;
}


function copyTemplateFiles($this_dir) {
	//copy mandatory files to page directory
	if(copy('template/index.php', $this_dir.'index.php')){
		chmod($this_dir.'index.php', 0777);
	}
	if(copy('template/iframe_display_info.php', $this_dir.'iframe_display_info.php')){
		chmod($this_dir.'iframe_display_info.php', 0777);
	}
	if(copy('template/iframe_display.php', $this_dir.'iframe_display.php')){
		chmod($this_dir.'iframe_display.php', 0777);
	}
	if(copy('template/photogallery_info.txt', $this_dir.'photogallery_info.txt')){
		chmod($this_dir.'photogallery_info.txt', 0777);
	}
}


//Function: Bubble sorts the array in descending order - Task-master is primarily storeDirList()
function bubbleSort($sort_this_array) {
	$temp = '';
	$size = count($sort_this_array);
	$remove_these = array('t_','.jpg');
	for($i = 0; $i < $size-1; $i++) {
		for($j = 0; $j < $size - 1 - $i; $j++) {
			$current_tilenumber = str_replace($remove_these,'',basename($sort_this_array[$j]));
			$next_tilenumber = str_replace($remove_these,'',basename($sort_this_array[$j+1]));
			if(floatval($next_tilenumber) > floatval($current_tilenumber)) {
				echo '<br/>'.$next_tilenumber.' > '.$current_tilenumber;
				$temp = $sort_this_array[$j];
				$sort_this_array[$j] = $sort_this_array[$j+1];
				$sort_this_array[$j+1] = $temp;
			}
			//echo '</br>'.$sort_this_array[$i];
		}
	}
	return $sort_this_array;
}


//Function: Counts the number of product images in a given image_folder 
function countFiles($this_image_folder) {
	$count = 0; //Reset count to start afresh
	//Open up upload directory - category page1 folder and then count the
	//number of existing product images in page1 folder of given category.
	//Check given $image_folder directory, if it exists, count the files
	if ($handler = @opendir($this_image_folder)) {
		while ($file = readdir($handler)) {
			if ($file != '.' && $file != '..' && substr($file, 0, 2) == "t_") {
				$count++;
			}
		}
	global $image_folder;
	$image_folder = $this_image_folder;
	echo '</br>$image_folder is: '.$image_folder;
		
	//if it doesn't, create it and count the files.
	} else {
		//Firstly create the new folder and populate with required files
		$first_image_folder = substr($this_image_folder, 0, strpos($this_image_folder, '/page'))."/page1/";
		//$image_folder = substr($image_folder, 0, count($image_folder)-3).$folder_number."/";
		mkdir($this_image_folder, 0777);
		echo '</br>Creating a new page folder: '.$this_image_folder;
		global $server_dir_main;
		echo '</br>---------------------------------------------------------';
		copy($first_image_folder.'index.php', $this_image_folder.'index.php');
		echo '</br> Copying file: '.$this_image_folder.'index.php';
		chmod($this_image_folder.'index.php', 0777);
		copy($first_image_folder.'iframe_display_info.php', $this_image_folder.'iframe_display_info.php');
		echo '</br> Copying file: '.$this_image_folder.'iframe_display_info.php';
		chmod($this_image_folder.'iframe_display_info.php', 0777);
		copy($first_image_folder.'iframe_display.php', $this_image_folder.'iframe_display.php');
		echo '</br> Copying file: '.$this_image_folder.'iframe_display.php';
		chmod($this_image_folder.'iframe_display.php', 0777);
		copy($first_image_folder.'photogallery_info.txt', $this_image_folder.'photogallery_info.txt');
		echo '</br> Copying file: '.$this_image_folder.'photogallery_info.php';
		chmod($this_image_folder.'photogallery_info.txt', 0777);
		echo '</br>---------------------------------------------------------';
		global $image_folder;
		$image_folder = $this_image_folder;
		echo '</br>$image_folder is: '.$image_folder;
		//Now count the files
		$handler = opendir($this_image_folder);
		while ($file = readdir($handler)) {
			if ($file != '.' && $file != '..' && substr($file, 0, 2) == "t_") {
				$count++;
			}
		}
	}
	closedir($handler);
	return $count;
}


//Function:  Uploads file to the server folder
function uploadFiles($image_folder, $image_display) {	
	//Upload Display image
	if ($_FILES["filefield_display"]["error"] > 0) {
		//echo "Error: " . $_FILES["filefield_display"]["error"] . "<br />";
		return false;
	} else {
		echo "Upload: " . $image_display . "<br />";
		echo "Type: " . $_FILES["filefield_display"]["type"] . "<br />";
		echo "Size: " . ($_FILES["filefield_display"]["size"] / 1024) . " Kb<br />";
		echo "Stored in: " . $_FILES["filefield_display"]["tmp_name"];
	  
		if(move_uploaded_file($_FILES["filefield_display"]["tmp_name"], $image_folder.$image_display)){
			//resize display, so it is not larger than 290px
			resizeDisplay($image_folder.$image_display);
			//create thumbnail version
			$imagefile_filename = 't_'.$image_display;
			if(copy($image_folder.$image_display, $image_folder.$imagefile_filename)){
				createThumbnail($image_folder, $imagefile_filename, 70);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		//echo "\nStored in: " . $image_folder . $image_display;
	}
}

function resizeDisplay($imagesrc) {
	if(is_file($imagesrc)) {
		list($width, $height, $type, $attr) = getimagesize($imagesrc);
		if($width > 290 || $height > 290) { 
			$new_width = $new_height = 0;
			/*
			if($width > $height) { //landscape, reduce width to 290	
				$new_width = 290;
				$new_height = (290/$width)*$height;
			} else if ($height > $width) { //portrait, reduce height to 290
				$new_height = 290;
				$new_width = (290/$height)*$width;
			} else if ($height == $width) { //square, reduce both to 290
				$new_width = 290;
				$new_height = 290;
			}*/
			//make smallest size 290, the other side will keep to aspect ratio
			if($width < $height) {
				$new_width = 290;
				$new_height = (290/$width)*$height;
			} else if ($height < $width) {
				$new_height = 290;
				$new_width = (290/$height)*$width;
			} else if ($height == $width) { //square, reduce both to 290
				$new_width = 290;
				$new_height = 290;
			}
			if($new_width != 0 || $new_height != 0) {
				createImage($imagesrc, $new_width, $new_height); //resize it
			}
		}
	}
}

function createThumbnail($imagedir_path, $imagefile_filename, $size) {
	$imagesrc = $imagedir_path.$imagefile_filename;
	list($width, $height, $type, $attr) = getimagesize($imagesrc);	
	if($width > 70 || $height > 70) {
		$new_width = $new_height = 0;
		/*if($width > $height) { //landscape, reduce width to 70	
			$new_width = 70;
			$new_height = (70/$width)*$height;
		} else if ($height > $width) { //portrait, reduce height to 70
			$new_height = 70;
			$new_width = (70/$height)*$width;
		} else if ($height == $width) { //square, reduce both to 70
			$new_width = 70;
			$new_height = 70;
		}*/
		//make smallest size 70, the other side will keep to aspect ratio
		if($width < $height) {
			$new_width = 70;
			$new_height = (70/$width)*$height;
		} else if ($height < $width) {
			$new_height = 70;
			$new_width = (70/$height)*$width;
		} else if ($height == $width) { //square, reduce both to 70
			$new_width = 70;
			$new_height = 70;
		}
		if($new_width != 0 || $new_height != 0) {
			createImage($imagesrc, $new_width, $new_height); //resize it
			//echo 'resizing '.$imagefile_path_thumb.' to '.$newWidth.' x '.$newHeight.'<br/>';
		}
	}	
}

function createImage($imgsrc, $newWidth, $newHeight) {
	list($curWidth, $curHeight, $imageType) = getimagesize($imgsrc);
	$smallest_side = ($newWidth > $newHeight) ? $newHeight : $newWidth;
	
	switch ($imageType) {
		case 1: $src = imagecreatefromgif($imgsrc); break;
		case 2: $src = imagecreatefromjpeg($imgsrc); break;
		case 3: $src = imagecreatefrompng($imgsrc); break;
		default: echo '';  break;
	}
	
	//$tmp = imagecreatetruecolor($newWidth, $newHeight);
	$tmp = imagecreatetruecolor($smallest_side, $smallest_side);
	imageantialias($tmp, true); //add antialiasing
	//$src = imagecreatefromjpeg($imgsrc); 
	//Check if this image is PNG or GIF to preserve its transparency
	if(($imageType == 1) OR ($imageType == 3)) {
		imagealphablending($tmp, false);
		imagesavealpha($tmp,true);
		$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
		//imagefilledrectangle($tmp, 0, 0, $newWidth, $newHeight, $transparent);
		/*if($smallest_side == 70) {
			imagefilledrectangle($tmp, 0, 0, $smallest_side, $smallest_side, $transparent);
		} else{
			imagefilledrectangle($tmp, 0, 0, $newWidth, $newHeight, $transparent);
		}*/
		imagefilledrectangle($tmp, 0, 0, $smallest_side, $smallest_side, $transparent);
	}
	
	/*//find the x and y destination point (we want to crop to the center of the image)
	$src_x = ceil(($curWidth-$newWidth)/2);
	$src_y = ceil(($curHeight-$newHeight)/2);
	if($src_x<0){$src_x=0;}
	if($src_y<0){$src_y=0;}*/
	
	//imagecopyresized(resource $dst_image, resource $src_image, int $dst_x, int $dst_y, int $src_x, int $src_y, int $dst_w, int $dst_h, int $src_w, int $src_h)
	//imagecopyresampled($tmp, $src, 0, 0, $src_x, $src_y, $newWidth, $newHeight, $curWidth, $curHeight); //crop using above values
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $smallest_side, $smallest_side, $curWidth, $curHeight); 
	//imagecopyresized($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $curWidth, $curHeight);
	
	switch ($imageType) {
		case 1: imagegif($tmp); break;
		case 2: imagejpeg($tmp, $imgsrc, 100); break; // best quality
		case 3: imagepng($tmp, $imgsrc, 0); break; // no compression
		default: echo ''; break;
	}
}


//Function: Count the total number of pages that exist in the category root folder (given directory)
function countTotalPages($this_directory) {
	$pagecount = 0;
	if ($handler = @opendir($this_directory)) {
		while ($file = readdir($handler)) {
			if ($file != '..' && $file != "pagelinks.inc" && substr($file, 0, 4) == "page") {
				$pagecount++;
				echo '</br>'.$pagecount.'. Found page folder: '.$file;
			}
		}
		echo '</br>----------------------------------------';
		echo '</br>Total page folders found: '.$pagecount;
		echo '</br>----------------------------------------';
	}
	return $pagecount;
}


//Function:  Proceed to next step of the process with page redirect
function proceedProcess() {
	global $image_folder, $pagecount;	
	$image_folder_root = 'gallery/'.str_replace('page1','',$_POST['select_imagelocation']);	
	//header('location:regenerate_gallery.php?select_imagelocation='.$image_folder_root.'&prev=add_image.php');
	echo '<script>self.location="process_creategallery.php?image_folder='.$image_folder_root.'&pagecount='.$pagecount.'&prev=add_image.php";</script>';
	//echo '</br>image_folder='.$image_folder_root.'&pagecount='.$pagecount.'';
}
?>