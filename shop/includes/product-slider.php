<script type="text/javascript" src="scripts/jquery.sliderkit.1.9.2.pack.js"></script>
                  
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
						$result_size_check = mysql_query("SELECT * FROM shop_size WHERE Code='$item_size' AND is_active='1'");
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
						<div> <img src="<?=(is_file($image1))?$image1:'images/blank.gif'?>" alt="" class="browseProductImage" border="0" title=""> </div>
						</a>
                         
						<p class="productName"> <a href="detail.php?id=<?=$item_id?>" title="<?=$item_name?>" class="productName"><?=$row_webitems['Desc']?><span><?=$item_display_size?> <div class="price_buy hide">$<?=number_format($item_buy,2).' per '.$item_unit?></div>
								
                                                                
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