<? 
	session_start();
	include('../dbconnect.php');
	include('includes/global_variables.php');
	include('includes/requests.php');
	include("class/class.watermark.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
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
		emptyfields += "\n   Your postcode *";
	}
//         if(document.getElementById('country').value == '') {
//		emptyfields += "\n   Your country *";
//	}
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
<?
	if($_POST['firstname']!=""){
			$name = "TILESBRISBANE.COM";
			$from = "sales@tilesbrisbane.com.au";
			$to = "sales@tilesbrisbane.com.au";
			$to2 = $_POST['email'];
			$subject = 'TILESBRISBANE.COM: Client Request Quote';
			$subject2 = 'TILESBRISBANE.COM: Thank for your enquiry';
			
			$message .= '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Order Invoice. Don\'t reply this message!</title>
			</head>
			
			<body>
			';
			$message .= 'Enquiry Details'."<br/>\n";
			$message .= 'TILESBRISBANE.COM'."<br/>\n";
			$message .= ''. $_POST['firstname'].' '.$_POST['lastname'].' Just send this mail to check quotation of below items:';
				$check_wishlist = mysql_query("SELECT WL.item_code AS 'Products Code', ITEMS.InternalCode AS 'Internal Code', ITEMS.InternalDesc AS 'Description',  WL.qty AS 'QTY', WL.price AS 'Item Prices per QTY' FROM shop_cart AS WL LEFT JOIN shop_webitems AS ITEMS ON WL.item_code = ITEMS.Code WHERE WL.user_id LIKE '%".$_shop_user_id."%' AND WL.qty > 0 AND WL.is_active = 1");
				$check_wishlist_num = mysql_num_rows($check_wishlist);
				$message .= '
				<table border="1">
				<tr>
				<th>Product Code</th>
				<th>Internal Code</th>
				<th>Description</th>
				<th>QTY</th>
				<th>Item Prices Per QTY</th>
				<th>Total</th>
				</tr>
				';
				for($i=0; $i<$check_wishlist_num; $i++){
				$rows_WL = mysql_fetch_array($check_wishlist);
				$message .= '
				<tr>
				<td>'.$rows_WL['Products Code'].'</td>
				<td>'.$rows_WL['Internal Code'].'</td>
				<td>'.$rows_WL['Description'].'</td>
				<td>'.$rows_WL['QTY'].'</td>
				<td>AU$ '.$rows_WL['Item Prices per QTY'].'</td>
				<td>AU$ '.$rows_WL['Item Prices per QTY']*$rows_WL['QTY'].'</td>
				</tr>
				';	
				}
				$message .= '
				</table>
				';

			$message .= '************************************************************************'."<br/>\n";
			$message .= "Client's Person Information:<br/>\n";
			$message .= 'shipping method: '.$_POST['shipping']."<br/>\n";
			$message .= 'First Name: '.$_POST['firstname']."<br/>\n";
			$message .= 'Last Name: '.$_POST['lastname']."<br/>\n";
			$message .= 'Email: '.$_POST['email']."<br/>\n";
			$message .= 'Phone Number: '.$_POST['phoneno']."<br/>\n";
			$message .= 'Address: '.$_POST['address']."<br/>\n";
			$message .= 'City: '.$_POST['city']."<br/>\n";
			$message .= 'State: '.$_POST['state']."<br/>\n";
			$message .= 'Postcode: '.$_POST['zipcode']."<br/>\n";
			$message .= '************************************************************************'."<br/>\n";
			$message .= "Please contact client ASAP. Thanks";
			$message .= '************************************************************************'."<br/>\n";
			$message .= "<br/>\n";
			$message .= "<br/>\n";
			$message .="Sincerely,"; 
			$message .="</body>
			</html>"; 
			$message2 .= '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Order Invoice. Don\'t reply this message!</title>
			</head>
			
			<body>
			';
			$message2 .= 'Enquory Details'."<br/>\n";
			$message2 .= 'TILESBRISBANE.COM'."<br/>\n";
			$message2 .= 'Hi '. $_POST['firstname'].' '.$_POST['lastname'].', We are already processing your request now.:';
			$message2 .= "And we will contact you ASAP to send you the good prices!<br/>\n";
			$message2 .= "<br/>\n";
			$message2 .= "<br/>\n";
			$message2 .="Sincerely,"; 
			$message2 .="</body></html>"; 
			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
			
			$headers .="From: ". $name . " <" . $from . ">\r\n";
			
			if(mail($to, $subject, $message, $headers)){
				$succ_mag = "Thanks for your Enquiry, We will contact you for quote.";
				$_SESSION['_shop_order_id'] = "";
			}
			mail($to2, $subject2, $message2, $headers);
			
			
	}
?>
</head>

<body oncontextmenu="return false"  onselectstart="return false">
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
            <form action="#" method="post" onsubmit="return validate();">
            <? //<form action="process.php?action=process" method="post" onsubmit="return validate();">?>
		<div id="body_right" class="body_right">
                    <div id="cart" class="cart">
                    <h2 style="color:RED;"><?php echo $succ_mag;?></h2>
				<h1>	Shipping Options:  </h1>				
                                <table class="form-listing">
                                    <tr>
                                        <td width="10%">Pick Up:</td>
                                        <td width="70%"><input type="radio" id="pickup" name="shipping" value="pickup"></input> (No freight charges.)</td>
                                    </tr>
                                    <tr>
                                        <td>Deliver:</td>
                                        <td><input type="radio" id="deliver" name="shipping" value="deliver"></input> (We deliver Australia wide. Enter your delivery address below for freight quote.)</td>
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
                                        <td>Delivery Address:</td>
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
                                        <td>Postcode:</td>
                                        <td><input type="text" id="zipcode" name="zipcode" class="textfield1"></input></td>
                                    </tr>
