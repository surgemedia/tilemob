<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?
include('includes/meta.php'); //Meta tags
include('includes/variables.php'); //Global variables
include('includes/security.php'); //Security features
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out

if(!empty($_POST['delete_id'])) {	
	$delete_content_id = $_POST['delete_id'];
	//echo 'delete_news_id: '.$delete_news_id.'<br/>';
	mysql_query("UPDATE content SET is_deleted='1' WHERE ID='$delete_content_id'");
	echo '<script>self.location="manage_content.php?s2=Your page was successfully deleted.";</script>';
}
?>

<script>
function deleteContent(content_id) {
	if(prompt('Do you wish to delete this page?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = content_id;
		document.getElementById('deleteform').submit();
	} else {
		document.getElementById('delete_id').value = '';
	}
}
</script>
</head>
<body>
<div class="container">
   <div class="header"></div>
   <div class="navigation">
      <? include('includes/navigation.php'); ?>
   </div>
   <div class="middle">
      <h1>Edit page</h1>
		<?
		if($_GET['s1'] != '' || $_GET['s2'] != '' || $_GET['s3'] != '') {
			if($_GET['s1']!=''){$s = 1;}else if($_GET['s2']!=''){$s = 2;}else if($_GET['s3']!=''){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			echo '<div class="status'.$s.'">'.$status.'</div>';
			echo '<div class="clear"></div>';
		}
		?>
      <form id="form_content" name="form_content" method="post" action="">
         <table width="860" border="0" cellspacing="0" cellpadding="3" class="table1">
            <tr>
               <td colspan="2" class="table1_head"><h3>Page name</h3></td>
               <td width="100" class="table1_head">&nbsp;</td>
            </tr>
			<?php
			$result_content = mysql_query("SELECT * FROM content WHERE under_content_id = '0' AND is_locked != '1' AND is_custompage != '1' AND is_deleted != '1' ORDER BY ordering ASC");
			$content_count = 1;
			while($row_content = mysql_fetch_array($result_content)) {
				$content_id = $row_content['ID'];
				if($row_content['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
				echo '<tr><td colspan="2" class="table1_body"><a href="edit_content.php?id='.$content_id.'" title="Edit this page"><b>'.$content_count.'. '.stripslashes($row_content['pageheading']).'</b> '.$show_hidden.'</td><td align="right" class="table1_body"><a href="edit_content.php?id='.$content_id.'" title="Edit this page">edit</a></td></tr>';
				$result_subcontent = mysql_query("SELECT * FROM content WHERE under_content_id = '$content_id' AND is_locked != '1' AND is_deleted != '1' ORDER BY ordering ASC");
				$subcontent_count = 1;
				while($row_subcontent = mysql_fetch_array($result_subcontent)) {
					$subcontent_id = $row_subcontent['ID'];
					if($row_subcontent['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
					if($row_subcontent['is_custompage'] == '0') {
						echo '<tr><td width="20" class="table1_body">&nbsp;</td><td class="table1_body"><a href="edit_content.php?id='.$subcontent_id.'" title="Edit this page">'.stripslashes($row_subcontent['pageheading']).' '.$show_hidden.'</td><td align="right" class="table1_body"><a href="edit_content.php?id='.$subcontent_id.'" title="Edit this page">edit</a></td></tr>';
					} else {
						echo '<tr><td width="20" class="table1_body">&nbsp;</td><td class="table1_body"><a href="edit_content.php?id='.$subcontent_id.'" title="Edit this page">'.stripslashes($row_subcontent['pageheading']).' '.$show_hidden.'</td><td align="right" class="table1_body"><a href="edit_content.php?id='.$subcontent_id.'" title="Edit this page">edit</a> | <a href="#" onclick="deleteContent('.$subcontent_id.');">delete</a></td></tr>';
					}
					$subcontent_count++;
				}
				$content_count++;
			}
			//Custom pages
			$result_content = mysql_query("SELECT * FROM content WHERE is_custompage = '1' AND under_content_id = '' AND is_deleted != '1' ORDER BY ordering ASC");
			while($row_content = mysql_fetch_array($result_content)) {
				$content_id = $row_content['ID'];
				if($row_content['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
				echo '<tr><td colspan="2" class="table1_body"><a href="edit_content.php?id='.$content_id.'" title="Edit this page">'.$content_count.'. '.stripslashes($row_content['pageheading']).' '.$show_hidden.'</td><td align="right" class="table1_body"><a href="edit_content.php?id='.$content_id.'" title="Edit this page">edit</a> | <a href="#" onclick="deleteContent('.$content_id.');">delete</a></td></tr>';
				$content_count++;
			}
			?>
			<tr><td colspan="3" height="50"><input type="button" id="add_new_page" name="add_new_page" value="Add new page »" onclick="self.location='edit_content.php';"></td></tr>
		 </table>
      </form>
   </div>
   <div class="footer"></div>
</div>
<form id="deleteform" name="deleteform" method="post">
<input type="hidden" id="delete_id" name="delete_id" value="">
</form>
</body>
</html>
