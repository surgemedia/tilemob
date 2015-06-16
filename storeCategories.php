<? 
	session_start();
	include('../dbconnect.php');
	include('includes/global_variables.php');
	include('includes/requests.php');
	$heading         = $_GET['key'];
	$sqlSearchFor    = mysql_query("SELECT Description FROM shop_heading WHERE Code LIKE '".$heading."'") or die(mysql_error());
	$resSearchFor    = mysql_fetch_array($sqlSearchFor);				 
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
			$gallery_string = $query = '';
			$total_results = 0;
		
				$result_webitems = mysql_query("SELECT * FROM shop_webitems WHERE WebExport LIKE 'YES' AND is_active = 1 AND Heading = '".$heading."'") or die(mysql_error());
				
				$total_results = mysql_num_rows($result_webitems);
				$pagenumbers = '';
				$results_per_page = 20;				
				$total_pages = ceil($total_results/$results_per_page);
				if(!empty($_GET['p'])){$page=trim($_GET['p']);}else{$page=1;}
				$end_row = $page*$results_per_page;
				$start_row = ($end_row-$results_per_page);
				if($total_pages>1) {
					$pagenumbers .= '<div class="pagenumbers">';
					if($page>1){$pagenumbers.='<div class="prev"><a href="storeCategories.php?'.$_parse_url['query'].'&p='.($page-1).'" title="Prev">Prev</a></div>';}
					for($i=1;$i<=$total_pages;$i++) {
						if($i==$page){$page_class='page_selected';}else{$page_class='page';}
						$pagenumbers .= '<div class="'.$page_class.'"><a href="storeCategories.php?'.$_parse_url['query'].'&p='.$i.'" title="'.$i.'">'.$i.'</a></div>';						
					}
					if($page<$total_pages){$pagenumbers.='<div class="next"><a href="storeCategories.php?'.$_parse_url['query'].'&p='.($page+1).'" title="Next">Next</a></div>';}
					$pagenumbers .= '<div class="clear"></div></div>';
				}
			
			?>
            
			<div id="blackheading" class="blackheading"><!--Search results -->› <span><?php echo trim($resSearchFor['Description']); ?></span></div>
			<div id="gallery" class="gallery">
				<?php
				//gallery
				if($total_results>0) {
					$five_counter = 0;
					$gallery_string .= '<div class="gallery_top">'.$total_results.' results.<div class="clear"></div></div>';
					$gallery_string .= $pagenumbers.'<div class="clear"></div>';
					$result_webitems = mysql_query("SELECT *, WebPricePce, TradePricePce, (WebPricePce+TradePricePce) as pricesum FROM shop_webitems WHERE WebExport LIKE 'YES' AND is_active = 1 AND Heading = '".$heading."' LIMIT ".$start_row.",".$results_per_page) or die(mysql_error());
					while($row_webitems = mysql_fetch_array($result_webitems)) {
						$item_id = $row_webitems['item_id'];
						$item_code = $row_webitems['Code'];
						$item_name = $row_webitems['Desc'];
						$item_size = $row_webitems['Size'];
						$result_size_check = mysql_query("SELECT * FROM shop_size WHERE Code LIKE '".$item_size."' AND is_active = 1");
						if($row_size_check = mysql_fetch_array($result_size_check)) {
							$item_display_size = $row_size_check['Description'];
						} else { $item_display_size=''; }
						//$gallery_string .= $row_webitems['Desc'].'<br/>';
						$item_pcsm2 = floatval($row_webitems['PcsM2']);
						$item_unit = $row_webitems['Unit'];
						if($item_pcsm2>0 && $item_pcsm2!=''){ //sell in m2
							$item_webpricem2 = $row_webitems['WebPriceM2'];
							$item_retailpricem2 = $row_webitems['RetailPriceM2'];
							if(!empty($item_webpricem2)) {
								$item_buy = floatval($item_webpricem2);
							} else { //if web price value does not exist, use 20% off from retail price
							    $item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
								$item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
							}
							/*if($item_webpricem2!="") {
								$item_buy = floatval($item_webpricem2);
							} else { //if web price value does not exist, use 20% off from retail price
							
								$item_web_discount_amount = floatval($item_retailpricem2)*0.2; //20% of retail price
								$item_buy = floatval($item_retailpricem2)-$item_web_discount_amount;
							}*/
							
							$item_rrp = floatval($item_retailpricem2);
							$item_unit='m&sup2;';
						} /*else {
							$item_unit = str_replace('M2','m&sup2;',$item_unit);
						}*/
               ////////////////////////////////////////////Newly added for pcs price caluculation///////////////////////////////////
                
               if($item_pcsm2==0&&$item_pcsm2==''){ 
                    $item_webpricepce = $row_webitems['WebPricePce'];
                    $item_retailpricepce = $row_webitems['RetailPricePce'];
                        if(!empty($item_webpricepce)) {
                            
                                $item_buy = floatval($item_webpricepce);
			} else { //if web price value does not exist, use 20% off from retail price
                               	$item_web_discount_amount = floatval($item_retailpricepce)*0.2; //20% of retail price
				$item_buy = floatval($item_retailpricepce)-$item_web_discount_amount;
			}
                        $item_retailpricepce = $row_webitems['RetailPricePce'];
			$item_rrp = floatval($item_retailpricepce);
			$item_unit='pcs';
		}
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						$item_save = $item_rrp-$item_buy;
						if($item_save<0){$item_buy=0.00;}
						$item_images = unserialize($row_webitems['images']);
						$images_dir = 'images/items/';
						$image1 = $image1_imgsrc = '';
						$image1 = $images_dir.$item_images[0];
						if(is_file($image1)) {
							$image1_imgsrc = '<img src="'.$images_dir.$item_images[0].'" alt="'.$item_name.'" border="0" />';
						} else {
							$image1_imgsrc = '<img src="images/blank.gif" alt="'.$item_name.'" border="0" />';
						}
						//*****Flag Images****
						$img_s= '';
						if($row_webitems['Country']=='SPAIN')
						{
							$img_s='<img src="images/Spain.png" title="Spain"/>';
						}
						else if($row_webitems['Country']=='ITALY')
						{
							$img_s='<img src="images/Italy.png" title="Italy"/>';
						}else{
							$img_s= '';
						}
						
						//*****Flag Images****
						$gallery_string .= 
						'<div class="thumb">
							<div class="thumbnail" style="position:relative;"><a href="detail.php?id='.$item_id.'" title="'.$item_name.'">'.$image1_imgsrc.'</a>
							';
						if(!is_file($image1)){
							$gallery_string .= '
	                            <span style="position:absolute; top:0px; left:0px;">Code:'.$row_webitems['InternalCode'].'<br/>Description:'.$row_webitems['InternalDesc'].'</span>
							';
						}
						$gallery_string .= '</div>
							<div class="size">'.$item_display_size.'</div>
							<div class="code">'.$row_webitems['Code'].'</div>
							<div class="name"><a href="detail.php?id='.$item_id.'" title="More info">'.$row_webitems['Desc'].'</a></div>
							<div class="price_info">';
								//<div class="price_buy">Buy $'.number_format($item_buy,2).''.$item_unit.'</div>
								//<div class="price_rrp">RRP $'.number_format($item_rrp,2).''.$item_unit.'</div>
								//<div class="price_save">SAVE $'.number_format($item_save,2).''.$item_unit.'</div>
								//<div class="clear"></div>
						$gallery_string .= '
						<div><a href="#" >'.$img_s.'</a></div>
							</div>							
							<div id="addtocart_button_'.$item_id.'" class="button"><!--<a href="javascript:void(0);" title="add to cart" onclick="addToCart(\''.$_shop_user_id_encoded.'\',\''.$_shop_user_session.'\',\''.$item_code.'\',1,\''.$item_id.'\');">add to cart</a>-->
                                                            <a href="detail.php?id='.$item_id.'" title="'.$item_name.'">View details</a></div>
							<div id="addtocart_feedback_'.$item_id.'" class="feedback">Item added</div>
							<div class="clear"></div>
						</div>';
						$five_counter++;
						if($five_counter==5) {
							$gallery_string .= '<div class="clear"></div>';
							$five_counter = 0;
						}
					}
					$gallery_string .= '<div class="clear"></div><div style="position:relative; height:80px;"><div class="gallery_top">'.$total_results.' results.<div class="clear"></div></div>'.$pagenumbers.'</div>';
				} else {
					$gallery_string .= '<div class="gallery_top">No tiles to list.</div>';
				}
				echo $gallery_string;
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
<?php 
include('includes/end_body.php'); 
echo '<!-- search_material: '.$search_material.' -->';
if(!empty($search_peirating)||!empty($search_type)||!empty($search_pattern)||
	!empty($search_material)||!empty($search_thickness)||!empty($search_edge)||!empty($search_sliprating)) {
	echo '<script>moreTileFinderOptions(\'show\');</script>'; //show advanced search options
}
?>
</body>
</html>