<html>
<head>
<title></title>
</head>
<body>
<?php

$directoryList = array();
listDirectories();
printArray();


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
							$directoryList[$startDirectory . $file]['name'] = $file;
							$directoryList[$startDirectory . $file]['path'] =
							$startDirectory;
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


function printArray() {
	global $directoryList;
	foreach ($directoryList as $list) {
		echo $list['path'].$list['name']."<br>";
	}
}



?>
</body>
</html>