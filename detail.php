<? 
	session_start();
	include('../dbconnect.php');
	include('includes/global_variables.php');
	include('includes/requests.php');
	include("class/class.watermark.php");
	$id   = $_GET['id'];
	$msg  = $_GET['s2'];
	if(!empty($_GET['id'])) {
		$item_id = trim($_GET['id']);
		$result_item = mysql_query("SELECT * FROM shop_webitems WHERE item_id LIKE '".$item_id."' AND WebExport LIKE 'YES' AND is_active = 1");
		if($row_item=mysql_fetch_array($result_item)) {
			$item_lead= $row_item['LeadTime'];
			$item_Code = $row_item['Code'];
			$item_Desc = $row_item['Desc'];
			$item_iCode = $row_item['InternalCode'];
			$item_iDesc = $row_item['InternalDesc'];
			$item_RetailPricePce = $row_item['RetailPricePce'];
			$item_RetailPriceM2 = $row_item['RetailPriceM2'];
			$item_TradePricePce = $row_item['TradePricePce'];
			$item_TradePriceM2 = $row_item['TradePriceM2'];
			$item_WebPricePce = $row_item['WebPricePce'];
			$item_WebPriceM2 = $row_item['WebPriceM2'];
			$item_images = $row_item['images'];
			$item_Weight = $row_item['Weight'];
			$item_Unit = $row_item['Unit'];
			$item_Unit_m2 = $row_item['Unit'];
			$item_PEIRating = $row_item['PEIRating'];
			$item_SlipRating = $row_item['SlipRating'];
			$item_QtyAvailable = $row_item['QtyAvailable'];
			$item_PcsM2 = $row_item['PcsM2'];
			$item_PcsBox = $row_item['PcsBox'];
			$item_M2Box = $row_item['M2Box'];
			$item_BoxesPallet = $row_item['BoxesPallet'];
			$item_M2Pallet = $row_item['M2Pallet'];
			$item_Category = $row_item['Category'];
			$item_CategoryDescription = $row_item['CategoryDescription'];
			$item_SupplierCode = $row_item['SupplierCode'];
			$item_SupplierName = $row_item['SupplierName'];
			$item_SuppStock = $row_item['SuppStock'];
			$item_Type = $row_item['Type'];
			$item_Material = $row_item['Material'];
			$item_Size = $row_item['Size'];
			$item_Thickness = $row_item['Thickness'];
			$item_Use = $row_item['Use'];
			$item_Edge = $row_item['Edge'];
			$item_Colour = $row_item['Colour'];
			$item_Surface = $row_item['Surface'];
			$item_Pattern = $row_item['Pattern'];
			$item_RelatedTo = $row_item['RelatedTo'];
			$item_Heading = $row_item['Heading'];
			$item_SubHeading = $row_item['SubHeading'];
			$item_Country = $row_item['Country']; //flag
			$item_Manufacturer = $row_item['Manufacturer'];
			$item_Pantone = $row_item['Pantone'];
			$item_Location = $row_item['Location'];
			$item_Notepad2 = $row_item['Notepad2'];
			$item_GstCode = $row_item['GstCode'];
			$item_GstDesc = $row_item['GstDesc'];
			$item_lastupdate = $row_item['lastupdate'];
			$result_heading = mysql_query("SELECT * FROM shop_heading WHERE Code LIKE '".$item_Heading."' AND is_active = 1");
			if($row_heading=mysql_fetch_array($result_heading)){$item_Heading_name=$row_heading['Description'];}
			$result_relatedto = mysql_query("SELECT * FROM shop_relatedto WHERE Code LIKE '".$item_RelatedTo."' AND is_active = 1");
			if($row_relatedto=mysql_fetch_array($result_relatedto)){$item_RelatedTo_name=$row_relatedto['Description'];}
			$result_use = mysql_query("SELECT * FROM shop_use WHERE Code LIKE '".$item_Use."' AND is_active = 1");
			if($row_use=mysql_fetch_array($result_use)){$item_Use_name=$row_use['Description'];}
			$result_sliprating = mysql_query("SELECT * FROM shop_sliprating WHERE Code LIKE '".$item_SlipRating."' AND is_active = 1");
			if($row_sliprating=mysql_fetch_array($result_sliprating)){$item_SlipRating_name=$row_sliprating['Description'];}else{$item_SlipRating_name='';}
			$result_peirating = mysql_query("SELECT * FROM shop_peirating WHERE Code LIKE '".$item_PEIRating."' AND is_active = 1");
			if($row_peirating=mysql_fetch_array($result_peirating)){$item_PEIRating_name=$row_peirating['Description'];}else{$item_PEIRating_name='';}
			$result_size = mysql_query("SELECT * FROM shop_size WHERE Code LIKE '".$item_Size."' AND is_active=1");
			if($row_size=mysql_fetch_array($result_size)){$item_Size_name=$row_size['Description'];}
			$result_thickness = mysql_query("SELECT * FROM shop_thickness WHERE Code LIKE '".$item_Thickness."' AND is_active = 1");
			if($row_thickness=mysql_fetch_array($result_thickness)){$item_Thickness_name=$row_thickness['Description'];}
			$result_colour = mysql_query("SELECT * FROM shop_colour WHERE Code LIKE '".$item_Colour."' AND is_active = 1");
			if($row_colour=mysql_fetch_array($result_colour)){$item_Colour_name=$row_colour['Description'];}
			$result_surface = mysql_query("SELECT * FROM shop_surface WHERE Code LIKE '".$item_Surface."' AND is_active = 1");
			if($row_surface=mysql_fetch_array($result_surface)){$item_Surface_name=$row_surface['Description'];}
			$result_edge = mysql_query("SELECT * FROM shop_edge WHERE Code LIKE '".$item_Edge."' AND is_active = 1");
			if($row_edge=mysql_fetch_array($result_edge)){$item_Edge_name=$row_edge['Description'];}
			$result_material = mysql_query("SELECT * FROM shop_material WHERE Code LIKE '".$item_Material."' AND is_active = 1");
			if($row_material=mysql_fetch_array($result_material)){$item_Material_name=$row_material['Description'];}
			$result_pantone = mysql_query("SELECT * FROM shop_pantone WHERE Code LIKE '".$item_Pantone."' AND is_active = 1");
			if($row_pantone=mysql_fetch_array($result_pantone)){$item_Pantone_name=$row_pantone['Description'];}else{$item_Pantone_name='';}
			$result_pattern = mysql_query("SELECT * FROM shop_pattern WHERE Code LIKE '".$item_Pattern."' AND is_active = 1");
			if($row_pattern=mysql_fetch_array($result_pattern)){$item_Pattern_name=$row_pattern['Description'];}
			$result_location = mysql_query("SELECT * FROM shop_location WHERE Code LIKE '".$item_Location."' AND is_active = 1");
			if($row_location=mysql_fetch_array($result_location)){$item_Location_name=$row_location['Description'];}					
			if($item_PcsM2>0 && $item_PcsM2!=''){
						if(!empty($item_WebPriceM2)) {
								$item_buy = floatval($item_WebPriceM2);
				} else { //if web price value does not exist, use 20% off from retail price
								$item_web_discount_amount = floatval($item_RetailPriceM2)*0.2; //20% of retail price
					$item_buy = floatval($item_RetailPriceM2)-$item_web_discount_amount;
				}
				$item_rrp = floatval($item_RetailPriceM2);
				$item_Unit='m&sup2;';
			}
					/////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
					
					if($item_PcsM2==0 || $item_PcsM2==''){ 
							if(!empty($item_WebPricePce)) {
								
					$item_buy = floatval($item_WebPricePce);
				} else { //if web price value does not exist, use 20% off from retail price
							   
					$item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
					$item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
				}
				$item_rrp = floatval($item_RetailPricePce);
				//$item_Unit='pcs';
							$item_Unit = 'pcs';
			}
					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$item_Weight_name = $item_Weight.'kg/'.$item_Unit;
			$item_save = $item_rrp-$item_buy;
			if($item_save<0){$item_buy=0.00;}
			$item_images = unserialize($row_item['images']);
					//print_r($item_images);
			$images_dir = 'images/items/';
			$image1 = $image1_imgsrc = '';
			$image1 = $images_dir.$item_images[0];
			if(is_file($image1)) {
				$image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_Desc.'
				'.$item_iCode.'
				'.$item_iDesc.'
				" border="0" class="galleryImg" />';
				$product_details_icode = $item_iCode;
				$product_details_idesc = $item_iDesc;
			} else {
				$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_Desc.'
				'.$item_iCode.'
				'.$item_iDesc.'
				" border="0" />';
				$product_details_icode = $item_iCode;
				$product_details_idesc = $item_iDesc;
			}
		} else {
			header('location:index.php');
		}
	} else {
		header('location:index.php');
	}
	
	
	
	if(!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email'])) {
		$name = $_SESSION['name'] = trim($_POST['name']);
		$email = $_SESSION['email'] = trim($_POST['email']);
		$phone = $_SESSION['phone'] = trim($_POST['phone']);
		if(empty($_POST['subject'])){$_SESSION['contact_subject']=$subject='Website enquiry form';}else{$_SESSION['contact_subject']=$subject=trim($_POST['subject']);}
		$enquiry = $_SESSION['enquiry'] = trim($_POST['enquiry']);
		
		$message = $responder = '';
		
		
			$message .= 'WEBSITE ENQUIRY FORM'."\n";
			$message .= 'TILESBRISBANE.COM'."\n";
			$message .= '******************************************************************'."\n";
			$message .= 'NAME: '.$name."\n";
			$message .= 'E-MAIL ADDRESS: '.$email."\n";	
			if(!empty($phone)){
				$message .= 'PHONE: '.$phone."\n";
			}		
			$message .= '******************************************************************'."\n";
			$message .= 'ENQUIRY/MESSAGE: '."\n";
			$message .= $enquiry."\n";
			$message .= '******************************************************************'."\n";
			$message .= 'End of message.'."\n";
			
			$store_message = $message;
			
			$sendto_admin = 'thetilemob@gmail.com';
			// $sendto_admin = 'sacheesh_rc@ispg.in';
			$strtotime = strtotime('now');
			
			ini_set('sendmail_from', $email);
			$mail_headers = "From: ".$email."\r\nReply-To: ".$email."";	
			if(trim($_POST['security'])!=$_SESSION['image_random_value_raw']) {
				$show_error_code = "Your form could not been sent because the verification code at the end of the form was entered incorrectly. Please try again.');";
			}else{
				if (mail($sendto_admin, $subject, $message, $mail_headers)) { //Send to admin
				}else{
					echo "EMAIL SENT ERROR!";	
					exit;
				}
				
				ini_set('sendmail_from', $sendto_admin);
				$mail_headers = "From: ".$sendto_admin."\r\nReply-To: ".$sendto_admin.""; 
				
				$_SESSION['name'] = '';
				$_SESSION['email'] = '';
				$_SESSION['phone'] = '';
				$_SESSION['enquiry'] = '';
				$pdtId = $_POST['pdtId'];		
				header('location:detail.php?id='.$pdtId.'&s2=Thank you, your enquiry was sent!');
			}
	}
	/* code for ask a question ends*/
	
	$productDesc = "Code : ".$item_Code. " , Description: ".$item_Desc;
	
	
	/* Code for add deals*/
	
	
	
	
	
	
	if($_POST['submit'] ==  "Submit") {
		$desc  =  $_SESSION['desc']  = trim($_POST['desc']);
			$qty   =  $_SESSION['qty']   = trim($_POST['qty']);
		$name  =  $_SESSION['name']  = trim($_POST['name']);
			$phone =  $_SESSION['phone'] = trim($_POST['phone']);
			$email =  $_SESSION['email'] = trim($_POST['email']);
		$subject='LRG QTY DEAL';
		
		$message = $responder = '';
		
			$message .= 'BIG QTY DEALS'."\n";
			$message .= 'TILESBRISBANE.COM'."\n";
			$message .= '******************************************************************'."\n";
			$message .= 'Description: '.$desc."\n";
			$message .= 'Qty: '.$qty."\n";	
			
			$message .= 'Phone: '.$phone."\n";
			
					$message .= 'Email: '.$email."\n";	
			$message .= '******************************************************************'."\n";
			$message .= 'End of message.'."\n";
			
			$store_message = $message;
			
			//$sendto_admin = 'richard@dmwcreative.com.au';
					$sendto_admin = 'thetilemob@gmail.com';
			// $sendto_admin = 'sacheesh_rc@ispg.in';
			$strtotime = strtotime('now');
			
			ini_set('sendmail_from', $email);
			$mail_headers = "From: ".$email."\r\nReply-To: ".$email."";	
			if(trim($_POST['security'])!=$_SESSION['image_random_value_raw']) {
				$show_error_code = "Your form could not been sent because the verification code at the end of the form was entered incorrectly. Please try again.');";
			}else{
				if (mail($sendto_admin, $subject, $message, $mail_headers)) { //Send to admin
					/*mysql_query("INSERT INTO shop_forms 
					(form_id, form, subject, message, sendername, senderemail, receivername, receiveremail, is_deleted, strtotime) 
					VALUES ('', 'Contact form', '$subject', '$store_message', '$fullname', '$email', 'Admin', '$sendto_admin', '0', '$strtotime')");
					$last_insert_id = mysql_insert_id();*/
				}
				
				ini_set('sendmail_from', $sendto_admin);
				$mail_headers = "From: ".$sendto_admin."\r\nReply-To: ".$sendto_admin.""; 
				$_SESSION['desc'] = '';
				$_SESSION['qty'] = '';
				$_SESSION['name'] = '';
				$_SESSION['phone'] = '';
				$_SESSION['email'] = '';
						
				$pdtId = $_POST['pdtId'];		
				header('location:detail.php?id='.$pdtId.'&s2=Thank you, your enquiry was sent!');
			}
		
	}
	/* code for add deal ends*/
	
	// code for watermark///////////
	$images_folder = 'images/items/';
	
	// Save watermarked images to this folder, must end with slash.
	$destination_folder = 'images/items/watermarked/';
	
	if($item_images){
	foreach($item_images as  $val){  
	$image2 = $image2_imgsrc = '';
	$image2 = $images_dir.$val;
	if(is_file($image2)) {
	  // Image path
	  $image_path = $image2; 
	  // Where to save watermarked image
	  $imgdestpath = $destination_folder . $val;  
	  // Watermark image
	  $img = new watermark();
	  $img -> create_watermark($image_path, $imgdestpath);
	
	}
	}
	}
	  //$destination_folder = 'images/items/';
	
					if($item_images[0] != ""){
			$image1 = $image1_imgsrc = '';
			$image1 = $destination_folder.$item_images[0];
					}
					else{
						$image1 ="";
					}
			if(is_file($image1)) {
				$image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_Desc.'
				'.$item_iCode.'
				'.$item_iDesc.'
				" border="0" class="galleryImg" />';
			} else {
				$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_Desc.'
				'.$item_iCode.'
				'.$item_iDesc.'
				" border="0" />';
			}  
	  /// code for watermark ends here///
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
function checkFields() {
	//alert("checking fields");
	emptyfields = "";		
	if(document.getElementById('name').value == "") {
		emptyfields += "\n   Your name *";
	}
        if(document.getElementById('phone').value == "") {
		emptyfields += "\n   Your phone *";
	}
	if(document.getElementById('email').value == "") {
		emptyfields += "\n   Your e-mail *";
	}
	if(document.getElementById('enquiry').value == "") {
		emptyfields += "\n   Your message *";
	}
	if(document.getElementById('security').value=='') {
		emptyfields += "\n   Spam protection verification code *";
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
function validate() {
	//alert("checking fields");
	emptyfields = "";
        if(document.getElementById('qty').value == '') {
		emptyfields += "\n   Quantity *";
	}
	if(document.getElementById('name1').value == '') {
		emptyfields += "\n   Your name *";
	}        
        if(document.getElementById('phone1').value == '') {
		emptyfields += "\n   Your phone *";
	}
	if(document.getElementById('email1').value == '') {
		emptyfields += "\n   Your e-mail *";
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
<script type="text/javascript">
    $(document).ready(function(){
   // $(document).ready(function(){
        var arr = ['tab1','tab2','tab3','tab4'];
        $(".tbs").click(function(){
            var id = $(this).attr('id'); 
            $.each(arr , function(index, value){
            if(value != id){
            $("#"+value+"").addClass("tab_inactive");
            $("#page4").hide();
            
            }
            if(id == 'tab4'){
             $("#page4").show();
            }
           });           
        })     
    })
</script>
<script type="text/javascript">
	function keyuptime(){
       var qty =document.getElementById("item_order_qty").value;
        var productId = $("#productId").val();  
        var unit      = $("#unit").val();
        var item_M2Box = $("#item_M2Box").val();
        var datastring = 'productId='+productId+'&qty='+qty+'&item_M2Box'+item_M2Box+'&unit='+unit;
        ajxCall(datastring); 
        
//       $("#item_order_qty").focusout(function(){
//        var qty = $(this).val();
//        var productId = $("#productId").val();      
//        var datastring = 'productId='+productId+'&qty='+qty+'&item_M2Box'+item_M2Box;
//        ajxCall(datastring);
//       })
        $("#item_order_qty").change(function(){
        var qty = $(this).val();
        var productId = $("#productId").val();      
        var datastring = 'productId='+productId+'&qty='+qty+'&item_M2Box'+item_M2Box+'&unit='+unit;
        ajxCall(datastring);
       })
       
       function ajxCall(datastring)
       {
           $.ajax
	     ({
		   type: "POST",
		   url : "ajxPdtDetails.php",
		   data: datastring,
                   dataType:"json",
		   cache :false,
		   success: function(res)
		   {
                      // alert(res);
                       //$("#category").html(res.category);   
                       $("#vboxes").html(res.valueBoxes);
                       $("#totlprice").html(res.totalprice);
                       $("#totprice").val(res.totalprice);
                       $("#totalm2").html(res.totalm2);
                       $("#totm2").val(res.totalm2);
                       $("#pdtunit").val(res.unit)  ;
		   }
	      })
       }
       ///////////////////// Add to cart /////////////////////////
       $("#additemtocart").click(function(event){
			event.preventDefault();
			 var shop_user_id_encoded = $("#shop_user_id_encoded").val();
			 var shop_user_session    = $("#shop_user_session").val();
			 var shop_order_id        = $("#shop_order_id").val();
			 var item_Code            = $("#item_Code").val();
			 var pdtunit              = $("#pdtunit").val();
			// var item_order_qty       = $("#item_order_qty").val();
			 var item_order_qty       = $("#totm2").val();
			 var item_id              = $("#item_id").val();
		   //  var totprice             = $("#totprice").val();
			  if(pdtunit == "M2")
				 {
			 var totprice             = $("#totprice").val();
				 }
				  if(pdtunit == "pcs")
				 {
			 var totprice             = $("#totprice").val();
				 }
			 var addToCart = addToCartPdtDetails(shop_user_id_encoded,shop_order_id,shop_user_session,item_Code,item_order_qty,item_id,totprice);
			 
          
       })
       ////////////////////////////////Image gallery //////////////////////////////
       $(".imggallery").click(function(){
           var src = $(this).attr("src");
           //alert(src);
          
           $(".galleryImg").attr("src",src);
           $(".lightbox").attr("href",src);
       })
    }
</script>
<style type="text/css">
   .price_rrp {
                                padding-right: 15px;
				position: relative;
				display: block;
				width: auto;
				float: left;
				font-size: 11px;
				font-weight: normal;
				line-height: 130%;				
				text-align: left;
				text-decoration: line-through;
				color: #888888;
			}
</style>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
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
			<div id="item_detail" class="item_detail">
				<!-- HEAD -->
				<div id="goback" class="goback"><a href="javascript:history.go(-1);" title="Back to previous page">« Back to previous page</a></div>
				<h1><?php echo $item_Desc.' <span>('.$item_Size_name.')</span>'; ?></h1>
				<div id="details" class="details">					
					<!-- PRICING, QTY and button -->
                                       	<div id="pricing" class="pricing">
						<div id="price" class="price" style="background-color:#FFFFFF"><?php //echo "$".number_format($item_buy,2).'<span>per '.$item_Unit.'</span>'; ?>
                                                     <input type="hidden" name="defaultprice" id="defaultprice" value="<?=number_format($item_buy,2)?>"></input>
                                                  <!--  <div class="price_buy">Buy $<?=number_format($item_buy,2)?><?=$item_unit?></div>
								<div class="price_rrp">RRP $<?=number_format($item_rrp,2)?><?=$item_unit?></div>
								<div class="price_save">SAVE $<?=number_format($item_save,2)?></div>
								<div class="clear"></div>--><br />
<span class="lrg-qty-deal">Ask for LRG QTY deal!</span></div>
						<div id="calculation" class="calculation">
							<div id="item_qty" class="item_qty">
								<div id="label" class="label">Your order quantity:</div>
								<div id="field" class="field"><input type="text" id="item_order_qty" name="item_order_qty" value="0" class="textfield" onkeyup="keyuptime()">
                                                                </div>
								<div id="label" class="label"><?php echo $item_Unit; ?></div>
                                                                <input type="hidden" id="productId" name="productId" value="<?=$id?>"></input>
                                                                <input type="hidden" id="item_M2Box" name="item_M2Box" value="<?=$item_M2Box?>"></input>
                                                                
								<div class="clear"></div>
                         
							</div>
                                                    <?php
                                                    if($unit == "pcs") {
                                                    ?>
<!--                                                    <div id="item_calculation" class="item_calculation">
                                                         <?php if($item_PcsBox > 0){?>This order comes in <br/><b><span id="vboxes"></span> boxes</b> (<?=$item_PcsBox?> pcs per box) <br/>Total price = <b>$<span id="totlprice"></span></b><?php }?>
								<div class="clear"></div>
							</div>-->
                                                         <div id="item_calculation" class="item_calculation">
                                                        <? //Total price = <b>$<span id="totlprice"></span></b> ?>
								<div class="clear"></div>
							</div>
                                                    <?php
                                                    }
                                                    else {
                                                    ?>
							<div id="item_calculation" class="item_calculation">
                                                               <?php if($item_M2Box!=0){?> This order comes in <br/><b><span id="vboxes"></span> boxes</b> (<?=$item_M2Box?> m2 per box)<br/><?php if($item_Unit_m2=="M2"){?>Total m2=<span id="totalm2"> </span><?php }?><br/><? //Total price = <b>$<span id="totlprice"></span></b>?><?php } ?><?php if($item_M2Box==0){?><? //Total price = <b>$<span id="totlprice">?><? //=number_format($item_buy,2)?><? //</span></b> ?><?php }?>
								<div class="clear"></div>
							</div>
                                                    <?php
                                                    }
                                                    ?>
							<div class="clear"></div>
						</div>
						<!--<input type="submit" id="additemtocart" name="additemtocart" value="Add to cart" class="big_addtocart">-->
                        <form action="cart.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="shop_user_id_encoded" name="shop_user_id_encoded" value=" <?=$_shop_user_id_encoded?>"></input> 
                            <input type="hidden" id="shop_order_id" name="shop_order_id" value=" <?=$_shop_order_id?>"></input>
                            <input type="hidden" id="shop_user_session" name="shop_user_session" value="<?=$_shop_user_session?>"></input>
                            <input type="hidden" id="item_Code" name="item_Code" value="<?=$item_Code?>"></input>
                            <input type="hidden" id="item_id" name="item_id" value="<?=$item_id?>"></input>
                            <input type="hidden" id="pdtunit" name="pdtunit"></input>
                            <input type="hidden" name="totprice" id="totprice"></input>
                            <input type="hidden" name="totm2" id="totm2"></input>
                            <input type="submit" value="Add to cart" class="big_addtocart">
                        </form>
                       <?php 
						//flag images
						$_SESSION['new_items']=1;
						if($item_Country == 'SPAIN')
                                        {
                                           $img_s='<img src="images/Spain.png" title="Spain"/>';
                                        }
                                        else if($item_Country == 'ITALY')
                                        {
                                            $img_s='<img src="images/Italy.png" title="Italy"/>';
                                        }
						
							
						?>
                        <div id="flag"><a href="#" ><?php echo $img_s ?></a></div>
						<div class="clear"></div>
					</div>
                                        <?php
                                        if($show_error_code){
											echo '<div id="msg">'.$show_error_code.'</div>';
										}else{
											if($msg){                                             
                                        ?> 
                                                <div id="msg"><?=$msg?></div>
                                        
                                        <?php
											}
										}
                                        ?>
                       					<?
										 
										?>
                                        <div class="clear"></div>
                                        <div class="price_info">
                                        	<div class="price_rrp">RRP $<?=number_format($item_rrp,2)?><?=$item_Unit?></div>
						<div class="price_save">SAVE $<?=number_format($item_save,2)?> per <?=$item_Unit?></div>
                                        </div>	
                                        <div class="clear"></div>
                                        <a href="javascript:void(0);" onclick="goToProductTab(4);" class="btnBQD"> <input type="button" value="BIG QUANTITY DEALS" id="lrgqtydeals" class="btn-red"><span class="tooltip">Need a large quantity of this item? Click this button and ask us for a deal!  We'll tailor a price just for you and respond ASAP.<span class="arrow"></span></span></a>
					<?php if($item_Notepad2<>""){ 
                                         
                                                 $display   =   "style='display:block'";
                                                 $ContentDisplay =  "style='display:none'";
                                                 $activeTab     = 'tab_inactive';
                                        }else{ 
                                                 $display   =   "style='display:none'";
                                                 $ContentDisplay = "style='display:block'";
                                                 $activeTab = 'tab';
                                         } ?>
                                        <!-- TABS -->
					<div id="tabs" class="tabs">
						<div id="tab1" class="tab tbs" <?php echo $display; ?> ><a href="javascript:void(0);" onclick="goToProductTab(1);" title="OVERVIEW">OVERVIEW</a></div>
						<div id="tab2" class="<?php echo $activeTab; ?> tbs"><a href="javascript:void(0);" onclick="goToProductTab(2);" title="SPECS">SPECS</a></div>
						<div id="tab3" class="tab_inactive tbs"><a href="javascript:void(0);" onclick="goToProductTab(3);" title="ASK A QUESTION">ASK A QUESTION</a></div>
                        <div id="tab4" class="tab_inactive tbs"><a href="javascript:void(0);" onclick="goToProductTab(4);" title="BIG QUANTITY DEALS">BIG QTY DEALS</a></div>
                        
						<div class="clear"></div>
					</div>
					<!-- OVERVIEW -->
					<div id="page1" class="page">
						<div id="description" class="description">
							<?php echo nl2br($item_Notepad2); ?>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
					<!-- SPECS -->
					<div id="page2" class="page"  <?php echo $ContentDisplay; ?> style="display:none;">
						<table id="details_table" width="100%" class="details_table">
							<tr>
								<td colspan="4"><h3><?php echo $item_Heading_name; ?></h3></td>
							</tr>
                                                     <?php if($item_Code){?>
							<tr>
								<td width="100"><span>Code</span></td>
								<td colspan="3"><?php echo $item_Code; ?></td>
							</tr>
                                                     <?php }?>
                                                     <?php if($item_Size_name){?>
							<tr>
								<td><span>Size</span></td>
								<td colspan="3"><?php echo $item_Size_name; ?></td>
							</tr>
                                                     <?php } ?>
                                                     <?php if($item_Thickness_name){?>
							<tr>
								<td><span>Thickness</span></td>
								<td colspan="3"><?php echo $item_Thickness_name; ?></td>
							</tr>
                                                     <?php } ?>
                                                     <?php if($item_Colour_name){?>
							<tr>
								<td><span>Colour</span></td>
								<td colspan="3"><?php echo $item_Colour_name; ?></td>
							</tr>
                                                     <?php }?>
							<!--<tr>
								<td style="padding-top:15px;"><span>Price</span></td>
								<td colspan="3" style="padding-top:15px;">								
									<div class="price_buy">$<?php echo number_format($item_buy,2).'/'.$item_Unit; ?></div>
									<div class="item_qty">
										Your Order Quantity: 
										<input type="text" id="add_qty" name="add_qty" value="1" class="textfield1" onchange="checkAddQtyValue('<?php echo $item_buy; ?>','<?php echo $item_M2Box; ?>',this.value);"> <?php echo $item_Unit; ?>
										<div class="clear"></div>
									</div>
									<div id="addtocart_button_<?php echo $item_id; ?>" class="button"><a href="javascript:void(0);" title="add to cart" onclick="addToCart('<?php echo $_shop_user_id_encoded ?>','<?php echo $_shop_user_session; ?>','<?php echo $item_Code; ?>', document.getElementById('add_qty').value,'<?php echo $item_id; ?>');">add to cart</a></div>
									<div id="addtocart_feedback_<?php echo $item_id; ?>" class="feedback">Item added to cart</div>
								</td>
							</tr>
							<tr>
								<td><span>Normally</span></td>
								<td colspan="3">
									<div class="price_rrp">$<?php echo number_format($item_rrp,2).'/'.$item_Unit; ?></div>
									<div class="price_save">SAVE $<?php echo number_format($item_save,2); ?></div>
								</td>
							</tr>-->
                                                     <?php if($item_Surface_name){?>
							<tr>
								<td><span>Finish</span></td>
								<td colspan="3"><?php echo $item_Surface_name; ?></td>															
							</tr>
                                                     <?php }?>
                                                     <?php if($item_Material_name){?>
							<tr>
								<td><span>Material</span></td>
								<td colspan="3"><?php echo $item_Material_name; ?></td>
							</tr>
                                                     <?php }?>
                                                    <?php if($item_SlipRating_name != ""){?>
							<tr>
								<td><span>Slip-Rating</span></td>
								<td colspan="3"><?php echo $item_SlipRating_name; ?></td>								
							</tr>
                                                    <?php }?>
                                                    <?php if($item_Use_name){?>
							<tr>
								<td><span>Category/Use</span></td>
								<td colspan="3"><?php echo $item_Use_name; ?></td>
							</tr>
                                                    <?php }?>
                                                    <?php if($item_RelatedTo_name){?>
							<tr>
								<td><span>Collection</span></td>
								<td colspan="3"><?php echo $item_RelatedTo_name; ?></td>
							</tr>
                                                    <?php }?>
                                                    <?php if($item_Pattern_name){?>
							<tr>
								<td><span>Pattern</span></td>
								<td colspan="3"><?php echo $item_Pattern_name; ?></td>
							</tr>
                                                    <?php }?>
							<?php
							if(!empty($item_Pantone_name)) {
								echo '
								<tr>
									<td><span>Pantone</span></td>
									<td colspan="3">'.$item_Pantone_name.'</td>
								</tr>';
							}
							?>
                                                    <?php if($item_Edge_name){?>
							<tr>
								<td><span>Edge Finish</span></td>
								<td colspan="3"><?php echo $item_Edge_name; ?></td>
							</tr>
                                                    <?php }?>
                                                    <?php if($item_Weight_name){?>
<!--							<tr>
								<td><span>Weight</span></td>
								<td colspan="3"><?php echo $item_Weight_name; ?></td>
							</tr>-->
                                                    <?php }?>
                                                    <?php // if($item_PcsBox!="" && $item_PcsBox!=0){
                                                    if($item_PcsM2!="" && $item_PcsM2!=0){
                                                    
                                                    ?>
							<tr>
								<td><span>Box Size</span></td>
								<td><?php echo $item_PcsBox; ?>
								<?php
								
									echo '
									pcs / '.$item_M2Box.' '.$item_Unit_m2.' ('.$item_PcsBox.' pcs per '.$item_Unit_m2.')';
									
								
								?></td>
							</tr>
                                                    <?php }?>
                                                    <?php if($item_M2Pallet){?>
							<tr>
								<td><span>Pallet Size</span></td>
								<td colspan="3"><?php echo $item_M2Pallet.'m&sup2; ('.$item_BoxesPallet.' Boxes)'; ?></td>
							</tr>
                                                    <?php }?>
                                                    <?php { ?>
							<tr>
								<td><span>Ships From</span></td>
								<td colspan="3"><?php echo $item_Location_name; ?></td>
							</tr>
                                                    <?php }?>
							<tr>
								<td ><span>Lead Time to Despatch Order:</span> </td>
                                                                <td colspan="3"><?php echo $item_lead; ?> Days (approx.)</td>
							</tr>
						</table>
						<div class="clear"></div>
					</div>
					<!-- ASK A QUESTION -->
					<div id="page3" class="page" style="display:none;">
                                            <form action ="" method ="post" enctype="multipart/form-data" onsubmit="return checkFields();">
                                                <table class="form-listing">
                                                    <tr><td width="30%" >Name:</td><td width="70%"><input type="text" name="name" id="name" class="textfield1"></input></td></tr>
                                                    <tr><td>Phone:</td><td><input type="text" name="phone" id="phone" class="textfield1"></input></td></tr>
                                                    <tr><td>Email:</td><td><input type="text" name="email" id="email" class="textfield1"></input></td></tr>
                                                    <tr><td>Enquiry:</td><td><textarea name="enquiry" id="enquiry" class="textfield1"></textarea></td></tr>
                                                    <tr><td>Spam protection:</td><td>Please verify that you are human by entering this code into the field before submitting: <span class="asterisk">*</span>
                                                    <img src="randomImage.php" border="0" align="absmiddle"/><br /><input type="text" name="security" id="security" class="textfield1" style="width:100px;margin-top:3px;"/>
                                                    </td></tr>
                                                    <input type ="hidden" name="pdtId" id="pdtId" value="<?=$id?>"></input>
                                                    <tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit" value="Send"></input></td></tr>
                                                </table>
                                            </form>
						<div class="clear"></div>
					</div>
                                        <!--- DEAL QTY -->
                                        <div id="page4" class="page" style="display:none;">
                                        <h4>Need a large quantity of this item? Fill out this enquiry form and ask us for a deal! We'll tailor a price just for you and respond ASAP.  You can also call us on 0419 774 758.</h4>
					   <form action ="" method ="post" enctype="multipart/form-data" onsubmit="return validate();">
                                                <table class="form-listing"> 
                                                    <tr ><td width="30%">ProductDetails:</td><td width="70%"><textarea class="textfield1" disabled><?=$productDesc?></textarea>
                                                    <input type="hidden" id="desc" name="desc" value="<?=$productDesc?>">                                                        
                                                    </td></tr>
                                                    <tr><td>Quantity:</td><td><input type="text" name="qty" id="qty" class="textfield1"></input></td></tr>
                                                    <tr><td>Name:</td><td><input type="text" name="name" id="name1" class="textfield1"></input></td></tr>
                                                    <tr><td>Phone:</td><td><input type="text" name="phone" id="phone1" class="textfield1"></input></td></tr>
                                                    <tr><td>Email:</td><td><input type="text" name="email" id="email1" class="textfield1"></input></td></tr>
                                                    <tr><td>Spam protection:</td><td>Please verify that you are human by entering this code into the field before submitting: <span class="asterisk">*</span>
                                                    <img src="randomImage.php" border="0" align="absmiddle"/><br /><input type="text" name="security" id="security" class="textfield1" style="width:100px;margin-top:3px;"/>
                                                    </td></tr>
                                                    <input type ="hidden" name="pdtId" id="pdtId" value="<?=$id?>"></input>
                                                    <tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit" value="Submit"></input></td></tr>
                                                </table>
                                            </form>
                                            
						<div class="clear"></div>
					</div>
                                        <!----------------->
					<div class="clear"></div>
				</div>
                                <div id="image" class="image product_overlay_img">
					<!-- image -->
                                        <?php 
											if(is_file($image1)){
												echo $image1_imgsrc;
												echo '
													<a href="'.$image1.'" title="'.$item_Desc.'" class="lightbox">
													</a>
												';
/*												echo '
													<a href="'.$image1.'" title="'.$item_Desc.'" class="lightbox overlay">
														<span class="overlay_title">
															'.$item_Desc.'
															<br/>Code: '.$product_details_icode.'
															<br/>Details: '.$product_details_idesc.'
														</span>
													</a>
												';
*/											}else{
												echo $image1_imgsrc;
												echo '
													<a href="'.$image1.'" title="'.$item_Desc.'" class="lightbox overlay">
														<span class="overlay_title">
															Code: '.$item_iCode.'<br/>
															Description: '.$item_iDesc.'
														</span>
													</a>
												';
											}
										?>										
					<div class="clear"></div>
				</div>
                <ul class="thumb-list">
                    <?php if(count($item_images)>=2){
                    foreach($item_images as $secImages) {   
                    ?>
                    
                    <li><a href="javascript:void(0);"><img src="images/items/watermarked/<?=$secImages?>" class="imggallery"/></a></li>
                    <?php }}?>
                    <!--<li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>
                    <li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>
                    <li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>
                    <li><a href="#"><img src="images/items/TMW1524.JPG"/></a></li>-->
                </ul>
                <div id="enlarge_image" class="enlarge_image"><?php if($image1){?><a href="<?php echo $image1; ?>" title="<?php echo $item_Desc; ?>" class="lightbox">Enlarge image</a><?php }?></div>
				<div class="clear"></div>
				<!-- Product variations -->
				<div id="product_variations" class="product_variations">
					<h1>Product Variations</h1>
					<div id="related_products" class="related_products" style="display:block;">
					<h2>Related products to <?php echo $item_Desc; ?></h2>
                    <div class="list">
					<?php 
					$related_string = '';
//                                        $sql = "SELECT sw.*,MATCH(sw.Desc) AGAINST ('\"$item_Desc\"' IN BOOLEAN MODE) AS relevance FROM shop_webitems as sw WHERE sw.RelatedTo='$item_RelatedTo' AND sw.Colour='$item_Colour' AND sw.Surface='$item_Surface' AND sw.item_id!='$item_id' AND sw.WebExport='YES' AND sw.is_active='1' GROUP BY sw.Size ORDER BY relevance DESC LIMIT 0, 24";
                                         $sql = "SELECT sw.*,MATCH(sw.Desc) AGAINST ('\"".$item_Desc."\"' IN BOOLEAN MODE) AS relevance FROM shop_webitems as sw WHERE sw.RelatedTo LIKE '".$item_RelatedTo."' AND sw.Colour LIKE '".$item_Colour."' AND sw.Surface LIKE '".$item_Surface."' AND sw.item_id != ".$item_id." AND sw.WebExport LIKE 'YES' AND sw.is_active = 1 ORDER BY relevance DESC LIMIT 0, 24";
                                        $result_related = mysql_query($sql);
//                                        while($row_related=mysql_fetch_array($result_related)) {
//                                         echo "Here <pre/>";   print_r($row_related);
//                                        }
                                       
                                        //echo $result_related;
					$total_related=mysql_num_rows($result_related);
                                        //echo $total_related;
                                      
					
					if($total_related>0) {
						while($row_related=mysql_fetch_array($result_related)) {
//                                                  echo "<pre/>";  print_r($row_related);
                                                $item_size = $row_related['Size'];
						$result_size_check = mysql_query("SELECT * FROM shop_size WHERE Code LIKE '".$item_size."' AND is_active = 1");
						if($row_size_check = mysql_fetch_array($result_size_check)) {
							$item_display_size = $row_size_check['Description'];
						} else { $item_display_size=''; }
							$this_id = $row_related['item_id'];
                                                        $relatedProducts[] = $row_related['item_id'];
							$item_name = $row_related['Desc'];
                                                        /////////////////// Newly added //////////////////////////
							$item_pcsm2 = floatval($row_related['PcsM2']);
						$item_unit = $row_related['Unit'];
						if($item_pcsm2>0 && $item_pcsm2!=''){ //sell in m2
							$item_webpricem2 = $row_related['WebPriceM2'];
							$item_retailpricem2 = $row_related['RetailPriceM2'];
							if(!empty($item_webpricem2)) {
								$item_buy = floatval($item_webpricem2);
							} else { //if web price value does not exist, use 20% off from retail price
							    $item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
								$item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
							}
													
							$item_rrp = floatval($item_retailpricem2);
							$item_unit='m&sup2;';
						} 
                                                /////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
//                if($item_pcsm2==0&&$item_unit=='PCS'){ 
//                        if(!empty($item_webpricem2)) {
//                                $item_buy = floatval($item_webpricem2);
//			} else { //if web price value does not exist, use 20% off from retail price
//                               	$item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
//				$item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
//			}
//                        $item_retailpricem2 = $row_related['RetailPriceM2'];
//			$item_rrp = floatval($item_retailpricem2);
//			$item_unit='pcs';
//		}
                                                if($item_pcsm2==0 ||  $item_pcsm2 =='')
                                                { 
                                                    $item_WebPricePce = $row_related['WebPricePce'];
                                                    $item_RetailPricePce = $row_related['RetailPricePce'];
                                                    if(!empty($item_WebPricePce)) 
                                                    {
                                                       $item_buy = floatval($item_WebPricePce);
                                                    } 
                                                    else 
                                                    { //if web price value does not exist, use 20% off from retail price
                                                        $item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
                                                        $item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
                                                    }
//                                                    $item_retailpricem2 = $row_related['RetailPriceM2'];
                                                    $item_rrp = floatval($item_RetailPricePce);
                                                    $item_unit='pcs';
                                                }
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$item_save = $item_rrp-$item_buy;
						if($item_save<0){$item_buy=0.00;}
						$item_images = unserialize($row_related['images']);
						$images_dir = 'images/items/';
						$image1 = $image1_imgsrc = '';
						$image1 = $images_dir.$item_images[0];
							if(is_file($image1)) {
								$image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_name.'
								\n<br/>'.$row_related['InternalCode'].'
								\n<br/>'.$row_related['InternalDesc'].'
								" border="0" />';
							} else {
								$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_name.'
								\n<br/>'.$row_related['InternalCode'].'
								\n<br/>'.$row_related['InternalDesc'].'
								" border="0" />';
							}
							
                                                //*****Flag Images****
                                       $img_s='';
                                        if($row_related['Country']=='SPAIN')
                                        {
                                            $img_s='<img src="images/Spain.png" title="Spain"/>';
                                        }
                                        else if($row_related['Country']=='ITALY')
                                        {
                                            $img_s='<img src="images/Italy.png" title="Italy"/>';
                                        }else{
											$img_s='';
										}
                                        
                                        //*****Flag Images****         
                                                      $related_string .= '<div class="thumb">
	<div class="thumbnail" style="position:relative;"><a href="detail.php?id='.$item_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a>
							';
						if(!is_file($image1)){
							$related_string .= '
	                            <span style="position:absolute; top:0px; left:0px;">Code:'.$row_related['InternalCode'].'<br/>Description:'.$row_related['InternalDesc'].'</span>
							';
						}
						$related_string .= '</div>
	<div class="thumb-details">
	<div class="size">'.$item_display_size.'</div>
	<div class="code">'.$row_related['Code'].'</div>
	<div class="name"><a href="detail.php?id='.$this_id.'" title="More info">'.$row_related['Desc'].'</a></div>
	<div class="price_info">';
	//<div class="price_buy">Buy $'.number_format($item_buy,2).''.$item_unit.'</div>
	//<div class="price_rrp">RRP $'.number_format($item_rrp,2).''.$item_unit.'</div>
	//<div class="price_save">SAVE $'.number_format($item_save,2).''.$item_unit.'</div>
             $related_string .= '<div><a href="#" >'.$img_s.'</a></div>
	<div class="clear"></div>
	</div>							
<div class="clear"></div>
</div>	
</div>';



						}
					}
					echo $related_string;
					?>
                    </div>
					<div class="clear"></div>
				</div>
                                        
					<div id="related_products" class="related_products" style="display:block;">
					<h2>Other products you might like</h2>
                    <div class="list">
					<?php 
					//related by use
					$related_string = '';
                                        // echo "SELECT DISTINCT * FROM shop_webitems WHERE `RelatedTo`='$item_RelatedTo' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' GROUP BY Colour,Surface,size ORDER BY Size DESC LIMIT 0, 24";
                                        // $sql = "SELECT * FROM shop_webitems WHERE `RelatedTo`='$item_RelatedTo' AND Colour='$item_Colour' AND Surface='$item_Surface' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' GROUP BY Size ORDER BY Size DESC LIMIT 0, 24";
                                        // $sql = "SELECT DISTINCT * FROM shop_webitems WHERE `RelatedTo`='$item_RelatedTo' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' GROUP BY Colour,Surface,size ORDER BY Size DESC LIMIT 0, 24"
					//$result_related = mysql_query($sql);
                                        //echo $item_RelatedTo;
                                        //$sql = "SELECT sw.* FROM shop_webitems as sw WHERE sw.RelatedTo='$item_RelatedTo' AND sw.Colour!='$item_Colour' OR sw.Surface!='$item_Surface' AND sw.item_id!='$item_id' AND sw.WebExport='YES' AND sw.is_active='1' GROUP BY sw.Size LIMIT 0, 24";
                                        //print_r($relatedProducts);
                                        if(count($relatedProducts))
                                        {
                                            $relatedProducts = implode(',',$relatedProducts);
                                        }
                                        //$sql = "SELECT * FROM shop_webitems WHERE RelatedTo='$item_RelatedTo' AND  item_id NOT IN($relatedProducts) ORDER BY Size DESC LIMIT 0, 24";
                                        $sql = "SELECT * FROM shop_webitems WHERE RelatedTo LIKE '".$item_RelatedTo."' AND item_id != ".$item_id." AND WebExport LIKE 'YES'";
                                        if($relatedProducts!="")
                                        {
                                            $sql .= " AND item_id NOT IN(".$relatedProducts.") ORDER BY Size DESC LIMIT 0, 24";
                                        }
                                        //echo $sql;
                                        $result_related = mysql_query($sql);
					$total_related=mysql_num_rows($result_related);
                                       
					/*if($total_related==0) {
						$result_related = mysql_query("SELECT * FROM shop_webitems WHERE `Use`='$item_Use' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' ORDER BY RAND() LIMIT 0, 24");
						$total_related=mysql_num_rows($result_related);
					}*/
					if($total_related>0) 
                                        {
                                            while($row_related=mysql_fetch_array($result_related)) 
                                            {
//                                               echo "<pre/>"; print_r($row_related);
                                                $this_id = $row_related['item_id'];
						$item_name = $row_related['Desc'];
						$item_pcsm2 = floatval($row_related['PcsM2']);
						$item_unit = $row_related['Unit'];
                                                 //****by*****
                                                $item_size=$row_related['Size'];
                                                //**********added By********
                                                $result_size_check1 = mysql_query("SELECT * FROM shop_size WHERE Code LIKE '".$item_size."' AND is_active = 1");
						if($row_size_check1 = mysql_fetch_array($result_size_check1)) 
                                                {
                                                    $item_display_size1 = $row_size_check1['Description'];
						} 
                                                else 
                                                { 
                                                    $item_display_size1=''; 
                                                    
                                                }
                                                  //*****Flag Images****
                                      
                                        if($row_related['Country']=='SPAIN')
                                        {
                                            $img_s='<img src="images/Spain.png" title="Spain"/>';
                                        }
                                        else if($row_related['Country']=='ITALY')
                                        {
                                            $img_s='<img src="images/Italy.png" title="Italy"/>';
                                        }
                                        //*****Flag Images****       
                                                //**********by*******
						if($item_pcsm2>0&&$item_unit=='M2')
                                                { //sell in m2
                                                    $item_webpricem2 = $row_related['WebPriceM2'];
                                                    $item_retailpricem2 = $row_related['RetailPriceM2'];
                                                    if(!empty($item_webpricem2)) 
                                                    {
                                                        $item_buy = floatval($item_webpricem2);
                                                    } 
                                                    else 
                                                    { //if web price value does not exist, use 20% off from retail price
                                                        $item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
							$item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
                                                    }
													
                                                    $item_rrp = floatval($item_retailpricem2);
                                                    $item_unit='m&sup2;';
						} 
                                                /////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
                                                if($item_pcsm2==0&&$item_unit!='M2')
                                                { 
                                                    $item_WebPricePce = $row_related['WebPricePce'];
                                                    $item_RetailPricePce = $row_related['RetailPricePce'];
                                                    if(!empty($item_webpricem2)) 
                                                    {
                                                       $item_buy = floatval($item_WebPricePce);
                                                    } 
                                                    else 
                                                    { //if web price value does not exist, use 20% off from retail price
                                                        $item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
                                                        $item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
                                                    }
                                                    $item_retailpricem2 = $row_related['RetailPriceM2'];
                                                    $item_rrp = floatval($item_RetailPricePce);
                                                    $item_unit='pcs';
                                                }
                                                
                                                
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$item_save = $item_rrp-$item_buy;
						if($item_save<0)
                                                {
                                                    $item_buy=0.00;
                                                
                                                }
						$item_images = unserialize($row_related['images']);
						$images_dir = 'images/items/';
						$image1 = $image1_imgsrc = '';
						$image1 = $images_dir.$item_images[0];
						if(is_file($image1)) 
                                                {
                                                    $image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_name.$row_related['InternalCode'].$row_related['InternalDesc'].'" border="0" />';
													$show_internal_code = '';
						} 
                                                else 
                                                {
                                                    $image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_name.$row_related['InternalCode'].$row_related['InternalDesc'].'" border="0" />';
													$show_internal_code = '<span style="position:absolute; top:0px; left:0px;">Code:'.$row_related['InternalCode'].'<br/>Description:'.$row_related['InternalDesc'].'</span>';
						}
							/*$related_string .= '
							<div id="thumb'.$this_id.'" class="thumb">
								<div class="thumbnail"><a href="detail.php?id='.$this_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a></div>
								<div class="clear"></div>
							</div>';*/
                                                $related_string .= 
                                                         '<div class="thumb">
                                                                <div class="thumbnail"><a href="detail.php?id='.$this_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a>'.$show_internal_code.'</div>
                                                                <div class="thumb-details">
                                                                    <div class="size">'.$item_display_size1.'</div>
                                                                    <div class="code">'.$row_related['Code'].'</div>
                                                                    <div class="name"><a href="detail.php?id='.$this_id.'" title="More info">'.$row_related['Desc'].'</a></div>
                                                                        <div class="price_info">';
                                                                            //<div class="price_buy">Buy $'.number_format($item_buy,2).''.$item_unit.'</div>
                                                                            //<div class="price_rrp">RRP $'.number_format($item_rrp,2).''.$item_unit.'</div>
                                                                            //<div class="price_save">SAVE $'.number_format($item_save,2).''.$item_unit.'</div>
                                                $related_string .= '
                                                                                <div><a href="#" >'.$img_s.'</a></div>
                                                                            <div class="clear"></div>
                                                                        </div>							
                                                                        <div class="clear"></div>
                                                                </div>
                                                        </div>';
						}
					}
					echo $related_string;
					?>
                    </div>
					<div class="clear"></div>
				</div>
					<div class="clear"></div>
				</div>
				
				<!-- Other products -->
				<div id="related_products" class="related_products" style="display:none;">
					<h2>Related products to <?php echo $item_Desc; ?></h2>
					<?php 
					//related by use
					$related_string = '';
					//$result_related = mysql_query("SELECT * FROM shop_webitems WHERE `Use`='$item_Use' AND item_id!='$item_id' AND WebExport='YES' AND is_active='1' ORDER BY RAND() LIMIT 0, 24");
					$result_related = mysql_query("SELECT * FROM shop_webitems WHERE `RelatedTo` LIKE '".$item_RelatedTo."' AND Colour LIKE '".$item_Colour."' AND Surface LIKE '".$item_Surface."' AND item_id != ".$item_id." AND WebExport LIKE 'YES' AND is_active = 1 ORDER BY Size DESC LIMIT 0, 24");
					$total_related=mysql_num_rows($result_related);
					if($total_related==0) {
						$result_related = mysql_query("SELECT * FROM shop_webitems WHERE `Use` LIKE '".$item_Use."' AND item_id != ".$item_id." AND WebExport LIKE 'YES' AND is_active = 1 ORDER BY RAND() LIMIT 0, 24");
						$total_related=mysql_num_rows($result_related);
					}
					if($total_related>0) {
						while($row_related=mysql_fetch_array($result_related)) {
							$this_id = $row_related['item_id'];
							$item_name = $row_related['Desc'];
							$item_images = unserialize($row_related['images']);
							$images_dir = 'images/items/';
							$image1 = $image1_imgsrc = '';
							$image1 = $images_dir.$item_images[0];
							if(is_file($image1)) {
								$image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_name.'" border="0" />';
								$show_internal_code = '';
							} else {
								$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_name.'" border="0" />';
								$show_internal_code = '<span style="position:absolute; top:0px; left:0px;">Code:'.$row_related['InternalCode'].'<br/>Description:'.$row_related['InternalDesc'].'</span>';
						}
							$related_string .= '
							<div id="thumb'.$this_id.'" class="thumb">
								<div class="thumbnail"><a href="detail.php?id='.$this_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a>'.$show_internal_code.'</div>
								<div class="clear"></div>
							</div>';
						}
					}
					echo $related_string;
					?>
					<div class="clear"></div>
				</div>
				<div id="from_collection" class="from_collection" style="display:none;">
					<h2>More from this collection / <?php echo $item_RelatedTo_name; ?></h2>
					<?php
					$collection_string = '';
					if(!empty($item_RelatedTo)) {
						$result_collection = mysql_query("SELECT * FROM shop_webitems WHERE RelatedTo LIKE '".$item_RelatedTo."' AND item_id != ".$item_id." AND WebExport LIKE 'YES' AND is_active = 1 ORDER BY RAND() LIMIT 0, 24");
						$total_collection=mysql_num_rows($result_collection);
						$item_iCode = $item_iDesc = "";
						if($total_collection>0) {
							while($row_collection=mysql_fetch_array($result_collection)) {
								$this_id = $row_collection['item_id'];
								$item_iCode = $row_collection['InternalCode'];
								$item_iDesc = $row_collection['InternalDesc'];
								$item_images = unserialize($row_collection['images']);
								$images_dir = 'images/items/';
								$image1 = $image1_imgsrc = '';
								$image1 = $images_dir.$item_images[0];
								if(is_file($image1)) {
									$image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_Desc.$item_iCode.$item_iDesc.'" border="0" />';
									$show_internal_code = '';
								} else {
									$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_Desc.$item_iCode.$item_iDesc.'" border="0" />';
									$show_internal_code = '<span style="position:absolute; top:0px; left:0px;">Code:'.$row_collection['InternalCode'].'<br/>Description:'.$row_collection['InternalDesc'].'</span>';
								}
								$collection_string .= '
								<div id="thumb'.$this_id.'" class="thumb">
									<div class="thumbnail"><a href="detail.php?id='.$this_id.'" title="'.$row_collection['Desc'].'">'.$image1_imgsrc.'</a>'.$show_internal_code.'
									</div>
									<div class="clear"></div>
								</div>';
							}
						}
					}
					echo $collection_string;
					?>
					<div class="clear"></div>
				</div>
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
<script>
$(document).ready(function() {
    $('ul.thumb-list li:nth-child(3n)').addClass('last-row');
	$('.list .thumb:nth-child(4n)').addClass('last-row');
});

</script>
</body>
</html>