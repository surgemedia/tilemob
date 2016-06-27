<?php 
session_start();
include('includes/prerun.php');
include('includes/connection.php');
include('includes/global_variables.php');
include('includes/requests.php');
//print_r(mysql_query("SELECT * FROM shop_webitems WHERE Code='NC225420' AND WebExport='YES' "));
$qty     = $_POST['qty'];
$item_id = $_POST['productId'];
$unit = $_POST['unit'];
//if($unit=="PCS")
//{
//    $item_PcsBox = $_POST['item_M2Box'];
//}
//$item_M2Box  = $_POST['item_M2Box'];
$result_item = mysql_query("SELECT * FROM shop_webitems WHERE Code='$item_id' AND WebExport='YES' ");
if($row_item=mysql_fetch_array($result_item)) {
   // echo "<pre/>";print_r($row_item);
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
	$item_Country = $row_item['Country'];
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
	if($row_sliprating=mysql_fetch_array($result_sliprating)){$item_SlipRating_name=$row_sliprating['Description'];}else{$item_SlipRating_name='-';}
	$result_peirating = mysql_query("SELECT * FROM shop_peirating WHERE Code='$item_PEIRating' AND is_active='1'");
	if($row_peirating=mysql_fetch_array($result_peirating)){$item_PEIRating_name=$row_peirating['Description'];}else{$item_PEIRating_name='-';}
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
	if($row_pantone=mysql_fetch_array($result_pantone)){$item_Pantone_name=$row_pantone['Description'];}else{$item_Pantone_name='-';}
	$result_pattern = mysql_query("SELECT * FROM shop_pattern WHERE Code='$item_Pattern' AND is_active='1'");
	if($row_pattern=mysql_fetch_array($result_pattern)){$item_Pattern_name=$row_pattern['Description'];}
	$result_location = mysql_query("SELECT * FROM shop_location WHERE Code='$item_Location' AND is_active='1'");
	if($row_location=mysql_fetch_array($result_location)){$item_Location_name=$row_location['Description'];}					
	if($item_PcsM2>0){ //sell in m2
		if(!empty($item_WebPriceM2)) {
			$item_buy = floatval($item_WebPriceM2);
		} else { //if web price value does not exist, use 20% off from retail price
			$item_web_discount_amount = floatval($item_RetailPriceM2)*0.2; //20% of retail price
			$item_buy = floatval($item_RetailPriceM2)-$item_web_discount_amount;
		}
		$item_rrp = floatval($item_RetailPriceM2);
		//$item_Unit='m&sup2;';
                $item_Unit='M2';
	}
        /////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
                if($item_PcsM2==0){ 
                   // $item_PcsBox = $item_PcsBox;
			if(!empty($item_WebPriceM2)) {
				$item_buy = floatval($item_WebPricePce);
			} else { //if web price value does not exist, use 20% off from retail price
				$item_web_discount_amount = floatval($item_RetailPricePce)*0.2; //20% of retail price
				$item_buy = floatval($item_RetailPricePce)-$item_web_discount_amount;
			}
			$item_rrp = floatval($item_RetailPricePce);
			$item_Unit='pcs';
		}
               // echo $item_Unit;
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$item_Weight_name = $item_Weight.'kg/'.$item_Unit;
	$item_save = $item_rrp-$item_buy;
	if($item_save<0){$item_buy=0.00;}
	$item_images = unserialize($row_item['images']);
	$images_dir = 'images/items/';
	$image1 = $image1_imgsrc = '';
	$image1 = $images_dir.$item_images[0];
	} 
       
        if($item_Unit == "M2" && $item_M2Box != 0) {
           
            $valueBoxes     = ceil($qty/$item_M2Box);
            $totalM2        = $item_M2Box * $valueBoxes;
            $totalPrice     = $item_buy*$item_M2Box*$valueBoxes;
            $result['M2Box']= urldecode($item_M2Box);
            $result['valueBoxes']= urldecode($valueBoxes);
            $result['totalprice']= urldecode($totalPrice);
            $result['totalm2']  = urldecode($totalM2);
            $result['unit'] = $item_Unit;
        }
         if($item_Unit == "M2" && $item_M2Box == 0) {
            
            if($qty == "")
            {
                $qty = 1;
            }
            $totalPrice     = $item_buy*$qty; 
            $result['totalprice']= urldecode($totalPrice);
            $result['totalm2']  = $qty; 
            $result['unit'] = $item_Unit;
        }
        if($item_Unit == "pcs") {   
           // $item_PcsBox = 1;
            
//            $valueBoxes     = ceil($qty/$item_PcsBox);
//            $totalM2        = $item_PcsBox * $valueBoxes;
//            $totalPrice     = $item_buy*$item_PcsBox*$valueBoxes;
//            $result['valueBoxes']= urldecode($valueBoxes);
//            $result['totalm2']  = urldecode($totalM2);
//            $result['totalprice']= urldecode($totalPrice);
//            $result['unit'] = $item_Unit;
            
            ///// Added Newly//////////////
             if($qty == "")
            {
                $qty = 1;
            }
            $totalPrice     = $item_buy*$qty; 
            $result['totalprice']= urldecode($totalPrice);
            $result['totalm2']  = $qty; 
            $result['unit'] = $item_Unit;
        }
        echo json_encode($result);
?>