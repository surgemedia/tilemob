<?
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Date: 21/03/07
//Script: Process Store Directory
//Description: 	This script stores an array of files from the page's image directory.
//			It sub-strings the image's filename (made up of the tile's reference number)
//			and auto-arranges it in descending order in the array using bubble-sorting.
//----------------------------------------------------------------------------------------------------------------------------------------------

error_reporting(0);
//General Variables below ---------------------------------------------------------------------------------------------------------------
$directory = $_GET['image_folder']; //Directory path of files
$pagecount = $_GET['pagecount']; //Number of pages in category root folder
$array_size_limit = 24; //Total number of elements allowed in array
$image_files = array(); //Create an array to hold directory list
$product_limit = 16; //Limit number of product images per gallery page
//echo "Directory of Files in " .$directory."\n";
//Function Executions below  -----------------------------------------------------------------------------------------------------------
dirList($directory); //1. Execute function to store image files into array
bubbleSort(); //2. Execute function bubble sort our newly populated array
printArray(); //3. Execute function to print contents of newly bubble sorted array
proceedProcess(); //4. Execute function to proceed to the next step of the process
//-----------------------------------------------------------------------------------------------------------------------------------------------


//Function: Stores selected image files from folder directory into an array
function dirList ($directory) {
	//Declare global variables
	global $image_files;
    // create a handler for the directory
    $handler = opendir($directory);
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
		}
    }
    // tidy up: close the handler
    closedir($handler);
}


//Function: Bubble sorts the array in descending order
function bubbleSort() {
	//Declare global variables
	global $image_files;
    $temp = "";
    $size = count($image_files);
    for($i = 0; $i < $size-1; $i++) {
         for($j = 0; $j < $size - 1 - $i; $j++) {
              if($image_files[$j+1] > $image_files[$j]) {
                   $temp = $image_files[$j];
                   $image_files[$j] = $image_files[$j+1];
                   $image_files[$j+1] = $temp;
              }
			  //echo "".$image_files[i]."\n";
         }
    }
}


//Function: Outputs all contents in array
function printArray(){
	//Declare global variables
	global $image_files;
	for ($i = 0; $i < count($image_files); $i++) {
		//echo $image_files[$i]."\n";
	}
}


//Function: Redirects to the next step of the process page
function proceedProcess() {
	//Declare global variables
	global $directory, $image_files, $pagecount;
	
	//Serialize and encode the Array to make it a simple string.
	//$serialize_image_files = array();
	//$serialize_image_files = base64_encode(serialize($image_files));
	//header('Location: process_creategallery.php?serialized_array=$serialize_image_files');
	/*echo '<script language="Javascript" type="text/javascript">
		<!--
			parent.location.replace("process_creategallery.php?image_folder='.$directory.'&pagecount='.$pagecount.'");
		//-->
		</script>';*/
		header('location:process_creategallery.php?image_folder='.$directory.'&pagecount='.$pagecount.'&prev='.$_GET['prev']);
}
?>