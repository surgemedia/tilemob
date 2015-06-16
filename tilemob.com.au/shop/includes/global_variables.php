<?php
////////////// Newly added ///////////////
$x      = 6; // Amount of digits
$min    = pow(10,$x);
$max    = pow(10,$x+1)-1;
$value  = rand($min, $max);
$value1 = rand($min, $max);

if(!isset($_COOKIE['_shop_user_id'])) {
    $cooke = setcookie('_shop_user_id', $value,time()+3600*24);    
}
else
{
     $cooke =  $_COOKIE["_shop_user_id"];
}
$_shop_user_id = $cooke;

//////////Order Id ///////////////////////
if(!isset($_COOKIE['_shop_order_id'])) {
    $cooke1 = setcookie('_shop_order_id', $value1,time()+3600*24);    
}
else
{
     $cooke1 =  $_COOKIE["_shop_order_id"];
}
$_shop_order_id = $cooke1;
//////////////////////////////////////////


$_pageurl = basename($_SERVER['PHP_SELF']);
$_parse_url = parse_url($_SERVER['REQUEST_URI']);

//$_shop_user_id = $_SESSION['_shop_user_id'] = 1;   // commented this line

$_shop_user_id_encoded = base64_encode($_shop_user_id.'remove_this_secret_string');
$_shop_username = $_SESSION['_shop_username'] = 'richard@dmwcreative.com.au';
$_shop_firstname = $_SESSION['_shop_firstname'] = 'Richard';
$_shop_lastname = $_SESSION['_shop_lastname'] = 'Chong';
$_shop_email = $_SESSION['_shop_email'] = 'richard@dmwcreative.com.au';

$_shop_total_cart = 0;
$temp_result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id='$_shop_user_id' AND qty>0 AND is_active='1'");
while($temp_row_cart = mysql_fetch_array($temp_result_cart)) {
	$temp_cart_item_code = $temp_row_cart['item_code'];
	$temp_cart_qty = $temp_row_cart['qty'];
	/*$temp_result_cart_webitems = mysql_query("SELECT * FROM shop_webitems WHERE Code='$temp_cart_item_code' AND is_active='1'");
	if(mysql_num_rows($temp_result_cart_webitems)>0) {
		$_shop_total_cart += intval($temp_cart_qty);
	}*/
        
        $sql = "SELECT count(*) as total_qty FROM shop_cart WHERE user_id='$_shop_user_id' AND is_active='1'";
        $result_cart_sum = mysql_query($sql);
        if($row_cart_sum = mysql_fetch_array($result_cart_sum)) {
             $_shop_total_cart =   $row_cart_sum['total_qty'];
        }
}
?>
