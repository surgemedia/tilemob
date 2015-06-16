<html>
<head>
<title></title>
</head>
<body>
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
$images_array = unserialize(base64_decode($_GET['serialized_array']));
$pagecount = $_GET['pagecount']; //Number of pages in category root folder
//Table properties below -----------------------------------------------------------------------------------------------------------------
$td_main_width = '"width="370"';
$td_border = 'border="0"';
$td_align = 'align="left"';
$td_cellspacing = 'cellspacing="10"';
$td_cellpadding = 'cellpadding="0"';
//Function Executions below  -----------------------------------------------------------------------------------------------------------
createGallery(); // 1. Execute function to create gallery grid
createShowDisplay(); //2. Execute function to display the first image in Display iFrame
createFile(); //3. Execute function to create file to store the gallery data (gallery.inc)
createPageLinks(); //4. Execute function to create or update page links for given category
proceedProcess(); //5. Execute function to proceed to next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Creates a gallery page by dynamically generating HTML code
function createGallery() {
	//Declare global variables
	global $gallery_data, $images_array, $read_filename, $image_folder,
	$image_description, $td_main_width, $td_border, $td_align,
	$td_cellspacing, $td_cellpadding, $server_url_this, $server_dir_main;
	
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
			$myFile = $image_folder.$read_filename; //read file
			$fh = fopen($myFile, 'r'); //open file
			//Go through file line by line, Extract description for matching tile reference code 
			while (!feof($fh)) { // Go through each line in file
				$current_line = fgets($fh);
				//echo "current_line: ".$current_line;
				if (strcmp(substr($current_line, 0, 5), 
				strval($images_array[$array_index])) == 0) { 
					//echo "found match";
					$image_description = substr($current_line, 6);
					//echo $image_description;
					//echo "hey: ".$current_line;
					break;
				} else {
					$image_description = "";
				}
			}
			fclose($fh);
			$gallery_data .= '<a href="'.$server_url_this.$image_folder.
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
				$myFile = $image_folder.$read_filename; //read file
				$fh = fopen($myFile, 'r'); //open file
				//Go through file line by line, Extract description for matching tile reference code 
				while (!feof($fh)) { // Go through each line in file
					$current_line = fgets($fh);
					//echo "current_line: ".$current_line;
					if (strcmp(substr($current_line, 0, 5), 
					strval($images_array[$array_index])) == 0) { 
						//echo "found match";
						$image_description = substr($current_line, 6);
						//echo $image_description;
						//echo "hey: ".$current_line;
						break;
					} else {
						$image_description = "";
					}
				}
				fclose($fh);
				//Now print the table data with 1. hyperlink, 2. code variable, 3. description variable, 
				$gallery_data .= '<a href="'.$server_url_this.$image_folder.
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


//Function: Creates a content file to store the newly created gallery
function createFile() {
	//declare global variables
	global $image_folder, $generate_file, $gallery_data;
	
	$fh = fopen($image_folder.$generate_file, 'w') or die("can't open file");
	fwrite($fh, $gallery_data);
	fclose($fh);
	//echo $gallery_data;
	//echo 'Current Path: ' .$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/")+1);
}


//Function: Create or update page links include file for the index.php pages
function createPageLinks() {
	//declare global variables
	global $server_dir_main, $image_folder_root, $pagecount;
	
	$fh = fopen($image_folder_root.'pagelinks.inc', 'w') or die("can't open file");
	$pagelinks_data = '';
	if ($pagecount > 1) {		
		//Generate HTML Linking data
		$pagelinks_data .= 'Page:';	
		for ($i = 0; $i < $pagecount; $i++) {		
			$pagelinks_data .= ' | ';
			$pagelinks_data .= '<a href="'.$server_dir_main.$image_folder_root.'page'.($i+1).'/">';
			$pagelinks_data .= $i+1;
			$pagelinks_data .= '</a>';
		}
		$pagelinks_data .= ' | ';
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
	echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.location.replace("product_update.html");
		//-->
		</script>';
}

?>
</body>
</html>