<?php
session_start();
require( '../wordpress/wp-load.php' );
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');
include("class/class.watermark.php");
$result_webitems = mysql_query("SELECT *, WebPricePce, TradePricePce, (WebPricePce+TradePricePce) as pricesum FROM shop_webitems WHERE WebExport='YES' AND is_active='1' ORDER BY RAND() LIMIT 0,20") or die(mysql_error());
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta name="google-site-verification" content="aQXedls-hbPpeEDjYSu_ZRZC-Z_5Ty9KYbUeocNoxGE" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <?php
          include('includes/attach_styles.php'); //Cascading Style Sheets
          include('includes/attach_scripts.php'); //Javascripts and scripts
        ?>
        <?php get_template_part('templates/head'); ?>
    </head>
    <body class='grey_bg'>
        <!--[if lt IE 9]>
                    <div class="alert alert-warning">
            <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
        </div>
        <![endif]-->
        <?php
          do_action('get_header');
          get_template_part('templates/header');
        ?>
        <div class="wrap container" role="document">
            <div class="content row">
                <main class="main" role="main">
                        <?php include('includes/shop-navigation.php'); ?>
                    <div class="clearfix white_bg">
                        <div class="col-lg-4">
                            <?php include('includes/finder.php'); ?>
                            <?php include('includes/store-categories.php'); ?>
                            <?php include('includes/featured-products.php'); ?>
                        </div>
                        <!-- Main -->
                        <div class="col-lg-8">
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
                        </div>
                    </div>
                </main><!-- /.main -->
            </div><!-- /.content -->
			<?php
                do_action('get_footer');
                get_template_part('templates/footer');
                wp_footer();
			?>
        </div><!-- /.wrap -->
    </body>
</html>