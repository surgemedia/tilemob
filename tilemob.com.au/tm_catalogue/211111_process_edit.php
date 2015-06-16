<html>
<head>
<title></title>
</head>
<body>
<?php
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Date: 28/03/07
//Script: Process Edit Product Image
//Description: 	
//			
//			
//----------------------------------------------------------------------------------------------------------------------------------------------

error_reporting(0);
//General Variables below ---------------------------------------------------------------------------------------------------------------
$image_code = $_POST['textfield_edittile'];
$image_description = $_POST['textarea_newdescription'];
$startDirectory = "gallery/";
$write_filename = "photogallery_info.txt"; //Filename to write to
$files = array();
$directoryList = array();
$image_files = array(); //Create an array to hold directory list
$image_folder = ""; //To be updated by function
//Function Executions below  -----------------------------------------------------------------------------------------------------------
listDirectories(); //1. Execute function to list all sub-directories in gallery/
readDirectories(); // 2. Execute function to read all specified image files in directory
//printArray(); //3. Execute function to print array that contains sub-directory paths
//writeDescription(); //4. Execute function to edit description
proceedProcess(); //5. Execute function to proceed to next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


function listDirectories ($startDirectory="gallery/", $searchSubdirs=1, 
							$directoriesOnly=0, $maxLevel="all", $level=1) {
	$ignoredDirectory[] = ".";
	$ignoredDirectory[] = "..";
	$ignoredDirectory[] = "_vti_cnf";
	global $directoryList;
   
	if (is_dir($startDirectory)) {
		if ($dh = opendir($startDirectory)) {
			while (($file = readdir($dh)) !== false) {
               if (!(array_search($file,$ignoredDirectory) > -1)) {
                 if (filetype($startDirectory . $file) == "dir") {
					   if (substr($file, 0, 4) == "page"){
							//echo "adding: ".$startDirectory.$file."/";							
							$directoryList[] = $startDirectory.$file."/";
						}
                       if ($searchSubdirs) {
                           if ((($maxLevel) == "all") or ($maxLevel > $level)) {
                               listDirectories($startDirectory . $file . "/", $searchSubdirs, 
							   $directoriesOnly, $maxLevel, $level + 1);
                           }
                       }
                   }
				}
			}
           closedir($dh);
		}		
	}
}


function readDirectories() {
	global $directoryList, $image_files, $image_code, $image_description, $image_folder;
	
	for ($i = 0; $i < count($directoryList); $i++) {
		$handler = opendir($directoryList[$i]);
		//echo "directory: ".$directoryList[$i]."<br>";
		// keep going until all files in directory have been read
	    while ($file = readdir($handler)) {
	        // if $file isn't this directory or its parent, add it to the image_files array
	        if ($file != '.' && $file != '..' && substr($file, 0, 2) == "t_") {
				//Substring filename to take only reference number
				$file_number = substr($file, 2, -4);
				//echo "\nFile: ".$file_number."\n";
	            $image_files[] = $file_number;
				//If this directory's file_number equals the textfield's image_code
				//We tell writeDescription() to write description for this image_code
				if (strcmp($file_number, $image_code) == 0) {
					writeDescription($directoryList[$i], $image_code, $image_description);
					$image_folder = $directoryList[$i];
				}
			}
	    }
	    // tidy up: close the handler
	    closedir($handler);
	}
}


function printArray() {
	global $image_files;
	foreach ($image_files as $list) {
		echo $list."<br>";
	}
	echo "array count: ".count($image_files);
}


//Function: writes the description for the file in a text file
function writeDescription($w_directory, $w_code, $w_description) {
	//Declare global variables
	global $image_folder;
	global $write_filename;
	
	$image_code_exist = "no";
	
	//Check to see if description for that image code already exists in file
	//If it does, then we replace that line with new image_description
	//If it doesn't, just use the existing description for image_code
	$readFile = $w_directory.$write_filename; //read file
	$fh = fopen($readFile, 'r');
	while (!feof($fh)) { // Go through each line in file
		$currentLine = fgets($fh);
		$line_image_code = substr($currentLine, 0, 5); //Get image code of that line
		if ($currentLine != "") {
			if (trim($line_image_code) == trim($w_code)) { //If image_code exists in file, replace it
				$stringData .= trim($w_code). ' ' .rtrim($w_description)."\r\n";
				$image_code_exist = "yes";
			} else {
				$stringData .= rtrim($currentLine)."\r\n"; //No replacement required for line
			}
		}
	}
	
	if ($image_code_exist == "no") {
		$stringData .= $w_code. " " .rtrim($w_description)."\r\n";
	}
	
	//Write description to file
	$writeFile = $w_directory.$write_filename;
	$fh = fopen($writeFile, 'w') or die("can't open file");
	//$stringData .= "\r\n".$image_code." ".$image_description;
	fwrite($fh, $stringData);
	fclose($fh);
	
	//echo "\nWriting to file: " .$write_filename;
	//echo "\nWriting: ".$stringData;	
}


/*//Function:  Proceed to next step of the process with page redirect
function proceedProcess() {
	global $image_folder;
	//Redirect to process image to store directory in array and then create gallery
	echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.location.replace("process_storedirectory.php?image_folder='; 
			echo $image_folder; echo '");
		//-->
		</script>';
}*/


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
</body>
</html>