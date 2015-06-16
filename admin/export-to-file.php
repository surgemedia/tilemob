<?php
include('includes/prerun.php');
include('includes/connection.php');

// Export to CSV
if($_GET['action'] == 'export') {	
	$export_result = mysql_query("SHOW COLUMNS FROM content");
	$i = 0;
	if (mysql_num_rows($export_result) > 0) {
		while ($row = mysql_fetch_assoc($export_result)) {
			$csv_output .= $row['Field']."; ";
			$i++;
		}
	}
	$csv_output .= "\n";

	$values = mysql_query("SELECT * FROM content");
	while ($rowr = mysql_fetch_row($values)) {
		for ($j=0;$j<$i;$j++) {
			$csv_output .= $rowr[$j]."; ";
		}
		$csv_output .= "\n";
	}

	$filename = 'file_'.date("Y-m-d_H-i",time());
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: csv" . date("Y-m-d") . ".csv");
	header( "Content-disposition: filename=".$filename.".csv");
	echo $csv_output;
	exit;
}
?>