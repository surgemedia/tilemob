<? 
	session_start();
	include('../dbconnect.php');
	include('includes/global_variables.php');
	include('includes/requests.php');
	$result_webitems = mysql_query("SELECT *, WebPricePce, TradePricePce, (WebPricePce+TradePricePce) as pricesum FROM shop_webitems WHERE WebExport LIKE 'YES' AND is_active = 1 ORDER BY RAND() LIMIT 0,20") or die(mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<?php 
	include('includes/attach_styles.php'); //Cascading Style Sheets
	include('includes/attach_scripts.php'); //Javascripts and scripts
?>			
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<link href="styles/sliderkit.css" rel="stylesheet" type="text/css" />
<link href="cssslider.css" rel="stylesheet" type="text/css" />

<title>Title of the document</title>
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
		<!-- Slider Setup -->
            <input checked type=radio name=slider id=slide1 />
            <input type=radio name=slider id=slide2 />
            <input type=radio name=slider id=slide3 />
        
        
            <!-- The Slider -->
            
            <div id=slides>
            
                <div id=overflow>
                
                    <div class=inner>
                    
                        <article>
                            <img src=images/sliders/slider1.jpg />
                        </article>
                        
                        <article>
                            <img src=images/sliders/slider2.jpg />
                        </article>
                        
                        <article>
                            <img src=images/sliders/slider3.jpg />
                        </article>
                        
                    </div> <!-- .inner -->
                    
                </div> <!-- #overflow -->
            
            </div> <!-- #slides -->
        
        
            <!-- Controls and Active Slide Display -->
        
            <div id=controls>
    
                <label for=slide1></label>
                <label for=slide2></label>
                <label for=slide3></label>
            
            </div> <!-- #controls -->
            
            <div id=active>
    
                <label for=slide1></label>
                <label for=slide2></label>
                <label for=slide3></label>
                
            </div> <!-- #active -->
			<div id="pagebody" class="pagebody">
			  <table width="800" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td colspan="4">
                
                  
                 <div class="sliderkit carouselBottomProduct">
		<div class="sliderkit-nav">
			<div class="sliderkit-nav-clip">
            <ul>
<?php
while($row_webitems = mysql_fetch_array($result_webitems)) {
	                    $item_id = $row_webitems['item_id'];
						$item_code = $row_webitems['Code'];
						$item_name = $row_webitems['Desc'];
						$item_size = $row_webitems['Size'];
//echo "<pre/>";	print_r($row_webitems);
	                    $item_images = unserialize($row_webitems['images']);
						$images_dir = 'images/items/';
						$image1 = $image1_imgsrc = '';
						$image1 = $images_dir.$item_images[0];
						$result_size_check = mysql_query("SELECT * FROM shop_size WHERE Code = '".$item_size."' AND is_active= 1 ");
						if($row_size_check = mysql_fetch_array($result_size_check)) {
							$item_display_size = $row_size_check['Description'];
						} else { $item_display_size=''; } 
						$item_pcsm2 = floatval($row_webitems['PcsM2']);
						$item_unit = $row_webitems['Unit'];
						if($item_pcsm2>0&&$item_unit=='M2'){ //sell in m2
							$item_webpricem2 = $row_webitems['WebPriceM2'];
							$item_retailpricem2 = $row_webitems['RetailPriceM2'];
							if(!empty($item_webpricem2)) {
								$item_buy = floatval($item_webpricem2);
							} else { //if web price value does not exist, use 20% off from retail price
							    $item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
								$item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
							}
														
							$item_rrp = floatval($item_retailpricem2);
							$item_unit='m&sup2;';
						} else {
							$item_unit = str_replace('M2','m&sup2;',$item_unit);
						}
						$item_save = $item_rrp-$item_buy;
						if($item_save<0){$item_buy=0.00;}


?>

<li> <a class="imgBox" href="detail.php?id=<?=$item_id?>">
						<div style="position:relative;"> <img src="<?=(is_file($image1))?$image1:'images/blank.gif'?>" title="<?php echo $item_name;?>" alt="Code:<?php echo $row_webitems['Code'];?>  Description:<?php echo $row_webitems['Desc'];?>" class="browseProductImage" border="0" title=""> 
                        	<?php if(!is_file($image1)){?>
	                            <span style="position:absolute; top:0px; left:0px;">Code:<?php echo $row_webitems['InternalCode'];?>  <br/>Description:<?php echo $row_webitems['InternalDesc'];?></span>
                        	<?php } ?>
                        </div>
						</a>
                         
						<p class="productName"> <a href="detail.php?id=<?=$item_id?>" title="<?=$item_name?>" class="productName"><?=$row_webitems['Desc']?><span><?=$item_display_size?>
                        </span></a> <a href="detail.php?id=<?=$item_id?>" title="<?=$item_name?>" class="enquiry">more info</a> </p>
					</li> 

 <?php
}
 ?>
</ul></div>
			<div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-prev"><a href="#" title="Scroll to the left"><span>Previous</span></a></div>
			<div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-next"><a href="#" title="Scroll to the right"><span>Next</span></a></div>
		</div>
	</div>
</td>
		        </tr>
		      </table>
            
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
<script type="text/javascript" src="scripts/jquery.sliderkit.1.9.2.pack.js"></script>
<script type="text/javascript">
	$(window).load(function(){ 
		$(".carouselBottomProduct").sliderkit({
			auto:true,
			scroll:1,
			circular:true,
			start:2,
			shownavitems:5,
			scrollspeed: 700
		});
	});
</script>
</body>
</html>