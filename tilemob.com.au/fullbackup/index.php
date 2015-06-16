<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Site backup feature</title>
<link href="../styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<span class = "the-tile-mob">
<?
//Author: Richard Chong (Programmer | Developer | Designer)
//Date: 17/07/07
//Contact: richardcwc@gmail.com
//Script: Site backup feature (entire site)
//Description: 	Performs a backup of a specified directory on the server,
//				Use URL variable passing to process page.

$rootdir = $_SERVER['DOCUMENT_ROOT'];
$tm_catalogue = $rootdir.DIRECTORY_SEPARATOR."tm_catalogue";
?>
</span>
<blockquote>
  <p class="the-tile-mob-dark">&nbsp;</p>
  <p class="the-tile-mob-dark">Select a backup option </p>
  <p><span class = "the-tile-mob-dark"><strong><a href="process_backup.php?backupsource=<?=$rootdir?>">Backup (Entire site)</a></strong></span></p>
  <p><span class = "the-tile-mob-dark"><strong><a href="process_backup.php?backupsource=<?=$tm_catalogue?>">Backup (Catalogue Browser)</a></strong></span></p>
  <p class="the-tile-mob-dark">Important notice:<br />
    This feature creates a backup (ZIP Archive) of your entire site's directory structure (or a specified sub-directory). <br />
    The backup
    process performs scan and copy of all files and sub-directories on the server and creates a .ZIP archive<br />
    file ready to download. The server will only store 1 copy of the backup archive (because of  the file-size involved); <br />
    everytime 
    you run the backup process, the previous zip archive will be deleted. <br />
    ZIP archives are named with the filenaming convention: <strong>day/month/year_24hrTime.zip</strong><br />
    <br />
    Please note that  this backup process can take up to a minute or longer, depending on the total number of files/folders <br />
    that
    require archiving. Select a backup option ONCE and let the system run. Once successful, the system will generate<br />
    a download link of your ZIP archive. <br />
  </p>
</blockquote>
<span class = "the-tile-mob-dark">
<p>&nbsp;</p>
</span>
</body>
</html>