<!--                                    <tr>
                                        <td>Country:</td>
                                        <td><input type="text" id="country" name="country" class="textfield1"></input></td>
                                    </tr>-->
                                </table>	
				<div class="clear"></div>
			</div>
                    <div id="cart" class="cart">
				<h1>Confirm and Check Quote Request</h1>				
				<?php
				$cart_string = '';
				$cart_final_total = 0;
				if($_SESSION['_shop_order_id']==""){
					$_shop_user_id = "abc123";
				}
				$result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id LIKE '%".$_shop_user_id."%' AND qty > 0 AND is_active = 1");
				if($_shop_total_cart>0) {
					$cart_string .= '
					<table id="cart_table" width="100%" class="cart_table">
						<tr>
							<th width="90">Thumbnail</th>
							<th align="left" valign="middle">Item</th>
							<th width="60" align="center" valign="middle">QTY</th>
							';
							//<th width="100" align="right" valign="middle">Price</th>
					//$cart_string .= '<th width="100" align="right" valign="middle">Total</th>';
					$cart_string .= '</tr>';
					while($row_cart = mysql_fetch_array($result_cart)) {
                                        // echo "<pre/>";   print_r($row_cart);
						$row_cart_id = $row_cart['cart_id'];
						$cart_item_code = $row_cart['item_code'];
						$cart_qty = $row_cart['qty'];
						$result_cart_webitems = mysql_query("SELECT * FROM shop_webitems WHERE Code LIKE '".$cart_item_code."' AND is_active = 1");
						if($row_cart_webitems = mysql_fetch_array($result_cart_webitems)) {
                                                  //echo "<pre/>";  print_r($row_cart_webitems);
							$cart_item_id = $row_cart_webitems['item_id'];
							$cart_item_name = $row_cart_webitems['Desc'];
							$cart_item_pcsm2 = floatval($row_cart_webitems['PcsM2']);
							$cart_item_unit = $row_cart_webitems['Unit'];						
							if($cart_item_pcsm2>0){ //sell in m2
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
                                                          /////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
                                                             if($cart_item_pcsm2==0 || $cart_item_pcsm2==''){ 
                                                                $item_WebPricePce    = floatval($row_cart_webitems['WebPricePce']);
                                                                $item_RetailPricePce = floatval($row_cart_webitems['RetailPricePce']);
                                                               if(!empty($item_WebPricePce)) {
                                                                $cart_item_buy = floatval($item_WebPricePce);
                                                                } else { //if web price value does not exist, use 20% off from retail price
                                                                $item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
                                                                $cart_item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
                                                                }
                                                                $cart_item_rrp = floatval($item_RetailPricePce);
                                                                $cart_item_unit='pcs';
                                                             }
                                                         //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
							$result_size = mysql_query("SELECT * FROM shop_size WHERE Code LIKE '".$row_cart_webitems['Size']."' AND is_active=1");
							if($row_size=mysql_fetch_array($result_size)){$item_Size_name=$row_size['Description'];}
							$display_size_name_inwishlist = '';
							if($item_Size_name!=""){ $display_size_name_inwishlist = '('.$item_Size_name.')'; }
							$cart_string .= '
							<tr>
								<td align="center" valign="middle"><div class="thumb"><!--<a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">-->'.$cart_image1_imgsrc.'<!--</a>--></div></td>
								<td align="left" valign="middle"><!--<a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">-->'.$cart_item_name.'<!--</a>--> '.$display_size_name_inwishlist.'</td>
								<td align="center" valign="middle">
									<div class="qty">
										
                                                                                    <div id="qty_value_'.$row_cart_id.'" class="text">'.$cart_qty.'<div class="clear"></div></div>
										    <div class="clear"></div>
									</div>
								</td>
							';
								//<td align="right" valign="middle">$'.number_format($cart_item_buy,2).''.$cart_item_unit.'</td>
							//$cart_string .= '<td align="right" valign="middle"><div id="subtotal_'.$row_cart_id.'">$'.number_format($cart_item_subtotal,2).'</div></td>';
							$cart_string .= '</tr>';
						}
					}
					$cart_string .= '
					</table>
					<div id="cart_checkout_note" class="cart_checkout_note">This page shows contents of your wishlist. To submit quote with quote, click request now.</div>';
					//$cart_string .= '<div id="cart_total" class="cart_total"><div class="price">$'.number_format($cart_final_total,2).'</div><div class="label">TOTAL</div><div class="clear"></div></div>';
				} else {
					$cart_string .= '<div class="bodytext">You have not added any items to your Wishlist yet.</div>';
				}
				echo $cart_string;
				?>				
				<div class="clear"></div>
			</div>
	                <!--<input type="hidden" name="currency_code" value="AUD">
                    <input type="hidden" id="total" name="total" value="<?php //echo $cart_final_total?>"></input>-->
                    <input type="submit" value="Submit Quote Request" name="submit" id="placeorder">
                        <a href="cart.php"><input type="button" value="Review Wishlist" name="submit" id="placeorder"></input></a>
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