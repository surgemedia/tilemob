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
	$delete_id = $_POST['delete_id'];
	//echo 'delete_news_id: '.$delete_news_id.'<br/>';
	mysql_query("UPDATE biography SET is_active='0' WHERE biography_id='$delete_id'");
	echo '<script>self.location="manage_biography.php?s2=Biography was successfully deleted.";</script>';
}
?>

<script>
function deleteThis(id, name) {
	if(prompt('Do you wish to delete '+name+'?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = id;
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
		<h1>Directors</h1>
         <table width="860" border="0" cellspacing="0" cellpadding="3" class="table1">
            <tr>
               <td colspan="2" class="table1_head"><h3>Name</h3></td>
               <td width="100" class="table1_head">&nbsp;</td>
            </tr>
			<?php
			$string = '';
			$result_biography = mysql_query("SELECT * FROM biography WHERE category = 'director' AND is_active = '1' ORDER BY ordering ASC");
			$count = 1;
			while($row_biography = mysql_fetch_array($result_biography)) {
				$biography_id = $row_biography['biography_id'];
				if($row_biography['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
				$string .= '<tr><td colspan="2" class="table1_body"><a href="edit_biography.php?id='.$biography_id.'" title="Edit this page"><b>'.$count.'. '.stripslashes($row_biography['name']).'</b> '.$show_hidden.'</td><td align="right" class="table1_body"><a href="edit_biography.php?id='.$biography_id.'" title="Edit this page">edit</a> | <a href="#" onclick="deleteThis('.$biography_id.', \''.$row_biography['name'].'\');" title="Delete">delete</a></td></tr>';
				$count++;
			}
			if(mysql_num_rows($result_biography) == 0) {
				$string .= '<tr><td colspan="3" class="table1_body"><em>There are no directors to list.</em></td></tr>';
			}
			echo $string;
			?>
		</table>
		 <!--
		 <h1 style="margin-top:30px;">Producers</h1>
         <table width="860" border="0" cellspacing="0" cellpadding="3" class="table1">
            <tr>
               <td colspan="2" class="table1_head"><h3>Name</h3></td>
               <td width="100" class="table1_head">&nbsp;</td>
            </tr>
			<?php
			$string = '';
			$result_biography = mysql_query("SELECT * FROM biography WHERE category = 'producer' AND is_active = '1' ORDER BY ordering ASC");
			$count = 1;
			while($row_biography = mysql_fetch_array($result_biography)) {
				$biography_id = $row_biography['biography_id'];
				if($row_biography['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
				$string .= '<tr><td colspan="2" class="table1_body"><a href="edit_biography.php?id='.$biography_id.'" title="Edit this page"><b>'.$count.'. '.stripslashes($row_biography['name']).'</b> '.$show_hidden.'</td><td align="right" class="table1_body"><a href="edit_biography.php?id='.$biography_id.'" title="Edit this page">edit</a> | <a href="#" onclick="deleteThis('.$biography_id.', \''.$row_biography['name'].'\');" title="Delete">delete</a></td></tr>';
				$count++;
			}
			if(mysql_num_rows($result_biography) == 0) {
				$string .= '<tr><td colspan="3" class="table1_body"><em>There are no producers to list.</em></td></tr>';
			}
			echo $string;
			?>
			<tr><td colspan="3" height="50"><input type="button" id="add" name="add" value="Add a director/producer »" onclick="self.location='add_biography.php';"></td></tr>
		 </table>
		 -->
      </form>
   </div>
   <div class="footer"></div>
</div>
<form id="deleteform" name="deleteform" method="post">
<input type="hidden" id="delete_id" name="delete_id" value="">
</form>
</body>
</html>
