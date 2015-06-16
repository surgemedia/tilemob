<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['delete_id'])) {	
	$delete_content_id = $_POST['delete_id'];
	//echo 'delete_news_id: '.$delete_news_id.'<br/>';
	mysql_query("UPDATE content SET is_deleted='1' WHERE ID='$delete_content_id'");
	echo header('location:pages.php?s2=Page was successfully deleted.');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
include('includes/meta.php'); //Meta tags
include('includes/variables.php'); //Global variables
include('includes/security.php'); //Security features
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
include('includes/other.php'); //Other things missed out
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
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle" style="width:800px;">
		<h1>Forms</h1>
		<?php
		if(!empty($_GET['s1']) || !empty($_GET['s2']) || !empty($_GET['s3'])) {
			if(!empty($_GET['s1'])){$s = 1;}else if(!empty($_GET['s2'])){$s = 2;}else if(!empty($_GET['s3'])){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			echo '<div class="status'.$s.'">'.$status.'</div>';
			echo '<div class="clear"></div>';
		}
		?>
		<div id="content" class="content">
			<form id="submitform" name="submitform" method="post">
			<table width="100%" class="table1">
				<tr>
					<th colspan="5" align="right">
						<select id="export_form" name="export_form" style="padding:5px;">
							<option value="none">Please select a form to export »</option>
							<option value="contact_form">Contact form</option>
							<option value="appointment_form">Appointment Request Form</option>
							<!--<option value="quote_request_form">Request a Quote form</option>-->
						</select>
						<input type="button" id="export_button" name="export_button" value="Export" onclick="if(document.getElementById('export_form').value!='none'){self.location='export-form-to-file.php?form='+document.getElementById('export_form').value;}else{alert('Please select a form to export');}">
					</th>
				</tr>
				<tr>
				   <th align="left" width="30">#</th>
				   <th align="left" width="80">Date</th>
				   <th align="left">Subject</th>
				   <th align="left" width="250">From</th>
				   <th width="60">&nbsp;</th>
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
					$string .= '<tr><td align="left">'.$count.'. </td>';
					$string .= '<td align="left">'.$datetime.'</td>';
					$string .= '<td align="left"><a href="view-form.php?id='.$form_id.'" title="View">'.$row_forms['subject'].'</a></td>';
					$string .= '<td align="left">'.$row_forms['senderemail'].'</td>';
					$string .= '<td align="center"><a href="view-form.php?id='.$form_id.'" title="View">view</a></td></tr>';
					$count++;
				}
				if(mysql_num_rows($result_forms) == 0) {
					echo '<tr><td colspan="4"><em>There are no forms available.</em></td></tr>';
				}
				
				//page numbers			
				if($total_pages > 1) {
					$string .= '<tr><td height="40" colspan="5" align="right">Page: ';
					for($i=1; $i < ($total_pages+1); $i++) {	
						if($i==$current_page){$string.='<b>'.$i.'</b>';}else{$string.='<a href="forms.php?p='.$i.'">'.$i.'</a>';}
						if($i<$total_pages){$string.=' | ';}
					}
					$string .= '</td></tr>';
				}
				
				echo $string;
				?>
			 </table>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
</div>
<form id="deleteform" name="deleteform" method="post">
<input type="hidden" id="delete_id" name="delete_id" value="">
</form>
<?php include('includes/end_body.php'); ?>
</body>
</html>