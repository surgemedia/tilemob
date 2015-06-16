<?php
error_reporting(E_ALL);
include('includes/connection.php');

$xml_dir = 'xml/';
$xml_file = $xml_dir.'Pantone.xml';
if(is_file($xml_file)) {
	echo 'XML to SQL.<br/>'.$xml_file.' found.<br/>filesize: '.filesize($xml_file).'<br/>';
	parseXML($xml_file, 'shop_pantone');
} else {
	echo $xml_file.' not found.';
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
		for($i=0; $i<$items_array_count; $i++) {
			$query_columns = $query_values = '';
			foreach($sql_columns as $key => $column) {
				//$output .= $column.': '.$items_array[$i][$column].', ';
				if(!empty($items_array[$i][$column])) {
					$column_value = $items_array[$i][$column];
					$query_columns .= '`'.$column.'`, ';
					$query_values .= '\''.mysql_real_escape_string(trim($column_value)).'\', ';
				} else {
					$column_value = '';
				}
			}
			$query_columns = substr(trim($query_columns), 0, -1);
			$query_values = substr(trim($query_values), 0, -1);
			$output .= '
				<br/><br/>INSERT INTO $sql_table ('.$query_columns.' ) 
				VALUES ('.$query_values.')</pre><br/>';
			//Check if exists
			$item_code = $items_array[$i]['Code'];
			//$result = mysql_query("SELECT * FROM $sql_table WHERE Code='$item_code' AND is_active='1'");
			//if(mysql_num_rows($result)==0) {
				$output .= '<br/>'.$item_code.' added to database.<br/>';
				mysql_query("INSERT INTO $sql_table 
					($query_columns) 
					VALUES ($query_values)") 
					or die(mysql_error());
			//}
		}
	}
	
	echo $output;
	//echo $xml_string;
}