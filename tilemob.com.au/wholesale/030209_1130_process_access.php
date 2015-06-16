<?
if(trim(strtolower($_GET['code'])) == "tmnc1234") {
	//download price list #1
	header("location:pricelists/pricelist_tmnc1234.pdf");
} else if(trim(strtolower($_GET['code'])) == "tm1234") {
	//download price list #2
	header("location:pricelists/pricelist_tm1234.pdf");
} else {
	//code invalid, go back to previous page!
	header("location:index.php");
}
?>
