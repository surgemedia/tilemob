<?php
include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<script language="JavaScript" type="text/javascript" src="scripts/disablerightclick.js"></script>
<title>New in Store - The Tile Mob Pty Ltd, Brisbane</title>
<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #FFFFFF;
}
.first_cell{
	width:60%; height:620px; float:left; text-align:center;
}
.first_cell_text{
	width:352px; background-color:#666; height:50px; display:table-cell; vertical-align:middle;
}
.first_pdfs_photo{
	width:352px;
	height:493px;
	
}
.pdfs_photo{
	width:140px;
	height:200px;
}
.pdfs_photos_style{
	margin-bottom:10px;
}
.pdfs_table_first_look_style{
	display:table; margin:0 auto;
}
.pdfs_table_look_style{
	display:table; margin:0 auto; width:175px;
}
.pdfs_cell{
	width:20%; height:310px; float:left; text-align:center;
}
.pdf_cell_text{
	 background-color:#666; height:50px; display:table-cell; vertical-align:middle; font-size:12px; padding-left:10px; padding-right:10px;
}
a{
	color:#fff;
	text-decoration:none;
}
a:hover{
	color:#fff;
}
.clearfixnow{
	content:"";
	display:table;
	clear:both;
	height:50px;
}
</style>
</head>

<body style="width:910px;">
	<?
		if($_GET['childpage']==""){
			$pdfs = "SELECT * FROM file_pdfs WHERE child_index = 0 AND enable_option = 1 ORDER BY id DESC";	
			$back_to_main = '
			';
		}else{
			$pdfs = "SELECT * FROM file_pdfs WHERE child_index = ".$_GET['childpage']." AND enable_option = 1 ORDER BY id DESC";
			$back_to_main = '
				<div class="clearfixnow">
				<a href="new-in-store.php" title="Back to top" style="color:red !important;">Back to main page</a>
				</div>
			';
		}
		$pdfs_result = mysql_query($pdfs);
		$pdfs_num = mysql_num_rows($pdfs_result);
		for ($i = 0; $i < $pdfs_num; $i++) {
			$pdfs_row = mysql_fetch_array($pdfs_result);
			if($pdfs_row['pdf_file']=="COLLECTION"){
				$pdf_linking = "new-in-store.php?childpage=".$pdfs_row['id'];
				$link_open = '';
			}else{
				$pdf_linking = $pdfs_row['pdf_file'];
				$link_open = ' target="_blank"';
			}
			if($i==0){
				echo '
					<a href="'.$pdf_linking.'" '.$link_open.'>
					<div class="first_cell">
						<div class="pdfs_photos_style"><img src="'.$pdfs_row['img_file'].'" class="first_pdfs_photo" /></div>
						<div class="pdfs_table_first_look_style">
							<div class="first_cell_text">'.$pdfs_row['name'].'</div>
						</div>
					</div>
					</a>
				';	
			}else{
				echo '
					<a href="'.$pdf_linking.'" '.$link_open.'>
					<div class="pdfs_cell">
						<div class="pdfs_photos_style"><img src="'.$pdfs_row['img_file'].'" class="pdfs_photo" /></div>
						<div class="pdfs_table_look_style">
							<div class="pdf_cell_text">'.$pdfs_row['name'].'</div>
						</div>
					</div>
					</a>
				';
			}
		}
		echo $back_to_main;
	?>
</body>
</html>