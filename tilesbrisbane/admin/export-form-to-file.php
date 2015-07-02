<?php
error_reporting(E_ALL);
include('includes/connection.php');

require_once 'PHPExcel-develop/Classes/PHPExcel.php';
if($_GET['form']=='contact_form') {	
	$query = "SELECT subject, message, sendername, senderemail, receivername, receiveremail FROM forms WHERE form='Contact form' ORDER by form_id DESC"; 
	$headings = array('Subject', 'Message', 'Sender name', 'Sender e-mail', 'Receiver name', 'Receiver e-mail'); 
	if ($result = mysql_query($query) or die(mysql_error())) { 
		// Create a new PHPExcel object 
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getActiveSheet()->setTitle('Contact form'); 
		$rowNumber = 1; 
		$col = 'A'; 
		foreach($headings as $heading) { 
			$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading); 
			$col++; 
		} 
		// Loop through the result set 
		$rowNumber = 2; 
		while ($row = mysql_fetch_row($result)) { 
			$col = 'A'; 
			foreach($row as $cell) { 
				$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell); 
				$col++; 
			} 
			$rowNumber++; 
		} 
		// Freeze pane so that the heading line won't scroll 
		$objPHPExcel->getActiveSheet()->freezePane('A2'); 
		// Save as an Excel BIFF (xls) file 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="contact_'.date('His_dmY').'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter->save('php://output'); 
	   exit(); 
	}
} else if($_GET['form']=='appointment_form') {
	$query = "SELECT subject, message, sendername, senderemail, receivername, receiveremail FROM forms WHERE form='Appointment Request Form' ORDER by form_id DESC"; 
	$headings = array('Subject', 'Message', 'Sender name', 'Sender e-mail', 'Receiver name', 'Receiver e-mail'); 
	if ($result = mysql_query($query) or die(mysql_error())) { 
		//Create a new PHPExcel object 
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getActiveSheet()->setTitle('Appointment Request Form'); 
		$rowNumber = 1; 
		$col = 'A';
		foreach($headings as $heading) { 
			$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading); 
			$col++; 
		} 
		//Loop through the result set 
		$rowNumber = 2; 
		while($row = mysql_fetch_row($result)) {
			$col = 'A'; 
			foreach($row as $cell) {
				//$cell = str_replace('\n','\r\n',$cell);
				$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell); 
				$col++; 
			} 
			$rowNumber++; 
		} 
		// Freeze pane so that the heading line won't scroll 
		$objPHPExcel->getActiveSheet()->freezePane('A2'); 
		// Save as an Excel BIFF (xls) file 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="appointments_'.date('His_dmY').'.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter->save('php://output'); 
	   exit(); 
	}
}
?>