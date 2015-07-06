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
	foreach($xml->children() as $child) {
		$child_name = $child->getName();
		$xml_string .= '<br/>'.$child_name.': <br/>';
		foreach($child->children() as $subchild) {
			$subchild_name = $subchild->getName();
			$xml_string .= ' - '.$subchild_name.': '.$subchild.'<br/>';
		}
	}
	
	echo $xml_string;
}