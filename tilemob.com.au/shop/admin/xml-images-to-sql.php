<?php
error_reporting(E_ALL);
include('includes/connection.php');

$xml_dir = 'xml/';
$xml_file = $xml_dir.'WebItemsExport.xml';
if(is_file($xml_file)) {
	echo 'XML to SQL.<br/>'.$xml_file.' found.<br/>filesize: '.filesize($xml_file).'<br/>';
	parseXML_images($xml_file, 'shop_relatedto');
} else {
	echo $xml_file.' not found.';
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
				echo $code.'<br/>'.$temp_string.'<br/>'.$images_array_serialized.'<br/>';				
				mysql_query("UPDATE shop_webitems SET images='$images_array_serialized' WHERE Code='$code' AND is_active='1'") or die(mysql_error());
			}			
		}		
	}
	
	//echo $output;
	//echo $xml_string;
}
?>