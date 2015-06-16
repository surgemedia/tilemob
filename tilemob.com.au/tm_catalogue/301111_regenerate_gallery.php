<?php
if(!empty($_POST['select_imagelocation'])){
	$image_folder = trim($_POST['select_imagelocation']);
} else if(!empty($_GET['select_imagelocation'])) {
	$image_folder = trim($_GET['select_imagelocation']);	
}

if(!empty($_GET['prev'])) {
	$prev = $_GET['prev'];
} else {
	$prev = '';
}

if(!empty($image_folder)) {
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
		/*echo '</br>----------------------------------------';
		echo '</br>Total page folders found: '.$pagecount;
		echo '</br>----------------------------------------';*/
	}
	return $pagecount;
}
?>