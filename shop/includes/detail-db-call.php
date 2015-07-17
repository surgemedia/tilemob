<?php
$id   = $_GET['id'];
$msg  = $_GET['s2'];
if(!empty($_GET['id'])) {
	$item_id = trim($_GET['id']);
	$result_item = mysql_query("SELECT * FROM shop_webitems WHERE item_id='$item_id' AND WebExport='YES' AND is_active='1'");
	if($row_item=mysql_fetch_array($result_item)) {
           //echo "<pre/>"; print_r($row_item);
            //*****
              $item_lead= $row_item['LeadTime'];
              //*******
		$item_Code = $row_item['Code'];
		$item_Desc = $row_item['Desc'];
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
		$result_heading = mysql_query("SELECT * FROM shop_heading WHERE Code='$item_Heading' AND is_active='1'");
		if($row_heading=mysql_fetch_array($result_heading)){$item_Heading_name=$row_heading['Description'];}
		$result_relatedto = mysql_query("SELECT * FROM shop_relatedto WHERE Code='$item_RelatedTo' AND is_active='1'");
		if($row_relatedto=mysql_fetch_array($result_relatedto)){$item_RelatedTo_name=$row_relatedto['Description'];}
		$result_use = mysql_query("SELECT * FROM shop_use WHERE Code='$item_Use' AND is_active='1'");
		if($row_use=mysql_fetch_array($result_use)){$item_Use_name=$row_use['Description'];}
		$result_sliprating = mysql_query("SELECT * FROM shop_sliprating WHERE Code='$item_SlipRating' AND is_active='1'");
		if($row_sliprating=mysql_fetch_array($result_sliprating)){$item_SlipRating_name=$row_sliprating['Description'];}else{$item_SlipRating_name='';}
		$result_peirating = mysql_query("SELECT * FROM shop_peirating WHERE Code='$item_PEIRating' AND is_active='1'");
		if($row_peirating=mysql_fetch_array($result_peirating)){$item_PEIRating_name=$row_peirating['Description'];}else{$item_PEIRating_name='';}
		$result_size = mysql_query("SELECT * FROM shop_size WHERE Code='$item_Size' AND is_active='1'");
		if($row_size=mysql_fetch_array($result_size)){$item_Size_name=$row_size['Description'];}
		$result_thickness = mysql_query("SELECT * FROM shop_thickness WHERE Code='$item_Thickness' AND is_active='1'");
		if($row_thickness=mysql_fetch_array($result_thickness)){$item_Thickness_name=$row_thickness['Description'];}
		$result_colour = mysql_query("SELECT * FROM shop_colour WHERE Code='$item_Colour' AND is_active='1'");
		if($row_colour=mysql_fetch_array($result_colour)){$item_Colour_name=$row_colour['Description'];}
		$result_surface = mysql_query("SELECT * FROM shop_surface WHERE Code='$item_Surface' AND is_active='1'");
		if($row_surface=mysql_fetch_array($result_surface)){$item_Surface_name=$row_surface['Description'];}
		$result_edge = mysql_query("SELECT * FROM shop_edge WHERE Code='$item_Edge' AND is_active='1'");
		if($row_edge=mysql_fetch_array($result_edge)){$item_Edge_name=$row_edge['Description'];}
		$result_material = mysql_query("SELECT * FROM shop_material WHERE Code='$item_Material' AND is_active='1'");
		if($row_material=mysql_fetch_array($result_material)){$item_Material_name=$row_material['Description'];}
		$result_pantone = mysql_query("SELECT * FROM shop_pantone WHERE Code='$item_Pantone' AND is_active='1'");
		if($row_pantone=mysql_fetch_array($result_pantone)){$item_Pantone_name=$row_pantone['Description'];}else{$item_Pantone_name='';}
		$result_pattern = mysql_query("SELECT * FROM shop_pattern WHERE Code='$item_Pattern' AND is_active='1'");
		if($row_pattern=mysql_fetch_array($result_pattern)){$item_Pattern_name=$row_pattern['Description'];}
		$result_location = mysql_query("SELECT * FROM shop_location WHERE Code='$item_Location' AND is_active='1'");
		if($row_location=mysql_fetch_array($result_location)){$item_Location_name=$row_location['Description'];}					
		if($item_PcsM2>0 && $item_PcsM2!=''){
//                       echo "Here";//sell in m2
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
			$image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_Desc.'" border="0" class="galleryImg" />';
		} else {
			$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_Desc.'" border="0" />';
		}
	} else {
		header('location:index.php');
	}
} else {
	header('location:index.php');
}

/* Code for ask a question*/
if(!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email'])) {
	$name = $_SESSION['name'] = trim($_POST['name']);
	$email = $_SESSION['email'] = trim($_POST['email']);
	$phone = $_SESSION['phone'] = trim($_POST['phone']);
	if(empty($_POST['subject'])){$_SESSION['contact_subject']=$subject='Website enquiry form';}else{$_SESSION['contact_subject']=$subject=trim($_POST['subject']);}
	$enquiry = $_SESSION['enquiry'] = trim($_POST['enquiry']);
	
	$message = $responder = '';
	
	//if (!$resp->is_valid) { //check that captcha code is correct
	
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
				/*mysql_query("INSERT INTO shop_forms 
				(form_id, form, subject, message, sendername, senderemail, receivername, receiveremail, is_deleted, strtotime) 
				VALUES ('', 'Contact form', '$subject', '$store_message', '$fullname', '$email', 'Admin', '$sendto_admin', '0', '$strtotime')");
				$last_insert_id = mysql_insert_id();*/
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

// Path to the watermark image (apply this image as waretmark)
//$watermark_path = 'images/watermark.png';

// MOST LIKELY YOU WILL NOT NEED TO CHANGE CODE BELOW

// Load functions for image watermarking


// Watermark all the "jpg" files from images folder
// and save watermarked images into destination folder
//foreach (glob($images_folder."*.jpg") as $filename) {
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
			$image1_imgsrc = '<img src="'.$image1.'" alt="'.$item_Desc.'" border="0" class="galleryImg" />';
		} else {
			$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_Desc.'" border="0" />';
		}  
  /// code for watermark ends here///
?>

