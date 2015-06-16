<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Site backup feature</title>
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<span class = "the-tile-mob-dark">
<blockquote>


<?
//----------------------------------------------------------------------------------------------------------------------------------------------
//Author: Richard Chong
//Role: Web Designer/Developer/Programmer
//Company: dmwcreative
//Start Date: 
//Script: Process Backup directories
//Description: 	
//----------------------------------------------------------------------------------------------------------------------------------------------


//URL passes to this script the backup source location on server
if (isset($_GET['backupsource'])) {
	$rootdir = substr($_SERVER['DOCUMENT_ROOT'], 1).'/';
	$backupLocation = $rootdir."backupdir/";
	$backupSource = $_GET['backupsource'];
	//echo 'backupSource is: '.$backupSource.'<br />'; 
	//echo 'backupLocation is: '.$backupLocation.'<br />';	
	//Before proceeding, make sure backup source and backup location exist
	//if (is_readable($backupLocation) && is_readable($backupSource)) {
		//echo 'Running backup directory function...<br />';
		backupDir($backupSource, $backupLocation, $firstStart=true);
	//}
}


//Function: Creates a backup of a source directory into a backup location directory's sub-folder (timestamp generated)
//Essentially copies all files and folders from source directory into backup location.
function backupDir($this_backupSource, $this_backupLocation, $firstStart) {
	if ($firstStart == true) {
		//1. Create a sub-folder under backup location in the name of today's date and time eg: 20070712_1258
		$name_date = date("dmy"); //outputs: 120707 (day+month+year)
		$name_time = date("Hi"); //outputs: 1300 (hour+minutes)
		$temp_folder = $name_date."_".$name_time;
		//echo 'temporary folder name: '.$temp_folder.'<br />';
		$this_backupLocation = DIRECTORY_SEPARATOR.$this_backupLocation.$temp_folder;
		/*if (!is_dir($this_backupLocation)) {
			mkdir($this_backupLocation, 0777);
		}
		echo 'New backup location set: '.$this_backupLocation.'<br />';
		echo '----------------------------------------------------------------<br />';*/
		$firstStart = false;
	}
	
	//Start the copying (or not, if you comment it out)
	//copyDir($this_backupSource, $this_backupLocation);
	echo '<b>Backup Complete.</b><br />';
	//echo '----------------------------------------------------------------<br />';
	echo 'Creating ZIP file... Complete.<br />';
	echo '<br />';
	//2. Create the ZIP archive of the temporary backup directory, using the folder name as the zip filename
	$zip_backup_dir = "zip_backups/";
	if (!is_dir($zip_backup_dir)) { //If zip backup directory doesn't exist, create it
		mkdir($zip_backup_dir, 0777);
	} else { //delete if already exists, and recreate it, therefore we only ever have 1 zip backup each time
		removeDir($zip_backup_dir);
		mkdir($zip_backup_dir, 0777);
	}
	
	//Now create the ZIP of directory
	include_once('classes/pclzip.lib.php');
	$archive = new PclZip($zip_backup_dir.$temp_folder.'.zip');
	$v_list = $archive->create($this_backupSource);
	if ($v_list == 0) {
		die("Error : ".$archive->errorInfo(true));
	}
	echo '<a href="zip_backups/'.$temp_folder.'.zip">Download</a><br />';
}


//Function: Copies all files and folders from a given source to a given destination (Credit goes to PHP.net users)
function copyDir($this_backupSource, $this_backupLocation, $verbose=true) {
	$num = 0;
	if(!is_dir($this_backupLocation)) mkdir($this_backupLocation);
	if($curdir = opendir($this_backupSource)) {
		while($file = readdir($curdir)) {
			if($file != '.' && $file != '..') {
				$srcfile = $this_backupSource .DIRECTORY_SEPARATOR. $file;
				$dstfile = $this_backupLocation .DIRECTORY_SEPARATOR. $file;
				if(is_file($srcfile)) {
					if(is_file($dstfile)) $ow = filemtime($srcfile) - filemtime($dstfile); else $ow = 1;
					if($ow > 0) {
						if($verbose) echo "Copied: '$dstfile'";
						if(copy($srcfile, $dstfile)) {
							touch($dstfile, filemtime($srcfile)); $num++;
						if($verbose) echo " (OK)\n";
						} else echo "Error: File '$srcfile' could not be copied!\n";
					}                  
				} else if(is_dir($srcfile)) {
					$num += copyDir($srcfile, $dstfile, $verbose);
				}
			}
		}
		closedir($curdir);	
	}  
}


//Function: Removes the specified directory along with all the contents within this directory
function removeDir($this_dir) {
	if ($dirHandle = opendir($this_dir)) {
		chdir($this_dir);
		while ($file = readdir($dirHandle)) {
			if ($file == '.' || $file == '..') continue;
			if (is_dir($file)) removeDir($file);
			else unlink($file);
		}
		chdir('..');
		rmdir($this_dir);
		closedir($dirHandle);
	}
}
?>


</blockquote>
</span>
</body>
</html>