<?
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Start Date: 21/03/07, 22/03/07, 23/03/07
//Script: Process Create Gallery Page
//Description: 	This script uses the array from process_storedirectory.php and generates a gallery page
//			that contains a 5 x 5 grid of thumbnails (25 total images) per page. The newly created 
//			page will be saved as .inc file extension so it can be read/edited by fckeditor. 
//----------------------------------------------------------------------------------------------------------------------------------------------

error_reporting(0);
//General Variables below ---------------------------------------------------------------------------------------------------------------
$server_url_this = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/")+1); //Server directory address where this file resides
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
$image_folder = $_GET['image_folder']; //Folder to open/read (Make this dynamic from $_GET)
$image_folder_root = substr($image_folder, 0, strpos($image_folder, '/page')).'/'; 
$read_filename = "photogallery_info.txt"; //Filename to read from
$image_description = "";
$gallery_data = "";
$generate_file = "gallery.inc"; //Generates a file with gallery contents
$images_array = array();
//$images_array = unserialize(base64_decode($_GET['serialized_array']));
$pagecount = $_GET['pagecount']; //Number of pages in category root folder
//Table properties below -----------------------------------------------------------------------------------------------------------------
$td_main_width = '"width="370"';
$td_border = 'border="0"';
$td_align = 'align="left"';
$td_cellspacing = 'cellspacing="10"';
$td_cellpadding = 'cellpadding="0"';
//Function Executions below  -----------------------------------------------------------------------------------------------------------
createGalleryType(); // 1. Execute function to create gallery page type
proceedProcess(); //2. Execute function to proceed to next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Determine whether to create a multi-page gallery with bottom page navigation links or a single-page gallery without bottom page navigation links
function createGalleryType() {
	global $pagecount, $image_folder;
	
	if ($pagecount > 1) {
		//echo '</br>Create Multi-Gallery...';
		createMultiGallery($image_folder);
	} else {
		//echo '</br>Create Single-Gallery...';
		createSingleGallery();
	}
}


