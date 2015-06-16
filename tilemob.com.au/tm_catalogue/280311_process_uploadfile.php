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

error_reporting(0);
//General Variables below ---------------------------------------------------------------------------------------------------------------
//$image_thumbnail = $_FILES['filefield_thumbnail']; //Filename for upload
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
$image_thumbnail = $_FILES['filefield_thumbnail']['name'];
$image_display = $_FILES['filefield_display']['name'];
$image_code = substr($image_thumbnail, 2, -4); //Image tile reference number code
$image_folder = "gallery/".$_POST['select_imagelocation']."/"; //Folder to upload images to
$write_filename = "photogallery_info.txt"; //Filename to write to
$image_description = $_POST['textarea_description']; //Get description from description textarea
//$pagecount = 0; //Reset pagecount to start afresh
$product_limit = 16; //Limit number of product images per gallery page
//Function Executions below  -----------------------------------------------------------------------------------------------------------
checkFolder(); // 1. Execute function to check page folder for product images
writeDescription(); // 2. Execute function to save description for file
proceedProcess(); // 3. Execute function to proceed to next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Check page folder for number of current product images
function checkFolder() {
	//Declare global variables
	global $image_thumbnail, $image_display, $image_folder, $product_limit;
	
	$image_folder_root = substr($image_folder, 0, strpos($image_folder, '/page')).'/'; 
	$pagecount = countTotalPages($image_folder_root); //Count number of pages in this category root folder, returns with pagecount value
	$file_uploaded = false; //Boolean checker to make sure we only upload the product image once, turned on/off by script
	
	$this_page_folder = $image_folder_root.'page1/'; //This is the page1 folder we want to check
	$check_this_page = array(); //Create an array that will hold product images of the folder we want to check
	$check_this_page = storeDirList($this_page_folder); //Create an array of product images in this page folder
	if (count($check_this_page) < $product_limit) {
			//Upload $image_thumbnail to this folder
			echo '</br>Upload type: Direct upload to first page folder found with less than: '.$product_limit;
			if ($file_uploaded == false) { //Only upload product image if it hasn't already been uploaded before
				uploadFiles($this_page_folder, $image_thumbnail, $image_display); //Upload file
				echo '</br>Commence upload of '.$image_thumbnail.' and '.$image_display.' to folder: '.$this_page_folder;
				$file_uploaded = true; //Boolean checker to make sure we only upload the product image once, turned on/off by script
			}
	}
	
	for ($i = 0; $i < $pagecount; $i++) { //Go through all page folders in this category root folder
		$this_page_folder = $image_folder_root.'page'.($i+1).'/'; //This is the page folder we want to check
		echo '</br>$this_page_folder is: '.$this_page_folder; 
		$next_page_folder = $image_folder_root.'page'.($i+2).'/'; //This is the subsequent page folder (if available)
		echo '</br>$next_page_folder is: '.$next_page_folder;
		$check_this_page = array(); //Create an array that will hold product images of the folder we want to check
		$check_this_page = storeDirList($this_page_folder); //Create an array of product images in this page folder
		
			//Go through all elements in this array and make sure if $image_thumbnail can be placed in this folder, if not go next folder and check
			//Iteration will check the array to see if this array contains a product image with a product reference #value 
			//Remember that this array contains all the products(thumbnails) in this page folder
			for ($j = 0; $j < count($check_this_page); $j++) {
				echo '</br>Upload type: Iteration check, product number comparison';
				$image_number = substr($image_thumbnail, 2, 
								(strpos($image_thumbnail, '.jpg')-1)); //Get only the product's reference number to compare
				echo '</br>$image_number is: '.$image_number;
				if ($image_number > $check_this_page[$j]) { //If product number is higher value than an existing product in that folder
					echo '</br>'.$image_number.' is larger value than: '.$check_this_page[$j];
				
					//Upload $image_thumbnail to this folder
					if ($file_uploaded == false) { //Only upload product image if it hasn't already been uploaded before
						uploadFiles($this_page_folder, $image_thumbnail, $image_display); //Upload file
						echo '</br>Commence upload of '.$image_thumbnail.' and '.$image_display.' 
						to folder: '.$this_page_folder;
						$file_uploaded = true; //Boolean checker to make sure we only upload the product image once, turned on/off by script
						
						//Now move the last element in this page folder to the next page folder 
						$element_to_move = $check_this_page[count($check_this_page)-1]; //Last element
						echo '</br>$element_to_move is: '.$element_to_move;
						echo '</br>count($check_this_page)-1 is: '.(count($check_this_page)-1);
						//First check to see if a next page folder exists
						if (is_dir($next_page_folder)) {
							//If so, move the last element in this page folder to the next page folder
							@rename($this_page_folder.'t_'.$element_to_move.'.jpg', 
							$next_page_folder.'t_'.$element_to_move.'.jpg'); //Move Thumbnail
							echo '</br> Moving file: '.$this_page_folder.'t_'.$element_to_move.'.jpg';
							@rename($this_page_folder.$element_to_move.'.jpg', 
							$next_page_folder.$element_to_move.'.jpg'); //Move Display
							echo '</br> Moving file: '.$this_page_folder.$element_to_move.'.jpg';
						} else {
							//Create it, and then move the last element in this page folder to the next page folder
							mkdir($next_page_folder, 0777);
							echo '</br>Creating a new page folder: '.$next_page_folder;
							global $server_dir_main;
							echo '</br>---------------------------------------------------------';
							copy($this_page_folder.'index.php', $next_page_folder.'index.php');
							echo '</br> Copying file: '.$next_page_folder.'index.php';
							chmod($next_page_folder.'index.php', 0777);
							copy($this_page_folder.'iframe_display_info.php', $next_page_folder.
							'iframe_display_info.php');
							echo '</br> Copying file: '.$next_page_folder.'iframe_display_info.php';
							chmod($next_page_folder.'iframe_display_info.php', 0777);
							copy($this_page_folder.'iframe_display.php', $next_page_folder.'iframe_display.php');
							echo '</br> Copying file: '.$next_page_folder.'iframe_display.php';
							chmod($next_page_folder.'iframe_display.php', 0777);
							copy($this_page_folder.'photogallery_info.txt', $next_page_folder.'photogallery_info.txt');
							echo '</br> Copying file: '.$next_page_folder.'photogallery_info.php';
							chmod($next_page_folder.'photogallery_info.txt', 0777);
							echo '</br>---------------------------------------------------------';
							//move the last element in this page folder to the next page folder
							@rename($this_page_folder.'t_'.$element_to_move.'.jpg', 
							$next_page_folder.'t_'.$element_to_move.'.jpg'); //Move Thumbnail
							echo '</br> Moving file: '.$this_page_folder.'t_'.$element_to_move.'.jpg';
							@rename($this_page_folder.$element_to_move.'.jpg', 
							$next_page_folder.$element_to_move.'.jpg'); //Move Display
							echo '</br> Moving file: '.$this_page_folder.$element_to_move.'.jpg';
						}
					}					
				}			
			}
	}
	//Finally if the image_number cannot be placed in any of the cycled through page folders in category root folder, this means that this
	//image_number is the lowest ranking file in the category root folder. We must put this product image into the last page folder.
	//If this last page folder does not already exist (because the previous folders are full on product images), we must create it.	
	if ($file_uploaded == false) { //Only upload product image if it hasn't already been uploaded before
		echo '</br>Upload type: Upload to newest page number, product number is the lowest ranking';
		if (is_dir($next_page_folder)) { //If the next page folder already exists, then just upload the thumbnail/display to the next page folder		
			uploadFiles($next_page_folder, $image_thumbnail, $image_display); //Upload file
			echo '</br>Commence upload of '.$image_thumbnail.' and '.$image_display.' 
			to folder: '.$next_page_folder;
			$file_uploaded = true; //Boolean checker to make sure we only upload the product image once, turned on/off by script
			//If the next page folder DOES NOT already exists, then we must create the page folder plus move all neccessary files 
			//from previous folder (make copies) and then upload the thumbnail/display to the next page folder
		} else {
			mkdir($next_page_folder, 0777);
			echo '</br>Creating a new page folder: '.$next_page_folder;
			global $server_dir_main;
			echo '</br>---------------------------------------------------------';
			copy($this_page_folder.'index.php', $next_page_folder.'index.php');
			echo '</br> Copying file: '.$next_page_folder.'index.php';
			chmod($next_page_folder.'index.php', 0777);
			copy($this_page_folder.'iframe_display_info.php', $next_page_folder.'iframe_display_info.php');
			echo '</br> Copying file: '.$next_page_folder.'iframe_display_info.php';
			chmod($next_page_folder.'iframe_display_info.php', 0777);
			copy($this_page_folder.'iframe_display.php', $next_page_folder.'iframe_display.php');
			echo '</br> Copying file: '.$next_page_folder.'iframe_display.php';
			chmod($next_page_folder.'iframe_display.php', 0777);
			copy($this_page_folder.'photogallery_info.txt', $next_page_folder.'photogallery_info.txt');
			echo '</br> Copying file: '.$next_page_folder.'photogallery_info.php';
			chmod($next_page_folder.'photogallery_info.txt', 0777);
			echo '</br>---------------------------------------------------------';
			//Uploading thumbnail + display image to the newly created folder
			uploadFiles($next_page_folder, $image_thumbnail, $image_display); //Upload file
			echo '</br>Commence upload of '.$image_thumbnail.' and '.$image_display.' 
			to folder: '.$next_page_folder;
			$file_uploaded = true; //Boolean checker to make sure we only upload the product image once, turned on/off by script
		}
	}
}


