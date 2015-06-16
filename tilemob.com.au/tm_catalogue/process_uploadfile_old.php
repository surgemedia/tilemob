<?php
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Start Date: 22/03/07
//Script:  
//Description: 	
//----------------------------------------------------------------------------------------------------------------------------------------------


//General Variables below ---------------------------------------------------------------------------------------------------------------
//$image_thumbnail = $_FILES['filefield_thumbnail']; //Filename for upload
$server_dir_main = 'http://'.$_SERVER["SERVER_NAME"].substr($_SERVER["SCRIPT_NAME"], 0, strpos($_SERVER["SCRIPT_NAME"], "/", 2)+1); //Server main directory address
$image_thumbnail = $_FILES['filefield_thumbnail']['name'];
$image_display = $_FILES['filefield_display']['name'];
$image_code = substr($image_thumbnail, 2, -4); //Image tile reference number code
$image_folder = "gallery/".$_POST['select_imagelocation']."/"; //Folder to upload images to
$write_filename = "photogallery_info.txt"; //Filename to write to
$image_description = $_POST['textarea_description']; //Get description from description textarea
//Function Executions below  -----------------------------------------------------------------------------------------------------------
checkFolder(); // 1. Execute function to check page folder for product images
//uploadFiles(); // 2. Execute function to upload the file
//writeDescription(); // 3. Execute function to save description for file
//proceedProcess(); // 4. Execute function to proceed to next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Check page folder for number of current product images
function checkFolder() {
	//Declare global variables
	global $image_thumbnail, $image_display, $image_folder;
	
	$count = countFiles($image_folder); //Count number of product images in $image_folder - Assign count results
	echo '</br>$count for '.$image_folder.' is '.$count;
	if ($count < 16) { 
		uploadFiles($image_folder, $image_thumbnail, $image_display); //Upload file
		echo '</br>Commence upload to folder: '.$image_folder;
	} else {
		//Check next image folder to determine if there is less than 16 product images
		$folder_number = 1;
		while ($count >= 16) {
			$folder_number++;
			$next_image_folder = substr($image_folder, 0, count($image_folder)-3).$folder_number."/";
			$count = countFiles($next_image_folder); //Count number of product images in $image_folder - Assign count results
			echo '</br>$count for '.$next_image_folder.' is '.$count;
		}
		$next_image_folder = substr($image_folder, 0, count($image_folder)-3).$folder_number."/";
		echo '</br>Commence upload to folder: '.$next_image_folder;
		uploadFiles($next_image_folder, $image_thumbnail, $image_display); //Upload file
	}
}


function countFiles($image_folder) {
	$count = 0;	
	//Open up upload directory - category page1 folder and then count the
	//number of existing product images in page1 folder of given category.
	//Check given $image_folder directory, if it exists, count the files
	if ($handler = @opendir($image_folder)) {
		while ($file = readdir($handler)) {
			if ($file != '.' && $file != '..' && substr($file, 0, 2) == "t_") {
				$count++;
			}
		}
	//if it doesn't, create it and count the files.
	} else {
		//Firstly create the new folder and populate with required files
		$folder_number += substr($image_folder, count($image_folder)-3, count($image_folder)-2);
		$next_image_folder = substr($image_folder, 0, count($image_folder)-3).$folder_number."/";		
		mkdir($next_image_folder, 0755);
		echo '</br>Creating a new page folder: '.$next_image_folder;
		global $server_dir_main;
		copy($server_dir_main.'page/'.'index.php', $next_image_folder.'index.php');
		copy($server_dir_main.'page/'.'iframe_display_info.php', $next_image_folder.'iframe_display_info.php');
		copy($server_dir_main.'page/'.'iframe_display.php', $next_image_folder.'iframe_display.php');
		copy($server_dir_main.'page/'.'photogallery_info.txt', $next_image_folder.'photogallery_info.txt');
				
		//Now count the files
		$handler = opendir($next_image_folder);
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
	$fh = fopen($writeFile, 'w') or die("can't open file");
	//$stringData .= "\r\n".$image_code." ".$image_description;
	fwrite($fh, $stringData);
	fclose($fh);
	
	//echo "\nWriting to file: " .$write_filename;
	//echo "\nWriting: ".$stringData;	
}


//Function:  Proceed to next step of the process with page redirect
function proceedProcess() {
	global $image_folder;
	//Redirect to process image to store directory in array and then create gallery
	echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.location.replace("process_storedirectory.php?image_folder='; 
			echo $image_folder; echo '");
		//-->
		</script>';
}
?>