//Function: Creates a gallery page by dynamically generating HTML code
function createSingleGallery() {
	//Declare global variables
	global $gallery_data, $images_array, $read_filename, $image_folder,
	$image_description, $td_main_width, $td_border, $td_align,
	$td_cellspacing, $td_cellpadding, $server_url_this, $server_dir_main;
	
	if (preg_match('/page/i', $image_folder)) {
		$current_page_dir = $image_folder;
		//echo '</br> $current_page_dir is: '.$current_page_dir;
	} else {
		$current_page_dir = $image_folder.'page1/';
		//echo '</br> $current_page_dir is: '.$current_page_dir;
	}
		
	//Firstly, we must store all page product images found in the first and subsequent page folders in an array
	$images_array = storeDirList($current_page_dir); //Create an array of product images in 1st page folder (also bubble-sorted)	
	
	$array_index = 0; //Start from first element in array
	$row_amount = 4; // Number of rows in table
	$col_amount = 4; // Number of columns in table
	
	$gallery_data .= '<table "'.$td_main_width.$td_border.$td_align.$td_cellspacing.$td_cellpadding.'>';
	for ($row = 0; $row < $row_amount; $row++) {
		$gallery_data .= '<tr>';
		if ($images_array[$array_index] != null && is_file('t'.$images_array[$array_index].'.jpg')) {
			//Read from the file and extract description string from reference code
			$myFile = $current_page_dir.$read_filename; //read file
			$fh = @fopen($myFile, 'r'); //open file
			//Go through file line by line, Extract description for matching tile reference code 
			while (!feof($fh)) { // Go through each line in file
				$current_line = fgets($fh);
				//echo "current_line: ".$current_line;
				//if (strcmp(substr($current_line, 0, 5), strval($images_array[$array_index])) == 0) { 
				if(substr($current_line, 0, strpos($current_line, ' ')) == $images_array[$array_index]) {
					//echo "found match";
					$image_description = trim(substr($current_line, strpos($current_line, ' ')));
					//echo $image_description;
					//echo "hey: ".$current_line;
					break;
				} else {
					$image_description = "";
				}
			}
			fclose($fh);
			$gallery_data .= '<td width="80" height="80" align="center" valign="middle" background="'.$server_dir_main.'images/bkg_thumb_cell.gif" scope="row">';
			$gallery_data .= '<a href="'.$server_url_this.$current_page_dir.'iframe_display_info.php?image='.$images_array[$array_index].'&description='.$image_description.'" target="iframe_display_info">';
			$gallery_data .= '<img src="t_'.$images_array[$array_index].'.jpg" border="0" alt="'.$image_description.'"></a></td>';
			$array_index++;
		}else{
			$gallery_data .= '<td width="80" height="80" align="center" valign="middle" background="'.$server_dir_main.'images/bkg_thumb_cell.gif" scope="row">';
			$gallery_data .= '<img src="'.$server_dir_main.'images/img_thumb_empty.jpg" border="0"></a></td>';
		}
		for ($col = 1; $col < $col_amount; $col++) {
			if ($images_array[$array_index] != null && is_file('t'.$images_array[$array_index].'.jpg')) {
				//Read from the file and extract description string from reference code
				$myFile = $current_page_dir.$read_filename; //read file
				$fh = @fopen($myFile, 'r'); //open file
				//Go through file line by line, Extract description for matching tile reference code 
				while (!feof($fh)) { // Go through each line in file
					$current_line = fgets($fh);
					//echo "current_line: ".$current_line;
					//if (strcmp(substr($current_line, 0, 5), strval($images_array[$array_index])) == 0) { 
					if(substr($current_line, 0, strpos($current_line, ' ')) == $images_array[$array_index]) {
						//echo "found match";
						//$image_description = substr($current_line, 6);
						$image_description = trim(substr($current_line, strpos($current_line, ' ')));
						//echo $image_description;
						//echo "hey: ".$current_line;
						break;
					} else {
						$image_description = "";
					}
				}
				fclose($fh);
				//Now print the table data with 1. hyperlink, 2. code variable, 3. description variable, 
				$gallery_data .= '<td width="80" height="80" align="center" valign="middle" background="'.$server_dir_main.'images/bkg_thumb_cell.gif" scope="row">';
				$gallery_data .= '<a href="'.$server_url_this.$current_page_dir.'iframe_display_info.php?image='.$images_array[$array_index].'&description='.$image_description.'" target="iframe_display_info">';
				$gallery_data .= '<img src="t_'.$images_array[$array_index].'.jpg" border="0" alt="'.$image_description.'"></a></td>';
				$array_index++; 
			} else {
				$gallery_data .= '<td width="80" height="80" align="center" valign="middle" background="'.$server_dir_main.'images/bkg_thumb_cell.gif" scope="row">';
				$gallery_data .= '<img src="'.$server_dir_main.'images/img_thumb_empty.jpg" border="0"></td>';
			}
		}
		$gallery_data .= '</tr>';
	}
	$gallery_data .= '</table>';
	createFile($current_page_dir); //Now create the gallery.inc file in $image_folder (category page 1 folder) Since this is a Single-page gallery
	//Finally create the page links at the bottom of the gallery for this single-page gallery
	$image_folder_root = $image_folder; //$image_folder is the category root folder
	createPageLinks($image_folder_root); //Execute function to create or update page links for given category
}


