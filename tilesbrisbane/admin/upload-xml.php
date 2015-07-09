<?php
session_start();
include('includes/prerun.php');
include('../../dbconnect.php'); //Database connections
include('includes/checklogin.php'); //Check login 

$xml_dir = 'xml/';
$images_dir = '../images/items/';
$strtotime_now = microtime();
$xml_zipsrc = $xml_dir.$strtotime_now.'.zip';
$xml_tempdir = $xml_dir.$strtotime_now.'/';
if(move_uploaded_file($_FILES['xmlzip']['tmp_name'], $xml_zipsrc)) {
	$zip = zip_open($xml_zipsrc);
	if(is_resource($zip)){
		$xml_files = $image_files = array();
		while(($zip_entry=zip_read($zip))!==false){
			$filename = basename(zip_entry_name($zip_entry));
			echo 'found: '.$filename.'<br/>';
			if(!is_dir($xml_dir.$strtotime_now)){
				@mkdir($xml_dir.$strtotime_now, 0777, true);
			}
			echo $xml_tempdir.$filename.'<br/>';
			file_put_contents($xml_tempdir.$filename, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
			$file_extension = strtolower(substr($filename, strrpos($filename, '.')+1));
			if($file_extension=='xml') {
				$xml_files[] = $xml_tempdir.$filename;
			} else if ($file_extension=='jpg'||$file_extension=='gif'||$file_extension=='png'||$file_extension=='jpeg'||$file_extension=='tif'||$file_extension=='bmp') {
				$image_files[] = $xml_tempdir.$filename;
			}
		}
		@unlink($xml_zipsrc);
		//corresponding tables for the xml files
		$data_correspondence = array(
			'WebItemsExport.xml'=>'shop_webitems','Colour.xml'=>'shop_colour',
			'Size.xml'=>'shop_size','Surface.xml'=>'shop_surface','Thickness.xml'=>'shop_thickness',
			'PeiRating.xml'=>'shop_peirating','Type.xml'=>'shop_type','Pattern.xml'=>'shop_pattern',
			'Material.xml'=>'shop_material','Edge.xml'=>'shop_edge','SlipRating.xml'=>'shop_sliprating',
			'Use.xml'=>'shop_use','RelatedTo.xml'=>'shop_relatedto');
		//parse selected XML files
		$xml_transfer_details = '';
		if(!empty($data_correspondence)) {			
			foreach($data_correspondence as $xml_file_name => $sql_table_name) {
				if(is_file($xml_tempdir.$xml_file_name)) {			
					$parseXML_feedback = parseXML($xml_tempdir.$xml_file_name, $sql_table_name);
					$xml_transfer_details .= 'Found '.$xml_file_name.' for '.$sql_table_name.', now parsing XML for SQL:<br/> '.$parseXML_feedback.'<br/>';
				}
			}
			//echo $xml_transfer_details;
		}
		//copy images
		if(!empty($image_files)) {
			foreach($image_files as $key => $image_file_name) {
				@copy($xml_tempdir.$image_file_name, $images_dir.$image_file_name);
				$xml_transfer_details .= 'Copied '.$image_file_name.' to '.$images_dir.$image_file_name.'<br/>';
			}
		}
	}
}

function parseXML($xml_file, $sql_table) {
	$xml = simplexml_load_file($xml_file);
	$output = $xml_string = $sql_columns = $sql_values = '';
	$items_array = array();
	$item_index = 0;
	foreach($xml->children() as $child) {
		$child_name = $child->getName();
		$xml_string .= '<br/>'.$child_name.': <br/>';
		foreach($child->children() as $subchild) {
			$subchild_name = $subchild->getName();
			$items_array[$item_index][$subchild_name] = $subchild;
			$xml_string .= ' - '.$subchild_name.': '.$subchild.'<br/>';
		}
		$item_index++;
	}
	//get columns
	$sql_columns = array();
	$result = mysql_query("SHOW COLUMNS FROM $sql_table");
	if(mysql_num_rows($result)>0) {
		while($row = mysql_fetch_assoc($result)) {
			$sql_columns[] = $row['Field'];
		}
	}
	//SQL query
	$items_array_count = count($items_array);
	if($items_array_count>0) {
		for($i=0; $i<$items_array_count; $i++) { //xml data rows
			$query_updates = $query_columns = $query_values = '';
			foreach($sql_columns as $key => $column) { //match to each sql column
				//$output .= $column.': '.$items_array[$i][$column].', ';
				$item_column_value = $items_array[$i][$column];
				if(!empty($item_column_value)) {
					$column_value = $item_column_value;
					$query_columns .= '`'.$column.'`, ';
					$safe_column_value = mysql_real_escape_string(trim($column_value));
					$query_values .= '\''.$safe_column_value.'\', ';
					if($column!='Code') {
						$query_updates .= '`'.$column.'`=\''.$safe_column_value.'\', '; //update column with value
					}
				} else {
					$column_value = '';
				}
			}
			$query_columns = substr(trim($query_columns), 0, -1);
			$query_values = substr(trim($query_values), 0, -1);
			$query_updates = substr(trim($query_updates), 0, -1);
			$item_code = $items_array[$i]['Code']; //all tables have Code column			
			//check if data exists in sql
			$result_check_exists = mysql_query("SELECT * FROM $sql_table WHERE Code='$item_code' AND is_active='1'");
			if(mysql_num_rows($result_check_exists)>0) {
				//update existing
				mysql_query("UPDATE $sql_table SET $query_updates WHERE Code='$item_code' AND is_active='1'");
				$output .= '<pre>UPDATE '.$sql_table.' SET '.$query_updates.' WHERE Code=\''.$item_code.'\' AND is_active=\'1\'</pre>';				
			} else {
				//insert nonexisting
				mysql_query("INSERT INTO $sql_table ($query_columns) VALUES ($query_values)") or die(mysql_error());
				$output .= '<pre>INSERT INTO '.$sql_table.' ('.$query_columns.' ) VALUES ('.$query_values.')</pre>';
			}
		}
	}
	return $output;
	echo $xml_string;
}
$data_correspondence = array(
			'WebItemsExport.xml'=>'shop_webitems','Colour.xml'=>'shop_colour',
			'Size.xml'=>'shop_size','Surface.xml'=>'shop_surface','Thickness.xml'=>'shop_thickness',
			'PeiRating.xml'=>'shop_peirating','Type.xml'=>'shop_type','Pattern.xml'=>'shop_pattern',
			'Material.xml'=>'shop_material','Edge.xml'=>'shop_edge','SlipRating.xml'=>'shop_sliprating',
			'Use.xml'=>'shop_use','RelatedTo.xml'=>'shop_relatedto');
		//parse selected XML files
		$xml_transfer_details = '';
		if(!empty($data_correspondence)) {			
			foreach($data_correspondence as $xml_file_name => $sql_table_name) {
				if(is_file($xml_tempdir.$xml_file_name)) {			
					$parseXML_feedback = parseXML_images($xml_tempdir.$xml_file_name, $sql_table_name);
					$xml_transfer_details .= 'Found '.$xml_file_name.' for '.$sql_table_name.', now parsing XML for SQL:<br/> '.$parseXML_feedback.'<br/>';
				}
			}
			echo $xml_transfer_details;
		}

function parseXML_images($xml_file, $sql_table) {
	$xml = simplexml_load_file($xml_file);
	
	$output = $xml_string = $sql_columns = $sql_values = $code = $temp_string = '';	
	
	foreach($xml->children() as $child) {
		$child_name = $child->getName();		
		foreach($child->children() as $subchild) {
			$subchild_name = $subchild->getName();
			if($subchild_name=='Code') {
				$code = $subchild;
				//$xml_string .= '<br/>'.$code.': <br/>';
			}
			if($subchild_name=='ItemImage') {
				$images_array = array();
				$temp_string = '';
				foreach($subchild->children() as $childling) {
					$childling_name = $childling->getName();					
					if($childling_name=='ImageDetails') {
						$item_index = 0;						
						foreach($childling->children() as $filename) {							
							$baby_name = $filename->getName();							
							if($baby_name=='FileName') {
								$filename = $filename->asXML();
								$filename = str_replace('<FileName>','',$filename);
								$filename = str_replace('</FileName>','',$filename);
								$images_array[] = $filename;
								//$xml_string .= ' - '.$baby_name.': '.$filename.'<br/>';
								$temp_string .= ' - '.$baby_name.': '.$filename.'<br/>';
								
							}
							$item_index++;
						}						
					}					
				}
				$images_array_serialized = serialize($images_array);
			//echo $code.'<br/>'.$temp_string.'<br/>'.$images_array_serialized.'<br/>';				
				mysql_query("UPDATE shop_webitems SET images='$images_array_serialized' WHERE Code='$code' AND is_active='1'") or die(mysql_error());
			}			
		}		
	}
	
	//echo $output;
	//echo $xml_string;
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
		<h1>Upload XML ZIP file</h1>
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
			<form id="submitform" name="submitform" method="post" enctype="multipart/form-data" onsubmit='return checkFields();'>
			<div id="xmlzip_uploader" class="xmlzip_uploader">
				<h3>Provide a ZIP file and click Upload</h3>
				<p><input type="file" id="xmlzip" name="xmlzip" style="padding:5px;margin-right:10px;" /></p>
				<p><input type="submit" id="upload" name="upload" value="Upload" class="button2" /></p>
				<div class="clear"></div>
			</div>
			<?php
			if(!empty($xml_transfer_details)){
				echo '<div id="runfeedback" class="runfeedback"><h1>Data transfer successful.</h1>'.$xml_transfer_details.'<div class="clear"></div></div>';
			}
			?>
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