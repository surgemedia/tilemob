<?php 
include('../includes/connection.php');

if((!empty($_GET['user_id'])||!empty($_GET['user_session']))&&!empty($_GET['id'])) {
	$user_id_encoded = trim($_GET['user_id']);
	$user_id = str_replace('remove_this_secret_string','',base64_decode($user_id_encoded));
	$guest_session = mysql_real_escape_string(trim($_GET['user_session']));
	$cart_id = mysql_real_escape_string(trim($_GET['id']));	
	//--user exists--
	if(!empty($user_id)) {
		$result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id='$user_id' AND cart_id='$cart_id' AND is_active='1'"); //item exists in cart
	} else if(!empty($guest_session)) {
		$result_cart = mysql_query("SELECT * FROM shop_cart WHERE guest_session='$guest_session' AND cart_id='$cart_id' AND is_active='1'"); //item exists in cart
	}
	
	if(mysql_num_rows($result_cart)>0) { //update qty
		mysql_query("UPDATE shop_cart SET is_active='0' WHERE cart_id='$cart_id'");
		echo 'self.location.reload();';
	}
}
?>