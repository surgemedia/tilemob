<?php 
include('../../dbconnect.php');

if((!empty($_GET['user_id'])||!empty($_GET['user_session']))&&!empty($_GET['id'])) {
	$user_id_encoded = trim($_GET['user_id']);
	$user_id = str_replace('remove_this_secret_string','',base64_decode($user_id_encoded));
	$guest_session = mysql_real_escape_string(trim($_GET['user_session']));
	$cart_id = mysql_real_escape_string(trim($_GET['id']));	
	//--user exists--
	if(!empty($user_id)) {
		$result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id = ".$user_id." AND cart_id = ".$cart_id." AND is_active = 1"); //item exists in cart
	} else if(!empty($guest_session)) {
		$result_cart = mysql_query("SELECT * FROM shop_cart WHERE guest_session LIKE '".$guest_session."' AND cart_id = ".$cart_id." AND is_active = 1"); //item exists in cart
	}
	if($row_cart = mysql_fetch_array($result_cart)) { //update qty
		$current_qty = intval($row_cart['qty']);
		$new_qty = $current_qty-1;
		if($new_qty>0) {
			mysql_query("UPDATE shop_cart SET qty = '".$new_qty."' WHERE cart_id = ".$cart_id);
			$result_cart_sum = mysql_query("SELECT sum(qty) as total_qty FROM shop_cart WHERE user_id = ".$user_id." AND is_active = 1");
			if($row_cart_sum = mysql_fetch_array($result_cart_sum)) {
				$cart_item_code = $row_cart['item_code'];
				$result_cart_webitems = mysql_query("SELECT * FROM shop_webitems WHERE Code LIKE '".$cart_item_code."' AND is_active = 1");
				if($row_cart_webitems = mysql_fetch_array($result_cart_webitems)) {
					$cart_item_pcsm2 = floatval($row_cart_webitems['PcsM2']);
					$cart_item_unit = $row_cart_webitems['Unit'];						
					if($cart_item_pcsm2>0&&$cart_item_unit=='M2'){ //sell in m2
						$cart_item_buy = floatval($row_cart_webitems['WebPriceM2']);
						if($cart_item_buy<=0){$cart_item_buy=floatval($row_cart_webitems['TradePriceM2']);}
						$cart_item_rrp = floatval($row_cart_webitems['RetailPriceM2']);
						$cart_item_unit='m&sup2;';
					}
					$cart_item_subtotal = $cart_item_buy*$new_qty;
					echo '
					document.getElementById(\'qty_field_'.$cart_id.'\').value=\''.$new_qty.'\';
					document.getElementById(\'subtotal_'.$cart_id.'\').innerHTML=\'$'.number_format($cart_item_subtotal,2).'\'; 
					document.getElementById(\'header_cart_items\').innerHTML=\''.$row_cart_sum['total_qty'].'\';';
				}
			}
		}
	}
}
?>