<?php
//error_reporting(0);
//General Variables below ---------------------------------------------------------------------------------------------------------------
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
$write_filename = "photogallery_info.txt"; //Filename to write to
$pagecount = 0; //Reset pagecount to start afresh
$product_limit = 16; //Limit number of product images per gallery page
if(!empty($_POST['select_imagelocation'])){
	$image_folder = 'gallery/'.trim($_POST['select_imagelocation']);
} else if(!empty($_GET['select_imagelocation'])) {
	$image_folder = 'gallery/'.trim($_GET['select_imagelocation']);	
}

if(!empty($_GET['prev'])) {
	$prev = $_GET['prev'];
} else {
	$prev = 'regenerate.php';
}
//Function Executions below  -----------------------------------------------------------------------------------------------------------
checkFolder(); // 1. Execute function to check page folder for product images
proceedProcess(); // 3. Execute function to proceed to next step of the process


//Function: Check page folder for number of current product images
function checkFolder() {
	//Declare global variables
	global $image_code, $image_display, $image_description, $image_folder, $product_limit, $write_filename, $pagecount;
	
	$image_folder_root = substr($image_folder, 0, strpos($image_folder, '/page')).'/'; 
	$this_page_folder = $image_folder_root.'page1/'; //This is the page1 folder we want to check
	$pagecount = countTotalPages($image_folder_root); //Count number of pages in this category root folder, returns with pagecount value
	echo '<br/>pagecount: '.$pagecount;
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
			//echo '</br>old_page_folder: '.$old_page_folder;
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


//Function: Count total pages in category root folder
function countTotalPages($this_directory) {
	$pagecount = 0;
	if ($handler = @opendir($this_directory)) {
		while ($file = readdir($handler)) {
			if ($file != '..' && $file != "pagelinks.inc" && substr($file, 0, 4) == "page") {
				$pagecount++;
				//echo '</br>'.$pagecount.'. Found page folder: '.$file;
			}
		}
		echo '</br>----------------------------------------';
		echo '</br>Total page folders found: '.$pagecount;
		echo '</br>----------------------------------------';
	}
	return $pagecount;
}

/*if(!empty($image_folder)) {
	$image_folder_root = "gallery/".$image_folder."/";	
	$image_folder_root = substr($image_folder_root, 0, strpos($image_folder_root, '/page')).'/'; 
	
	if(is_dir($image_folder_root)) {
		$pagecount = countTotalPages($image_folder_root);
		if ($pagecount > 1) {
			//Redirect to process image to organize directory in array and then create gallery
			//Organize directory process page does not require the page count because it performs it's own page count to organize pages in category root directory
			//echo 'image_folder_root: '.$image_folder_root;
			header('location:process_orgdirectory.php?image_folder='.$image_folder_root.'&prev='.$prev);
		} else {			
			//Redirect to process image to store directory in array and then create gallery
			//echo 'image_folder: '.$image_folder;
			header('location:process_storedirectory.php?image_folder='.$image_folder.'&pagecount='.$pagecount.'&prev='.$prev);
		}
	}
} else {
	header('location:regenerate.php');
}*/

//Function:  Proceed to next step of the process with page redirect
function proceedProcess() {
	global $image_folder, $pagecount;	
	$image_folder_root = str_replace('page1','',$image_folder);	
	//header('location:regenerate_gallery.php?select_imagelocation='.$image_folder_root.'&prev=add_image.php');
	echo '<script>self.location="process_creategallery.php?image_folder='.$image_folder_root.'&pagecount='.$pagecount.'&prev='.$_GET['prev'].'";</script>';
	//echo '</br>image_folder='.$image_folder_root.'&pagecount='.$pagecount.'';
}
?>