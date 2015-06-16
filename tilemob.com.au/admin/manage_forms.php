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
      <h1>View forms</h1>
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
			<td colspan="5" align="right">
			<select id="export_form" name="export_form" style="padding:3px;">
			<option value="none">Please select a form to export »</option>
			<option value="contact_form">Contact form</option>
			<option value="quote_request_form">Request a Quote form</option>
			<option value="meeting_request_form">Request a Meeting form</option>
			<option value="friend_form">Send to a friend form</option>
			</select>
			<input type="button" id="export_button" name="export_button" value="Export" onclick="if(document.getElementById('export_form').value!='none'){self.location='export-form-to-file.php?form='+document.getElementById('export_form').value;}else{alert('Please select a form to export');}">
			</td>
			</tr>
            <tr>
			   <td width="20" class="table1_head"><h3>#</h3></td>
			   <td width="75" class="table1_head"><h3>Date</h3></td>
               <td class="table1_head"><h3>Subject</h3></td>
			   <td width="250" class="table1_head"><h3>From</h3></td>
               <td width="80" class="table1_head">&nbsp;</td>
            </tr>
			<?php
			$result_forms = mysql_query("SELECT * FROM forms WHERE is_deleted != '1' ORDER BY form_id DESC");
			
			//For page numbers
			$total_rows = mysql_num_rows($result_forms);
			$maximum_rows = 20;
			$total_pages = ceil($total_rows/$maximum_rows);
			if(!empty($_GET['p'])){$current_page=$_GET['p'];}else{$current_page = 1;}
			$start_rows = ($current_page*$maximum_rows)-$maximum_rows; //mysql LIMIT starts at 0
			if($current_page==1){$start_rows=0;}
			$end_rows = $start_rows+$maximum_rows;
			$result_forms = mysql_query("SELECT * FROM forms WHERE is_deleted != '1' ORDER BY form_id DESC LIMIT $start_rows, $end_rows");
			
			$count = 1;
			$string = '';
			while($row_forms = mysql_fetch_array($result_forms)) {
				$form_id = $row_forms['form_id'];
				$datetime = date('d/m/Y g:i A', $row_forms['strtotime']);
				if(date('d/m/Y', $row_forms['strtotime']) == date('d/m/Y')) {
					$datetime = date('g:i A', $row_forms['strtotime']);
				} else {
					$datetime = date('d/m/Y', $row_forms['strtotime']);
				}
				$string .= '<tr><td class="table1_body">'.$count.'. </td>';
				$string .= '<td class="table1_body">'.$datetime.'</td>';
				$string .= '<td class="table1_body"><a href="view_form.php?id='.$form_id.'" title="View">'.$row_forms['subject'].'</a></td>';
				$string .= '<td class="table1_body">'.$row_forms['senderemail'].'</td>';
				$string .= '<td align="right" class="table1_body"><a href="view_form.php?id='.$form_id.'" title="View">view</a></td></tr>';
				$count++;
			}
			if(mysql_num_rows($result_forms) == 0) {
				echo '<tr><td colspan="4"><em>There are no forms currently available.</em></td></tr>';
			}
			
			//page numbers			
			if($total_pages > 1) {
				$string .= '<tr><td height="40" colspan="5" align="right">Page: ';
				for($i=1; $i < ($total_pages+1); $i++) {	
					if($i==$current_page){$string.='<b>'.$i.'</b>';}else{$string.='<a href="manage_forms.php?p='.$i.'">'.$i.'</a>';}
					if($i<$total_pages){$string.=' | ';}
				}
				$string .= '</td></tr>';
			}
			
			echo $string;
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
