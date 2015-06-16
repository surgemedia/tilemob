<? 
	session_start();
	include('../dbconnect.php');
	include('includes/global_variables.php');
	include('includes/requests.php');
	
	if($_POST['rm_cart_id']!=""){
		mysql_query("UPDATE shop_cart SET is_active = 0 WHERE cart_id = ".$_POST['rm_cart_id']);
	}
	
	If($_POST['item_Code']!="" && $_POST['totm2']!="" && $_SESSION['new_items']==1){
		$check_dbss = mysql_query("SELECT * FROM shop_cart WHERE user_id LIKE '%".$_POST['shop_order_id']."%' AND item_code LIKE '".$_POST['item_Code']."' AND is_active = 1");
		$check_db_num = mysql_num_rows($check_dbss);
		$check_db_rows = mysql_fetch_array($check_dbss);		
		$update_qty = $check_db_rows['qty'] + $_POST['totm2'];
		$update_price = $check_db_rows['price'] + $_POST['totprice'];
		
		if($check_db_num>0){
			mysql_query("UPDATE shop_cart SET qty = '".$update_qty."', price = '".$update_price."' WHERE cart_id =".$check_db_rows['cart_id']);
			echo "UPDATE shop_cart SET qty = '".$update_qty."', price = '".$update_price."' WHERE cart_id =".$check_db_rows['cart_id'];
		}else{
			mysql_query("INSERT INTO shop_cart VALUES(NULL, '".$_POST['shop_order_id']."', '".$_POST['shop_order_id']."', '', '".$_POST['item_Code']."', '".$_POST['totm2']."', '".$_POST['totprice']."', NULL, 1)");
		}
		$_SESSION['new_items']=0;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<?php 
include('includes/attach_styles.php'); //Cascading Style Sheets
include('includes/attach_scripts.php'); //Javascripts and scripts
?>
</head>
<body oncontextmenu="return false"  onselectstart="return false">
<?php include('includes/start_body.php'); ?>
<div id="container" class="container">
	<div id="header" class="header"><?php include('includes/header.php'); ?></div>
	<div id="body" class="body">
		<div id="body_left" class="body_left">
			<?php include('includes/finder.php'); ?>
                    <?php include('includes/store-categories.php'); ?>
                    <?php include('includes/featured-products.php'); ?>
			<div class="clear"></div>
		</div>
		<div id="body_right" class="body_right">
        	<?php
			if($_shop_user_id!=""){
				$check_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id LIKE '%".$_shop_user_id."%' AND is_active = 1");
				$check_cart_num = mysql_num_rows($check_cart);
			}
			?>
			<div id="cart" class="cart">
				<h1>Your Wishlist contains <?php echo $check_cart_num; ?> items</h1>				
				<?php
				$cart_string = '';
				$cart_final_total = 0;
				$result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id LIKE '%".$_shop_user_id."%' AND qty > 0 AND is_active = 1");
				if($check_cart_num>0) {
					$cart_string .= '
					
					<table id="cart_table" width="100%" class="cart_table">
						<tr>
							<th width="90">Thumbnail</th>
							<th align="left" valign="middle">Item</th>
							<th width="60" align="center" valign="middle">QTY</th>';
							//<th width="100" align="right" valign="middle">Price</th>
							//<th width="100" align="right" valign="middle">Total</th>
					$cart_string .= '
						</tr>';
					$j_counter = 1;
					while($row_cart = mysql_fetch_array($result_cart)) {
                                        // echo "<pre/>";   print_r($row_cart);
						$row_cart_id = $row_cart['cart_id'];
						$cart_item_code = $row_cart['item_code'];
						$cart_qty = $row_cart['qty'];
						$result_cart_webitems = mysql_query("SELECT * FROM shop_webitems WHERE Code='".$cart_item_code."' AND is_active = 1 ");
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
                
                                                             if($cart_item_pcsm2==0 ||  $cart_item_pcsm2==''){ 
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
                                                       // echo "cart_item_save".$cart_item_save;
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
								<td align="left" valign="middle">
								<form action="#" method="post" id="rm_cart_id'.$j_counter.'">
									<input type="hidden" name="rm_cart_id" value="'.$row_cart['cart_id'].'">
								</form>
								<!--<a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">-->'.$cart_item_name.'<!--</a>--> '.$display_size_name_inwishlist.'(<span class="redlink"><a href="#" onclick="document.getElementById(\'rm_cart_id'.$j_counter.'\').submit();">remove</a></span>)</td>
								<td align="center" valign="middle">
									<div class="qty">
										<!--<div id="qty_value_'.$row_cart_id.'" class="text"><input type="text" id="qty_field_'.$row_cart_id.'" name="qty_field_'.$row_cart_id.'" value="'.$cart_qty.'" class="textfield1" onkeyup="updateCartQty(\''.$_shop_user_id_encoded.'\',\'\','.$row_cart_id.');"><div class="clear"></div></div>-->
                                                                                    <div id="qty_value_'.$row_cart_id.'" class="text">'.$cart_qty.'<div class="clear"></div></div>
										<!--<div id="qty_controls_'.$row_cart_id.'" class="controls">
											<div id="increase_'.$row_cart_id.'" class="increase"><a href="javascript:void(0);" title="+" onclick="increaseCartQty(\''.$_shop_user_id_encoded.'\',\'\','.$row_cart_id.');"><div class="clear"></div></a>
											<div id="decrease_'.$row_cart_id.'" class="decrease"><a href="javascript:void(0);" title="-" onclick="decreaseCartQty(\''.$_shop_user_id_encoded.'\',\'\','.$row_cart_id.');"><div class="clear"></div></a>
											<div class="clear"></div>
										</div>-->
										<div class="clear"></div>
									</div>
								</td>';
								//<td align="right" valign="middle">$'.number_format($cart_item_buy,2).''.$cart_item_unit.'</td>
							//$cart_string .= '<td align="right" valign="middle"><div id="subtotal_'.$row_cart_id.'">$'.number_format($cart_item_subtotal,2).'</div></td>';
							$cart_string .= '</tr>';
						$j_counter = $j_counter + 1;
						}
					}
					$cart_string .= '
					</table>
					<div id="cart_checkout_note" class="cart_checkout_note">This page shows contents of your wishlist. To submit quote with quote, click request now.</div>
					';
					//<div id="cart_total" class="cart_total"><div class="price">$'.number_format($cart_final_total,2).'</div><div class="label">TOTAL</div><div class="clear"></div></div>
					$cart_string .= '
					<div class="checkout_button"><a href="checkOut.php" title="Checkout now"><input id="placeorder" type="submit" value="GET QUOTE"></a></div>';
				} else {
					$cart_string .= '<div class="bodytext">You have not added any items to your Wishlist yet.</div>';
				}
				echo $cart_string;
				?>				
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer" class="footer"><?php include('includes/footer.php'); ?></div>
	<div class="clear"></div>
</div>
<?php include('includes/end_body.php'); ?>
</body>
</html>