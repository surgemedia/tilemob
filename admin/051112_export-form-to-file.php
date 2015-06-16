<?php
include('includes/prerun.php');
include('includes/connection.php');

// Export to XLS
if($_GET['form'] == 'contact_form') { 
	$xls_output = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); //start of xls
	$export_result = mysql_query("SHOW COLUMNS FROM forms");
	$row_count = $col_count = $num_cols = 0;
	//headers
	if (mysql_num_rows($export_result) > 0) {
		while ($row = mysql_fetch_assoc($export_result)) {
			$xls_output .= xlsWriteLabel($row_count, $col_count, $row['Field']);
			$col_count++;
			$num_cols++;
		}		
		$row_count = 1;
		$col_count = 0;
	}
	//data
	$values = mysql_query("SELECT * FROM forms WHERE form='Contact form' AND is_deleted='0'");
	while ($rowr = mysql_fetch_row($values)) {
		for ($j=0;$j<$num_cols;$j++) {
			if($col_count == $num_cols){$row_count++;$col_count=0;}
			$xls_output .= xlsWriteLabel($row_count, $col_count, $rowr[$j]);
			$col_count++;
		}
	}
	$xls_output .= pack("ss", 0x0A, 0x00); //end of xls

	$filename = 'contact_'.date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: xls" . date("Y-m-d") . ".xls");
	header( "Content-disposition: filename=".$filename.".xls");
	echo $xls_output;
	exit;
} else if($_GET['form'] == 'appointment_form') {
	$xls_output = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); //start of xls
	$export_result = mysql_query("SHOW COLUMNS FROM forms");
	$row_count = $col_count = $num_cols = 0;
	//headers
	if (mysql_num_rows($export_result) > 0) {
		while ($row = mysql_fetch_assoc($export_result)) {
			$xls_output .= xlsWriteLabel($row_count, $col_count, $row['Field']);
			$col_count++;
			$num_cols++;
		}		
		$row_count = 1;
		$col_count = 0;
	}
	//data
	$values = mysql_query("SELECT * FROM forms WHERE form='Appointment Request Form' AND is_deleted='0'");
	while ($rowr = mysql_fetch_row($values)) {
		for ($j=0;$j<$num_cols;$j++) {
			if($col_count == $num_cols){$row_count++;$col_count=0;}
			$xls_output .= xlsWriteLabel($row_count, $col_count, $rowr[$j]);
			$col_count++;
		}
	}	
	$xls_output .= pack("ss", 0x0A, 0x00); //end of xls

	$filename = 'quote_'.date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: xls" . date("Y-m-d") . ".xls");
	header( "Content-disposition: filename=".$filename.".xls");
	echo $xls_output;
	exit;
} else if($_GET['form'] == 'quote_request_form') {
	$xls_output = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); //start of xls
	$export_result = mysql_query("SHOW COLUMNS FROM quote_request_form");
	$row_count = $col_count = 0;
	//headers
	if (mysql_num_rows($export_result) > 0) {
		while ($row = mysql_fetch_assoc($export_result)) {
			$xls_output .= xlsWriteLabel($row_count, $col_count, $row['Field']);
			$col_count++;
		}		
		$row_count = 1;
		$col_count = 0;
	}
	$num_cols = 14;
	//data
	$values = mysql_query("SELECT * FROM quote_request_form");
	while ($rowr = mysql_fetch_row($values)) {
		for ($j=0;$j<$num_cols;$j++) {
			if($col_count == $num_cols){$row_count++;$col_count=0;}
			$xls_output .= xlsWriteLabel($row_count, $col_count, $rowr[$j]);
			$col_count++;
		}
	}	
	$xls_output .= pack("ss", 0x0A, 0x00); //end of xls

	$filename = 'quote_'.date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: xls" . date("Y-m-d") . ".xls");
	header( "Content-disposition: filename=".$filename.".xls");
	echo $xls_output;
	exit;
} else if($_GET['form'] == 'meeting_request_form') { 
	$xls_output = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); //start of xls
	$export_result = mysql_query("SHOW COLUMNS FROM meeting_request_form");
	$row_count = $col_count = 0;
	//headers
	if (mysql_num_rows($export_result) > 0) {
		while ($row = mysql_fetch_assoc($export_result)) {
			$xls_output .= xlsWriteLabel($row_count, $col_count, $row['Field']);
			$col_count++;
		}		
		$row_count = 1;
		$col_count = 0;
	}
	$num_cols = 18;
	//data
	$values = mysql_query("SELECT * FROM meeting_request_form");
	while ($rowr = mysql_fetch_row($values)) {
		for ($j=0;$j<$num_cols;$j++) {
			if($col_count == $num_cols){$row_count++;$col_count=0;}
			$xls_output .= xlsWriteLabel($row_count, $col_count, $rowr[$j]);
			$col_count++;
		}
	}	
	$xls_output .= pack("ss", 0x0A, 0x00); //end of xls

	$filename = 'meeting_'.date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: xls" . date("Y-m-d") . ".xls");
	header( "Content-disposition: filename=".$filename.".xls");
	echo $xls_output;
	exit;
} else if($_GET['form'] == 'friend_form') { 
	$xls_output = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); //start of xls
	$export_result = mysql_query("SHOW COLUMNS FROM friend_form");
	$row_count = $col_count = 0;
	//headers
	if (mysql_num_rows($export_result) > 0) {
		while ($row = mysql_fetch_assoc($export_result)) {
			$xls_output .= xlsWriteLabel($row_count, $col_count, $row['Field']);
			$col_count++;
		}		
		$row_count = 1;
		$col_count = 0;
	}
	$num_cols = 6;
	//data
	$values = mysql_query("SELECT * FROM friend_form");
	while ($rowr = mysql_fetch_row($values)) {
		for ($j=0;$j<$num_cols;$j++) {
			if($col_count == $num_cols){$row_count++;$col_count=0;}
			$xls_output .= xlsWriteLabel($row_count, $col_count, $rowr[$j]);
			$col_count++;
		}
	}	
	$xls_output .= pack("ss", 0x0A, 0x00); //end of xls

	$filename = 'friend_'.date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: xls" . date("Y-m-d") . ".xls");
	header( "Content-disposition: filename=".$filename.".xls");
	echo $xls_output;
	exit;
}

function xlsWriteLabel($Row, $Col, $Value ) {
	$temp_string = '';
	$L = strlen($Value);
	$temp_string .= pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	$temp_string .= $Value;
    return $temp_string;
}
?>