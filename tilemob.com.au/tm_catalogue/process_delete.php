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
$image_code = $_POST['textfield_removetile'];
$startDirectory = "gallery/";
$write_filename = "photogallery_info.txt"; //Filename to write to
$files = array();
$directoryList = array();
$image_files = array(); //Create an array to hold directory list
$image_folder = ''; //To be updated by function
//Function Executions below  -----------------------------------------------------------------------------------------------------------
listDirectories(); //1. Execute function to list all sub-directories in gallery/
readDirectories(); // 2. Execute function to read all specified image files in directory
//printArray(); //3. Execute function to print array that contains sub-directory paths
//writeDescription(); //4. Execute function to edit description
proceedProcess(); //5. Execute function to proceed to next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Delve in and list all category directories under the "gallery/" 
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
					   if (substr($file, 0, 4) == 'page'){
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


//Function: Go through all directories in category root folder and find the product number
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
				//$file_number = substr($file, 2, -4);
				$file_number = str_ireplace('t_', '', $file);
				$file_number = str_ireplace('.jpg', '', $file_number);
				//echo "\nFile: ".$file_number."\n";
	            $image_files[] = $file_number;
				//If this directory's file_number equals the textfield's image_code
				//We tell writeDescription() to write description for this image_code
				if (strcmp($file_number, $image_code) == 0) {
					deleteProduct($directoryList[$i], $image_code);
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
function deleteProduct($u_directory, $u_code) {	
	//Remove product thumbnail from folder location
	$removeFile = $u_directory."t_".$u_code.".jpg";
	$fh = fopen($removeFile, 'w') or die("can't open file");
	//$stringData .= "\r\n".$image_code." ".$image_description;
	unlink($removeFile);
	fclose($fh);
	
	//Remove product display from folder location
	$removeFile = $u_directory.$u_code.".jpg";
	$fh = fopen($removeFile, 'w') or die("can't open file");
	//$stringData .= "\r\n".$image_code." ".$image_description;
	unlink($removeFile);
	fclose($fh);
}


//Function:  Proceed to next step of the process with page redirect
function proceedProcess() {
	global $image_folder;
	$image_folder = str_replace('gallery/','',$image_folder);
	$image_folder = dirname($image_folder).'/page1/';
	//Redirect to process image to store directory in array and then create gallery
	/*echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.location.replace("process_orgdirectory.php?image_folder='; 
			echo $image_folder; echo '");
		//-->
		</script>';*/
	//echo '<br/>image_folder: '.$image_folder;
	echo '<script>self.location="regenerate_gallery.php?select_imagelocation='.$image_folder.'&prev=remove_image.php";</script>';
}
?>
</body>
</html>