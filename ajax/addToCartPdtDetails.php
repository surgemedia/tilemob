<?php 
ob_start();
include('../../dbconnect.php');

if((!empty($_GET['user_id'])||!empty($_GET['user_session']))&&!empty($_GET['shop_order_id'])&&!empty($_GET['item_code'])&&!empty($_GET['item_quantity'])&&!empty($_GET['button_id'])) {
	$user_id_encoded = trim($_GET['user_id']);
	$user_id = str_replace('remove_this_secret_string','',base64_decode($user_id_encoded));
        $orderId = mysql_real_escape_string(trim($_GET['shop_order_id']));
	$guest_session = mysql_real_escape_string(trim($_GET['user_session']));
	$item_code = mysql_real_escape_string(trim($_GET['item_code']));
	$item_quantity = mysql_real_escape_string(trim($_GET['item_quantity']));
	$button_id = mysql_real_escape_string(trim($_GET['button_id']));
	$item_price = mysql_real_escape_string(trim($_GET['totprice']));
        
	if(intval($item_quantity)>=1) {
		//--user exists--
		$result_item = mysql_query("SELECT * FROM shop_webitems WHERE Code LIKE '".$item_code."' AND is_active = 1");
		if($row_item = mysql_fetch_array($result_item)) { //item available
			$item_id = $row_item['item_id'];
			if(!empty($user_id)) {
				$result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id LIKE '".$user_id."' AND item_code LIKE '".$item_code."' AND is_active = 1"); //item exists in cart
			} else if(!empty($guest_session)) {
				$result_cart = mysql_query("SELECT * FROM shop_cart WHERE guest_session LIKE '".$guest_session."' AND item_code LIKE '".$item_code."' AND is_active =1"); //item exists in cart
			}
			if($row_cart = mysql_fetch_array($result_cart)) { //update qty
				$my_cart_id = $row_cart['cart_id'];
                                //$current_qty = intval($row_cart['qty']);
				$current_qty = $row_cart['qty'];
				$new_qty = $current_qty+$item_quantity;
                                $sql="UPDATE shop_cart SET qty = '".$new_qty."' WHERE cart_id = ".$my_cart_id;
				mysql_query($sql);
			} else { //new
				//$item_price = 0;
				$new_qty = $item_quantity;
				mysql_query("INSERT INTO shop_cart (cart_id, user_id, guest_session, item_code, qty, price, lastupdated, is_active,order_id) 
				VALUES ('', '".$user_id."', '".$guest_session."', '".$item_code."', '".$new_qty."', '".$item_price."', NOW(), 1,'".$orderId."')");
			}
			//$sql = "SELECT sum(qty) as total_qty FROM shop_cart WHERE user_id='$user_id' AND is_active='1'";
                        $sql = "SELECT count(*) as total_qty FROM shop_cart WHERE user_id = ".$user_id." AND is_active = 1";
			$result_cart_sum = mysql_query($sql);
			if($row_cart_sum = mysql_fetch_array($result_cart_sum)) {
				echo '
				document.getElementById(\'header_cart_items\').innerHTML=\''.$row_cart_sum['total_qty'].'\';';
                                                               
			}
		}
	}
       
}

?>