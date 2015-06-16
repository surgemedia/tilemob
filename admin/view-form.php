<?php
session_start();
include('includes/prerun.php');
include('includes/connection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_GET['id'])) {
	$form_id = $_GET['id'];
	$result_forms = mysql_query("SELECT * FROM forms WHERE form_id='$form_id' AND is_deleted != '1'");
	if($row_forms = mysql_fetch_array($result_forms)) {
		$form = $row_forms['form'];
		$subject = $row_forms['subject'];
		$message = nl2br($row_forms['message']);
		$datetime = date('d/m/Y g:i A', $row_forms['strtotime']);
		$sendername = $row_forms['sendername'];
		$senderemail = $row_forms['senderemail'];
		$receivername = $row_forms['receivername'];
		$receiveremail = $row_forms['receiveremail'];
		
	}
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
</head>
<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="navigation" class="navigation"><?php include('includes/navigation.php'); ?></div>
	<div id="middle" class="middle" style="width:800px;">
		<h1><?php echo $form; ?></h1>
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
			<div class="clear" style="margin-bottom:20px;"><input name="cancel" type="button" id="cancel" value="&laquo; Cancel, go back" onclick="location.href='forms.php';" class="button1" /><hr/></div>
			<table width="100%" class="table1">
			<tr>
				<td width="80" align="left"><b>From</b></td>
				<td align="left"><?php echo $sendername.' ('.$senderemail.')'; ?></td>
			</tr>
			<tr>
				<td align="left"><b>Subject</b></td>
				<td align="left"><?php echo $subject; ?></td>
			</tr>
			<tr>
				<td align="left"><b>To</b></td>
				<td align="left"><?php echo $receivername.' ('.$receiveremail.')'; ?></td>
			</tr>
			<tr>
				<td align="left"><b>Date</b></td>
				<td align="left"><?php echo $datetime; ?></td>
			</tr>
			<tr>
				<td align="left" colspan="2">
					<div style="padding-left:20px;padding-top:20px;padding-bottom:20px;font-family:Courier New;font-size:12px;line-height:16px;color:#000000;">
					<?php echo $message; ?>
					</div>
				</td>
			</tr>
			</table>
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