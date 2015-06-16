<?php 
session_start();
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php 
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
?>
<script language="javascript">
function validate() {
	//alert("checking fields");
	emptyfields = "";
        
        if((document.getElementById('pickup').checked == false) && (document.getElementById('deliver').checked == false)) {
		emptyfields += "\n   shipping method *";
	}
	if(document.getElementById('firstname').value == '') {
		emptyfields += "\n   Your firstname *";
	}
        if(document.getElementById('lastname').value == '') {
		emptyfields += "\n   Your lastname *";
	}
        if(document.getElementById('email').value == '') {
		emptyfields += "\n   Your e-mail *";
	}
        if(document.getElementById('phoneno').value == '') {
		emptyfields += "\n   Your phone *";
	}
	if(document.getElementById('address').value == '') {
		emptyfields += "\n   Your address *";
	}
        if(document.getElementById('city').value == '') {
		emptyfields += "\n   Your city *";
	}
        if(document.getElementById('state').value == '') {
		emptyfields += "\n   Your state *";
	}
         if(document.getElementById('zipcode').value == '') {
		emptyfields += "\n   Your zipcode *";
	}
         if(document.getElementById('country').value == '') {
		emptyfields += "\n   Your country *";
	}
	//alert("checking fields");
	if (emptyfields!="") { //mandatories not completed!
		alertmessage = "You've forgotten these fields:\n";
		alert(alertmessage+emptyfields);
		return false;
	} else { //all mandatories filled in!
		return true;
	}
}
</script>
</head>

