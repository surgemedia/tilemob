<?
//Force no-cache
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
session_start();

include('../../../CdbSecurityFolders/dbconnection.php'); //Database connections
include('includes/checklogin.php'); //Check login 

if(!empty($_POST['delete_id'])) {	
	$delete_brochure_id = $_POST['delete_id'];
	//echo 'delete_news_id: '.$delete_news_id.'<br/>';
	$result_brochures = mysql_query("SELECT * FROM brochures WHERE brochure_id='$delete_brochure_id'");
	if($row_brochures = mysql_fetch_array($result_brochures)) {
		if(is_file('../'.$row_brochures['filepath'])) {
			rename('../'.$row_brochures['filepath'], '../'.$row_brochures['filepath'].'_'.strtotime('now').'_deleted');
		}
		mysql_query("UPDATE brochures SET is_active='0' WHERE brochure_id='$delete_brochure_id'");
		header('location:manage_brochures.php?s2=Your brochure was successfully deleted.');
	} else {
		header('location:manage_brochures.php?s3=Your brochure could not be deleted. Brochure does not exist.');
	}
}

//upload new brochure
if(!empty($_FILES['new_brochure'])) {
	if(trim($_FILES['new_brochure']['name']) != '') {
		$brochuredir_path = '../brochures/';
		$brochuredir_path2 = 'brochures/';
		if(!is_dir($brochuredir_path)) {
			//image directory
			mkdir($brochuredir_path, 0777); 
		}
		//check if brochure filename already exists or not (rename if it does)
		$check_brochure_filepath = $brochuredir_path2.$_FILES['new_brochure']['name'];
		$result_brochures_check = mysql_query("SELECT * FROM brochures WHERE filepath = '$check_brochure_filepath' AND is_active='1'");
		if(mysql_num_rows($result_brochures_check) > 0) {
			$brochures_filepath = $brochuredir_path.strtotime('now').'_'.$_FILES['new_brochure']['name'];
			$brochures_filepath2 = $brochuredir_path2.strtotime('now').'_'.$_FILES['new_brochure']['name'];
		} else {
			$brochures_filepath = $brochuredir_path.$_FILES['new_brochure']['name']; //move_uploaded_file version
			$brochures_filepath2 = $brochuredir_path2.$_FILES['new_brochure']['name']; //db insert version
		}
		if (move_uploaded_file($_FILES['new_brochure']['tmp_name'], $brochures_filepath)) {
			mysql_query("INSERT INTO brochures (brochure_id, filepath, is_active) VALUES 
			('', '$brochures_filepath2', '1')");
			header('location:manage_brochures.php?s2=Your brochure was successfully uploaded');
		} else {
			header('location:manage_brochures.php?s3=Your brochure could not be uploaded. Please check the file and try again.');
		}
	}
}

//replace existing brochures 
if($_POST['update']) {
	$brochuredir_path = '../brochures/';
	$brochuredir_path2 = 'brochures/';
	$result_brochures = mysql_query("SELECT * FROM brochures WHERE filepath != '' AND is_active = '1'");
	while($row_brochures = mysql_fetch_array($result_brochures)) {
		$this_brochure_id = $row_brochures['brochure_id'];
		$old_filepath = '../'.$row_brochures['filepath'];
		if(!empty($_FILES['brochure_'.$this_brochure_id])) {
			if(trim($_FILES['brochure_'.$this_brochure_id]['name']) != '') {
				//check if brochure filename already exists or not (rename if it does)
				$check_brochure_filepath = $brochuredir_path2.$_FILES['brochure_'.$this_brochure_id]['name'];
				$result_brochures_check = mysql_query("SELECT * FROM brochures WHERE filepath = '$check_brochure_filepath' AND is_active='1'");
				if(mysql_num_rows($result_brochures_check) > 0) {
					$brochures_filepath = $brochuredir_path.strtotime('now').'_'.$_FILES['brochure_'.$this_brochure_id]['name'];
					$brochures_filepath2 = $brochuredir_path2.strtotime('now').'_'.$_FILES['brochure_'.$this_brochure_id]['name'];
				} else {
					$brochures_filepath = $brochuredir_path.$_FILES['brochure_'.$this_brochure_id]['name']; //move_uploaded_file version
					$brochures_filepath2 = $brochuredir_path2.$_FILES['brochure_'.$this_brochure_id]['name']; //db insert version
				}
				//upload it
				if (move_uploaded_file($_FILES['brochure_'.$this_brochure_id]['tmp_name'], $brochures_filepath)) {
					if(is_file($old_filepath)) {
						@unlink($old_filepath);
					}
					mysql_query("UPDATE brochures SET filepath='$brochures_filepath2' WHERE brochure_id='$this_brochure_id'");
				}
			}
		}
	}
	header('location:manage_brochures.php?s2=Brochures successfully updated.');
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
function deleteBrochure(brochure_id) {
	if(prompt('Do you wish to delete this brochure?\nPlease type yes below:') == 'yes') {
		document.getElementById('delete_id').value = brochure_id;
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
      <h1>Manage brochures</h1>
		<?
		if($_GET['s1'] != '' || $_GET['s2'] != '' || $_GET['s3'] != '') {
			if($_GET['s1']!=''){$s = 1;}else if($_GET['s2']!=''){$s = 2;}else if($_GET['s3']!=''){$s = 3;}
			$status = $_GET['s'.$s];
			//s1: notice | s2: success | s3: error 
			echo '<div class="status'.$s.'">'.$status.'</div>';
			echo '<div class="clear"></div>';
		}
		?>
      <form id="form_content" name="form_content" method="post" enctype="multipart/form-data" action="" >
         <table width="860" border="0" cellspacing="0" cellpadding="3" class="table1">
			<tr>
               <td colspan="4" height="40" align="right"><b>Upload a brochure: </b><input type="file" id="new_brochure" name="new_brochure"><input type="submit" id="upload" name="upload" value="Upload"></td>
            </tr>
            <tr>
			   <td width="20" class="table1_head"><h3>#</h3></td>
               <td width="220" class="table1_head"><h3>Replace file</h3></td>
			   <td class="table1_head"><h3>Brochure</h3></td>
			   <td width="100" class="table1_head">&nbsp;</td>
            </tr>
			<?php
			$result_brochures = mysql_query("SELECT * FROM brochures WHERE is_active = '1'");
			$count = 1;
			$string = '';
			while($row_brochures = mysql_fetch_array($result_brochures)) {
				$brochure_id = $row_brochures['brochure_id'];
				if(is_file('../'.$row_brochures['filepath'])) {
					$string .= '<tr><td class="table1_body">'.$count.'.</td>';
					$string .= '<td class="table1_body"><input type="file" id="brochure_'.$row_brochures['brochure_id'].'" name="brochure_'.$row_brochures['brochure_id'].'"></td>';
					$string .= '<td class="table1_body"><a href="../'.$row_brochures['filepath'].'" target="_blank" title="View this brochure">'.basename($row_brochures['filepath']).'</a></td>';
					$string .= '<td align="right" class="table1_body"><a href="#" onclick="deleteBrochure('.$row_brochures['brochure_id'].');return false;">Remove</a></td></tr>';
					$count++;
				}
			}
			if(mysql_num_rows($result_brochures) == 0) {
				$string .= '<tr><td colspan="4" height="40"><em>There are no brochures available.</em></td></tr>';
			} else {
				$string .= '<tr><td colspan="4" height="40" align="right"><input type="submit" id="update" name="update" value="Update"></td></tr>';
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