function createMultiGallery($this_image_folder_root) {
	//Declare global variables
	global $pagecount, $gallery_data, $images_array, $read_filename, $image_folder_root, 
	$image_description, $td_main_width, $td_border, $td_align,
	$td_cellspacing, $td_cellpadding, $server_url_this, $server_dir_main;
	
	//Create a gallery for each page folder in category
	$count = 0; //Reset count to start afresh
	for ($i = 0; $i < $pagecount; $i++) {
		$current_page_dir = $this_image_folder_root.'page'.($i+1).'/';
		//echo '</br> $current_page_dir is: '.$current_page_dir;		
		
		//Firstly, we must store all page product images found in the first and subsequent page folders in an array
		$images_array = storeDirList($current_page_dir); //Create an array of product images in 1st page folder (also bubble-sorted)				
		
		$array_index = 0; //Start from first element in array
		$row_amount = 4; // Number of rows in table
		$col_amount = 4; // Number of columns in table
		
		$gallery_data .= '<table "'.$td_main_width.$td_border.$td_align
						.$td_cellspacing.$td_cellpadding.'>';
		for ($row = 0; $row < $row_amount; $row++) {
			$gallery_data .= '<tr><td width="80" height="80" align="center" valign="middle" 
			background="'.$server_dir_main.'images/bkg_thumb_cell.gif" scope="row">';
			if ($images_array[$array_index] != null) {
				//Read from the file and extract description string from reference code
				$myFile = $current_page_dir.$read_filename; //read file
				$fh = @fopen($myFile, 'r'); //open file
				//Go through file line by line, Extract description for matching tile reference code 
				while (!feof($fh)) { // Go through each line in file
					$current_line = fgets($fh);
					//echo "current_line: ".$current_line;
					//if (strcmp(substr($current_line, 0, 5), strval($images_array[$array_index])) == 0) { 
					if(substr($current_line, 0, strpos($current_line, ' ')) == $images_array[$array_index]) {
						//echo "found match";
						$image_description = trim(substr($current_line, strpos($current_line, ' ')));
						//echo $image_description;
						//echo "hey: ".$current_line;
						break;
					} else {
						$image_description = "";
					}
				}
				fclose($fh);
				$gallery_data .= '<a href="'.$server_url_this.$current_page_dir.
				'iframe_display_info.php?image='.$images_array[$array_index].
						'&description='.$image_description.'" target="iframe_display_info">';
				$gallery_data .= '<img src="t_'.$images_array[$array_index].
					'.jpg" border="0" alt="'.$image_description.'"></a></td>';
				$array_index++;
			}else{
				$gallery_data .= '<img src="'.$server_dir_main.
				'images/img_thumb_empty.jpg" border="0"></a></td>';
			}
			for ($col = 1; $col < $col_amount; $col++) {
				$gallery_data .= '<td width="80" height="80" align="center" valign="middle" 
			background="'.$server_dir_main.'images/bkg_thumb_cell.gif" scope="row">';
				if ($images_array[$array_index] != null) {
					//Read from the file and extract description string from reference code
					$myFile = $current_page_dir.$read_filename; //read file
					$fh = @fopen($myFile, 'r'); //open file
					//Go through file line by line, Extract description for matching tile reference code 
					while (!feof($fh)) { // Go through each line in file
						$current_line = fgets($fh);
						//echo "current_line: ".$current_line;
						//if (strcmp(substr($current_line, 0, 5), strval($images_array[$array_index])) == 0) { 
						if(substr($current_line, 0, strpos($current_line, ' ')) == $images_array[$array_index]) {
							//echo "found match";
							$image_description = trim(substr($current_line, strpos($current_line, ' ')));
							//echo $image_description;
							//echo "hey: ".$current_line;
							break;
						} else {
							$image_description = "";
						}
					}
					fclose($fh);
					//Now print the table data with 1. hyperlink, 2. code variable, 3. description variable, 
					$gallery_data .= '<a href="'.$server_url_this.$current_page_dir.
					'iframe_display_info.php?image='.$images_array[$array_index].
						'&description='.$image_description.'" target="iframe_display_info">';
					$gallery_data .= '<img src="t_'.$images_array[$array_index].
					'.jpg" border="0" alt="'.$image_description.'"></a></td>';
					$array_index++; 
				} else {
					$gallery_data .= '<img src="'.$server_dir_main.
					'images/img_thumb_empty.jpg" border="0"></td>';
				}
			}
			$gallery_data .= '</tr>';
		}
		$gallery_data .= '</table>';
		createFile($current_page_dir); //Now create the gallery.inc file in $current_page_dir (category page folder)
	}
	//Finally create the page links at the bottom of the gallery for this multi-page gallery
	$image_folder_root = $this_image_folder_root;
	createPageLinks($image_folder_root); //Execute function to create or update page links for given category
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
			  //echo "</br> Bubble-Sorted: ".$sort_this_array[$i];
         }
    }
	return $sort_this_array;
}


//Function: Automatically display the first thumbnail's display picture in Display iFrame
function createShowDisplay() {
	global $server_url_this, $image_folder, $images_array, 
	$gallery_data, $image_description;
	$gallery_data .= '
		<script language="Javascript" type="text/javascript">
		<!--'; $gallery_data .= "
			parent.frames.['iframe_display_info'].location.replace"; $gallery_data .= '("product_update.html");
		//-->
		</script>';
}


