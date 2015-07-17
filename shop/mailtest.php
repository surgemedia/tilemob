<?
	$to = "yuen.brad@gmail.com";
	$subject = 'testing mail';
	$name = "TESTING NOW";
	$from = "sales@tilesbrisbane.com.au";
	$message = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Order Invoice. Don\'t reply this message!</title>
	</head>
	
	<body style="padding: 0px; margin: 0px;">
	test
	</body>
	</html>
			';
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			
			$headers .="From: ". $name . " <" . $from . ">\r\n";

				mail($to, $subject, $message, $headers);										

?>