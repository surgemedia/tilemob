<?
if(trim(strtolower($_GET['code'])) == "tmnc1234") {
	//download price list #1
	//header("location:pricelists/01FEB2009_NC_PriceList.pdf");
	$filename = 'pricelists/01FEB2009_NC_PriceList.pdf';
} else if(trim(strtolower($_GET['code'])) == "tm1234") {
	//download price list #2
	//header("location:pricelists/22june10_pricelist.pdf");
	//$filename = 'pricelists/22june10_pricelist.pdf';
	$filename = 'pricelists/01Feb2014MainPriceList_Combined.pdf';
} else {
	//code invalid, go back to previous page!
	header("location:index.php");
}

if($_GET['code'] != '' && is_file($filename)) {
	/*header("Pragma: public");
	header("Expires: 0");
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header('Content-disposition: attachment; filename=' . basename($filename));
	header("Content-Type: application/pdf");
	header("Content-Transfer-Encoding: binary");
	header('Content-Length: ' . filesize($filename));
	@readfile($filename);
	exit(0);*/
	header('location:'.$filename);
}
?>
