<?php
error_reporting(E_ALL);
include('includes/connection.php');

$xml_dir = 'xml/';
$xml_file = $xml_dir.'WebItemsExport.xml';
if(is_file($xml_file)) {
	echo $xml_file.' found.<br/>filesize: '.filesize($xml_file).'<br/>';
	parseXML($xml_file);	
} else {
	echo $xml_file.' not found.';
}

function parseXML($xml_file) {
	$xml = simplexml_load_file($xml_file);
	
	$xml_string = '';
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
	
	$output = '';
	if(!empty($items_array)) {
		foreach($items_array as $key => $items) {
			$output .= $key.': '.$items['Code'].'<br/>';
		}
	}
	
	echo $output;
	//echo $xml_string;
}