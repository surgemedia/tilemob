<?php
session_start();
require( '../wp-load.php' );
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');
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
                            <div id="cart" class="cart">
                                <h1>Your collection contains <?php echo $_shop_total_cart; ?> items<p class="sales-hotline">Sales Hotline: <?php the_field('sales_hotline','option') ?></p></h1>
                                <script>
                                  console.log(<?php echo $_shop_user_id; ?>);
                                </script>
                                <?php
                                  $cart_string = '';
                                  $cart_final_total = 0;
                                  $result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id='$_shop_user_id' AND qty>0 AND is_active='1'");
                                  if($_shop_total_cart>0) {
                                      $cart_string .= '
                                      <div class="checkout_button"><a href="checkOut.php" title="Checkout now">Submit my collection to request a Quote</a></div>
                                      <table id="cart_table" width="100%" class="cart_table">
                                              <tr>
                                                <th width="90">Thumbnail</th>
                                                <th align="left" valign="middle">Item</th>
                                                <th width="60" align="center" valign="middle">QTY</th>
                                                <!--<th width="100" align="right" valign="middle">Price</th>-->
                                                <!--<th width="100" align="right" valign="middle">Total</th>-->
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
                            		   $cart_item_size = $row_cart_webitems['Size'];

                                   // Get size from shop_size table
                                   $result_size_check = mysql_query("SELECT * FROM shop_size WHERE Code='$cart_item_size' AND is_active='1'");
                                    if($row_size_check = mysql_fetch_array($result_size_check)) {
                                        $item_display_size = '<span>Size: '.$row_size_check['Description'].'</span>';
                                    } else { $item_display_size=''; }

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
                            				$cart_string .= '
                                        <tr>
                                        <td align="center" valign="middle"><div class="thumb"><a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">'.$cart_image1_imgsrc.'</a></div></td>
                                        <td align="" valign="middle"><a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">'.$cart_item_name.'</a> (<span class="redlink"><a href="javascript:void(0);" title="Remove" onclick="removeFromCart(\''.$_shop_user_id_encoded.'\',\'\','.$row_cart_id.');">remove</a></span>)<br><span>Code: '.$cart_item_code.'</span><br>'.$item_display_size.'</td>
                                        <td align="" valign="middle">
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
                                         </td>
                                         <!--<td align="" valign="middle">$'.number_format($cart_item_buy,2).''.$cart_item_unit.'</td>-->
                                         <!--<td align="" valign="middle"><div id="subtotal_'.$row_cart_id.'">$'.number_format($cart_item_subtotal,2).'</div></td>-->
                                         </tr>';
                        }
                    }
                    $cart_string .= '
                                      </table>
                                      <div id="cart_checkout_note" class="cart_checkout_note">This page shows contents of your wishlist. To proceed with quote, click Submit my collection for a Quote.</div>
                                      <!--<div id="cart_total" class="cart_total"><div class="price">$'.number_format($cart_final_total,2).'</div><div class="label">TOTAL</div><div class="clear"></div></div>-->
                                      <div class="checkout_button"><a href="checkOut.php" title="Checkout now" class="btn green">Submit my collection for a Quote</a></div>';
                } else {
                                 $cart_string .= '<div class="bodytext">You have not added any items to your collection yet.</div>';
                }
                echo $cart_string;
                ?>
                                                    </div>
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