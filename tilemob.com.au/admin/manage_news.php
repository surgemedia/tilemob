<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['delete_id'])) {	
	$delete_news_id = $_POST['delete_id'];
	//echo 'delete_news_id: '.$delete_news_id.'<br/>';
	mysql_query("UPDATE news SET is_deleted='1' WHERE news_id='$delete_news_id'");
	header('location:manage_news.php?s2=Your news item was successfully deleted.');
}
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
?>
<script>
function deleteNews(news_id) {
	if(prompt('Do you wish to delete this news item?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = news_id;
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
      <h1>Edit news</h1>
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
               <td colspan="3" height="40" align="right"><input type="button" id="create_news" name="create_news" value="Create news item »" onclick="self.location='edit_news.php';" class="button_1"></td>
            </tr>
            <tr>
				<td width="80" class="table1_head"><h3>Date</h3></td>
               <td class="table1_head"><h3>Headline</h3></td>
               <td width="100" class="table1_head">&nbsp;</td>
            </tr>
			<?php
			$result_news = mysql_query("SELECT * FROM news WHERE is_deleted != '1' ORDER BY news_id DESC");
			$news_count = 1;
			while($row_news = mysql_fetch_array($result_news)) {
				$news_id = $row_news['news_id'];
				$show_is_hidden = ($row_news['is_hidden']==1) ? '<span style="color:#AAAAAA;"> (hidden)</span>' : '';
				echo '<tr><td class="table1_body">'.$row_news['date'].'</td><td class="table1_body"><a href="edit_news.php?id='.$news_id.'" title="Edit this item"><b>'.stripslashes($row_news['heading']).'</b>'.$show_is_hidden.'</td><td align="right" class="table1_body"><a href="edit_news.php?id='.$news_id.'" title="Edit this item">edit</a> | <a href="#" onclick="deleteNews('.$news_id.');">delete</a></td></tr>';
				$news_count++;
			}
			if(mysql_num_rows($result_news) == 0) {
				echo '<tr><td colspan="2" height="40"><em>There are no news items available.</em></td></tr>';
			}
			?>
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
