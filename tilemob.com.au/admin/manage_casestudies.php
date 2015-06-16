<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['delete_id'])) {	
	$delete_casestudy_id = $_POST['delete_id'];
	//echo 'delete_news_id: '.$delete_news_id.'<br/>';
	mysql_query("UPDATE casestudies SET is_deleted='1' WHERE casestudy_id='$delete_casestudy_id'");
	header('location:manage_casestudies.php?s2=Your case study was successfully deleted.');
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
function deleteCasestudy(casestudy_id) {
	if(prompt('Do you wish to delete this case study?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = casestudy_id;
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
      <h1>Edit case studies</h1>
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
               <td colspan="3" height="40" align="right"><input type="button" id="create_casestudy" name="create_casestudy" value="Create case study »" onclick="self.location='edit_casestudies.php';" class="button_1"></td>
            </tr>
            <tr>
				<td width="80" class="table1_head"><h3>Date</h3></td>
               <td class="table1_head"><h3>Headline</h3></td>
               <td width="100" class="table1_head">&nbsp;</td>
            </tr>
			<?php
			$result_casestudies = mysql_query("SELECT * FROM casestudies WHERE is_deleted != '1' ORDER BY casestudy_id DESC");
			$count = 1;
			while($row_casestudies = mysql_fetch_array($result_casestudies)) {
				$casestudy_id = $row_casestudies['casestudy_id'];
				$show_is_hidden = ($row_casestudies['is_hidden']==1) ? '<span style="color:#AAAAAA;"> (hidden)</span>' : '';
				echo '<tr><td class="table1_body">'.$row_casestudies['date'].'</td><td class="table1_body"><a href="edit_casestudies.php?id='.$casestudy_id.'" title="Edit this item"><b>'.stripslashes($row_casestudies['heading']).'</b>'.$show_is_hidden.'</td><td align="right" class="table1_body"><a href="edit_casestudies.php?id='.$casestudy_id.'" title="Edit this item">edit</a> | <a href="#" onclick="deleteCasestudy('.$casestudy_id.');">delete</a></td></tr>';
				$count++;
			}
			if(mysql_num_rows($result_casestudies) == 0) {
				echo '<tr><td colspan="2" height="40"><em>There are no case studies available.</em></td></tr>';
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
