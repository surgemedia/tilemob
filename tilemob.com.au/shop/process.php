<?php 
//echo $_shop_user_id;
session_start();
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');
require_once('paypal.class.php');  // include the class file.
$p = new paypal_class;             // initiate an instance of the class
/////////////////////////////////////////////////////////////////////
$cart_final_total = 0;
$result_cart = mysql_query("SELECT * FROM shop_cart WHERE user_id='$_shop_user_id' AND qty>0 AND is_active='1'");
if($_shop_total_cart>0) {
	while($row_cart = mysql_fetch_array($result_cart)) {
	$row_cart_id = $row_cart['cart_id'];
	$cart_item_code = $row_cart['item_code'];
	$cart_qty = $row_cart['qty'];
        $cart_price = $row_cart['price'];
	$cart_item_id = $row_cart_webitems['item_id'];
	$cart_item_unit = $row_cart_webitems['Unit'];						
	$cart_final_total += $cart_price;
	$cart_final_total = number_format($cart_final_total,2);						
        $amount	= $cart_final_total;					      }				
	} 
               
/////////////////////////////////////////////////////////////////////
if($_POST['submit'] == "Place Order")
{
   $firstName = $_POST['firstname'];
   $lastname  = $_POST['lastname'];
   $email     = $_POST['email'];
   $phoneno   = $_POST['phoneno'];
   $address   = $_POST['address'];
   $city      = $_POST['city'];
   $state     = $_POST['state'];
   $zipcode   = $_POST['zipcode'];
   $country   = $_POST['country'];
   $shipping  = $_POST['shipping'];
   mysql_query("INSERT INTO billing_info (order_id, first_name, last_name, email, phone, address, city, state,zip,country,shipping_option) 
				VALUES ('$_shop_order_id', '$firstName', '$lastname', '$email', '$phoneno', '$address', '$city', '$state','$zipcode','$country','$shipping')");
  // echo "INSERT INTO billing_info (order_id, order_date)	VALUES ('$_shop_user_id',now())";
   mysql_query("INSERT INTO order_details (order_id, order_date,order_status) VALUES ('$_shop_order_id',now(),'active')");
}

 
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
 
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
 
// if there is not action variable, set the default action of 'process'
//if (empty($_GET['action'])) $_GET['action'] = 'process';  
 
switch ($_GET['action']) {
 
   case 'process':      // Process and order...
 
      $p->add_field('business', "sacheesh_rc-facilitator@ispg.in");
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('custom', $_shop_order_id);//if any custom id needs to pass
	  $p->add_field('item_name', 'Shopping cart payment');
      $p->add_field('amount', $amount);
 
      $p->submit_paypal_post(); // submit the fields to paypal
      //$p->dump_fields();      // for debugging, output a table of all the fields
      break;
 
      case 'success':      // Order was successful...
  // print_r($_REQUEST);
   
          $_shop_order_id = $_REQUEST['_shop_order_id'];
          $orderId        = $_REQUEST['custom'];
          $_shop_user_id  = $_REQUEST['_shop_user_id'];
          $payment_status = ($_REQUEST['payment_status']=="Completed")?"active":"";
          if($_shop_order_id)
          {
              
              mysql_query("UPDATE order_details SET payment_order_id ='$_shop_order_id',payment_status ='active' WHERE order_id ='$_shop_order_id'");
          }
          
          
          /////////////////////////Send Order details/////////////////////////////////
          if($orderId){
          $billing_string = '';
          $result_billing_info = mysql_query("SELECT * FROM billing_info WHERE order_id ='$_shop_order_id'");
          $billing_string .=  '<u>Billing Information</u>'."<br/>\n";
          while($row = mysql_fetch_array($result_billing_info))
          {
              $orderNo         = $row['order_id'];
              $name            = $row['first_name'].'.'.$row['last_name'];
              $customerMail    = $row['email'];
              $shipping_option = $row['shipping_option'];
              $billing_string .= $row['first_name'].'.'.$row['last_name'] ."<br/>\n";
              $billing_string .= $row['email'] ."<br/>\n";
              $billing_string .= $row['phone'] ."<br/>\n";
              $billing_string .= $row['address'] ."<br/>\n";
              $billing_string .= $row['city'] ."<br/>\n";
              $billing_string .= $row['state'] ."<br/>\n";
              $billing_string .= $row['zip'] ."<br/>\n";
              $billing_string .= $row['country'] ."<br/>\n";
                         
          }
						
          $cart_string = '';
				$cart_final_total = 0;
				$result_cart = mysql_query("SELECT * FROM shop_cart WHERE order_id='$_shop_order_id' AND qty>0 AND is_active='1'");
				if($_shop_total_cart>0) {
					$cart_string .= '
					<table id="cart_table" width="50%" class="cart_table">
						<tr>
							<th align="left" valign="middle">Item</th>
							<th align="center" valign="middle">QTY</th>
							<th  align="right" valign="middle">Price</th>
							<th  align="right" valign="middle">Total</th>
						</tr>';
					while($row_cart = mysql_fetch_array($result_cart)) {
						$row_cart_id = $row_cart['cart_id'];
						$cart_item_code = $row_cart['item_code'];
						$cart_qty = $row_cart['qty'];
                                                $cart_price = $row_cart['price'];
						$result_cart_webitems = mysql_query("SELECT * FROM shop_webitems WHERE Code='$cart_item_code' AND is_active='1'");
						if($row_cart_webitems = mysql_fetch_array($result_cart_webitems)) {
                                                  //echo "<pre/>";  print_r($row_cart_webitems);
							$cart_item_id = $row_cart_webitems['item_id'];
							$cart_item_name = $row_cart_webitems['Desc'];
							$cart_item_pcsm2 = floatval($row_cart_webitems['PcsM2']);
							$cart_item_unit = $row_cart_webitems['Unit'];						
							if($cart_item_pcsm2>0&&$cart_item_unit=='M2'){ //sell in m2
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
							$cart_item_subtotal = $cart_item_buy*$cart_qty;
							 $cart_final_total += $cart_price;
							$cart_string .= '
							<tr>
								<td align="left" valign="middle"><a href="detail.php?id='.$cart_item_id.'" title="'.$cart_item_name.'">'.$cart_item_name.'</a> </td><!--(<span class="redlink"><a href="javascript:void(0);" title="Remove" onclick="removeFromCart(\''.$_shop_user_id_encoded.'\',\'\','.$row_cart_id.');">remove</a></span>)</td>-->
								<td align="center" valign="middle">
									<div class="qty">
										<div id="qty_value_'.$row_cart_id.'" class="text">'.$cart_qty.'</div>
										<!--<div id="qty_controls_'.$row_cart_id.'" class="controls">
											<div id="increase_'.$row_cart_id.'" class="increase"><a href="javascript:void(0);" title="+" onclick="increaseCartQty(\''.$_shop_user_id_encoded.'\',\'\','.$row_cart_id.');"><div class="clear"></div></a>
											<div id="decrease_'.$row_cart_id.'" class="decrease"><a href="javascript:void(0);" title="-" onclick="decreaseCartQty(\''.$_shop_user_id_encoded.'\',\'\','.$row_cart_id.');"><div class="clear"></div></a>
											<div class="clear"></div>
										</div>-->
										<div class="clear"></div>
									</div>
								</td>
								<td align="right" valign="middle">$'.number_format($cart_item_buy,2).''.$cart_item_unit.'</td>
								<td align="right" valign="middle"><div id="subtotal_'.$row_cart_id.'">$'.number_format($cart_price,2).'</div></td>
							</tr>';
						}
					}
					$cart_string .= '
                                        <tr><td>TOTAL :</td><td>$'.number_format($cart_final_total,2).'</td></tr>
					</table>';
				} 
				$message = $responder = '';
                $subject .= 'TILESBRISBANE.COM: Your Order';
		$message .= 'Order Details'."<br/>\n";
		$message .= 'TILESBRISBANE.COM'."<br/>\n";
                $message .= 'Hi '. $name. ',Thank you for shope with Tiles Brisbane. Your Order No is :' .$orderNo. ".<br/>\n";
		$message .= '************************************************************************'."<br/>\n";
                $message .= $billing_string."<br/>\n";
                $message .= 'Shipping Option :'.$shipping_option."<br/>\n";
                $message .= '************************************************************************'."<br/>\n";
                $message .= '<u>Order Content</u>'."<br/>\n";
		$message .= $cart_string."\n";
		
		$message .= '************************************************************************'."<br/>\n";
                $message .= "<br/>\n";
                $message .= "<br/>\n";
                $message .="Sincerely,"; 
		//$message .= 'End of message.'."\n";
		
		$store_message = $message."<br/>\n";
		
		//$sendto_admin = 'richard@dmwcreative.com.au';
                $sendto_customer = 'sacheesh_rc@ispg.in';
		// $sendto_admin = 'sacheesh_rc@ispg.in';
		$strtotime = strtotime('now');
		
		ini_set('sendmail_from', $email);
                $mail_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$mail_headers .= "From: TILESBRISBANE.COM\r\nReply-To: ".$email."";	
				
		mail($sendto_customer, $subject, $message, $mail_headers);
		
   
                /////////////////////////////// Notification admin//////////////////////////////////
                $subject  = "TILESBRISBANE.COM: New Order Received";
                $message1 = $responder1 = '';
   
		$message1 .= 'There is a new order placed on TILESBRISBANE.COM'."<br/>\n";
		//$message1 .= 'TILESBRISBANE.COM'."<br/>\n";
                $message1 .= '<u>Order Details</u>'. ".<br/>\n";
                $message1 .= 'Order No :' .$orderNo. ".<br/>\n";
		$message1 .= '************************************************************************'."<br/>\n";
                $message1 .= $billing_string."<br/>\n";
                $message1 .= 'Shipping Option :'.$shipping_option."<br/>\n";
                $message1 .= '************************************************************************'."<br/>\n";
                $message1 .= '<u>Order Content</u>'."<br/>\n";
		$message1 .= $cart_string."\n";
		
		$message1 .= '************************************************************************'."<br/>\n";
                $message1 .= "<br/>\n";
               
		//$message .= 'End of message.'."\n";
		
		$store_message1 = $message1."<br/>\n";
		
		//$sendto_admin = 'richard@dmwcreative.com.au';
                $sendto_admin = 'sacheesh_rc@ispg.in';
		// $sendto_admin = 'sacheesh_rc@ispg.in';
		$strtotime = strtotime('now');
		
		ini_set('sendmail_from', $email);
                $mail_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$mail_headers .= "From: TILESBRISBANE.COM\r\nReply-To: ".$email."";	
				
		mail($sendto_admin, $subject, $message1, $mail_headers);
          }
          setcookie("_shop_user_id", "", time()-3600);
          setcookie("_shop_order_id", "", time()-3600);
         /////////////////////////////////////////////////////////////////////////////
        header("location:thankyou.php");
          
 
      break;
 
      case 'cancel':       // Order was canceled...
          header("location:checkOut.php");
         //do what ever you like if the order was cancelled.
 
      break;
 
      case 'ipn':          // Paypal is calling page for IPN validation...
 
      if ($p->validate_ipn())
	  {
 
	  // This is ipn section which runs in the backend. You can call all the return values from here including transaction id, custom value etc. You can update the database from here.
	  }
	  break;
 }
?>