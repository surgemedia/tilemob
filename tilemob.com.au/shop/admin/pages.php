<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['delete_id'])) {	
	$delete_content_id = $_POST['delete_id'];
	mysql_query("UPDATE shop_content SET is_active='0' WHERE content_id='$delete_content_id'");
	header('location:pages.php?s2=Page was successfully deleted.');
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
<script type="text/javascript">
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
	<div id="middle" class="middle">
		<h1>Edit pages</h1>
		<?php
		if(!empty($_GET['s1']) || !empty($_GET['s2']) || !empty($_GET['s3'])) {
			$string = '';
			if(!empty($_GET['s1'])){$s = 1;}else if(!empty($_GET['s2'])){$s = 2;}else if(!empty($_GET['s3'])){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			$string .= '<div class="status'.$s.'">'.$status.'</div>';
			$string .= '<div class="clear"></div>';
			echo $string;
		}
		?>
		<div id="content" class="content">
			<form id="submitform" name="submitform" method="post">
			<table id="content-table" width="100%" class="table1">
				<thead>
					<tr>
						<th align="left">Page name</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$string = '';
				$result_content = mysql_query("SELECT * FROM shop_content WHERE under_content_id='0' AND is_active='1' ORDER BY ordering ASC");
				$content_count = 1;
				while($row_content = mysql_fetch_array($result_content)) {
					$content_id = $row_content['content_id'];
					if($row_content['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
					$string .= '
					<tr>
						<td align="left">
							<div class="float_left"><a href="edit-page.php?id='.$content_id.'" title="Edit this page">'.$content_count.'. <b>'.strip_tags($row_content['heading1']).'</b> ('.$row_content['linkname'].') '.$show_hidden.'</a></div>
							<div class="float_right"><a href="edit-page.php?id='.$content_id.'" title="Edit this page">edit</a></div>';
					$result_subcontent = mysql_query("SELECT * FROM shop_content WHERE under_content_id='$content_id' AND is_active='1' ORDER BY ordering ASC");
					$subcontent_count = 1;
					if(mysql_num_rows($result_subcontent) > 0) {
						$string .= '<table width="100%" class="table2">';
						while($row_subcontent = mysql_fetch_array($result_subcontent)) {
							$subcontent_id = $row_subcontent['content_id'];
							if($row_subcontent['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
							$string .= '
							<tr>
								<td width="20" align="left">&nbsp;</td>
								<td align="left"><a href="edit-page.php?id='.$subcontent_id.'" title="Edit this page">'.strip_tags($row_subcontent['heading1']).' '.$show_hidden.'</a></td>
								<td align="right"><a href="edit-page.php?id='.$subcontent_id.'" title="Edit this page">edit</a><!-- | <a href="#" onclick="deleteContent('.$subcontent_id.');">delete</a>--></td>
							</tr>';
							$subcontent_count++;
						}
						$string .= '</table>';
					}
					$string .= '</td></tr>';
					$content_count++;
				}
				//Custom pages
				/*$result_content = mysql_query("SELECT * FROM content WHERE is_custompage = '1' AND under_content_id = '' AND is_deleted != '1' ORDER BY ordering ASC");
				while($row_content = mysql_fetch_array($result_content)) {
					$content_id = $row_content['ID'];
					if($row_content['is_hidden']==1){$show_hidden = '<em style="color:#CCCCCC;">hidden</em>';}else{$show_hidden='';}
					$string .= '<tr><div class="float_left"><a href="edit-page.php?id='.$content_id.'" title="Edit this page">'.$content_count.'. '.stripslashes($row_content['pageheading']).' '.$show_hidden.'</div><div class="float_right"><a href="edit-page.php?id='.$content_id.'" title="Edit this page">edit</a> | <a href="#" onclick="deleteContent('.$content_id.');">delete</a></div></tr>';
					$content_count++;
				}*/
				echo $string;
				?>
				</tbody>
				<!--<tfoot>
					<tr><td colspan="3" height="60"><input type="button" id="add_new_page" name="add_new_page" value="New page" onclick="self.location='edit-page.php';" class="button1"></td></tr>
				</tfoot>-->
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