//Function: Stores selected product image files from given folder directory into an array
function storeDirList($store_this_dir) {
	$dirList = array(); //Create an array to store these product images
	$handler = @opendir($store_this_dir);
    // keep going until all files in directory have been read
    while ($file = @readdir($handler)) {
        if ($file != '.' && $file != '..' && substr($file, 0, 2) == "t_") {
			//Substring filename to take only reference number of product image
			$file_number = substr($file, 2, -4);
            $dirList[] = $file_number;
			//echo '</br>$file_number is: '.$file_number;
		}
    }
    // tidy up: close the handler
    @closedir($handler);
	//Do the final good deed by Bubble-sorting the populated array of products as well
	$dirList_sorted = array();
	$dirList_sorted = bubbleSort($dirList);
	//Now we can return the array back to the task-master
	return $dirList_sorted;
}


//Function: Bubble sorts the array in descending order - Task-master is primarily storeDirList()
function bubbleSort($sort_this_array) {
    $temp = "";
    $size = count($sort_this_array);
    for($i = 0; $i < $size-1; $i++) {
         for($j = 0; $j < $size - 1 - $i; $j++) {
              if($sort_this_array[$j+1] > $sort_this_array[$j]) {
                   $temp = $sort_this_array[$j];
                   $sort_this_array[$j] = $sort_this_array[$j+1];
                   $sort_this_array[$j+1] = $temp;
              }
			  //echo "".$sort_this_array[$i]."\n";
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
function uploadFiles($image_folder, $image_thumbnail, $image_display) {	
	//Upload Thumbnail image
	if ($_FILES["filefield_thumbnail"]["error"] > 0) {
		//echo "Error: " . $_FILES["filefield_thumbnail"]["error"] . "<br />";
	} else {
		//echo "Upload: " . $image_thumbnail . "<br />";
		//echo "Type: " . $_FILES["filefield_thumbnail"]["type"] . "<br />";
		//echo "Size: " . ($_FILES["filefield_thumbnail"]["size"] / 1024) . " Kb<br />";
		//echo "Stored in: " . $_FILES["filefield_thumbnail"]["tmp_name"];
	  
		move_uploaded_file($_FILES["filefield_thumbnail"]["tmp_name"],
		$image_folder . $image_thumbnail);
		//echo "\nStored in: " . $image_folder . $image_thumbnail;
	}
	
	//Upload Display image
	if ($_FILES["filefield_display"]["error"] > 0) {
		//echo "Error: " . $_FILES["filefield_display"]["error"] . "<br />";
	} else {
		//echo "Upload: " . $image_display . "<br />";
		//echo "Type: " . $_FILES["filefield_display"]["type"] . "<br />";
		//echo "Size: " . ($_FILES["filefield_display"]["size"] / 1024) . " Kb<br />";
		//echo "Stored in: " . $_FILES["filefield_display"]["tmp_name"];
	  
		move_uploaded_file($_FILES["filefield_display"]["tmp_name"],
		$image_folder . $image_display);
		//echo "\nStored in: " . $image_folder . $image_display;
	}
}


//Function: writes the description for the file in a text file
function writeDescription() {
	//Declare global variables
	global $image_code;
	global $image_folder;
	global $image_description;
	global $write_filename;
	global $image_folder;
	
	$image_code_exist = "no";
	
	//Check to see if description for that image code already exists in file
	//If it does, then we replace that line with new image_description
	//If it doesn't, just use the existing description for image_code
	$readFile = $image_folder.$write_filename; //read file
	$fh = fopen($readFile, 'r');
	while (!feof($fh)) { // Go through each line in file
		$currentLine = fgets($fh);
		$line_image_code = substr($currentLine, 0, 5); //Get image code of that line
		if ($currentLine != "") {
			if ($line_image_code == $image_code) { //If image_code exists in file, replace it
				$stringData .= $image_code. " " .rtrim($image_description)."\r\n";
				$image_code_exist = "yes";
			} else {
				$stringData .= rtrim($currentLine)."\r\n"; //No replacement required for line
			}
		}
	}
	
	if ($image_code_exist == "no") {
		$stringData .= $image_code. " " .rtrim($image_description)."\r\n";
	}
	
	//Write description to file
	$writeFile = $image_folder.$write_filename;
	echo '$writeFile: '.$writeFile;
	$fh = fopen($writeFile, 'w') or die("can't open file");
	//$stringData .= "\r\n".$image_code." ".$image_description;
	fwrite($fh, $stringData);
	fclose($fh);
	
	//echo "\nWriting to file: " .$write_filename;
	//echo "\nWriting: ".$stringData;	
}


//Function: Count the total number of pages that exist in the category root folder (given directory)
function countTotalPages($this_directory) {	
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
	//Declare global variables
	global $image_folder;
	
	$image_folder_root = "gallery/".$_POST['select_imagelocation']."/";
	$image_folder_root = substr($image_folder_root, 0, strpos($image_folder_root, '/page')).'/'; 
	$pagecount = countTotalPages($image_folder_root);

	if ($pagecount > 1) {
		//Redirect to process image to organize directory in array and then create gallery
		//Organize directory process page does not require the page count because it performs it's own page count to organize pages in category root directory
		echo '<script language="Javascript" type="text/javascript">
			<!--
				parent.location.replace("process_orgdirectory.php?image_folder='; 
				echo $image_folder_root; echo '");
			//-->
			</script>';
	} else {
		//Redirect to process image to store directory in array and then create gallery
		echo '<script language="Javascript" type="text/javascript">
			<!--
				parent.location.replace("process_storedirectory.php?image_folder='; 
				echo $image_folder; echo '&pagecount='.$pagecount.'");
			//-->
			</script>';
	}
}
?>