//Function: Creates a content file to store the newly created gallery - This creates the gallery.inc that subsides in the page folder
function createFile($this_page_folder) {
	//declare global variables
	global $image_folder, $generate_file, $gallery_data;
	
	$fh = @fopen($this_page_folder.$generate_file, 'w') or die("can't open file");
	fwrite($fh, $gallery_data);
	fclose($fh);	
	$gallery_data = "";//Reset $gallery_data
	//echo $gallery_data;
	//echo 'Current Path: ' .$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/")+1);
}


//Function: Create or update page links include file for the index.php pages
function createPageLinks($this_image_folder_root) {
	//declare global variables
	global $server_dir_main, $pagecount;
	
	$fh = @fopen($this_image_folder_root.'pagelinks.inc', 'w') or die("can't open file");
	$pagelinks_data = '';
	if ($pagecount > 1) { //If more than 1 page exists in that category, we must create a pagelinks.inc for category
		//Generate HTML Linking data
		/*$pagelinks_data .= 'Page:';	
		for ($i = 0; $i < $pagecount; $i++) {		
			$pagelinks_data .= ' | ';
			$pagelinks_data .= '<a href="'.$server_dir_main.$this_image_folder_root.'page'.($i+1).'/">';
			$pagelinks_data .= $i+1;
			$pagelinks_data .= '</a>';
		}
		$pagelinks_data .= ' | ';*/
		//Write in pagelinks.inc the php the following variables
		$pagelinks_data .= '<?';
		$pagelinks_data .= '$pagecount='.$pagecount.';';
		$pagelinks_data .= '$server_dir_main="'.$server_dir_main.'";';
		$pagelinks_data .= '$this_image_folder_root="'.$this_image_folder_root.'";';
		//Write also $currentpage
		$pagelinks_data .= '$currentpage=$_GET[\'page\'];';
		//Write also: PHP script to auto select current page link
		$pagelinks_data .= 
			'
			if ($currentpage > 1) {
			echo \' <a href="\'.$server_dir_main.$this_image_folder_root.\'page\'.($currentpage-1).\'/index.php?page=\'.($currentpage-1).\'"> « Prev </a>\';
			}
			for($i=0; $i<$pagecount; $i++) {
				if(($i+1) != $currentpage) {
					echo \' | \';
					echo \'<a href="\'.$server_dir_main.$this_image_folder_root.\'page\'.($i+1).\'/index.php?page=\'.($i+1).\'">\';
					echo \'\'.($i+1).\'\';
					echo \'</a>\';
				} else {
					echo \' | \';
					echo \'<span class="selectedpage">\';
					echo \'<a href="\'.$server_dir_main.$this_image_folder_root.\'page\'.($i+1).\'/index.php?page=\'.($i+1).\'">\';
					echo \'<b>\'.($i+1).\'</b>\';
					echo \'</a>\';
					echo \'</span>\';
				}
			}
			echo \' | \';
			if ($currentpage < $pagecount) {
			echo \' <a href="\'.$server_dir_main.$this_image_folder_root.\'page\'.($currentpage+1).\'/index.php?page=\'.($currentpage+1).\'"> Next » </a>\';
			}
			';
		$pagelinks_data .= '?>';
	}
	fwrite($fh, $pagelinks_data);
	fclose($fh);
}


//Function: Creates iFrames for Display area and Description area next to Gallery table
function createFrames() {
	echo
	'<table width="300" valign="top" scope="row"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th width="300" height="300" scope="row"><iframe name="iframe_display" width="300" 
		height="300" frameborder=0 scrolling=no src="_blank"></iframe></th>
      </tr>
      <tr>
        <th height="150" scope="row"><iframe name="iframe_display_info" width="300" height="150" 
		frameborder=0 scrolling=no src="iframe_display_info.php"></iframe></th>
      </tr>
    </table>';
}


//Function:  Proceed to next step of the process with page redirect
function proceedProcess() {
	//Return to CMS start
	/*echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.location.replace("product_update.html");
		//-->
		</script>';*/
	if(!empty($_GET['prev'])) {
		header('location:'.$_GET['prev']);
	} else {
		header('location:product_update.html');
	}
}

?>