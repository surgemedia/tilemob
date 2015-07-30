<div id="store_categories" class="store_categories">
	<h1>Categories</h1>
	<ul>		
<?php
		$listmaterial = mysql_query("SELECT * FROM shop_material");
		$listmaterialnum = mysql_num_rows($listmaterial);
		for($lm1=1; $lm1<=$listmaterialnum; $lm1++){
			$listmaterialrow = mysql_fetch_array($listmaterial);
			$lmcode[$lm1] = $listmaterialrow['Code'];
			$lmdecr[$lm1] = $listmaterialrow['Description'];
		}
		$listsurface = mysql_query("SELECT * FROM shop_surface");
		$listsurfacenum = mysql_num_rows($listsurface);
		for($ls1=1; $ls1<=$listsurfacenum; $ls1++){
			$listsurfacerow = mysql_fetch_array($listsurface);
			$lscode[$ls1] = $listsurfacerow['Code'];
			$lsdecr[$ls1] = $listsurfacerow['Description'];
		}
		

		function fix_and($string)
		{
			$string = str_replace ( '&', '_AND.', $string );
			return $string;
		}
		$result_shop_menu_categories = mysql_query("SELECT * FROM shop_heading WHERE is_active='1' ORDER BY recordListingID ASC");
		$total_menu_categories = mysql_num_rows($result_shop_menu_categories);
		$k=1;
		if($total_menu_categories>0) {
			while($row_shop_menu_categories = mysql_fetch_array($result_shop_menu_categories)) {
				$code             = $row_shop_menu_categories['Code'];
				$resultProductsPerCode = mysql_query("SELECT * FROM shop_webitems WHERE Heading ='$code'");
				$total_ProductsPerCode = mysql_num_rows($resultProductsPerCode);
				if($total_ProductsPerCode > 0)
				{
					$menu_category_id = $row_shop_menu_categories['heading_id'];
					$menu_category_title = ucwords(strtolower($row_shop_menu_categories['Description']));
					$menu_category_url = "storeCategories.php?key=".$row_shop_menu_categories['Code'];
					echo '<li';
					if($k==$total_menu_categories){ echo ' style="border-bottom:0"';}
					echo '><a href="'.$menu_category_url.'" title="'.$menu_category_title.'">'.$menu_category_title.'</a>';
					echo '<ul>';
					$query00 = mysql_query("SELECT * FROM shop_webitems WHERE Heading LIKE '".$code."' AND is_active = 1 group by Material");
					$num00 = mysql_num_rows($query00);
					if($num00!=0){
					echo '
						<li><a href="'.$menu_category_url.'">Material</a>
					<ul>';
					}
					for($i=1; $i<=$num00; $i++){
						$row00 = mysql_fetch_array($query00);
						for($lmk=1; $lmk<=$listmaterialnum; $lmk++){
							if($row00['Material']==$lmcode[$lmk]){$testlm=$lmdecr[$lmk];}
						}
						
						echo '<li';
							if($i==$num00){ echo ' style="border-bottom:0"';}
						echo '><a href="featuredProducts.php?key='.$code.'&material='.fix_and($row00['Material']).'">'.$testlm.'</a></li>';
					}
					if($num00!=0){
						echo '</ul>
						</li>
					';
					}
					$query01 = mysql_query("SELECT * FROM shop_webitems WHERE Heading LIKE '".$code."' AND is_active = 1 group by Surface");
					$num01 = mysql_num_rows($query01);
					if($num01!=0){
					echo '
						<li style="border-bottom:0"><a href="'.$menu_category_url.'">Surface Finish</a>
					<ul>';
					}
					for($i=1; $i<=$num01; $i++){
						$row01 = mysql_fetch_array($query01);
						for($lsk=1; $lsk<=$listsurfacenum; $lsk++){
							if($row01['Surface']==$lscode[$lsk]){$testls=$lsdecr[$lsk];}
						}
						echo '<li';
							if($i==$num01){ echo ' style="border-bottom:0"';}
						echo '><a href="featuredProducts.php?key='.$code.'&surface='.fix_and($row01['Surface']).'">'.$testls.'</a></li>';
					}
					if($num01!=0){
						echo '</ul>
						</li>
					';
					}
					echo '
					</ul>
					';


				echo '</li>';
				}
				$k=$k+1;
			}
		}
?>
	</ul>
	<div class="clear"></div>
</div>
<div class="clear"></div>
