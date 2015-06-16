<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
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
</head>
<body>
<div class="container">
   <div class="header"></div>
   <div class="navigation">
      <? include('includes/navigation.php'); ?>
   </div>
   <div class="middle">
      <h1><?php echo $form; ?></h1>
		<?
		if($_GET['s1'] != '' || $_GET['s2'] != '' || $_GET['s3'] != '') {
			if($_GET['s1']!=''){$s = 1;}else if($_GET['s2']!=''){$s = 2;}else if($_GET['s3']!=''){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			echo '<div class="status'.$s.'">'.$status.'</div>';
			echo '<div class="clear"></div>';
		}
		?>
      <div class="clear" style="margin-bottom:20px;"><input name="cancel" type="button" id="cancel" value="&laquo; Cancel, return to previous page" onclick="location.href='manage_forms.php';" class="button_1" /></div>
      
      <table width="860" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="60" class="table2_body"><h3>From</h3></td>
			<td class="table2_body"><?php echo $sendername.' ('.$senderemail.')'; ?></td>
		</tr>
		<tr>
			<td class="table3_body"><h3>Subject</h3></td>
			<td class="table3_body"><?php echo $subject; ?></td>
		</tr>
		<tr>
			<td class="table3_body"><h3>To</h3></td>
			<td class="table3_body"><?php echo $receivername.' ('.$receiveremail.')'; ?></td>
		</tr>
		<tr>
			<td class="table3_body"><h3>Date</h3></td>
			<td class="table3_body"><?php echo $datetime; ?></td>
		</tr>
		<tr>
			<td class="table1_body" colspan="2">
			<div style="padding-left:20px;padding-top:20px;padding-bottom:20px;font-family:Courier New;font-size:12px;line-height:16px;color:#000000;">
			<?php echo $message; ?>
			</div>
			</td>
		</tr>
	  </table>
      <p>&nbsp;</p>
   </div>
   <div class="footer"></div>
</div>
</body>
</html>