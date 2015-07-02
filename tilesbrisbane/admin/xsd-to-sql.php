<?php
error_reporting(E_ALL);
include('includes/connection.php');

$xsd_dir = '_xsd/';
$xsd_file = $xsd_dir.'ItemTransferTileMob.xsd';
if(is_file($xsd_file)) {
	echo $xsd_file.' found.<br/>filesize: '.filesize($xsd_file).'<br/>';
	xsdParser($xsd_file);	
} else {
	echo $xsd_file.' not found.';
}

function xsdParser($xsd_file) {	
	//$xml_string = file_get_contents($xsd_file);
	$file_handle = fopen($xsd_file, "r");
	$xml_string = '';
	$xml_lines = array();
	$line_count = 0;
	while(!feof($file_handle)) {
		$line_count++;
		$line = fgets($file_handle);
		if($line_count>6) { //skip first 6 lines
			$xml_string .= trim($line);
			$xml_lines[] = trim($line);
		}
	}
	fclose($file_handle);
	
	$output = '';
	$items = array();
	if(!empty($xml_lines)){
		foreach($xml_lines as $key => $line) {
			$item_num = 0;
			if(strpos($line,'element name="Item"')) { //Items
				$output .= '<br/>Item #'.$item_num.': <br/>';				
				$item_num++;
			}
			if(strpos($line,'element name="Code"')) { //Code
				if($line_value=extractBetweenString($line,'description="','">')) {
					$output .= ' - <b>Code:</b> '.$line_value.' <br/>';
					$items[$item_num]['Code'] = $line_value;
				}
			}
			if(strpos($line,'element name="Desc"')) { //Desc
				if($line_value=extractBetweenString($line,'description="','">')) {
					$output .= ' - <b>Desc:</b> '.$line_value.' <br/>';
					$items[$item_num]['Desc'] = $line_value;
				}
			}
		}
	}
	
	echo $output;
	//echo $xml_string;
}

function extractBetweenString($string, $from, $to) {
	$string_startpos = strrpos($string,$from);
	$string_endpos = strrpos($string,$to);
	if($string_startpos&&$string_endpos) {
		$string_startpos += strlen($from);
		$extracted = substr($string, $string_startpos, $string_endpos-$string_startpos);
		return $extracted;
	} else {
		return false;
	}
}
?>