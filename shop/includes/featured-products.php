<div id="store_categories" class="store_categories slide_feature">
	<h1>FEATURED PRODUCTS</h1>
	<ul id="featured_content">		
	   <?php
                $string = '';
		$result_shop_submenu_categories = mysql_query("SELECT * FROM shop_sub_heading WHERE is_active='1' ORDER BY recordListingID ASC");
		$total_submenu_categories = mysql_num_rows($result_shop_submenu_categories);
		if($total_submenu_categories>0) {
			$j = 1;
			while($row_shop_submenu_categories = mysql_fetch_array($result_shop_submenu_categories)) {
				if($j==$total_submenu_categories){$li_category_style=' style="border-bottom:0;---'.$j.'---"';}else{$li_category_style=' style="---'.$j.'---"';}
                                $code             = $row_shop_submenu_categories['Code'];
                                $resultProductsPerCode = mysql_query("SELECT * FROM shop_webitems WHERE SubHeading ='$code'");
                                $totalProductsPerCode = mysql_num_rows($resultProductsPerCode);
                                if($totalProductsPerCode > 0)
                                {
                                $submenu_category_id = $row_shop_submenu_categories['heading_id'];
				$submenu_category_title = ucwords(strtolower($row_shop_submenu_categories['Description']));
				$submenu_category_url = "featuredProducts.php?subheading=".$row_shop_submenu_categories['Code'];
				$string .= '<li'.$li_category_style.'><a href="'.$submenu_category_url.'" title="'.$submenu_category_title.'">'.$submenu_category_title.'</a>';
				   
                                $string = str_replace('---'.$j.'---', 'background-image:none;', $string); //remove li-small-arrow.gif for this li
				$string .= '</li>';
                                }
				$j++;
                                
			}
		}
		echo $string; 
            ?>
	</ul>
	<div class="clear"></div>
</div>
<div class="clear"></div>