<body>
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="body" class="body checkout-page">
		<div id="body_left" class="body_left">
			<?php include('includes/finder.php'); ?>
                        <?php include('includes/store-categories.php'); ?>
                        <?php include('includes/featured-products.php'); ?>
			<div class="clear"></div>
		</div>
            <form action="process.php?action=process" method="post" onsubmit="return validate();">
		<div id="body_right" class="body_right">
                    <div id="cart" class="cart">
				<h1>	Shipping Options:  </h1>				
                                <table class="form-listing">
                                    <tr>
                                        <td width="10%">Pick Up:</td>
                                        <td width="70%"><input type="radio" id="pickup" name="shipping" value="pickup"></input> (No freight charges.)</td>
                                    </tr>
                                    <tr>
                                        <td>Deliver:</td>
                                        <td><input type="radio" id="deliver" name="shipping" value="deliver"></input> (We deliver Australia wide. Contact us 7 days on 0419774758 for a quote.)</td>
                                    </tr>                                    
                                </table>	
				<div class="clear"></div>
			</div>
			<div id="cart" class="cart">
				<h1>	Billing Information  </h1>				
                                <table class="form-listing">
                                    <tr>
                                        <td width="10%">First Name:</td>
                                        <td width="70%"><input type="text" id="firstname" name="firstname" class="textfield1"></input></td>
                                    </tr>
                                    <tr>
                                        <td>Last Name:</td>
                                        <td><input type="text" id="lastname" name="lastname" class="textfield1"></input></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><input type="text" id="email" name="email" class="textfield1"></input></td>
                                    </tr>
                                    <tr>
                                        <td>Phone No:</td>
                                        <td><input type="text" id="phoneno" name="phoneno" class="textfield1"></input></td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td><textarea id="address" name="address" class="textfield1"></textarea></td>
                                    </tr>
                                     <tr>
                                        <td>City:</td>
                                        <td><input type="text" id="city" name="city" class="textfield1"></input></td>
                                    </tr>
                                    <tr>
                                        <td>State:</td>
                                        <td><input type="text" id="state" name="state" class="textfield1"></input></td>
                                    </tr>
                                    <tr>
                                        <td>Zip Code:</td>
                                        <td><input type="text" id="zipcode" name="zipcode" class="textfield1"></input></td>
                                    </tr>
                                    <tr>
                                        <td>Country:</td>
                                        <td><input type="text" id="country" name="country" class="textfield1"></input></td>
                                    </tr>
                                </table>	
				<div class="clear"></div>
			</div>
                    <div id="cart" class="cart">
				<h1>Confirm and Place Your Order</h1>				
				<?php
				$cart_string = '';
				$cart_final_total = 0;
				$result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id='$_shop_user_id' AND qty>0 AND is_active='1'");
				if($_shop_total_cart>0) {
					$cart_string .= '
					<div class="checkout_button"><a href="checkOut.php" title="Checkout now">Checkout now</a></div>
					<table id="cart_table" width="100%" class="cart_table">
						<tr>
							<th width="90">Thumbnail</th>
							<th align="left" valign="middle">Item</th>
							<th width="60" align="center" valign="middle">QTY</th>
							<th width="100" align="right" valign="middle">Price</th>
							<th width="100" align="right" valign="middle">Total</th>
						</tr>';
					while($row_cart = mysql_fetch_array($result_cart)) {
                                        // echo "<pre/>";   print_r($row_cart);
						$row_cart_id = $row_cart['cart_id'];
						$cart_item_code = $row_cart['item_code'];
						$cart_qty = $row_cart['qty'];
						$result_cart_webitems = mysql_query("SELECT * FROM shop_webitems WHERE Code='$cart_item_code' AND is_active='1'");
						if($row_cart_webitems = mysql_fetch_array($result_cart_webitems)) {
                                                  //echo "<pre/>";  print_r($row_cart_webitems);
							$cart_item_id = $row_cart_webitems['item_id'];
							$cart_item_name = $row_cart_webitems['Desc'];
							$cart_item_pcsm2 = floatval($row_cart_webitems['PcsM2']);
							$cart_item_unit = $row_cart_webitems['Unit'];						
							if($cart_item_pcsm2>0&&$cart_item_unit=='M2'){ //sell in m2
								/*$cart_item_buy = floatval($row_cart_webitems['WebPriceM2']);
								if($cart_item_buy<=0){$cart_item_buy=floatval($row_cart_webitems['TradePriceM2']);}
								$cart_item_rrp = floatval($row_cart_webitems['RetailPriceM2']);*/
                                                                $item_WebPriceM2    = floatval($row_cart_webitems['WebPriceM2']);
                                                                $item_RetailPriceM2 = floatval($row_cart_webitems['RetailPriceM2']);
                                                                if(!empty($item_WebPriceM2)) {
                                                                 $cart_item_buy = floatval($item_WebPriceM2);
			                                           } else { //if web price value does not exist, use 20% off from retail price
                           	                                 $item_web_discount_amount = floatval($item_RetailPriceM2)*0.2; //20% of retail price
				                                 $cart_item_buy  = floatval($item_RetailPriceM2)-$item_web_discount_amount;
			                                         }
			                                         $cart_item_rrp = floatval($item_RetailPriceM2);
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
								$cart_item_unit='m&sup2;';
							}							
							$cart_item_save = $cart_item_rrp-$cart_item_buy;
							if($cart_item_save<0){$cart_item_buy=0.00;}
							$cart_item_images = unserialize($row_cart_webitems['images']);
							$cart_images_dir = 'images/items/';
							$cart_image1 = $cart_image1_imgsrc = '';
							$cart_image1 = $cart_images_dir.$cart_item_images[0];
							if(is_file($cart_image1)) {
								$cart_image1_imgsrc = '<img src="'.$cart_images_dir.$cart_item_images[0].'" alt="'.$cart_item_name.'" border="0" />';
							} else {
								$cart_image1_imgsrc = '<img src="images/blank.gif" alt="'.$cart_item_name.'" border="0" />';
							}
							$cart_item_subtotal = $cart_item_buy*$cart_qty;
							$cart_final_total += $cart_item_subtotal;
							$cart_string .= '
							<tr>
								<td align="center" valign="middle"><div class="thumb"><!--<a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">-->'.$cart_image1_imgsrc.'<!--</a>--></div></td>
								<td align="left" valign="middle"><!--<a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">-->'.$cart_item_name.'<!--</a>--> </td>
								<td align="center" valign="middle">
									<div class="qty">
										
                                                                                    <div id="qty_value_'.$row_cart_id.'" class="text">'.$cart_qty.'<div class="clear"></div></div>
										    <div class="clear"></div>
									</div>
								</td>
								<td align="right" valign="middle">$'.number_format($cart_item_buy,2).''.$cart_item_unit.'</td>
								<td align="right" valign="middle"><div id="subtotal_'.$row_cart_id.'">$'.number_format($cart_item_subtotal,2).'</div></td>
							</tr>';
						}
					}
					$cart_string .= '
					</table>
					<div id="cart_checkout_note" class="cart_checkout_note">This page shows contents of your cart. To proceed with checkout, click Checkout now.</div>
					<div id="cart_total" class="cart_total"><div class="price">$'.number_format($cart_final_total,2).'</div><div class="label">TOTAL</div><div class="clear"></div></div>
					<div class="checkout_button"><a href="checkOut.php" title="Checkout now">Checkout now</a></div>';
				} else {
					$cart_string .= '<div class="bodytext">You have not added any items to your cart yet.</div>';
				}
				echo $cart_string;
				?>				
				<div class="clear"></div>
			</div>
                    <input type="hidden" id="total" name="total" value="<?=$cart_final_total?>"></input>
                    <input type="submit" value="Place Order" name="submit" id="placeorder">
			<div class="clear"></div>
		</div>
        </form>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
	<div class="clear"></div>
</div>
<?php include('includes/end_body.php'); ?>
</body>
</html>