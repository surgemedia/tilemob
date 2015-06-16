<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

$new_item = true;
if(!empty($_GET['id'])) {
	$casestudy_id = $_GET['id'];
	$result_casestudies = mysql_query("SELECT * FROM casestudies WHERE casestudy_id='$casestudy_id'");
	if($row_casestudies = mysql_fetch_array($result_casestudies)) {
		$new_item = false;
		$heading = stripslashes($row_casestudies['heading']);
		$date = $row_casestudies['date'];
		$short = $row_casestudies['short'];
		$body = $row_casestudies['body']; 
		$body2 = $row_casestudies['body2']; 
		$filename = $row_casestudies['filename']; 
		if ($row_casestudies['is_hidden'] == 1) {
			$is_hidden = 'checked="checked"';
		} else {
			$is_hidden = '';
		}
	}
} else {
	//new case studies
}

//Save
if(!empty($_GET['id']) && $_POST['save_casestudy'] && !empty($_POST['date']) && !empty($_POST['heading'])){
	$casestudy_id = $_GET['id'];
	$heading = stripslashes($_POST['heading']);
	$date = $_POST['date'];
	$short = $_POST['short'];
	$body = $_POST['body']; 
	$body2 = $_POST['body2']; 
	if ($_POST['is_hidden'] == 1) {
		$is_hidden = 1;
	} else {
		$is_hidden = 0;
	}
	
	$hourOffset_timedate = strtotime("+15 hour");
	$last_updated =  date("d/m/Y (h:i a)", $hourOffset_timedate);
	
	$casestudy_filename = strtotime('now').'_'.$_FILES['upload_file']['name'];
	$target_path = '../casestudies/'.$casestudy_filename;
	
	if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $target_path)) {
		//Delete previous file
		if(is_file('../casestudies/'.$filename)) { 
			unlink('../casestudies/'.$filename);
		}
		//Update database
		mysql_query("UPDATE casestudies SET 
					date = '$date',
					heading = '$heading',
					is_hidden = '$is_hidden',
					short = '$short',
					body = '$body',
					body2 = '$body2',
					filename = '$casestudy_filename'
					WHERE casestudy_id = '$casestudy_id'") or die(mysql_error());	//Done.

		//All done
		header('location:edit_casestudies.php?id='.$casestudy_id.'&s2='.$heading.' was successfully saved.');
	} else {
		header('location:edit_casestudies.php?id='.$casestudy_id.'&s2='.$heading.' could not be updated. Please check your file and try again.');
	}
}

