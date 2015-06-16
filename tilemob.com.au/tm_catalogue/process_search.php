<html>
<head>
<title></title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<span class="the-tile-mob">
<?php
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Date: 28/03/07
//Script: Process Search Product
//Description: 	
//			
//			
//----------------------------------------------------------------------------------------------------------------------------------------------


//General Variables below ---------------------------------------------------------------------------------------------------------------
$image_code = $_POST['textfield_searchtile'];
$startDirectory = "gallery/";
$files = array();
$directoryList = array();
$image_files = array(); //Create an array to hold directory list
$image_folder = ""; //To be updated by function
//Function Executions below  -----------------------------------------------------------------------------------------------------------
listDirectories(); //1. Execute function to list all sub-directories in gallery/
readDirectories(); // 2. Execute function to read all specified image files in directory
//printArray(); //3. Execute function to print array that contains sub-directory paths
//writeDescription(); //4. Execute function to edit description
//proceedProcess(); //5. Execute function to proceed to next step of the process
//reportResults(); //6. Execute function report search results
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


//Function: Go through all directories in category root folder and find the product number
function readDirectories() {
	global $directoryList, $image_files, $image_code, $image_description, $image_folder;
	
	$product_found = false; //Initialize found check
	
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
				if (strcmp($file_number, $image_code) == 0) {
					//Report Results (Found) - takes the parameters 1. folder location of product 2. product number match found
					$product_found = true;
					reportResults($directoryList[$i], $image_code);
					$image_folder = $directoryList[$i];
				}
			}
	    }
	    // tidy up: close the handler
	    closedir($handler);
	}
	
	if ($product_found == false) {
		reportResults('not found', $image_code);
	}
}


//Function: Reports search results
function reportResults($this_result, $code) {
	echo '</br> <strong>Search Results</strong>';
	echo '</br>-------------------------------------------------------------------------------';
	if ($this_result == 'not found') {
		echo '</br> Product #'.$code.' does not exist in the database';
		echo '</br>-------------------------------------------------------------------------------';
		echo '</br>';
	} else {
		echo '</br> Product #'.$code.' found: ';
		echo '</br> - Category: '.$this_result;
		echo '</br>-------------------------------------------------------------------------------';
		echo '</br>';
		echo '
		<table width="300" height="300" border="0" cellpadding="0" cellspacing="0">
		<tr>
	    <th background="images/bkg_display_cell.gif" scope="row">
		<img src="'.$this_result.$code.'.jpg">
		</th>
		</tr>
		</table>';
		echo '</br>';
	}
}


?>
</span>
</body>
</html>