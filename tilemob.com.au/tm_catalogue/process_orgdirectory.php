<?php
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Date: 19/04/07
//Script: Process Organize Directory Files
//Description: 	Auto shuffles all product images in the category page folders. Say if page1 had 15 images, and page2 had 5 images,
//			This script will fill the gap in page1 (requiredAmount of 1 product image) by moving (requiredAmount of 1 product image)	
//			from page2 across to page1. 		
//----------------------------------------------------------------------------------------------------------------------------------------------

error_reporting(0);
//General Variables below ---------------------------------------------------------------------------------------------------------------
$image_folder = $_GET['image_folder']; //Directory path of files
$array_size_limit = 24; //Total number of elements allowed in array
$image_files = array(); //Create an array to hold directory list
$current_page_products = array(); //Create an array to hold current page product images (thumbnails)
$next_page_products = array(); //Create an array to hold next page product images (thumbnails)
$product_limit = 16; //Limit number of product images per gallery page
$pagecount = 0; //The number of page folders in the category, Will be dynamically updated (firstly to 1).
//echo "Directory of Files in " .$directory."\n";
//Function Executions below  -----------------------------------------------------------------------------------------------------------
organizePageDir(); //1. Execute function to auto shuffle-organize  product images for each page directory
cleanDirectory(); //2. Execute function to remove page folders that contain no product images
proceedProcess(); //3. Execute function to proceed to the next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Primary engine(Task-master) for the organization of page folders in category directory (Auto-Shuffles the product images in page folders)
function organizePageDir() {
	global $image_folder, $pagecount, $product_limit, $current_page_products, $next_page_products;

	if (preg_match('/page/i', $image_folder)) {
		$image_folder_root = substr($image_folder, 0, strpos($image_folder, '/page')).'/'; 
		//echo '</br>$image_folder_root is: '.$image_folder_root;
	} else {
		$image_folder_root = $image_folder;
	}
	$image_folder = $image_folder_root;
	
	//In category directory, check all page folders and calculate number of page numbers in that category
	//We need to know whether we want to continue with organizing page directory files or just skip this process
	//if there is only 1 page folder in category directory. 
	if ($handler = @opendir($image_folder_root)) {
		while ($file = @readdir($handler)) {
			if ($file != '..' && $file != "pagelinks.inc" && substr($file, 0, 4) == "page") {
				$pagecount++; //update global pagecount (this is the number of gallery page folders in category directory
			}
		}
	}
	@closedir($handler);	
	//If more than 1 page exists in that folder
	$count = 0; //Reset count to start afresh
	for ($i = 0; $i < $pagecount; $i++) {
		$current_page_dir = $image_folder_root.'page'.($i+1).'/';
		//echo '</br> $current_page_dir is: '.$current_page_dir;
		$next_page_dir = $image_folder_root.'page'.($i+2).'/';
		//echo '</br> $next_page_dir is: '.$next_page_dir;
		//Firstly, we must store all page product images found in the first and subsequent page folders in an array
		$current_page_products = storeDirList($current_page_dir); //Create an array of product images in 1st page folder (also bubble-sorted)
		$next_page_products = storeDirList($next_page_dir); //Create an array of product images in 2nd page folder (also bubble-sorted)
		//Find out if first page has less than 16 product images, if so we fill missing gap with product images from next page
		$requiredAmount = 0; //Reset requiredAmount to start afresh
		if (count($current_page_products) < $product_limit) {
			$requiredAmount = $product_limit - count($current_page_products); //first page requires this amount of products to fill its gap
			//echo '</br> Required Amount: '.$requiredAmount;
			if (is_dir($next_page_dir)) {
				//Shuffle product images - Move product images from next page folder to first page folder
				//shufflePages(arg1, arg2, arg3, arg4, arg5) takes the parameters -  "1. required amount to fill first page", 
				//											"2. destination folder contents",  "3. destination folder path"
				//											"4. source folder contents", "5. source folder path"
				//echo '</br>Proceeding to shuffle...';
				shufflePages($requiredAmount, $current_page_products, $current_page_dir, 
							$next_page_products, $next_page_dir);
			}
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
			//$file_number = substr($file, 2, -4);
			$file_number = str_ireplace('t_', '', $file);
			$file_number = str_ireplace('.jpg', '', $file_number);
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


//Function: Auto shuffles all product images in category for all pages that exist in the category
function shufflePages($this_requiredAmount, $this_destination_contents, $this_destination_dir,
					$this_source_contents, $this_source_dir) {
	
	//Keep copying each product image file from source folder to destination folder until all requiredAmount of product images has been copied over
	for ($i = 0; $i < $this_requiredAmount; $i++) {
		$thumbnail_file_to_move = 't_'.$this_source_contents[$i].'.jpg';
		$display_file_to_move = $this_source_contents[$i].'.jpg';
		//Copy product images from source folder to destination folder - product images in source folder are copied from file number descending order
		@rename($this_source_dir.$thumbnail_file_to_move, $this_destination_dir.$thumbnail_file_to_move);
		//echo '</br> Moving file: '.$this_source_dir.$thumbnail_file_to_move;
		@rename($this_source_dir.$display_file_to_move, $this_destination_dir.$display_file_to_move);
		//echo '</br> Moving file: '.$this_source_dir.$display_file_to_move;
	}	
}


//Function: Goes through all folders in category and cleans the category by removing page folders that contain no product images
function cleanDirectory() {
	global $image_folder, $pagecount;
	
	//echo '</br>Running function cleanDirectory()... ';
	//echo '</br>--------------------------------------------------------------------';
	//If $image_folder is not already root path
	if (preg_match('/page/i', $image_folder)) {
		$image_folder_root = substr($image_folder, 0, strpos($image_folder, '/page')).'/'; 
		//echo '</br>$image_folder_root is: '.$image_folder_root;
	} else { //No change
		$image_folder_root = $image_folder;
		//echo '</br>$image_folder_root is: '.$image_folder_root;
	}
	$image_folder = $image_folder_root;
	
	//Go through each page folder in category and check if it has less than 1 product image
	if ($handler = @opendir($image_folder_root)) {
		while ($root_file = @readdir($handler)) {
			if ($root_file != '..' && $root_file != "pagelinks.inc" && substr($root_file, 0, 4) == "page") {
				if ($fh = @opendir($image_folder_root.$root_file.'/')) { //Access page directory
					//echo '</br>Accessing: '.$image_folder_root.$root_file.'/';
					//Go through all page folder contents and count number of product images
					$count = 0; //Reset $count to start afresh
					while ($file = @readdir($fh)) {
						if ($file != '.' && $file != '..' && substr($file, 0, 2) == "t_") {
							$count++;
						}
					}
					//echo '</br>Accessing: '.$image_folder_root.$root_file.'/ has product count of: '.$count;
					//If this page folder contains no product images, we remove the folder using deleteDirectory()
					if ($count < 1) {
						//echo '</br> Deleting directory: '.$image_folder_root.$root_file.'/';
						deleteDirectory($image_folder_root.$root_file.'/');
					}
				}
			}
		}
	}
	
	//Update $pagecount
	if ($handler = @opendir($image_folder_root)) {
		while ($file = @readdir($handler)) {
			if ($file != '..' && $file != "pagelinks.inc" && substr($file, 0, 4) == "page") {
				$pagecount++; //update global pagecount (this is the number of gallery page folders in category directory
				//This $pagecount data is used to be sent to the next process page. It allows create gallery to create the number of page links
			}
		}
	}
	@closedir($handler);
}


//Function: 
function deleteDirectory($dir_name) {
    if ($handler = @opendir($dir_name)) { //Access directory
		while ($file = @readdir($handler)) { //Go through all files in directory
			if ($file != '.' && $file != '..') { //if $file is a file not a directory folder or parent folder
				//delete every file that exists in that directory
				//echo '</br> Deleting file: '.$dir_name.$file;
				unlink($dir_name.$file);
			}
		}
		//Finally we finish off by deleting that folder directory itself
		//echo '</br> Removing directory: '.$dir_name;
		rmdir($dir_name);
	}
	@closedir($handler);
}


//Function: Count the total number of pages that exist in the category root folder (given directory)
function countTotalPages($this_directory) {	
	if ($handler = @opendir($this_directory)) {
		while ($file = readdir($handler)) {
			if ($file != '..' && $file != "pagelinks.inc" && substr($file, 0, 4) == "page") {
				$pagecount++;
				//echo '</br>'.$pagecount.'. Found page folder: '.$file;
			}
		}
		//echo '</br>----------------------------------------';
		//echo '</br>Total page folders found: '.$pagecount;
		//echo '</br>----------------------------------------';
	}
	return $pagecount;
}


//Function: Redirects to the next step of the process page
function proceedProcess() {
	//Declare global variables
	global $image_folder;
	
	//echo '</br>$image_folder is: '.$image_folder;
	$pagecount = countTotalPages($image_folder); //Count total number of pages in category root folder

	/*echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.location.replace("process_creategallery.php?image_folder='.$image_folder.
			'&pagecount='.$pagecount.'");
		//-->
		</script>';*/
	header('location:process_creategallery.php?image_folder='.$image_folder.'&pagecount='.$pagecount.'&prev='.$_GET['prev']);
}
?>