//Add
if($_POST['add_casestudy'] && !empty($_POST['date']) && !empty($_POST['heading'])){
	$casestudy_id = $_GET['id'];
	$heading = stripslashes(trim($_POST['heading']));
	$date = trim($_POST['date']);
	$short = trim($_POST['short']);
	$body = trim($_POST['body']); 
	$body2 = trim($_POST['body2']); 
	if ($_POST['is_hidden'] == 1) {
		$is_hidden = 1;
	} else {
		$is_hidden = 0;
	}
	
	$hourOffset_timedate = strtotime("+15 hour");
	$last_updated =  date("d/m/Y (h:i a)", $hourOffset_timedate);
	
	$casestudy_filename = strtotime('now').'_'.$_FILES['upload_file']['name'];
	$target_path = '../casestudies/'.$casestudy_filename;
	
	if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $target_path)) {
		//Update database
		mysql_query("UPDATE casestudies SET 
					date = '$date',
					heading = '$pageheading',
					is_hidden = '$is_hidden',
					short = '$short',
					body = '$body',
					body2 = '$body2',
					filename = '$casestudy_filename'
					WHERE casestudy_id = '$casestudy_id'") or die(mysql_error());	//Done.
		mysql_query("INSERT INTO casestudies 
		(casestudy_id, ordering, date, heading, short, body, body2, is_deleted, is_hidden)
		VALUES 
		('','99','$date','$heading','$short','$body','$body2','0','$is_hidden')");

		//All done
		header('location:manage_casestudies.php?id='.$casestudy_id.'&s2='.$heading.' was successfully created.');
	} else {
		header('location:manage_casestudies.php?Your case study could not be created. Please check your file and try again.');
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
<?php
$cur_servdir = '/'.substr(dirname($_SERVER['PHP_SELF']), 1).'/';
?>
function loadEditor() {
	var editor = CKEDITOR.replace('body',{
	height:"700",
	toolbar:'toolbar1',
	filebrowserBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserImageBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserFlashBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php'
	});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
	
	var editor2 = CKEDITOR.replace('body2',{
	height:"700",
	toolbar:'toolbar2',
	filebrowserBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserImageBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php',
	filebrowserFlashBrowseUrl : '<?php echo $cur_servdir;?>ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo $cur_servdir;?>ckeditor/filemanager/connectors/php/connector.php'
	});
	CKEDITOR.config.contentsCss = 'ckeditor/css/editor.css' ;
	CKEDITOR.config.forcePasteAsPlainText = true;
}
function checkFields() {
	//alert("checking fields");
	emptyfields = "";
	if (document.getElementById('date').value == "") {
		emptyfields += "\n   *Case Study date";
	}
	if (document.getElementById('heading').value == "") {
		emptyfields += "\n   *Heading";
	}
	
	//alert("checking fields");
	if (emptyfields!= "") { //mandatories not completed!
		emptyfields = "These fields cannot be empty:\n" +
		emptyfields + "\n\nPlease fill in all fields marked with *";
		alert(emptyfields);
		return false;
	} else { //all mandatories filled in!
		return true;
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
      <h1>Case study </h1>
		<?
		if($_GET['s1'] != '' || $_GET['s2'] != '' || $_GET['s3'] != '') {
			if($_GET['s1']!=''){$s = 1;}else if($_GET['s2']!=''){$s = 2;}else if($_GET['s3']!=''){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			echo '<div class="status'.$s.'">'.$status.'</div>';
			echo '<div class="clear"></div>';
		}
		?>
      <div class="clear" style="margin-bottom:20px;"><input name="cancel" type="button" id="cancel" value="&laquo; Cancel, return to previous page" onclick="location.href='manage_casestudies.php';" class="button_1" /></div>
      <div class="clear" style="height:20px;"><img src="images/1pixel_grey.gif" alt="divider" width="960" height="1" vspace="10" border="0" /></div>
      <h2>Please make changes to page content below. </h2>
      <form id="submitform" name="submitform" method="post" enctype="multipart/form-data" action="" onsubmit='return checkFields();'>
         <table width="960" border="0" cellspacing="3" cellpadding="0">
            <tr>
               <td width="130">&nbsp;</td>
               <td width="200">&nbsp;</td>
               <td width="70">&nbsp;</td>
               <td width="400">&nbsp;</td>
            </tr>
			<tr>
               <td><h3>Case Study date: *</h3></td>
               <td colspan="3"><input name="date" type="text" class="textfield_1" id="date" value="<?=$date;?>" /></td>
            </tr>
			<tr>
               <td><h3>Heading: *</h3></td>
               <td colspan="3"><input name="heading" type="text" class="textfield_1" id="heading" value="<?=$heading;?>" /></td>
            </tr>
			<tr>
               <td><h3>Hide: </h3></td>
               <td colspan="3"><input type="checkbox" id="is_hidden" name="is_hidden" value="1" <?php echo $is_hidden; ?>/></td>
            </tr>
			<tr><td colspan="4">&nbsp;</td></tr>
            <tr>
               <td><h3>Case Study PDF/other file: *</h3></td>
			   <td colspan="3">
			   <input type="file" id="upload_file" name="upload_file"> 
			   <?php
			   if(is_file('../casestudies/'.$filename)) {
					echo '<a href="../casestudies/'.$filename.'" target="_blank"><em>File available</em></a>';
			   }
			   ?>
			   </td>
			</tr>
			<tr><td colspan="4">&nbsp;</td></tr>			
            <tr>
               <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
               <td colspan="3" align="left" valign="middle"><input name="cancel2" type="button" id="cancel2" value="&laquo; Cancel, return to previous page" onclick="location.href='manage_casestudies.php';" class="button_1" /></td>
               <td align="right" valign="middle">
			   <?php
			   if($new_item) {
					echo '<input name="add_casestudy" type="submit" id="add_casestudy" value="Add case study &raquo;" class="button_1" />';
			   } else {
					echo '<input name="save_casestudy" type="submit" id="save_casestudy" value="Save changes &raquo;" class="button_1" />';
			   }
			   ?></td>
            </tr>
         </table>
      </form>
      <p>&nbsp;</p>
   </div>
   <div class="footer"></div>
</div>
</body>
</html>