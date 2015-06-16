<?
if(trim(strtolower($_GET['code'])) == "tmnc1234") {
	//download price list #1
	header("location:pricelists/01FEB2009_NC_PriceList.pdf");
} else if(trim(strtolower($_GET['code'])) == "tm1234") {
	//download price list #2
	header("location:pricelists/01FEB2009MainPriceList.pdf");
} else {
	//code invalid, go back to previous page!
	header("location:index.php");
}
?>
