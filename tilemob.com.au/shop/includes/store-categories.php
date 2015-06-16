<div id="store_categories" class="store_categories">
	<h1>Store Categories</h1>
	<ul>		
		<?php
		/*$string = '';
		$result_shop_menu_categories = mysql_query("SELECT * FROM shop_menu_categories WHERE under_menu_category_id='0' AND is_active='1' ORDER BY menu_category_id, ordering ASC");
		$total_menu_categories = mysql_num_rows($result_shop_menu_categories);
		if($total_menu_categories>0) {
			$i = 1;
			while($row_shop_menu_categories = mysql_fetch_array($result_shop_menu_categories)) {
				if($i==$total_menu_categories){$li_category_style=' style="border-bottom:0;---'.$i.'---"';}else{$li_category_style=' style="---'.$i.'---"';}
				$menu_category_id = $row_shop_menu_categories['menu_category_id'];
				$menu_category_title = $row_shop_menu_categories['title'];
				$menu_category_url = $row_shop_menu_categories['url'];
				$string .= '<li'.$li_category_style.'><a href="'.$menu_category_url.'" title="'.$menu_category_title.'">'.$menu_category_title.'</a>';
				$result_shop_menu_subcategories = mysql_query("SELECT * FROM shop_menu_categories WHERE under_menu_category_id='$menu_category_id' AND is_active='1' ORDER BY ordering ASC");
				$total_menu_subcategories = mysql_num_rows($result_shop_menu_subcategories);
				if($total_menu_subcategories>0) {
					$string = str_replace('---'.$i.'---', '', $string);
					$string .= '<ul>';
					$j = 1;
					while($row_shop_menu_subcategories = mysql_fetch_array($result_shop_menu_subcategories)) {
						if($j==$total_menu_subcategories){$li_subcategory_style=' style="border-bottom:0;"';}else{$li_subcategory_style='';}
						$menu_subcategory_id = $row_shop_menu_subcategories['menu_category_id'];
						$menu_subcategory_title = $row_shop_menu_subcategories['title'];
						$menu_subcategory_url = $row_shop_menu_subcategories['url'];
						$string .= '<li'.$li_subcategory_style.'><a href="'.$menu_subcategory_url.'" title="'.$menu_subcategory_title.'">'.$menu_subcategory_title.'</a>';
						$j++;
					}
					$string .= '</ul>';
				} else {
					$string = str_replace('---'.$i.'---', 'background-image:none;', $string); //remove li-small-arrow.gif for this li
				}
				$string .= '</li>';
				$i++;
			}
		}
		echo $string*/
		?>
                <?php
                $string = '';
		$result_shop_menu_categories = mysql_query("SELECT * FROM shop_heading WHERE is_active='1' ORDER BY recordListingID ASC");
		$total_menu_categories = mysql_num_rows($result_shop_menu_categories);
		if($total_menu_categories>0) {
			$i = 1;
			while($row_shop_menu_categories = mysql_fetch_array($result_shop_menu_categories)) {
				if($i==$total_menu_categories){$li_category_style=' style="border-bottom:0;---'.$i.'---"';}else{$li_category_style=' style="---'.$i.'---"';}
                                $code             = $row_shop_menu_categories['Code'];
                                $resultProductsPerCode = mysql_query("SELECT * FROM shop_webitems WHERE Heading ='$code'");
                                $total_ProductsPerCode = mysql_num_rows($resultProductsPerCode);
                                if($total_ProductsPerCode > 0)
                                {
                                $menu_category_id = $row_shop_menu_categories['heading_id'];
				$menu_category_title = ucwords(strtolower($row_shop_menu_categories['Description']));
				$menu_category_url = "storeCategories.php?key=".$row_shop_menu_categories['Code'];
				$string .= '<li'.$li_category_style.'><a href="'.$menu_category_url.'" title="'.$menu_category_title.'">'.$menu_category_title.'</a>';
				
                                
                                
                                
                               ////////////////////////////////////////////////////////////////////////////////////// 
                                
                                
                                $result_shop_menu_subcategories = mysql_query("SELECT sw.SubHeading,ssh.Description,ssh.Code FROM shop_webitems as sw INNER JOIN shop_sub_heading as ssh on sw.SubHeading = ssh.Code WHERE sw.Heading = '$code' AND sw.is_active='1' group by sw.SubHeading");
				$total_menu_subcategories = mysql_num_rows($result_shop_menu_subcategories);
				if($total_menu_subcategories>0) {
					$string = str_replace('---'.$i.'---', '', $string);
					$string .= '<ul>';
					$j = 1;
					while($row_shop_menu_subcategories = mysql_fetch_array($result_shop_menu_subcategories)) {
						if($j==$total_menu_subcategories){$li_subcategory_style=' style="border-bottom:0;"';}else{$li_subcategory_style='';}
						//$menu_subcategory_id = $row_shop_menu_subcategories['menu_category_id'];
						$menu_subcategory_title = ucwords(strtolower($row_shop_menu_subcategories['Description']));
                                                $subCatCode             = $row_shop_menu_subcategories['Code']; 
						$menu_subcategory_url   = "featuredProducts.php?key=".$subCatCode;
						$string .= '<li'.$li_subcategory_style.'><a href="'.$menu_subcategory_url.'" title="'.$menu_subcategory_title.'">'.$menu_subcategory_title.'</a>';
						$j++;
					}
					$string .= '</ul>';
				}
                                
                                else {
                                                            
                                /////////////////////////////////////////////////////
                                
                                
                                
                                $string = str_replace('---'.$i.'---', 'background-image:none;', $string); //remove li-small-arrow.gif for this li
                                }
				$string .= '</li>';
                                }
				$i++;
                                
			}
		}
		echo $string; 
            ?>
	</ul>
	<div class="clear"></div>
</div>
<div class="clear"></div>
